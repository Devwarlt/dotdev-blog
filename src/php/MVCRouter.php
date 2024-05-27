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
switch ($controller) {
    default:
        {
            utils::getSingleton()->onRedirectErr(
                "Controlador <strong>$controller</strong> não implementado!",
                "../"
            );
        }
        break;
    case "logout":
        {
            utils::getSingleton()->onRedirectOk("Logout efetuado com êxito!", "../");
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