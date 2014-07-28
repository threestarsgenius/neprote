<?php

class CommentsController extends \Framework\AbstractController {

	public function indexAction() {}

	public function addAction() {
		$this->view->disable();
		if($this->request->isPost() && $this->request->isAjax()) {
			if (!$this->view->commentForm) $this->view->setVar('commentForm', new \CommentForm\CommentAddForm());
			$newComment = new \Comments();
			if ($this->view->commentForm->isValid($this->getDI()->getRequest()->getPost(), $newComment) ) {
				$newComment->create(array('user_id' => $this->session->get('auth')->getUserId(), 'depth' => 0));
				$responce = array(
					'id' => $newComment->id,
					'post_id' => $newComment->post_id,
					'parent_id' => $newComment->parent_id,
					'user_from' => $this->view->getVar('escaper')->escapeHtml($newComment->users->name),
					'text' => $this->view->getVar('escaper')->escapeHtml($newComment->text),
					'created' => $this->view->getVar('escaper')->escapeHtml($newComment->created)
				);
				if($newComment->parent_id > 0) {
					$responce['user_to'] = $this->view->getVar('escaper')->escapeHtml($newComment->comments[0]->getUsers()->name);
				}
				$this->_send($responce);
			}
		}
	}

	public function removeAction() {
		$this->view->disable();
		if($this->request->isPost() && $this->request->isAjax()) {
			$comment_id = $this->request->getPost('comment_id', 'int');
			$commentsTable = new \Comments();
			$comment_remove = $commentsTable->removeCommentById($comment_id);
			$this->_send((int) $comment_remove);
		}
	}

	protected function _send($data) {
		echo json_encode($data);
	}

}
