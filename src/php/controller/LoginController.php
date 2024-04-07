<?php

namespace php\controller;

use php\dao\LoginDAO;
use php\model\LoginModel;

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

    private static LoginController $singleton;

    private function __construct() { }

    public static function getSingleton(): LoginController
    {
        if (self::$singleton === null) self::$singleton = new LoginController();
        return self::$singleton;
    }

    public function authUser(string $username, string $password): array
    {
        $result = array("login" => null, "err" => null);

        if (!preg_match(self::$NAME_REGEX_PATTERN, $username)) {
            $result["err"] = "Nome inválido!";
            return $result;
        }

        if (!preg_match(self::$PASSWORD_REGEX_PATTERN, $password)) {
            $result["err"] = "Senha inválida!";
            return $result;
        }

        $login = new LoginModel(-1, $username, $password, null, -1);
        $dao = LoginDAO::getSingleton();
        if (($result["login"] = $dao->signUp($login)) === null) {
            $result["err"] = "Credenciais não autenticadas!";
            return $result;
        }

        return $result;
    }

    public function signInUser(string $username, string $password, string $email): array
    {
        $result = array("status" => false, "err" => null);

        if (!preg_match(self::$NAME_REGEX_PATTERN, $username)) {
            $result["err"] = "Nome inválido!";
            return $result;
        }

        if (!preg_match(self::$PASSWORD_REGEX_PATTERN, $password)) {
            $result["err"] = "Senha inválida!";
            return $result;
        }

        if (!preg_match(self::$GMAIL_REGEX_PATTERN, $email)) {
            $result["err"] = "E-mail inválido! Apenas e-mails Google estão permitidos.";
            return  $result;
        }

        $login = new LoginModel(-1, $username, $password, $email, 0);
        $dao = LoginDAO::getSingleton();
        if ($dao->signUp($login) !== null) {
            $result["err"] = "Já existe um cadastro com esses dados. Efetue o login
                para continuar.";
            return $result;
        }

        if (!($result['status'] = $dao->signIn($login)))
            $result["err"] = "Não foi possível criar o usuário!";
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
        return array_key_exists(LOGIN_ID, $_SESSION)
            && array_key_exists(LOGIN_NAME, $_SESSION)
            && array_key_exists(LOGIN_PASSWORD, $_SESSION);
    }
}