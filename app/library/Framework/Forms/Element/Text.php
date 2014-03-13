<?

namespace Framework\Forms\Element;

Class Text extends \Phalcon\Forms\Element\TextArea {

	const ELEMENT_NAME = 'text';
	const ELEMENT_CLASS = 'form-control';
	const ELEMENT_SIZE = 30;
	const ELEMENT_VALIDATION_MESSAGE = 'Text is required';

	public function __construct() {
		parent::__construct(
			self::ELEMENT_NAME, 
			array('class' => self::ELEMENT_CLASS, 'size' => self::ELEMENT_SIZE)
		);
		$this->setLabel(ucfirst(self::ELEMENT_NAME));
		$this->addValidators(array(
				new \Phalcon\Validation\Validator\PresenceOf(array(
						'message' => self::ELEMENT_VALIDATION_MESSAGE))
		));
	}

}
