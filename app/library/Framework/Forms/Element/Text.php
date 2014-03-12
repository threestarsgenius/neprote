<?

namespace Framework\Forms\Element;

Class Text extends \Phalcon\Forms\Element\TextArea {

	const ELEMENT_NAME = 'text';

	public function __construct() {
		parent::__construct(self::ELEMENT_NAME, array('class' => 'form-control', 'size' => '30'));
		$this->setLabel(ucfirst(self::ELEMENT_NAME));
		$this->addValidators(array(
				new \Phalcon\Validation\Validator\PresenceOf(array(
						'message' => self::ELEMENT_NAME.' is required'))
		));
	}

}
