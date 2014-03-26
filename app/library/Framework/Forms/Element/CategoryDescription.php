<?

namespace Framework\Forms\Element;

Class CategoryDescription extends \Phalcon\Forms\Element\TextArea {

	const ELEMENT_NAME = 'description';
	const ELEMENT_CLASS = 'form-control';
	const ELEMENT_SIZE = 30;
	const ELEMENT_MAXLENGTH = 255;
	const ELEMENT_LABEL = 'Description';

	public function __construct() {
		parent::__construct(self::ELEMENT_NAME, array(
			'class' => self::ELEMENT_CLASS, 
			'size' => self::ELEMENT_SIZE, 
			'maxlength'=> self::ELEMENT_MAXLENGTH));
		$this->setLabel(self::ELEMENT_LABEL);
	}

}
