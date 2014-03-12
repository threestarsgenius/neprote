<?

namespace Framework\Forms\Element;

Class Title extends \Phalcon\Forms\Element\Text {

	const ELEMENT_NAME = 'title';

	public function __construct() {
		parent::__construct(self::ELEMENT_NAME, array('class' => 'form-control', 'size' => '30', 'maxlength'=>70));
		$this->setLabel(ucfirst(self::ELEMENT_NAME));
		$this->addValidators(array(
				new \Phalcon\Validation\Validator\PresenceOf(array(
						'message' => 'The '.self::ELEMENT_NAME.' is required')),
				new \Phalcon\Validation\Validator\StringLength(array(
						'max' => 70,
						'min' => 3,
						'messageMaximum' => 'This '.self::ELEMENT_NAME.' is too long. Please, select another one.',
						'messageMinimum' => 'This '.self::ELEMENT_NAME.' is too short. Please, select another one.' ))
		));
	}

}
