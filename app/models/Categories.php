<?php

class Categories extends \Phalcon\Mvc\Model {

	public function create($data = array(), $whiteList = array()) {
		if (count($data)) $this->assign($data);
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
		$this->save();
	}

	public function getCategories() {
		return self::find('deleted is NULL');
	}

	public function getCategoryByID($category_id) {
		return self::findFirst(array('id = :category_id: AND deleted is NULL', 'bind' => array('category_id' => $category_id)));
	}

	public function checkCategoryExistsByName($category_name, $id = 0) {
		if ($id > 0) {
			return self::findFirst(array('name = :category_name: AND deleted is NULL AND id != :id:', 'bind' => array('category_name' => $category_name, 'id' => $id)));
		} else {
			return self::findFirst(array('name = :category_name: AND deleted is NULL', 'bind' => array('category_name' => $category_name)));
		}
	}

	public function getUserNameByID() {
		$usersTable = new Users();
		return $usersTable->getUserByID($this->user_id)->name;
	}

	public function getCountCategories() {
		return self::count(self::getCategories());
	}

}
