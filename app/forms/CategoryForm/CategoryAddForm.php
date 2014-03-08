<?

namespace CategoryForm;

class CategoryAddForm extends \Framework\Forms\Form {

	public function initialize() {
		$this->setAction('categories/add');

		// name
		$this->add(new \Framework\Forms\Element\Name());

		// description
		$this->add(new \Framework\Forms\Element\CategoryDescription());

		// submit
		$element = new \Framework\Forms\Element\Submit();
		$element->setDefault('Add');
		$this->add($element);
	}

}
