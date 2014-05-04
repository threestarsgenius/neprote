<?php

class ApiController extends \Framework\AbstractController {

	const UPLOAD_FILE_TOO_BIG = 'The file is too big. Allowed size limit is 1mb.';
	const UPLOAD_WRONG_IMAGE_FORMAT = 'The image must be in either JPG or PNG format. Please upload a JPG or PNG instead.';
	const UPLOAD_NOT_VIA_POST = 'You may be attempting to hack our server. We\'re on to you; expect a knock on the door sometime soon.';
	const UPLOAD_CHECK_SCRIPT_PERMISSIONS = 'Oops something went wrong. But we still love you! Please try one more time.';

	public function beforeExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher) {
		//disable view render
		$this->view->disable();
		if (!$this->session->get('auth')->isAuthenticated()) return false;
	}

	public function indexAction() {}

	public function uploadpostimageAction() {
		// extensive suitability check before doing anything with the file…
		if (!$this->request->hasFiles()) return false;
		// get upload file data
		$file = $this->request->getUploadedFiles()[0]; // [0] because we don't use multyupload feature
		// prepare paths
		$url = $this->getDI()->get('config')->upload_file->upload_directory.'/'.time()."_".$file->getName();
		$saveFolder = APP_PATH.'/site'.$url;
		// file size must me less than 1mb
		if ($file->getSize() > $this->getDI()->get('config')->upload_file->max_size) {
			$message = self::UPLOAD_FILE_TOO_BIG;
		}
		// check file type and extesion
		else if (!in_array($file->getType(), $this->getDI()->get('config')->upload_file->types->toArray()) 
			&& !in_array(end(explode('.', $file->getName())), $this->getDI()->get('config')->upload_file->extensions->toArray()) ) {
			$message = self::UPLOAD_WRONG_IMAGE_FORMAT;
		}
		// checks whether the file has been uploaded via Post
		else if (!$file->isUploadedFile($file->getTempName())) {
			$message = self::UPLOAD_NOT_VIA_POST;
		}
		// try to move the temporary file to a destination within the application
		else {
			$message = "";
			if(!@$file->moveTo($saveFolder)) {
				$message = self::UPLOAD_CHECK_SCRIPT_PERMISSIONS;
			}
		}
		// send script responce with result
		if ($message) $url = '';
		$this->_sendResponse("'$url', '$message'");
	}

	protected function _sendResponse($data) {
		$funcNum = $this->getDI()->getRequest()->get('CKEditorFuncNum');
		echo '<script type=\'text/javascript\'>window.parent.CKEDITOR.tools.callFunction('.$funcNum.', '.$data.');</script>';
	}

}
