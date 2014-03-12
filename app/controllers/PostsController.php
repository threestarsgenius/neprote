<?php

class PostsController extends \Framework\AbstractController {

	public function beforeExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher) {
		// Not Authenticated user able to access only to indexAction
		// Trying to get any other action will be forbidden with
		// redirect to posts/index
		if (!$this->session->get('auth')->isAuthenticated()) {
			if ($dispatcher->getActionName() != 'index') {
				$dispatcher->forward(array('controller' => 'posts','action' => 'index'));
				return false;
			}
		}
	}

	public function indexAction() {
		if ($post = $this->_checkIfPostExistByID()) {
			$this->view->setVar('post', $post);
		} else {
			return $this->_forwardIndexIndex();
		}
	}

	public function addAction() {
		if (!$this->view->form) $this->view->setVar('form', new \PostForm\PostAddForm());
		if ($this->getDI()->getRequest()->isPost()) {
			$form = new \PostForm\PostAddForm();
			$post = new Posts();
			if ($this->view->form->isValid($this->getDI()->getRequest()->getPost(), $post)) {
				$post->create(array(
					'user_id' => $this->session->get('auth')->getUserCredentials()['id']
				));
				return $this->_forwardIndexIndex();
			} else {
				// output error message
				$this->view->setVar(
					'errors', 
					array_merge(
						array('name' => 'Can\'t save category with this name'),
						$this->view->form->getMessages()
					)
				);
			}
		}
	}

	public function editAction() {
		if ($postToEdit = $this->_checkIfPostExistByID()) {
			// declare and populate form
			$this->view->setVar('form', new \PostForm\PostEditForm($postToEdit));
			if ($this->getDI()->getRequest()->isPost()) {
				$post = new Posts(array('id' => $postToEdit->id));
				if ($this->view->form->isValid($this->getDI()->getRequest()->getPost(), $post) ) {
					$postToEdit->updatePost($post);
					return $this->_forwardIndexIndex();
				} else {
					// output error message
					$this->view->setVar(
						'errors', 
						array_merge(
							array('name' => 'Can\'t save category with this name'),
							$this->view->form->getMessages()
						)
					);
				}
			}
		} else {
			return $this->_forwardIndexIndex();
		}
	}

	public function deleteAction() {
		if ($postToDelete = $this->_checkIfPostExistByID()) {
			$postToDelete->deletePost();
		}
		return $this->_forwardIndexIndex();
	}

	protected function _forwardIndexIndex() {
		return $this->dispatcher->forward(
			array('controller' => 'index','action' => 'index')
		);
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

}
