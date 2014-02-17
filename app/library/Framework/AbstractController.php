<?php

namespace Framework;

class AbstractController extends \Phalcon\Mvc\Controller {

	public function beforeExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher) {
		if (!$this->session->get('auth')->isAuthenticated()) {
			$dispatcher->forward(array('controller' => 'user','action' => 'signin'));
			return false;
		}
	}

}