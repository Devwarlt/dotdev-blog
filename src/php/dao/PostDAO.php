<?php
	namespace php\dao
	{

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
	      owner_id,
	      views,
	      total_votes,
	      average_score,
	      creation_date,
	      last_updated,
	      last_update_user_id,
	      hidden)
       VALUES(':title',
              ':text',
              :owner_id,
              :views,
              :total_votes,
              :average_score,':creation_date',
              ':last_updated',
              :last_update_user_id,
              :hidden)", [
					":title"               => $post->getTitle(),
					":text"                => $post->getText(),
					":owner_id"            => $post->getOwnerId(),
					":views"               => $post->getViews(),
					":total_votes"         => $post->getTotalVotes(),
					":average_score"       => $post->getAverageScore(),
					":creation_date"       => $post->getCreationDate(),
					":last_updated"        => $post->getLastUpdated(),
					":last_update_user_id" => $post->getLastUpdateUserId(),
					":hidden"              => $post->isHidden()
				]));
			}

			public static function getSingleton() : PostDAO {
				if (self::$singleton === null) self::$singleton = new PostDAO();
				return self::$singleton;
			}
		}
	}
