<?php

class ApiController extends \Framework\AbstractController {

	public function beforeExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher) {
		//disable view render
		$this->view->disable();
		if (!$this->session->get('auth')->isAuthenticated()) {
			$this->$this->sendResponse("'', 'Unknown error. Please, retry!'");;
			return false;
		}
	}

	public function uploadpostimageAction() {
		$url = '/uploads/'.time()."_".$_FILES['upload']['name'];
		$saveFolder = APP_PATH.'/site'.$url;
		//extensive suitability check before doing anything with the file…
		if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name'])) ) {
			 $message = "No file uploaded.";
		}
		else if ($_FILES['upload']["size"] == 0) {
			 $message = "The file is of zero length.";
		}
		else if (($_FILES['upload']["type"] != "image/pjpeg") 
			AND ($_FILES['upload']["type"] != "image/jpeg") 
			AND ($_FILES['upload']["type"] != "image/png")) {
			 $message = "The image must be in either JPG or PNG format. Please upload a JPG or PNG instead.";
		}
		else if (!is_uploaded_file($_FILES['upload']["tmp_name"])) {
			 $message = "You may be attempting to hack our server. We're on to you; expect a knock on the door sometime soon.";
		}
		else {
			$message = "";
			if(!@move_uploaded_file($_FILES['upload']['tmp_name'], $saveFolder)) {
				 $message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
			}
		}
		$this->sendResponse("'$url', '$message'");
	}

	protected function sendResponse($data) {
		$funcNum = $this->getDI()->getRequest()->get('CKEditorFuncNum');
		echo '<script type=\'text/javascript\'>window.parent.CKEDITOR.tools.callFunction('.$funcNum.', '.$data.');</script>';
	}

	protected function _reportError() {
		echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '', '$message');</script>";
	}

/*	public function uploadpostimageAction() {
		// Allowed extentions (move this to config).
		$allowedExts = array('gif', 'jpeg', 'jpg', 'png');
		$allowedTypes = array('image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png');

		// Get extension.
		$extension = end(explode('.', $_FILES['file']['name']));

		// An image check is being done in the editor but it is best to
		// check that again on the server side.
		if (in_array($_FILES['file']['type'], $allowedTypes) && in_array($extension, $allowedExts)) { 
			// Generate new random name.
			$name = sha1(microtime()) . '.' . $extension;

			// Save file in the uploads folder.
			move_uploaded_file($_FILES['file']['tmp_name'], APP_PATH.'/site/uploads/' . $name);

			// Generate response.
			$response = new StdClass;
			$response->link = '/uploads/' . $name;
			echo stripslashes(json_encode($response));
		}
	}*/

/*	protected function _reportError() {
		$response = new StdClass;
		$response->error = 'Unknown error';
		echo stripslashes(json_encode($response));
	}*/
}