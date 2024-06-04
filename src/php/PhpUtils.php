<?php
	namespace php;
	define("RESPONSE_SUCCESS", "ok_response");
	define("RESPONSE_FAILURE", "err_response");
	define("RESPONSE_COOLDOWN", "1 days");
	define("DEFAULT_DATEFORMAT", "d/m/Y - H:i");

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

		/**
		 * # PHP Format Numbers to Nearest Thousands
		 * Here comes a PHP function to format numbers to nearest thousands such as Kilos, Millions, Billions, and
		 * Trillions with comma.
		 * > &nbsp;This code has been modified to satisfy current demand for this project.
		 *
		 * @param int $num
		 *
		 * @return string
		 * @since  26 Jun 2018
		 * @author Rafasashi
		 * @link   https://code.recuweb.com/2018/php-format-numbers-to-nearest-thousands/
		 */
		public function numberFormat(int $num) : string {
			if ($num > 1000) {
				$x = round($num);
				$x_number_format = number_format($x);
				$x_array = explode(',', $x_number_format);
				$x_parts = ['K', 'Mi', 'Bi', 'Tri'];
				$x_count_parts = count($x_array) - 1;
				$x_display = $x_array[0] .
				             ((int)$x_array[1][0] !== 0
					             ? '.' . $x_array[1][0]
					             : '');
				$x_display .= $x_parts[$x_count_parts - 1];
				return $x_display;
			}
			return $num;
		}
	}
