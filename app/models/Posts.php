<?php

class Posts extends \Phalcon\Mvc\Model {

	const STATUS_PUBLISH = 1;
	const STATUS_DRAFT = 2;
	const STATUS_MODERATION = 3;
	const STATUS_TRASH = 4;

	public function create($data = array(), $whiteList = array()) {
		if (count($data)) $this->assign($data);
		// TODO: it's temp status. by default it should be moderation
		$this->status = self::STATUS_PUBLISH;
		$this->created = time();
		return parent::create($data, $whiteList);
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
		return self::find('status = 1 AND deleted is NULL');
	}

	public function getPostByID($post_id) {
		return self::findFirst(
			array(
				"id = :post_id: AND deleted is NULL",
				'bind' => array('post_id' => $post_id)
			)
		);
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
