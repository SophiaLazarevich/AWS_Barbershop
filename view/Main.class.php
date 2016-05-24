<?php

/**
* 
*/
class Main extends UserTemplate {
	public function render() {
		$customer = $this->db->select(
			'customer',
			array(
				'[><]about' => array(
					'type' => 'id'
				),
			),
			array(
				'customer.id(i)',
				'customer.name(b)',
				'about.type(t)',
				'customer.age (a)'
			)
		);

		$placeholders = array(
			'customer' => $this->loader->loadTable(
				$customer,
				array(
					'№',
					'ФИО',
					'Длина волос',
					'Возраст',
					'',
					'',
				)
			)
		);

		$this->output  = $this->loader->setPlaceholders(
			$this->output,
			$placeholders
		);

		$this->output .= $this->loader->loadView('form/edit');

		parent::render();
	}
}