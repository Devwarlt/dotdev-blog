<?php

namespace php;

final class PhpUtils
{
    public static $singleton;
    private static string $php_injection_regex_pattern = '/^(?=.*<\?)|(?=.*\?>).*$/';

    private function __construct() { }

    public static function getSingleton(): PhpUtils
    {
        if (self::$singleton === null) self::$singleton = new PhpUtils();
        return self::$singleton;
    }

    public function onRawIndexErr(string $msg, string $ref): void { self::onRawRedirect($msg, $ref, "err"); }

    private function onRawRedirect(string $msg, string $ref, string $var): void
    {
        header("Location:$ref?$var=" . urlencode($msg));
    }

    public function onRawIndexOk(string $msg, string $ref): void { self::onRawRedirect($msg, $ref, "ok"); }

    public function checkPhpInjection(string $str): bool
    {
        return preg_match(self::$php_injection_regex_pattern, $str);
    }

    public function getContents(string $path): string
    {
        $file = dirname(__FILE__) . $path;
        if (!file_exists($file))
            return "<p style='color: red'><strong>Arquivo não encontrado:</strong> "
                . dirname(__FILE__) . "$path</p>";
        return file_get_contents($file);
    }
}