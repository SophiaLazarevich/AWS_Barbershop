<?php

/**
* 
*/
class Customer extends UserTemplate {
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
				'customer.age(a)'
			)
		);

		$this->placeholders = array(
			'render' => $this->loader->loadTable(
				'customer',
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

		parent::render();
	}
}