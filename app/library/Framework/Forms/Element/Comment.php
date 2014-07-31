<?

namespace Framework\Forms\Element;

Class Comment extends \Phalcon\Forms\Element\TextArea {

	const ELEMENT_NAME = 'text';

	public function __construct() {
		parent::__construct(self::ELEMENT_NAME, array('class' => 'form-control', 'size' => '30', 'maxlength'=>255));
		$this->setLabel('Comment');
	}

}
