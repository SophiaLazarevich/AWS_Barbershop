<?php

/**
* 
*/
class Order extends UserTemplate {
	public $table = 'order';

	public function render() {
		$order = $this->db->select(
			$this->table,
			array(
				'[><]master'    => array(
					'order.id_master'    => 'id'
				),
				'[><]hairstyle' => array(
					'order.id_hairstyle' => 'id'
				),
				'[><]customer'  => array(
					'order.id_customer'  => 'id'
				)
			),
			array(
				'order.id(i)',
				'customer.name(c)',
				'master.name(m)',
				'hairstyle.name(h)',
				'order.time(t)',
				'order.dateday(d)'
			)
		);

		$this->placeholders = array(
			'render' => $this->loader->loadTable(
				$this->table,
				$order,
				array(
					'№',
					'ФИО клиента',
					'ФИО мастера',
					'Прическа',
					'Время',
					'Дата',
					'',
					''
				)
			)
		);

		parent::render();
	}
}