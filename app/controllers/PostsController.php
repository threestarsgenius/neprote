<?php

class PostsController extends \Framework\AbstractController {

	const POST_SAVE_ERROR_MESSAGE = 'Can\'t save post with this name';
	const INDEX_CONTROLLER = 'index';
	const INDEX_ACTION = 'index';

	public function indexAction() {
		$postsTable = new Posts();
		$user_id = $this->session->get('auth')->getUserId();
		$this->view->setVar('posts', $postsTable->getPostsByUserID($user_id));
	}

	public function addAction() {
		if (!$this->view->form) $this->view->setVar('form', new \PostForm\PostAddForm());
		if ($this->getDI()->getRequest()->isPost()) {
			$post = new Posts();
			if ($this->view->form->isValid($this->getDI()->getRequest()->getPost(), $post)) {
				$post->createPost($this->session->get('auth')->getUserId());
				return $this->_forwardIndexIndex();
			} else {
				// output error message
				$this->view->setVar(
					'errors', 
					array_merge(
						array('name' => self::POST_SAVE_ERROR_MESSAGE),
						$this->view->form->getMessages()
					)
				);
			}
		}
	}

	public function editAction() {
		if ($postToEdit = $this->_getExistedPostByID()) {
			// declare and populate form
			$this->view->setVar('form', new \PostForm\PostEditForm($postToEdit));
			if ($this->getDI()->getRequest()->isPost()) {
				$post = new Posts(array('id' => $postToEdit->id));
				if ($this->view->form->isValid($this->getDI()->getRequest()->getPost(), $post) ) {
					$postToEdit->updatePost($post);
					// return $this->_forwardIndexIndex();
				} else {
					// output error message
					$this->view->setVar(
						'errors', 
						array_merge(
							array('name' => self::POST_SAVE_ERROR_MESSAGE),
							$this->view->form->getMessages()
						)
					);
				}
			}
		} 
		if (!$this->view->getVar('errors') && !$postToEdit) {
			return $this->_forwardIndexIndex();
		}
	}

	public function deleteAction() {
		if ($postToDelete = $this->_getExistedPostByID()) {
			$postToDelete->deletePost();
		}
		return $this->_forwardIndexIndex();
	}

	protected function _forwardIndexIndex() {
		return $this->dispatcher->forward(
			array('controller' => self::INDEX_CONTROLLER, 'action' => self::INDEX_ACTION)
		);
	}

	protected function _getExistedPostByID() {
		$filter = new \Phalcon\Filter();
		$sanitizedID = null;
		// get $id from dispatched params
		if (count($this->dispatcher->getParams()) > 0
			&& ($sanitizedID = $filter->sanitize($this->dispatcher->getParams()[0], 'int')) ) {
			$postsTable = new Posts();
			return $postsTable->getPostByID($sanitizedID);
		}
	}

}
