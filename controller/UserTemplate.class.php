<?php
/**
* 
*/
class UserTemplate {
	public $db              = null;
	public $router          = null;
	public $loader          = null;
	public $fields          = array();
	public $urlMatch        = null;
	protected $menu         = null;
	protected $form         = null;
	protected $table        = null;
	protected $query        = null;
	protected $headers      = null;
	protected $view         = null;
	protected $output       = null;
	protected $placeholders = null;

	function __construct($db, $router, $loader) {
		$this->db       =& $db;
		$this->router   =& $router;
		$this->loader   =& $loader;
		$this->urlMatch = $this->router->match();

		foreach ($this->router->routes as $route) {
			$menyElement = null;

			if (!is_callable($route[2]) && isset($route[3]) && !empty($route[3])) {
				$isActive = $this->urlMatch['name'] == $route[3]
					? ' class="active"'
					: null;
				$menyElement = $this->loader->loadView('menu/element');
				$menyElement = $this->loader->setPlaceholders(
					$menyElement,
					array(
						'isActive' => $isActive,
						'url'      => $route[1],
						'name'     => $route[3],
					)
				);
			}
			$this->menu .= $menyElement;
		}

		$this->output = !empty($view)
			? $this->loader->loadView($view)
			: $this->loader->loadView('index');
	}

	public function form($title, $action, $method) {
		foreach ($this->fields as $key => $value) {
			$fields = $this->loader->loadView('fields/'.$value['type']);
			$this->form .= $this->loader->setPlaceholders(
				$fields,
				array(
					'labelName'  => $value['labelName'],
					'labelWidth' => $value['labelWidth'],
					'fieldWidth' => $value['fieldWidth'],
				)
			);
		}

		$form = $this->loader->loadView('form/add');
		return $this->loader->setPlaceholders(
			$form,
			array(
				'title'  => $title,
				'action' => $action,
				'method' => $method,
				'fields' => $this->form,
			)
		);
	}

	public function controller() {}

	public function render() {
		$this->controller();

		if (is_array($this->urlMatch['params']) && !empty($this->urlMatch['params'])) {
			switch ($this->urlMatch['method']) {
				case 'GET':
					header('Content-type: application/json; charset=UTF-8');
					print $this->form('Добавить', '/api/'.$this->table.'/add/', 'POST');
					die();
					break;
				default:
					// print_r($this->urlMatch);
					break;
			}
		}

		$this->placeholders = array(
			'menu'   => $this->menu,
			'render' => $this->loader->loadTable($this->table, $this->query, $this->headers)
		);

		$this->output  = $this->loader->setPlaceholders($this->output, $this->placeholders);
		$this->output .= $this->loader->loadView('form/default');

		print $this->output;
	}
}
