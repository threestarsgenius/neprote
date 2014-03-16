<?php

class ModerationController extends \Framework\AbstractController {

	const STATUS_MODERATION = 'moderation';
	const INDEX_CONTROLLER = 'index';
	const INDEX_ACTION = 'index';

	public function indexAction() {
		$posts = new Posts;
		$this->view->setVar('posts', $posts->getModerationPosts());
	}

	public function acceptAction() {
		if ($postToAccept = $this->_getExistedPostByID() ) {
			if ($postToAccept->status == self::STATUS_MODERATION) {
				$postToAccept->acceptModeration();
			}
		}
		return $this->_forwardIndexIndex();
	}

	public function declineAction() {
		if ($postToAccept = $this->_getExistedPostByID() ) {
			if ($postToAccept->status == self::STATUS_MODERATION) {
				$postToAccept->declineModeration();
			}
		}
		return $this->_forwardIndexIndex();
	}

	protected function _getExistedPostByID() {
		$filter = new \Phalcon\Filter();
		// get $id from dispatched params
		if ($sanitizedID = $filter->sanitize($this->dispatcher->getParam(0), 'int')) {
			$postsTable = new Posts();
			return $postsTable->getPostByID($sanitizedID);
		}
	}

	protected function _forwardIndexIndex() {
		return $this->dispatcher->forward(
			array('controller' => self::INDEX_CONTROLLER, 'action' => self::INDEX_ACTION)
		);
	}

}
