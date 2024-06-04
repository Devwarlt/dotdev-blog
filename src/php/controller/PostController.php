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
					$post = new PostModel(-1, $title, $text, $login->getId(), 0, [0.00], null, null, -1, false));
				$dao = PostDAO::getSingleton();
				if (!$dao->create($post)) {
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

			/**
			 * @param int[]                 $postIds
			 * @param \php\model\LoginModel $login
			 *
			 * @return \php\model\PostResultModel
			 */
			public function delete(array $postIds, LoginModel $login) : PostResultModel {
				$result = new PostResultModel();
				$dao = PostDAO::getSingleton();
				if ($login->getLevel() === LOGIN_LEVEL_USER) {
					$countOwnedPosts = $dao->countOwnedPosts($login->getId(), $postIds);
					if (count($postIds) < $countOwnedPosts ?? 0) {
						$result->setErr("Um ou mais postagens não pertencem a você. Nível de acesso exigido.");
					}
					else {
						if (!$dao->delete($postIds)) {
							$result->setErr("Operação não concluída! Falha ao remover uma ou mais postagens.");
						}
					}
				}
				else {
					if (!$dao->delete($postIds)) {
						$result->setErr("Operação não concluída! Falha ao remover uma ou mais postagens.");
					}
				}
				return $result;
			}

			public function count(LoginModel $login) : PostResultModel {
				$result = new PostResultModel();
				$result->setCount($count = PostDAO::getSingleton()->count($login->getId()) ?? 0);
				if ($count === 0) {
					$result->setErr("Não foi possível consultar o número de postagens do usuário especificado.");
				}
				return $result;
			}

			public function fetch(LoginModel $login, int $min, int $max) : PostResultModel {
				$result = new PostResultModel();
				$result->setPosts(PostDAO::getSingleton()->fetch($login->getId(), $min, $max) ?? []);
				return $result;
			}

			public function update(int $postId, int $newEditorId, string $title, string $text) : PostResultModel {
				$result = new PostResultModel();
				if (!PostDAO::getSingleton()->update($postId, $newEditorId, $title, $text)) {
					$result->setErr("Não foi possível realizar a atualização da sua postagem! Tente novamente mais tarde.");
				}
				return $result;
			}
		}
	}
