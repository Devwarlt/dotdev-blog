<?php

include "PhpUtils.php";

use php\controller\LoginController;
use php\PhpUtils;

$utils = PhpUtils::getSingleton();
$errRef = $okRef = "../";

if (count($_POST) === 0 || !isset($_POST["controller"])) {
    $utils->onRawIndexErr("Requisição inválida!", $errRef);
    return;
}

$controller = $_POST["controller"];
switch ($controller) {
    default:
        $utils->onRawIndexErr("Controlador não encontrado: <strong>$controller</strong>", $errRef);
        break;
    case "login":
        {
            include "controller/LoginController.php";
            include "dao/engine/SQLQuery.php";
            include "dao/engine/MySQLDatabase.php";
            include "dao/LoginDAO.php";
            include "model/LoginModel.php";
            include "model/LoginResultModel.php";

            $login = LoginController::getSingleton();

            if (isset($_POST["logout"])) {
                $result = $login->closeSession();
                $utils->onRawIndexOk(
                    $result ? "Logout efetuado com sucesso!" : "Não foi possível efetuar o logout!",
                    $result ? $okRef : $errRef
                );
                return;
            }

            if (!isset($_POST["username"]) || !isset($_POST["password"])) {
                $utils->onRawIndexErr(
                    "Não foi possível efetuar seu login no sistema! Realize o login com suas credenciais "
                    . "adequadamente.",
                    "../login"
                );
                return;
            }

            $okRef = "../account";
            if ($login->isUserSignedUp()) {
                header("Location:$okRef");
                return;
            }

            $loginResponse = $login->logIn($_POST["username"], $_POST["password"]);
            if ($loginResponse->getErr() === null) {
                if ($loginResponse->getLogin() !== null)
                    $login->beginSession($loginResponse->getLogin());
                header("Location:$okRef");
            } else
                $utils->onRawIndexErr($loginResponse->getErr(), $errRef);
        }
        break;
}

function pJustified(string $msg): string
{
    return "<p style='text-align: justify; text-justify: inter-word'>$msg</p>";
}