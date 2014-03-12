<?php

class IndexController extends \Framework\AbstractController {

	public function beforeExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher) {}

	public function indexAction() {
		$posts = new Posts;
		$this->view->setVar('posts', $posts->getPublishPosts());
	}

}
