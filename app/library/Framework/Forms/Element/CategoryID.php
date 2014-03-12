<?

namespace Framework\Forms\Element;

Class CategoryID extends \Phalcon\Forms\Element\Select {

	const ELEMENT_NAME = 'category_id';

	public function __construct() {
		parent::__construct(self::ELEMENT_NAME, (new \Categories())->getCategories(), array('using' => array('id', 'name')));
		$this->setLabel(ucfirst(self::ELEMENT_NAME));
		$this->addValidators(array(
				new \Phalcon\Validation\Validator\PresenceOf(array(
						'message' => self::ELEMENT_NAME.' is required'))
		));
	}

}
