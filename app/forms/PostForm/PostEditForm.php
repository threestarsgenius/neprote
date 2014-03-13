<?

namespace PostForm;

class PostEditForm extends \Framework\Forms\Form {

	const POST_EDIT_ACTION = 'posts/edit/';
	const HIDDEN_ID_NAME = 'id';
	const HIDDEN_ID_MAXLENGTH = 10;
	const STATUS_ELEMENT_NAME = 'status';
	const STATUS_ELEMENT_LABEL = 'Status';
	const STATUS_ELEMENT_VALIDATION_MESSAGE = 'Status is required';
	const FORM_SUBMIT_LABEL = 'Edit';

	public function initialize() {
		$this->setAction(self::POST_EDIT_ACTION.$this->getEntity()->id);

		// id
		$this->add(new \Phalcon\Forms\Element\Hidden(
			self::HIDDEN_ID_NAME, 
			array('maxlength' => self::HIDDEN_ID_MAXLENGTH))
		);

		// title
		$this->add(new \Framework\Forms\Element\Title());

		// category
		$this->add(new \Framework\Forms\Element\CategoryID());

		// status
		$element = new \Phalcon\Forms\Element\Select(
			self::STATUS_ELEMENT_NAME, 
			(new \PostStatuses())->getPostStatuses(), array('using' => array('id', 'name'))
		);
		$element->setLabel(self::STATUS_ELEMENT_LABEL);
		$element->addValidators(array(
				new \Phalcon\Validation\Validator\PresenceOf(array(
						'message' => self::STATUS_ELEMENT_VALIDATION_MESSAGE))
		));
		$this->add($element);

		// text
		$this->add(new \Framework\Forms\Element\Text());

		// submit
		$element = new \Framework\Forms\Element\Submit();
		$element->setDefault(self::FORM_SUBMIT_LABEL);
		$this->add($element);
	}

}
