<?php

class IndexController extends \Framework\AbstractController {

	public function indexAction() {
		$posts = new Posts;
		$this->view->setVar('posts', $posts->getPublishPosts());
	}

	public function showAction() {
		$filter = new \Phalcon\Filter();
		// get $id from dispatched params
		if ($sanitizedID = $filter->sanitize($this->dispatcher->getParam(0), 'int')) {
			$postsTable = new Posts();
			$this->view->setVar('post', $postsTable->getPostByID($sanitizedID));
			$this->view->setVar('commentForm', new \CommentForm\CommentAddForm());
			$commentsTable = new Comments();
			$postComments = $commentsTable->getSortedCommentsForPost($this->view->getVar('post')->id);
			$this->view->setVar('comments',$postComments);
		}
		if (!$this->view->getVar('post')) {
			return $this->_forwardIndexIndex();
		}
	}

	protected function _forwardIndexIndex() {
		return $this->dispatcher->forward(
			array('controller' => 'index','action' => 'index')
		);
	}

}
