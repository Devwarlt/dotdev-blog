<?php
	namespace php
	{
		require('PhpUtils.php');
		require('controller\LoginController.php');
		require('dao\LoginDAO.php');
		require('dao\engine\SQLQuery.php');
		require('dao\engine\MySQLDatabase.php');
		require('model\LoginModel.php');
		require('model\LoginResultModel.php');

		use php\controller\LoginController as login;
		use php\PhpUtils as utils;

		if (!isset($_POST["controller"])) {
			header('HTTP/1.0 407 Proxy Authentication Required', true, 407);
			return;
		}
		$controller = $_POST["controller"];
		$username = $_POST["username"] ?? "";
		$password = $_POST["password"] ?? "";
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
		}
	}
