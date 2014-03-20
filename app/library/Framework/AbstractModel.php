<?php

namespace Framework;

class AbstractModel extends \Phalcon\Mvc\Model {

	public function getUserNameByID() {
		$usersTable = new \Users();
		return $usersTable->getUserByID($this->user_id)->name;
	}

}
