<?php
	namespace php\controller
	{

		use php\dao\PostDAO;
		use php\model\LoginModel;
		use php\model\PostModel;
		use php\model\PostResultModel;

		final class PostController
		{
			private static $singleton;

			private function __construct() { }

			public function create(string $title, string $text, LoginModel $login) : PostResultModel {
				$result = new PostResultModel();
				$result->setPost(
					$post = new PostModel(-1, $title, $text, $login->getId(), 0, 0, 0, null, null, -1, false));
				$dao = PostDAO::getSingleton();
				$result->setStatus($dao->create($post));
				if (!$result->getStatus()) {
					$result->setErr("Algo inesperado aconteceu durante a criação da sua 
					postagem. Tente novamente mais tarde. Esse problema pode estar vinculado 
					com o nosso banco de dados.");
				}
				return $result;
			}

			public static function getSingleton() : PostController {
				if (self::$singleton === null) self::$singleton = new PostController();
				return self::$singleton;
			}
		}
	}
