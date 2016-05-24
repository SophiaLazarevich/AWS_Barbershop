<?php
/**
* 
*/
class UserTemplate {
	public $db     = null;
	public $router = null;
	public $loader = null;

	function __construct($db, $router, $loader) {
		$this->db     =& $db;
		$this->router =& $router;
		$this->loader =& $loader;
	}

	public function render() {}
}
