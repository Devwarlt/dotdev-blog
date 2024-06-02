<?php
	namespace php\dao
	{

		use PDO;
		use php\dao\engine\MySQLDatabase;
		use php\dao\engine\SQLQuery;
		use php\model\LoginModel;

		final class LoginDAO
		{
			private static $singleton;

			private function __construct() { }

			public function signIn(LoginModel $login) : bool {
				return MySQLDatabase::getSingleton()->insert(new SQLQuery("
					INSERT INTO
						users(username,
						      password,
						      level)
					       VALUES(':username',
					              SHA2(':password', 256),
					              :level)", [
					":username" => $login->getUsername(),
					":password" => $login->getPassword(),
					":level"    => $login->getLevel()
				]));
			}

			public static function getSingleton() : LoginDAO {
				if (self::$singleton === null) self::$singleton = new LoginDAO();
				return self::$singleton;
			}

			public function signUp(LoginModel $login) : ?LoginModel {
				$result = MySQLDatabase::getSingleton()->select(new SQLQuery("
					SELECT
						id,
						username,
						password,
						level
					FROM
						users
					WHERE
						username = ':username'
					  AND
						password = SHA2(':password', 256)", [
					":username" => $login->getUsername(),
					":password" => $login->getPassword()
				]));
				if ($result === null) return null;
				$data = $result->fetch(PDO::FETCH_OBJ);
				return new LoginModel($data->id, $login->getUsername(), $login->getPassword(), $data->level);
			}

			public function updateCredentials(LoginModel $login) : bool {
				return MySQLDatabase::getSingleton()->update(new SQLQuery("
					UPDATE
						users
					SET
						username = ':username',
						password = SHA2(':password', 256),
						level = :level
					WHERE
						id = :id", [
					":id"       => $login->getId(),
					":username" => $login->getUsername(),
					":password" => $login->getPassword(),
					":level"    => $login->getLevel()
				]));
			}
		}
	}
