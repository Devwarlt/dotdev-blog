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
				$data = $result->fetch(PDO::FETCH_OBJ);
				return $data->total_posts;
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
		}
	}
