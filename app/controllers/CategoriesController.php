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
					&& (!$newCategory->checkCategoryExistsByName($newCategory->name)) ) {
				// create new category
				$newCategory->create(array('user_id' => $this->session->get('auth')->getUserCredentials()['id']));
				return $this->dispatcher->forward(array('controller' => 'categories','action' => 'index'));
			} else {
				// output error message
				$this->view->setVar('category_create_error', 'Can\'t save category with this name');
			}
		}
	}

	public function editAction($id = null) {
		// sanitize $id
		$filter = new \Phalcon\Filter();
		if (!$sanitizedID = $filter->sanitize($id, 'int')) {
			return $this->dispatcher->forward(array('controller' => 'categories','action' => 'index'));
		}
		$categoriesTable = new Categories();
		// check if exist and get category
		if (!$categoryToEdit = $categoriesTable->getCategoryByID($sanitizedID)) {
			return $this->dispatcher->forward(array('controller' => 'categories','action' => 'index'));
		}

		$this->view->setVar('form', new \CategoryForm\CategoryEditForm($categoryToEdit));
		// declare and populate form
		if ($this->getDI()->getRequest()->isPost()) {
			if (!$this->view->form) $this->view->setVar('form', new \CategoryForm\CategoryEditForm());
			$category = (object) Array();
			if ($this->view->form->isValid($this->getDI()->getRequest()->getPost(), $category)
					&& (!$categoriesTable->checkCategoryExistsByName($category->name, $sanitizedID)) ) {
				$categoryToEdit->updateCategory($category);
				return $this->dispatcher->forward(array('controller' => 'categories','action' => 'index'));
			} else {
				// output error message
				$this->view->setVar('category_create_error', 'Can\'t save category with this name');
			}
		} else {
			$this->view->getVar('form')->setAction("categories/edit/$id");
		}
	}

	public function deleteAction($id = null) {
		// sanitize $id
		$filter = new \Phalcon\Filter();
		if (!$sanitizedID = $filter->sanitize($id, 'int')) {
			return $this->dispatcher->forward(array('controller' => 'categories','action' => 'index'));
		}
		$categoriesTable = new Categories();
		// check if category is already deleted
		if ($categoryToDelete = $categoriesTable->getCategoryByID($sanitizedID)) {
			$categoryToDelete->deleteCategory();
		}
		return $this->dispatcher->forward(array('controller' => 'categories','action' => 'index'));
	}

}
