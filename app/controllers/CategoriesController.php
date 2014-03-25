<?php

class CategoriesController extends \Framework\AbstractController {

	public function initialize() {
		if (!$this->session->get('auth')->isAuthenticated()) {$this->response->redirect("user/signin");}//redirect to index/index page
	}

	public function indexAction() {
		if (!$this->view->addForm) $this->view->setVar('addForm', new \CategoryForm\CategoryAddForm());
		$categoriesTable = new Categories();
		$this->view->setVar('categories', $categoriesTable->getCategories());
	}

	public function addAction() {
		if (!$this->view->addForm) $this->view->setVar('addForm', new \CategoryForm\CategoryAddForm());
		if ($this->getDI()->getRequest()->isPost()) {
			$addForm = new \CategoryForm\CategoryAddForm();
			$newCategory = new Categories();
			if ($this->view->addForm->isValid($this->getDI()->getRequest()->getPost(), $newCategory)
					&& (!$newCategory->checkCategoryExistsByName()) ) {
				// create new category
				$newCategory->create(array('user_id' => $this->session->get('auth')->getUserCredentials()['id']));
				return $this->_forwardCategoriesIndex();
			} else {
				// output error message
				$this->view->setVar('errors', array_merge(array('name' => 'Can\'t save category with this name'),$this->view->addForm->getMessages()));
			}
		}
	}

	public function editAction() {
		// sanitize $id
		$filter = new \Phalcon\Filter();
		// get $id from dispatched params
		$id = $this->dispatcher->getParams()[0];
		if (!$sanitizedID = $filter->sanitize($id, 'int')) {
			return $this->_forwardCategoriesIndex();
		}
		$categoriesTable = new Categories();
		// check if exist and get category
		if (!$categoryToEdit = $categoriesTable->getCategoryByID($sanitizedID)) {
			return $this->_forwardCategoriesIndex();
		}

		$this->view->setVar('form', new \CategoryForm\CategoryEditForm($categoryToEdit));
		// declare and populate form
		if ($this->getDI()->getRequest()->isPost()) {
			$category = new Categories(array('id' => $categoryToEdit->id));
			if ($this->view->form->isValid($this->getDI()->getRequest()->getPost(), $category)
					&& (!$category->checkCategoryExistsByName()) ) {
				$categoryToEdit->updateCategory($category);
				return $this->_forwardCategoriesIndex();
			} else {
				// output error message
				$this->view->setVar('errors', array_merge(array('name' => 'Can\'t save category with this name'),$this->view->form->getMessages()));
			}
		}
	}

	public function deleteAction() {
		// sanitize $id
		$filter = new \Phalcon\Filter();
		// get $id from dispatched params
		$id = $this->dispatcher->getParams()[0];
		if (!$sanitizedID = $filter->sanitize($id, 'int')) {
			return $this->_forwardCategoriesIndex();
		}
		$categoriesTable = new Categories();
		$postsTable = new Posts();
		// check if category is already deleted
		if ( ($categoryToDelete = $categoriesTable->getCategoryByID($sanitizedID))
			&& (count($postsTable->getPostsByCategoryID($sanitizedID)) == 0) ) {
			$categoryToDelete->deleteCategory();
		}
		return $this->_forwardCategoriesIndex();
	}

	protected function _forwardCategoriesIndex() {
		return $this->dispatcher->forward(array('controller' => 'categories','action' => 'index'));
	}

}
