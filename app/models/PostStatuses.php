<?php

class PostStatuses extends \Phalcon\Mvc\Model {

	public function getPostStatuses() {
		return self::find();
	}

	public function getPostStatusByID($post_status_id) {
		return self::findFirst(
			array(
				'id = :post_status_id:',
				'bind' => array('post_status_id' => $post_status_id)
			)
		);
	}

}
