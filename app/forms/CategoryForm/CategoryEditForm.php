<?

namespace CategoryForm;

class CategoryEditForm extends \Framework\Forms\Form {

	public function initialize() {
		$filter = new \Phalcon\Filter();
		$sanitizedID = $filter->sanitize($this->getEntity()->id, 'int');
		// set form action using sanitized category id
		$this->setAction("categories/edit/$sanitizedID");

		// id
		$element = new \Phalcon\Forms\Element\Hidden('id', array('class' => 'form-control', 'size' => '10', 'maxlength'=>10));
		$this->add($element);

		// name
		$this->add(new \Framework\Forms\Element\Name());

		// description
		$this->add(new \Framework\Forms\Element\CategoryDescription());

		// submit
		$element = new \Framework\Forms\Element\Submit();
		$element->setDefault('Edit');
		$this->add($element);
	}

}
