<?php
	namespace php\model
	{
		final class LoginResultModel
		{
			private ?LoginModel $login;
			private string $err = "";
			private bool $status = false;

			public function __construct() { }

			public function getLogin() : ?LoginModel { return $this->login; }

			public function setLogin(?LoginModel $login) : void { $this->login = $login; }

			public function getErr() : string { return $this->err; }

			public function setErr(string $err) : void { $this->err = $err; }

			public function getStatus() : bool { return $this->status; }

			public function setStatus(bool $status) : void { $this->status = $status; }
		}
	}
