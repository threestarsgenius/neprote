<?

namespace Framework\Forms\Element;

Class Title extends \Phalcon\Forms\Element\Text {

	const ELEMENT_NAME = 'title';
	const ELEMENT_CLASS = 'form-control';
	const ELEMENT_SIZE = 30;
	const ELEMENT_MAXLENGTH = 70;
	const ELEMENT_LABEL = 'Title';
	const ELEMENT_VALIDATION_MESSAGE = 'Title is required';
	const ELEMENT_STRING_LENGTH_MAX = 70;
	const ELEMENT_STRING_LENGTH_MIM = 3;
	const ELEMENT_STRING_LENGTH_MAX_MESSAGE = 'This title is too long. Please, select another one.';
	const ELEMENT_STRING_LENGTH_MIN_MESSAGE = 'This titke is too short. Please, select another one.';

	public function __construct() {
		parent::__construct(
			self::ELEMENT_NAME, 
			array(
				'class' => self::ELEMENT_CLASS, 
				'size' => self::ELEMENT_SIZE, 
				'maxlength' => self::ELEMENT_MAXLENGTH
			)
		);
		$this->setLabel(self::ELEMENT_LABEL);
		$this->addValidators(array(
				new \Phalcon\Validation\Validator\PresenceOf(array(
						'message' => self::ELEMENT_VALIDATION_MESSAGE)),
				new \Phalcon\Validation\Validator\StringLength(array(
						'max' => 70,
						'min' => 3,
						'messageMaximum' => self::ELEMENT_STRING_LENGTH_MAX_MESSAGE,
						'messageMinimum' => self::ELEMENT_STRING_LENGTH_MAX_MESSAGE ))
		));
	}

}
