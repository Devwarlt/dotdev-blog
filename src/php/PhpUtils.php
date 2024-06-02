<?php
	namespace php;
	define("RESPONSE_SUCCESS", "ok_response");
	define("RESPONSE_FAILURE", "err_response");
	define("RESPONSE_COOLDOWN", "1 days");

	final class PhpUtils
	{
		public static $singleton;
		private static string $PHP_INJECTION_REGEX_PATTERN = '/^(?=.*<\?)|(?=.*\?>).*$/';

		private function __construct() { }

		public static function getSingleton() : PhpUtils {
			if (self::$singleton === null) {
				self::$singleton = new PhpUtils();
			}
			return self::$singleton;
		}

		public function onRedirectOk(
			?string $msg,
			string $ref
		) : void {
			self::setResponseCookie(RESPONSE_SUCCESS, $msg);
			header("Location:$ref");
		}

		private function setResponseCookie(
			string $name,
			string $msg
		) : void {
			$strippedMsg = preg_replace('/\s+/', ' ', $msg);
			setcookie($name, $strippedMsg, strtotime("+" . RESPONSE_COOLDOWN), "/");
		}

		public function getResponseCookie(
			string $name,
			bool $unset
		) : ?string {
			$value = $_COOKIE[$name] ?? null;
			if ($unset) {
				self::unsetResponseCookie($name);
			}
			return $value;
		}

		public function unsetResponseCookie(string $name) : void {
			if (isset($_COOKIE[$name])) {
				setcookie($name, "", 0, "/");
			}
		}

		public function checkPhpInjection(string...$params) : bool {
			$matches = function (array $args) : array {
				$result = [];
				foreach ($args as $arg) {
					$result[] = preg_match(self::$PHP_INJECTION_REGEX_PATTERN, $arg);
				}
				return $result;
			};
			return in_array(true, $matches($params));
		}

		public function onRedirectErr(
			string $msg,
			string $ref
		) : void {
			self::setResponseCookie(RESPONSE_FAILURE, $msg);
			header("Location:$ref");
		}

		public function flushResponseCookies() : void {
			self::unsetResponseCookie(RESPONSE_SUCCESS);
			self::unsetResponseCookie(RESPONSE_FAILURE);
		}
	}
