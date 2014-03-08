<?

namespace CategoryForm;

class CategoryEditForm extends \Framework\Forms\Form {

	public function initialize() {
		$this->setAction("categories/edit/".$this->getEntity()->id);

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
