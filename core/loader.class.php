<?php

/**
* azaazazaz
*/
class Loader
{
	function __construct()
	{
		
	}

	public function setPlaceholders($input, $from, $to) {
		return str_replace('{{'.$from.'}}', $to, $input);
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
