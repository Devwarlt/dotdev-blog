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

			public static function getSingleton() : PostDAO {
				if (self::$singleton === null) self::$singleton = new PostDAO();
				return self::$singleton;
			}

			public function fetch(PostModel $post, int $min, int $max) : ?array {
				$result = MySQLDatabase::getSingleton()->select(new SQLQuery("
					SELECT
						id,
						title,
						text,
						owner_id,
						views,
						total_votes,
						average_score,
						creation_date,
						last_updated,
						last_update_user_id,
						hidden
					FROM
						posts
					WHERE
						owner_id = ':owner_id'
					LIMIT :min, :max", [
					":owner_id" => $post->getOwnerId(),
					":min"      => $min,
					":max"      => $max
				]));
				if ($result === null) return null;
				$posts = [];
				foreach ($result->fetchAll(PDO::FETCH_OBJ) as $data) {
					$posts[] += new PostModel($data->id,
						$data->title,
						$data->text,
						$data->owner_id,
						$data->views,
						$data->total_votes,
						$data->average_score,
						$data->creation_date,
						$data->last_updated,
						$data->last_updated_user_id,
						$data->hidden);
				}
				return $posts;
			}
		}
	}
