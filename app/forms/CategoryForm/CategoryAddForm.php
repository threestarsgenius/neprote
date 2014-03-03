<?

namespace CategoryForm;

class CategoryAddForm extends \Phalcon\Forms\Form {

	public function initialize() {
		$this->setAction('categories/add');

		// name
		$element = new \Phalcon\Forms\Element\Text('name', array('class' => 'form-control', 'size' => '30', 'maxlength'=>30));
		$element->setLabel('Name');
		$element->addValidators(array(
				new \Phalcon\Validation\Validator\PresenceOf(array(
						'message' => 'The category name is required')),
		));
		$this->add($element);

		// description
		$element = new \Phalcon\Forms\Element\TextArea('description', array('class' => 'form-control', 'size' => '30', 'maxlength'=>255));
		$element->setLabel('Description');
		$this->add($element);

		// submit
		$element = new \Framework\Forms\Element\Submit();
		$element->setDefault('Add');
		$this->add($element);
	}

}
