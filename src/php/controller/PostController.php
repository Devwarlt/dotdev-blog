<?php
	namespace php\controller
	{

		use php\model\PostResultModel;

		final class PostController
		{
			private static $singleton;

			private function __construct() {
			}

			public static function getSingleton() : PostController {
				if (self::$singleton === null) self::$singleton = new PostController();
				return self::$singleton;
			}

			public function create() : PostResultModel {
				# TODO: this method must be implemented.
				$result = new PostResultModel();
				return $result;
			}
		}
	}
