<?php

class IndexController extends \Framework\AbstractController {

	public function beforeExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher) {}

	public function indexAction() {
		$posts = new Posts;
		$this->view->setVar('posts', $posts->getPublishPosts());
	}

	public function showAction() {
		if ($post = $this->_checkIfPostExistByID()) {
			$this->view->setVar('post', $post);
		} else {
			return $this->_forwardIndexIndex();
		}
	}

	protected function _checkIfPostExistByID() {
		$filter = new \Phalcon\Filter();
		$sanitizedID = null;
		// get $id from dispatched params
		if (count($this->dispatcher->getParams()) > 0
			&& ($sanitizedID = $filter->sanitize($this->dispatcher->getParams()[0], 'int')) ) {
			$postsTable = new Posts();
			return $postsTable->getPostByID($sanitizedID);
		}
	}

	protected function _forwardIndexIndex() {
		return $this->dispatcher->forward(
			array('controller' => 'index','action' => 'index')
		);
	}

}
