<?php

require("..\php\PhpUtils.php");

use php\controller\LoginController as login;
use php\PhpUtils as utils;

if (count($_POST) === 0 || !isset($_POST["controller"])) {
    utils::getSingleton()->onRedirectErr("Requisição inválida!", "../");
    return;
}

$controller = $_POST["controller"];
switch ($controller) {
    default:
        {
            utils::getSingleton()->onRedirectErr(
                "Controlador não encontrado: <strong>$controller</strong>",
                "../"
            );
        }
        break;
    case "logout":
        {
            require("..\php\controller\LoginController.php");

            if (login::getSingleton()->closeSession())
                utils::getSingleton()->onRedirectOk("Logout efetuado com êxito!", "../");
            else
                utils::getSingleton()->onRedirectErr("Não foi possível efetuar o logout!", "../");
        }
        break;
    case "login":
        {
            if (!isset($_POST["username"]) || !isset($_POST["password"])) {
                utils::getSingleton()->onRedirectErr(
                    "Não foi possível efetuar seu login no sistema! Realize o login com suas credenciais "
                    . "adequadamente.",
                    "../login"
                );
                return;
            }

            require("..\php\controller\LoginController.php");

            if (login::getSingleton()->isUserSignedUp()) {
                utils::getSingleton()->onRedirectOk(null, "../");
                return;
            }

            if (($response = login::getSingleton()->logIn($_POST["username"], $_POST["password"]))->getErr() === null) {
                login::getSingleton()->beginSession($response->getLogin());
                utils::getSingleton()->onRedirectOk(null, "../");
            } else
                utils::getSingleton()->onRedirectErr($response->getErr(), "../");
        }
        break;
}