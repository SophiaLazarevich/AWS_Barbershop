<?php
/**
* 
*/
class UserTemplate {
	public $db        = null;
	public $router    = null;
	public $loader    = null;
	protected $view   = null;
	protected $output = null;

	function __construct($db, $router, $loader) {
		$this->db     =& $db;
		$this->router =& $router;
		$this->loader =& $loader;

		$this->output = !empty($view)
			? $this->loader->loadView($view)
			: $this->loader->loadView('index');
	}

	public function render() {
		print $this->output;
	}
}
