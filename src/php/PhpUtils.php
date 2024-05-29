<?php

namespace php;

define("RESPONSE_SUCCESS", 'ok_response');
define("RESPONSE_FAILURE", 'err_response');
define("RESPONSE_COOLDOWN", "1 days");

define("CREDENTIALS_NOT_SET_LOGIN", 0);
define("CREDENTIALS_NOT_SET_REGISTER", 1);
define("CREDENTIALS_PHP_INJECTION", 2);

final class PhpUtils
{
    public static $singleton;
    private static string $php_injection_regex_pattern = '/^(?=.*<\?)|(?=.*\?>).*$/';

    private function __construct()
    {
    }

    public static function getSingleton(): PhpUtils
    {
        if (self::$singleton === null)
            self::$singleton = new PhpUtils();
        return self::$singleton;
    }

    public function onRedirectOk(?string $msg, string $ref): void
    {
        self::setResponseCookie(RESPONSE_SUCCESS, $msg);
        header("Location:$ref");
    }

    private function setResponseCookie(string $name, ?string $msg): void
    {
        setcookie($name, $msg, strtotime("+" . RESPONSE_COOLDOWN), "/");
    }

    public function getResponseCookie(string $name, bool $unset): ?string
    {
        $value = $_COOKIE[$name] ?? null;

        if ($unset)
            self::unsetResponseCookie($name);

        return $value;
    }

    public function unsetResponseCookie(string $name): void
    {
        if (isset($_COOKIE[$name])) {
            unset($_COOKIE[$name]);
            setcookie($name, "", -1, "/");
        }
    }

    public function validateCredentials(?string $username, ?string $password, string $controller): int
    {
        if (!isset($username) || !isset($password))
            return $controller === "login" ? CREDENTIALS_NOT_SET_LOGIN : CREDENTIALS_NOT_SET_REGISTER;

        if (self::checkPhpInjection($username) || self::checkPhpInjection($password))
            return CREDENTIALS_PHP_INJECTION;
    }

    public function checkPhpInjection(string... $params): bool
    {
        $matches = function (string... $args) {
            $result = [];
            foreach ($args as $arg)
                $result[] = preg_match(self::$php_injection_regex_pattern, $arg);
            return $result;
        };
        return in_array(true, $matches($params));
    }

    public function isErrRedirect(int $credentialsFlag, string $ref): bool
    {
        switch ($credentialsFlag) {
            default:
            {
                return false;
            }
            case CREDENTIALS_NOT_SET_REGISTER:
            {
                self::onRedirectErr(
                    "Não foi possível efetuar seu registro no sistema! Realize o seu cadastro novamente.",
                    $ref
                );
                return true;
            }
            case CREDENTIALS_NOT_SET_LOGIN:
            {
                self::onRedirectErr(
                    "Não foi possível efetuar seu login no sistema! Realize o login com suas credenciais "
                    . "adequadamente.",
                    $ref
                );
                return true;
            }
            case CREDENTIALS_PHP_INJECTION:
            {
                self::onRedirectErr(
                    "Php Inject detectado em um dos parâmetros enviados ao servidor!",
                    $ref
                );
                return true;
            }
        }
    }

    public function onRedirectErr(string $msg, string $ref): void
    {
        self::setResponseCookie(RESPONSE_FAILURE, $msg);
        header("Location:$ref");
    }
}