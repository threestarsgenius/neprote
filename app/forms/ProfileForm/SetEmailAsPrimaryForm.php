<?

namespace ProfileForm;

class SetEmailAsPrimaryForm extends \Phalcon\Forms\Form {

	public function initialize() {
		$this->setAction('profile/setprimaryemail');

		$element = new \Phalcon\Forms\Element\Text('id');
		$element->addValidators(array(
				new \Phalcon\Validation\Validator\PresenceOf(),
				new \Phalcon\Validation\Validator\Regex(array(
						'pattern' => '/([0-9]+)/' )) ));
		$this->add($element);

	}

}
