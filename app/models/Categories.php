<?php

class Categories extends \Phalcon\Mvc\Model {

	public function create($data = array(), $whiteList = array()) {
		if (count($data)) $this->assign($data);
		if (!isset($this->description) || (!$this->description)) unset($this->description);
		$this->created = time();
		return parent::create($data, $whiteList);
	}

	public function updateCategory($category) {
		$this->name = $category->name;
		if (isset($category->description)) $this->description = $category->description;
		$this->modified = time();
		$this->update();
	}

	public function deleteCategory() {
		$this->deleted = time();
		$this->update();
	}

	public function getCategories() {
		return self::find('deleted is NULL');
	}

	public function getCategoryByID($category_id) {
		return self::findFirst(
			array(
				'id = :category_id: AND deleted is NULL',
				'bind' => array('category_id' => $category_id)
			)
		);
	}

	public function checkCategoryExistsByName() {
		$bind = array_merge(
			array('category_name' => $this->name),
			isset($this->id) ? array('id' => $this->id) : array()
		);
		$params = array(
			'name = :category_name: AND deleted is NULL'.(isset($this->id) ? ' AND id != :id:' : ''),
			'bind' => $bind
		);
		return self::findFirst($params);
	}

	public function getUserNameByID() {
		$usersTable = new Users();
		return $usersTable->getUserByID($this->user_id)->name;
	}

}
