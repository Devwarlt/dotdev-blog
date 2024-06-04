<?php
	namespace php\model;
	final class PostResultModel
	{
		private ?PostModel $post;
		private string $err = "";
		private bool $success = false;
		private ?array $posts;
		private ?int $count;

		public function __construct() { }

		/**
		 * @return PostModel[]|null
		 */
		public function getPosts() : ?array { return $this->posts; }

		/**
		 * @param PostModel[]|null $posts
		 *
		 * @return void
		 */
		public function setPosts(?array $posts) : void { $this->posts = $posts; }

		public function getCount() : ?int { return $this->count; }

		public function setCount(?int $count) : void { $this->count = $count; }

		public function getPost() : ?PostModel { return $this->post; }

		public function setPost(?PostModel $post) : void { $this->post = $post; }

		public function getErr() : string { return $this->err; }

		public function setErr(string $err) : void {
			$this->err = $err;
			$this->success = false;
		}

		public function isSuccess() : bool { return $this->success; }
	}
