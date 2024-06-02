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
		$username = $_POST["username"] ?? "";
		$password = $_POST["password"] ?? "";
		$postCreateTitle = $_POST["post-create-title"] ?? "";
		$postCreateText = $_POST["post-create-text"] ?? "";
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
					if (($response = login::getSingleton()->logIn($username, $password))->getStatus()) {
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
					if (($response = login::getSingleton()->signIn($username, $password))->getStatus()) {
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
					login::getSingleton()->closeSession();
					utils::getSingleton()->onRedirectOk("Logout efetuado com êxito!", "../");
				}
				break;
			case "create-post":
				{
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
							$login))->getStatus()
					) {
						utils::getSingleton()->onRedirectOk("Sua postagem foi criada com êxito!", "../my_posts");
					}
					else {
						utils::getSingleton()->onRedirectErr($response->getErr(), "../my_posts");
					}
				}
				break;
		}
	}
