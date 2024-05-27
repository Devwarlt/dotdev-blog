<?php

namespace php;

define("RESPONSE_SUCCESS", 'ok_response');
define("RESPONSE_FAILURE", 'err_response');
define("RESPONSE_COOLDOWN", "1 days");

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

    public function onRedirectErr(string $msg, string $ref): void
    {
        self::setResponseCookie(RESPONSE_FAILURE, $msg);
        header("Location:$ref");
    }

    private function setResponseCookie(string $name, ?string $msg): void
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        setcookie($name, $msg, strtotime("+" . RESPONSE_COOLDOWN), "/");
    }

    public function onRedirectOk(?string $msg, string $ref): void
    {
        self::setResponseCookie(RESPONSE_SUCCESS, $msg);
        header("Location:$ref");
    }

    public function checkPhpInjection(string $str): bool
    {
        return preg_match(self::$php_injection_regex_pattern, $str);
    }

    public function getResponseCookie(string $name, bool $unset): ?string
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $value = $_COOKIE[$name] ?? null;

        if ($unset)
            self::unsetResponseCookie($name);

        return $value;
    }

    public function unsetResponseCookie(string $name): void
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        setcookie($name, "", strtotime("-" . RESPONSE_COOLDOWN), "/");
    }
}