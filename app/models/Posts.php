<?php

class Posts extends \Phalcon\Mvc\Model {

	const STATUS_PUBLISH = 1;
	const STATUS_DRAFT = 2;
	const STATUS_MODERATION = 3;
	const STATUS_TRASH = 4;

	public function createPost($user_id) {
		$this->user_id = $user_id;
		$this->status = self::STATUS_MODERATION;
		$this->created = time();
		$this->save();
	}

	public function updatePost($post) {
		$this->title = $post->title;
		$this->category_id = $post->category_id;
		$this->text = $post->text;
		$this->status = $post->status;
		$this->modified = time();
		$this->update();
	}

	public function deletePost() {
		$this->status = self::STATUS_TRASH;
		$this->deleted = time();
		$this->update();
	}

	public function getPublishPosts() {
		return self::find(
			array('status = 1', 'deleted is NULL', 'order' => 'created desc')
		);
	}

	public function getModerationPosts() {
		return self::find(
			array('status = 3', 'deleted is NULL', 'order' => 'created desc')
		);
	}

	public function getPostByID($post_id) {
		return self::findFirst(
			array(
				"id = :post_id: AND deleted is NULL",
				'bind' => array('post_id' => $post_id)
			)
		);
	}

	public function getPostsByUserID($user_id) {
		return self::find(
			array(
				"user_id = :user_id: AND deleted is NULL",
				'bind' => array('user_id' => $user_id),
				'order' => 'created desc'
			)
		);
	}

	public function acceptModeration() {
		$this->status = self::STATUS_PUBLISH;
		$this->update();
	}

	public function declineModeration() {
		$this->status = self::STATUS_DRAFT;
		$this->update();
	}

	// TODO: move this to abstract model which should be created in future
	public function getUserNameByID() {
		$usersTable = new Users();
		return $usersTable->getUserByID($this->user_id)->name;
	}

	// TODO: move this to abstract model which should be created in future
	public function getCategoryNameByID() {
		$usersTable = new Categories();
		return $usersTable->getCategoryByID($this->category_id)->name;
	}

	// TODO: move this to abstract model which should be created in future
	public function getPostStatusByID() {
		$usersTable = new PostStatuses();
		return $usersTable->getPostStatusByID($this->status)->name;
	}

}
