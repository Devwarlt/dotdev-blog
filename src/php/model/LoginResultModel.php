<?php
	namespace php\model
	{
		final class LoginResultModel
		{
			private ?LoginModel $login;
			private string $err = "";
			private bool $success = true;

			public function __construct() { }

			public function getLogin() : ?LoginModel { return $this->login; }

			public function setLogin(?LoginModel $login) : void { $this->login = $login; }

			public function getErr() : string { return $this->err; }

			public function setErr(string $err) : void {
				$this->err = $err;
				$this->success = false;
			}

			public function isSuccess() : bool { return $this->success; }
		}
	}
