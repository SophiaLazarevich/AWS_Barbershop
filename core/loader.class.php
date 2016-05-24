<?php

/**
* 
*/
class Loader
{
	function __construct() {}

	public function setPlaceholders($str, $array, $to = '') {
		if (is_array($array)) {
			foreach ($array as $key => $value) {
				$str = str_replace('{{'.$key.'}}', $value, $str);
			}
		} else {
			$str = str_replace('{{'.$array.'}}', $to, $str);
		}

		return $str;
	}

	public function loadView($path) {
		$path = 'tpl/'.$path.'.tpl';
		if (is_file($path)) {
			ob_start();
			include_once $path;
			return ob_get_clean();
		}
	}
}
