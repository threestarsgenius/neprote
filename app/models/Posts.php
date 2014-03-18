<?php

class Posts extends \Framework\AbstractModel {

	const STATUS_PUBLISH = 'publish';
	const STATUS_DRAFT = 'draft';
	const STATUS_MODERATION = 'moderation';
	const STATUS_TRASH = 'trash';

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
			array("status = '".self::STATUS_PUBLISH."'", 'deleted is NULL', 'order' => 'created desc')
		);
	}

	public function getModerationPosts() {
		return self::find(
			array("status = '".self::STATUS_MODERATION."'", 'deleted is NULL', 'order' => 'created desc')
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

	public function getPostStatuses() {
		return array(
			'publish' => 'publish', 'draft' => 'draft', 
			'moderation' => 'moderation', 'trash' => 'trash'
		);
	}

	public function isRequiredModeration() {
		return $this->status == 'moderation' ? true : false;
	}

	public function getStatus() {
		return $this->status;
	}

}
