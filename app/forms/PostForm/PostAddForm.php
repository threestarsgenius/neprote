<?

namespace PostForm;

class PostAddForm extends \Framework\Forms\Form {

	public function initialize() {
		$this->setAction('posts/add');

		// title
		$this->add(new \Framework\Forms\Element\Title());

		// category
		$this->add(new \Framework\Forms\Element\CategoryID());

		// text
		$this->add(new \Framework\Forms\Element\Text());

		// submit
		$element = new \Framework\Forms\Element\Submit();
		$element->setDefault('Add');
		$this->add($element);
	}

}
