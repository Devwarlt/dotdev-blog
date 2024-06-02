<?php
	namespace php\model;
	final class PostResultModel
	{
		private ?PostModel $post;
		private string $err = "";
		private bool $status = false;

		public function __construct() { }

		public function getPost() : ?PostModel { return $this->post; }

		public function setPost(?PostModel $post) : void { $this->post = $post; }

		public function getErr() : string { return $this->err; }

		public function setErr(string $err) : void { $this->err = $err; }

		public function getStatus() : bool { return $this->status; }

		public function setStatus(bool $status) : void { $this->status = $status; }
	}
