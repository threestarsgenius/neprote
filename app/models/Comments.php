<?php

class Comments extends \Framework\AbstractModel {

	const MAX_COMMENT_DEPTH = 5;

	public $subcomments;

	public function initialize() {
		$this->belongsTo('user_id', 'Users', 'id');
		$this->belongsTo('parent_id', 'Comments', 'id');
		$this->hasMany('parent_id', 'Comments', 'id');
	}

	public function create($data = array(), $whiteList = array()) {
		if (count($data)) $this->assign($data);
		$this->created = time();
		return parent::create($data, $whiteList);
	}

	public function getSortedCommentsForPost($post_id) {
		$comments = self::find(
			array(
				"post_id = :post_id:", 
				"order" => "parent_id,id",
				'bind' => array('post_id' => $post_id)
			) );
		$data = array();
		foreach ($comments as $comment) {
			if (!count($data) || !$comment->parent_id) {
				$data[$comment->id] = $comment;
			}
			else {
				$data = $this->appendItem($data, $comment);
			}
		}
		return $data;
	}

	public function isVisible() {
		$hasComments = false;
		if (is_array($this->subcomments)) {
			foreach ($this->subcomments as $comment) {
				if ($comment->isVisible()) {
					$hasComments = true;
					break;
				}
			}
		}
		return !$this->deleted || $hasComments;
	}

	public function getUsername() {
		$userTable = new \Users();
		return $userTable->getUserByID($this->user_id)->name;
	}

	public function removeCommentByID($comment_id) {
		$comment = self::findFirst(array(
			"conditions" => "id = :comment_id:",
			"bind" => array('comment_id' => $comment_id)
		));
		if (!((bool) $comment)) return false;
		$comment->deleted = time();
		return $comment->save();
	}

	public function appendItem($data, $comment) {
		if (array_key_exists($comment->parent_id, $data)) {
			if (!isset($data[$comment->parent_id]->subcomments)) $data[$comment->parent_id]->subcomments = array();
			$data[$comment->parent_id]->subcomments[$comment->id] = $comment;
		}
		else {
			foreach ($data as $item) {
				if (!isset($item->subcomments)) $item->subcomments = array();
				$item->subcomments = $this->appendItem($item->subcomments, $comment);
			}
		}
		return $data;
	}

}
