<?

namespace PostForm;

class PostAddForm extends \Framework\Forms\Form {

	const POST_ADD_ACTION = 'posts/add';
	const FORM_SUBMIT_LABEL = 'Add';

	public function initialize() {
		$this->setAction(self::POST_ADD_ACTION);

		// title
		$this->add(new \Framework\Forms\Element\Title());

		// category
		$this->add(new \Framework\Forms\Element\CategoryID());

		// text
		$this->add(new \Framework\Forms\Element\Text());

		// submit
		$element = new \Framework\Forms\Element\Submit();
		$element->setDefault(self::FORM_SUBMIT_LABEL);
		$this->add($element);
	}

}
