<?php

namespace php;

use HTTP_Request2;
use HTTP_Request2_Exception;

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
        self::onHeaderRedirect($ref, ["err" => $msg], HTTP_Request2::METHOD_POST);
    }

    /**
     * # RFC 2068 - Hypertext Transfer Protocol -- HTTP/1.1
     * <p align="justify">
     *     This document specifies an Internet standards track protocol for the
     * Internet community, and requests discussion and suggestions for
     * improvements.  Please refer to the current edition of the "Internet
     * Official Protocol Standards" (STD 1) for the standardization state
     * and status of this protocol.
     * Distribution of this memo is unlimited.
     * </p>
     *
     * <br/>
     *
     * ## References:
     * 1. `What does enctype='multipart/form-data' mean?`
     * 1. `form-data vs -urlencoded`
     * @version 2068
     * @since 1990
     * @link http://www.faqs.org/rfcs/rfc2616.html
     * @link http://www.faqs.org/rfcs/rfc2068.html
     * @see https://www.php.net/manual/en/function.header
     * @see https://stackoverflow.com/a/4526286
     * @see https://gist.github.com/joyrexus/524c7e811e4abf9afe56
     * @author R. Fielding
     * @author UC Irvine
     * @author J. Gettys
     * @author J. Mogul
     * @author DEC
     * @author H. Frystyk
     * @author T. Berners-Lee
     * @copyright The Internet Society (1999) / MIT / LCS
     **/
    private function onHeaderRedirect(string $ref, array $args, string $method): void
    {
        switch ($method) {
            case HTTP_Request2::METHOD_GET:
            default:
                {
                    $formatted_args = [];
                    foreach ($args as $k => $v)
                        $formatted_args[] = $k . "=" . urlencode($v);

                    header("Location" . $ref . "?" . implode('&', $formatted_args));
                }
                break;
            case HTTP_Request2::METHOD_POST:
                {
                    $request = new HTTP_Request2($ref, $method);
                    foreach ($args as $k => $v)
                        $request->addPostParameter($k, $v);

                    try {
                        $request->send();
                    } catch (HTTP_Request2_Exception $err) {
                        self::onHeaderRedirect(
                            "../",
                            ["err" => $err->getMessage()],
                            HTTP_Request2::METHOD_GET);
                    }
                }
                break;
        }
    }

    public function onRedirectOk(?string $msg, string $ref): void
    {
        self::onHeaderRedirect($ref, ["ok" => $msg], HTTP_Request2::METHOD_POST);
    }

    public function checkPhpInjection(string $str): bool
    {
        return preg_match(self::$php_injection_regex_pattern, $str);
    }
}