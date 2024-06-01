<?php
	namespace php\model
	{
		final class LoginModel
		{
			private int $id;
			private string $username;
			private string $password;
			private int $level;

			public function __construct(
				int $id,
				string $username,
				string $password,
				int $level
			) {
				$this->id = $id;
				$this->username = $username;
				$this->password = $password;
				$this->level = $level;
			}

			public function getId() : int {
				return $this->id;
			}

			public function getUsername() : string {
				return $this->username;
			}

			public function getPassword() : string {
				return $this->password;
			}

			public function getLevel() : int {
				return $this->level;
			}

			public function getLevelHumanReadable() : string {
				switch ($this->level) {
					case 0:
					default:
						{
							return "normal";
						}
					case 1:
						{
							return "moderador";
						}
					case 2:
						{
							return "adminstrador";
						}
				}
			}
		}
	}
