<?php

namespace php;

require('PhpUtils.php');

require('controller\LoginController.php');

require('dao\LoginDAO.php');
require('dao\engine\SQLQuery.php');
require('dao\engine\MySQLDatabase.php');

require('model\LoginModel.php');
require('model\LoginResultModel.php');

use Exception;
use php\controller\LoginController as login;
use php\PhpUtils as utils;

try {
    if (!isset($_POST["controller"])) {
        header('HTTP/1.0 407 Proxy Authentication Required', true, 407);
        return;
    }

    $controller = $_POST["controller"];
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";
    $email = $_POST["email"] ?? "";
    switch ($controller) {
        default:
            {
                utils::getSingleton()->onRedirectErr(
                    "Controlador de rota <strong>$controller</strong> não implementado!",
                    "../"
                );
            }
            break;
        case "login":
            {
                if (empty($username) || empty($password)) {
                    utils::getSingleton()->onRedirectErr(
                        "Não foi possível efetuar seu login no sistema! Realize o login com suas credenciais "
                        . "adequadamente.",
                        "../login"
                    );
                    return;
                }

                if (utils::getSingleton()->checkPhpInjection($username, $password)) {
                    utils::getSingleton()->onRedirectErr(
                        "Php Inject detectado em um dos parâmetros enviados ao servidor!",
                        "../login"
                    );
                    return;
                }

                if (empty(($response = login::getSingleton()->logIn($username, $password))->getErr())) {
                    login::getSingleton()->beginSession($response->getLogin());
                    utils::getSingleton()->onRedirectOk("Login efetuado com êxito!", "../");
                } else
                    utils::getSingleton()->onRedirectErr($response->getErr(), "../");
            }
            break;
        case "register":
            {
                if (empty($username) || empty($password) || empty($email)) {
                    utils::getSingleton()->onRedirectErr(
                        "Não foi possível efetuar seu registro no sistema! Realize o seu cadastro novamente.",
                        "../register"
                    );
                    return;
                }

                if (utils::getSingleton()->checkPhpInjection($username, $password, $email)) {
                    utils::getSingleton()->onRedirectErr(
                        "Php Inject detectado em um dos parâmetros enviados ao servidor!",
                        "../register"
                    );
                    return;
                }

                if (empty(($response = login::getSingleton()->signIn($username, $password, $email))->getErr())) {
                    login::getSingleton()->beginSession($response->getLogin());
                    utils::getSingleton()->onRedirectOk("Registro de nova conta efetuado com êxito!", "../");
                } else
                    utils::getSingleton()->onRedirectErr($response->getErr(), "../register");
            }
            break;
        case "logout":
            {
                login::getSingleton()->closeSession();
                utils::getSingleton()->onRedirectOk("Logout efetuado com êxito!", "../");
            }
            break;
    }
} catch (Exception $ex) {
    echo "
    <!DOCTYPE html>
<html lang='pt' style='height: 100%;'>
<head>
    <meta charset='UTF-8''>
    <title>.DEV Blog - Error</title>
    <link rel='stylesheet' href='../css/bootstrap.min.css'/>
</head>
<body style='height: 100%;' class='h-100 row align-items-center  alert-light'>
    <div class='card text-white bg-danger' style='padding: 4px; width: 100%'>
        <div class='text-warning card-header'>
            <strong><span class='glyphicon glyphicon-alert' aria-hidden='true'></span>&nbsp;&nbsp;
            <u>Internal connection exception!</u></strong></div>
        <div class='card-body'>
            <h5>Exception::getMessage():</h5>
            <p><small><strong>&blacktriangleright;&nbsp;Message:</strong>
            <code class='text-warning bg-dark border-warning rounded'>"
        . $ex->getMessage() . "</code></small></p>
        </div>
        <div class='card-footer'>
            <h5>Stack trace:</h5>
            <pre class='text-warning bg-dark border-warning rounded'>"
        . json_encode($ex->getTrace(), JSON_PRETTY_PRINT) .
        "</pre>
        </div>
    </div>
    <hr/>
    <script type='text/javascript' src='../js/bootstrap.min.js'></script>
    <script type='text/javascript' src='../js/bootstrap.bundle.min.js'></script>
</body>
</html>";
}