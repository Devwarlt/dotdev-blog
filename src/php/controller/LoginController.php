<?php

namespace php\controller;

use php\dao\LoginDAO;
use php\model\LoginModel;
use php\model\LoginResultModel;

define("LOGIN_ID", "login-id");
define("LOGIN_NAME", "login-name");
define("LOGIN_PASSWORD", "login-password");
define("LOGIN_EMAIL", "login-email");
define("LOGIN_LEVEL", "login-level");

final class LoginController
{
    private static string $NAME_REGEX_PATTERN = "/^[a-zA-ZáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]{3,255}$/";
    private static string $PASSWORD_REGEX_PATTERN = "/^[a-zA-Z0-9'\"!@#$%¨&*()_+¹²³£¢¬§=-]{3,255}$/";
    private static string $GMAIL_REGEX_PATTERN = "^[0-9a-zA-Z_]+@gmail\.com{,320}$/";

    private static $singleton;

    private function __construct()
    {
    }

    public function logIn(string $username, string $password): LoginResultModel
    {
        $result = new LoginResultModel();

        if (!preg_match(self::$NAME_REGEX_PATTERN, $username)) {
            $result->setErr("Nome inválido!");
            return $result;
        }

        if (!preg_match(self::$PASSWORD_REGEX_PATTERN, $password)) {
            $result->setErr("Senha inválida!");
            return $result;
        }

        $login = new LoginModel(-1, $username, $password, null, -1);
        $dao = LoginDAO::getSingleton();
        $result->setLogin($dao->signUp($login));
        if ($result->getLogin() === null) {
            $result->setErr("Credenciais não autenticadas!");
            return $result;
        }

        return $result;
    }

    public static function getSingleton(): LoginController
    {
        if (self::$singleton === null)
            self::$singleton = new LoginController();
        return self::$singleton;
    }

    public function signIn(string $username, string $password, string $email): LoginResultModel
    {
        $result = new LoginResultModel();

        if (!preg_match(self::$NAME_REGEX_PATTERN, $username)) {
            $result->setErr("Nome inválido!");
            return $result;
        }

        if (!preg_match(self::$PASSWORD_REGEX_PATTERN, $password)) {
            $result->setErr("Senha inválida!");
            return $result;
        }

        if (!preg_match(self::$GMAIL_REGEX_PATTERN, $email)) {
            $result->setErr("E-mail inválido! Apenas e-mails Google estão permitidos.");
            return $result;
        }

        $login = new LoginModel(-1, $username, $password, $email, 0);
        $dao = LoginDAO::getSingleton();
        if ($dao->signUp($login) !== null) {
            $result->setErr(
                "Já existe um cadastro com esses dados. Efetue o login para continuar."
            );
            return $result;
        }

        $result->setStatus($dao->signIn($login));
        if (!$result->getStatus())
            $result->setErr("Não foi possível criar o usuário!");
        return $result;
    }

    public function beginSession(LoginModel $login): bool
    {
        if ($session = session_start()) {
            $_SESSION[LOGIN_ID] = $login->getId();
            $_SESSION[LOGIN_NAME] = $login->getUsername();
            $_SESSION[LOGIN_PASSWORD] = $login->getPassword();
            $_SESSION[LOGIN_EMAIL] = $login->getEmail();
            $_SESSION[LOGIN_LEVEL] = $login->getLevel();
        }
        return $session;
    }

    public function closeSession(): bool
    {
        if (session_start()) {
            unset($_SESSION[LOGIN_ID]);
            unset($_SESSION[LOGIN_NAME]);
            unset($_SESSION[LOGIN_PASSWORD]);
            unset($_SESSION[LOGIN_EMAIL]);
            unset($_SESSION[LOGIN_LEVEL]);

            return session_abort();
        }
        return false;
    }

    public function isUserSignedUp(): bool
    {
        if (!isset($_SESSION))
            session_start();

        return array_key_exists(LOGIN_ID, $_SESSION)
            && array_key_exists(LOGIN_NAME, $_SESSION)
            && array_key_exists(LOGIN_PASSWORD, $_SESSION);
    }
}