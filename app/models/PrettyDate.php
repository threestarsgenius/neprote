<?php

class PrettyDate extends \Phalcon\Mvc\Model {

	const DAY = 86400;

	public static function prettify($timestamp) {
		$prefix = '';
		switch (true) {
			case date('Ymd') == date('Ymd', $timestamp):
				$dateFormat = 'H:i';break;
			case date('Ymd', time() - self::DAY) == date('Ymd', $timestamp):
				$dateFormat = 'H:i';$prefix = 'Yesterday, ';break;
			case date('Y') == date('Y', $timestamp):
				$dateFormat = 'd M';break;
			default:
				$dateFormat = 'd F Y';
		}
		return $prefix.date($dateFormat, $timestamp);
	}

}
