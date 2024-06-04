<?php
	namespace php\dao
	{

		use PDO;
		use php\dao\engine\MySQLDatabase;
		use php\dao\engine\SQLQuery;
		use php\model\PostModel;

		final class PostDAO
		{
			private static $singleton;

			private function __construct() { }

			/**
			 * @param int   $ownerId
			 * @param int[] $postIds
			 *
			 * @return int|null
			 */
			public function countOwnedPosts(int $ownerId, array $postIds) : ?int {
				$result = MySQLDatabase::getSingleton()->select(new SQLQuery("
					SELECT COUNT(id) AS 'total_owned_posts'
					FROM
						posts
					WHERE
						owner_id = :owner_id
					AND
						id IN (:postIds)", [":owner_id" => $ownerId, ":postIds" => implode(', ', $postIds)]));
				if ($result === null) return null;
				return $result->fetch(PDO::FETCH_OBJ)->total_owned_posts;
			}

			public static function getSingleton() : PostDAO {
				if (self::$singleton === null) self::$singleton = new PostDAO();
				return self::$singleton;
			}

			public function fetch(int $ownerId, int $min, int $max) : ?array {
				$result = MySQLDatabase::getSingleton()->select(new SQLQuery("
					SELECT
						id,
						title,
						text,
						owner_id,
						views,
						all_scores,
						creation_date,
						last_updated,
						last_update_user_id,
						hidden
					FROM
						posts
					WHERE
						owner_id = :owner_id
					LIMIT :min, :max", [
					":owner_id" => $ownerId,
					":min"      => $min,
					":max"      => $max
				]));
				if ($result === null) return null;
				$posts = [];
				foreach ($result->fetchAll(PDO::FETCH_OBJ) as $data) {
					$posts[] = new PostModel($data->id,
						urldecode($data->title),
						urldecode($data->text),
						$data->owner_id,
						$data->views,
						json_decode($data->all_scores),
						date_create($data->creation_date),
						date_create($data->last_updated),
						$data->last_update_user_id,
						$data->hidden);
				}
				return $posts;
			}

			public function count(int $ownerId) : ?int {
				$result = MySQLDatabase::getSingleton()->select(new SQLQuery("
					SELECT COUNT(id) AS 'total_posts'
					FROM
						posts
					WHERE
						owner_id = :owner_id", [
					":owner_id" => $ownerId
				]));
				if ($result === null) return null;
				return $result->fetch(PDO::FETCH_OBJ)->total_posts;
			}

			/**
			 * @param int[] $postIds
			 *
			 * @return bool
			 */
			public function delete(array $postIds) : bool {
				return MySQLDatabase::getSingleton()->delete(new SQLQuery("
					DELETE
					FROM
						posts
					WHERE
						id IN (:postIds);", [":postIds" => implode(', ', $postIds)]));
			}

			public function create(PostModel $post) : bool {
				return MySQLDatabase::getSingleton()->insert(new SQLQuery("
					INSERT INTO
						posts(title,
						      text,
						      owner_id)
					       VALUES(':title',
					              ':text',
					              :owner_id)", [
					":title"    => $post->getTitle(),
					":text"     => $post->getText(),
					":owner_id" => $post->getOwnerId()
				]));
			}

			public function update(int $postId, int $newEditorId, string $title, string $text) : bool {
				return MySQLDatabase::getSingleton()->update(new SQLQuery("
					UPDATE
						posts
					SET
						last_update_user_id = :last_update_user_id,
						title = ':title',
						text = ':text',
						last_updated = DEFAULT
					WHERE
						id = :id", [
					":id"                  => $postId,
					":last_update_user_id" => $newEditorId,
					":title"               => $title,
					":text"                => $text
				]));
			}
		}
	}
