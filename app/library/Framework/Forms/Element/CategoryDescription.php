<?

namespace Framework\Forms\Element;

Class CategoryDescription extends \Phalcon\Forms\Element\TextArea {

	const ELEMENT_NAME = 'description';

	public function __construct() {
		parent::__construct(self::ELEMENT_NAME, array('class' => 'form-control', 'size' => '30', 'maxlength'=>255));
		$this->setLabel('Description');
	}

}
