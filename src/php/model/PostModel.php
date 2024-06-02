<?php
	namespace php\model
	{

		use DateTime;

		final class PostModel
		{
			private int $id;
			private ?string $title;
			private ?string $text;
			private int $owner_id;
			private int $views;
			private int $total_votes;
			private float $average_score;
			private ?DateTime $creation_date;
			private ?DateTime $last_updated;
			private int $last_update_user_id;
			private bool $hidden;

			public function __construct(
				int $id,
				?string $title,
				?string $text,
				int $owner_id,
				int $views,
				int $total_votes,
				float $average_score,
				?DateTime $creation_date,
				?DateTime $last_updated,
				int $last_update_user_id,
				bool $hidden
			) {
				$this->id = $id;
				$this->title = $title;
				$this->text = $text;
				$this->owner_id = $owner_id;
				$this->views = $views;
				$this->total_votes = $total_votes;
				$this->average_score = $average_score;
				$this->creation_date = $creation_date;
				$this->last_updated = $last_updated;
				$this->last_update_user_id = $last_update_user_id;
				$this->hidden = $hidden;
			}

			public function getId() : int { return $this->id; }

			public function setId(int $id) : void { $this->id = $id; }

			public function getTitle() : ?string { return $this->title; }

			public function setTitle(?string $title) : void { $this->title = $title; }

			public function getText() : ?string { return $this->text; }

			public function setText(?string $text) : void { $this->text = $text; }

			public function getOwnerId() : int { return $this->owner_id; }

			public function setOwnerId(int $owner_id) : void { $this->owner_id = $owner_id; }

			public function getViews() : int { return $this->views; }

			public function setViews(int $views) : void { $this->views = $views; }

			public function getTotalVotes() : int { return $this->total_votes; }

			public function setTotalVotes(int $total_votes) : void { $this->total_votes = $total_votes; }

			public function getAverageScore() : float { return $this->average_score; }

			public function setAverageScore(float $average_score) : void { $this->average_score = $average_score; }

			public function getCreationDate() : ?DateTime { return $this->creation_date; }

			public function setCreationDate(?DateTime $creation_date) : void { $this->creation_date = $creation_date; }

			public function getLastUpdated() : ?DateTime { return $this->last_updated; }

			public function setLastUpdated(?DateTime $last_updated) : void { $this->last_updated = $last_updated; }

			public function getLastUpdateUserId() : int { return $this->last_update_user_id; }

			public function setLastUpdateUserId(int $last_update_user_id) : void {
				$this->last_update_user_id = $last_update_user_id;
			}

			public function isHidden() : bool { return $this->hidden; }

			public function setHidden(bool $hidden) : void { $this->hidden = $hidden; }
		}
	}
