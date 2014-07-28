<?php

class PrettyDate extends \Phalcon\Mvc\Model {

	const DAY = 86400;
	const YEAR = 31536000;

	public static function prettify($timestamp) {
		$now = time();
		$diff = $now - $timestamp;
		if ($diff < self::DAY) {
			$append = '';
			if (date("d",$now) > date("d",$timestamp)) $append = 'Yesterday ';
			$pretty_date = $append;
			$pretty_date .= date("H:i", $timestamp);
		} elseif(($diff > self::DAY) && ($diff < self::YEAR)) {
			$pretty_date = date("d M", $timestamp);
		} elseif($diff > self::YEAR) {
			$pretty_date = date("d F Y", $timestamp);
		} else {
			$pretty_date = 1;
		}
		return $pretty_date;
	}

}