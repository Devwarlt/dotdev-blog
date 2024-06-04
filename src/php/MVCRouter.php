<?php
	namespace php
	{
		require('PhpUtils.php');
		require('controller\LoginController.php');
		require('controller\PostController.php');
		require('dao\LoginDAO.php');
		require('dao\PostDAO.php');
		require('dao\engine\SQLQuery.php');
		require('dao\engine\MySQLDatabase.php');
		require('model\LoginModel.php');
		require('model\LoginResultModel.php');
		require('model\PostModel.php');
		require('model\PostResultModel.php');

		use php\controller\LoginController as login;
		use php\controller\PostController as post;
		use php\PhpUtils as utils;

		if (!isset($_POST["controller"])) {
			header('HTTP/1.0 407 Proxy Authentication Required', true, 407);
			return;
		}
		$controller = $_POST["controller"];
		// Credentials params:
		$username = $_POST["username"] ?? "";
		$password = $_POST["password"] ?? "";
		// Create post params:
		$postCreateTitle = $_POST["post-create-title"] ?? "";
		$postCreateText = $_POST["post-create-text"] ?? "";
		// Remove post params:
		$postRemoveList = $_POST["post-remove-list"] ?? "";
		// Edit post params:
		$postEditId = $_POST["post-edit-id"] ?? "";
		$postEditNewEditorId = $_POST["post-edit-new-editor"] ?? "";
		$postEditNewTitle = $_POST["post-edit-title"] ?? "";
		$postEditNewText = $_POST["post-edit-text"] ?? "";
		switch ($controller) {
			default:
				{
					utils::getSingleton()
					     ->onRedirectErr("Controlador de rota <strong>$controller</strong> não implementado!",
						     "../");
				}
				break;
			case "login":
				{
					if (login::getSingleton()->isUserSignedUp()) {
						utils::getSingleton()->onRedirectOk("Você já está entrou no sistema, não é necessário
							realizar outro login.",
							"/");
						return;
					}
					if (empty($username) || empty($password)) {
						utils::getSingleton()->onRedirectErr("Não foi possível efetuar seu login no sistema! 
							Realize o login com suas credenciais adequadamente.",
							"../login");
						return;
					}
					if (utils::getSingleton()->checkPhpInjection($username, $password)) {
						utils::getSingleton()
						     ->onRedirectErr("Php Inject detectado em um dos parâmetros enviados ao servidor!",
							     "../login");
						return;
					}
					if (($response = login::getSingleton()->logIn($username, $password))->isSuccess()) {
						login::getSingleton()->beginSession($response->getLogin());
						utils::getSingleton()->onRedirectOk("Login efetuado com êxito!", "../");
					}
					else {
						utils::getSingleton()->onRedirectErr($response->getErr(), "../");
					}
				}
				break;
			case "register":
				{
					if (login::getSingleton()->isUserSignedUp()) {
						utils::getSingleton()
						     ->onRedirectOk("Você já está registrado no sistema, não é necessário realizar outro cadastro.",
							     "/");
						return;
					}
					if (empty($username) || empty($password)) {
						utils::getSingleton()->onRedirectErr("Não foi possível efetuar seu registro no sistema! 
							Realize o seu cadastro novamente.",
							"../register");
						return;
					}
					if (utils::getSingleton()->checkPhpInjection($username, $password)) {
						utils::getSingleton()
						     ->onRedirectErr("Php Inject detectado em um dos parâmetros enviados ao servidor!",
							     "../register");
						return;
					}
					if (($response = login::getSingleton()->signIn($username, $password))->isSuccess()) {
						login::getSingleton()->beginSession($response->getLogin());
						utils::getSingleton()->onRedirectOk("Registro de nova conta efetuado com êxito!", "../");
					}
					else {
						utils::getSingleton()->onRedirectErr($response->getErr(), "../register");
					}
				}
				break;
			case "logout":
				{
					if (!login::getSingleton()->isUserSignedUp()) {
						utils::getSingleton()
						     ->onRedirectErr("Para realizar o logout, é necessário fazer login no sistema!.",
							     "/login");
						return;
					}
					login::getSingleton()->closeSession();
					utils::getSingleton()->onRedirectOk("Logout efetuado com êxito!", "../");
				}
				break;
			case "create-post":
				{
					if (!login::getSingleton()->isUserSignedUp()) {
						utils::getSingleton()->onRedirectErr("É necessário realizar o login para acessar esta página.",
							"/login");
						return;
					}
					if (empty($postCreateTitle) || empty($postCreateText)) {
						utils::getSingleton()->onRedirectErr("Não foi possível efetuar a criação da sua nova 
							postagem. Tente novamente, preenchendo todos os campos do formulário.",
							"../my_posts");
						return;
					}
					$login = login::getSingleton()->fetchLogin();
					if (
						($response = post::getSingleton()->create(urlencode($postCreateTitle),
							urlencode(nl2br($postCreateText)),
							$login))->isSuccess()
					) {
						utils::getSingleton()->onRedirectOk("Sua postagem foi criada com êxito!", "../my_posts");
					}
					else {
						utils::getSingleton()->onRedirectErr($response->getErr(), "../my_posts");
					}
				}
				break;
			case "remove-post":
				{
					if (!login::getSingleton()->isUserSignedUp()) {
						utils::getSingleton()->onRedirectErr("É necessário realizar o login para acessar esta página.",
							"/login");
						return;
					}
					if (empty($postRemoveList)) {
						utils::getSingleton()->onRedirectErr("Não foi possível efetuar a remoção de uma ou mais 
						    postagem. Tente novamente, selecionando as postagens que deseja efetuar esta ação.",
							"../my_posts");
						return;
					}
					$login = login::getSingleton()->fetchLogin();
					/** @var int[] $postIds */
					$postIds = array_map('intval', explode(',', $postRemoveList));
					if (($response = post::getSingleton()->delete($postIds, $login))->isSuccess()) {
						utils::getSingleton()->onRedirectOk(sprintf("%s postage%s removida%s com êxito!",
							$totalPosts = count($postIds),
							$totalPosts > 1
								? "ns"
								: "m",
							$totalPosts > 1
								? "s"
								: ""),
							"../my_posts");
					}
					else {
						utils::getSingleton()->onRedirectErr($response->getErr(), "../my_posts");
					}
				}
				break;
			case "edit-post":
				{
					if (!login::getSingleton()->isUserSignedUp()) {
						utils::getSingleton()->onRedirectErr("É necessário realizar o login para acessar esta página.",
							"/login");
						return;
					}
					if (
						empty($postEditId) || empty($postEditNewEditorId) || empty($postEditNewTitle) || empty
						($postEditNewText)
					) {
						utils::getSingleton()->onRedirectErr("Não foi possível efetuar a alteração da sua nova 
							postagem. Tente novamente, preenchendo todos os campos do formulário.",
							"../my_posts");
						return;
					}
					if (
						($response = post::getSingleton()->update(intval($postEditId),
							intval($postEditNewEditorId),
							urlencode($postEditNewTitle),
							urlencode(nl2br($postEditNewText))))->isSuccess()
					) {
						utils::getSingleton()->onRedirectOk("Sua postagem foi atualizada com êxito!",
							"../my_posts");
					}
					else {
						utils::getSingleton()->onRedirectErr($response->getErr(), "../my_posts");
					}
				}
				break;
		}
	}
