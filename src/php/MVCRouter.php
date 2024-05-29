<?php

namespace php;

include("PhpUtils.php");
include("controller\LoginController.php");

use php\controller\LoginController as login;
use php\PhpUtils as utils;

if (!isset($_POST["controller"])) {
    header('HTTP/1.0 407 Proxy Authentication Required', true, 407);
    return;
}

$controller = $_POST["controller"];
$username = $_POST["username"] ?? null;
$password = $_POST["password"] ?? null;
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
            if (!isset($username) || !isset($password)) {
                utils::getSingleton()->onRedirectErr(
                    "Não foi possível efetuar seu login no sistema! Realize o login com suas credenciais "
                    . "adequadamente.",
                    "../login"
                );
                return;
            }

            if (utils::getSingleton()->checkPhpInjection($username)
                || utils::getSingleton()->checkPhpInjection($username, $password)) {
                utils::getSingleton()->onRedirectErr(
                    "Php Inject detectado em um dos parâmetros enviados ao servidor!",
                    "../login"
                );
                return;
            }

            if (($response = login::getSingleton()->logIn($_POST["username"], $_POST["password"]))->getErr() === null) {
                login::getSingleton()->beginSession($response->getLogin());
                utils::getSingleton()->onRedirectOk(null, "../");
            } else
                utils::getSingleton()->onRedirectErr($response->getErr(), "../");
        }
        break;
    case "register":
        {
            if (!isset($username) || !isset($password)) {
                utils::getSingleton()->onRedirectErr(
                    "Não foi possível efetuar seu registro no sistema! Realize o seu cadastro novamente.",
                    "../new_account"
                );
                return;
            }

            if (utils::getSingleton()->checkPhpInjection($username)
                || utils::getSingleton()->checkPhpInjection($username, $password)) {
                utils::getSingleton()->onRedirectErr(
                    "Php Inject detectado em um dos parâmetros enviados ao servidor!",
                    "../new_account"
                );
                return;
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