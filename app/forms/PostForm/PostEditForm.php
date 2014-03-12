<?

namespace PostForm;

class PostEditForm extends \Framework\Forms\Form {

	public function initialize() {
		$this->setAction('posts/edit/'.$this->getEntity()->id);

		// id
		$element = new \Phalcon\Forms\Element\Hidden('id', array('class' => 'form-control', 'size' => '10', 'maxlength'=>10));
		$this->add($element);

		// title
		$this->add(new \Framework\Forms\Element\Title());

		// category
		$this->add(new \Framework\Forms\Element\CategoryID());

		// status
		$element = new \Phalcon\Forms\Element\Select('status', (new \PostStatuses())->getPostStatuses(), array('using' => array('id', 'name')));
		$element->setLabel('Status');
		$element->addValidators(array(
				new \Phalcon\Validation\Validator\PresenceOf(array(
						'message' => 'Status is required'))
		));
		$this->add($element);

		// text
		$this->add(new \Framework\Forms\Element\Text());

		// submit
		$element = new \Framework\Forms\Element\Submit();
		$element->setDefault('Edit');
		$this->add($element);
	}

}
