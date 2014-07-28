<?

namespace CommentForm;

class CommentAddForm extends \Framework\Forms\Form {

	const ELEMENT_VALIDATORS_REGEXP_PATTERN = '/([0-9]+)/';

	public function initialize() {
		$this->setAction('comments/add');

		// post id
		$element = new \Phalcon\Forms\Element\Hidden('post_id');
		$element->addValidators(array(
				new \Phalcon\Validation\Validator\Regex(array(
						'pattern' => self::ELEMENT_VALIDATORS_REGEXP_PATTERN )) ));
		$this->add($element);

		// parent id
		$element = new \Phalcon\Forms\Element\Hidden('parent_id');
		$element->addValidators(array(
				new \Phalcon\Validation\Validator\Regex(array(
						'pattern' => self::ELEMENT_VALIDATORS_REGEXP_PATTERN )) ));
		$this->add($element);

		// name
		$this->add(new \Framework\Forms\Element\Comment());

		// submit
		$element = new \Framework\Forms\Element\Submit();
		$element->setDefault('Add');
		$this->add($element);
	}

}
