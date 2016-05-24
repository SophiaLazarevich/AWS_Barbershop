<?php

/**
* 
*/
class Order extends UserTemplate {
	protected $table = 'order';

	public function controller() {
		$this->query = $this->db->select(
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

		$this->headers = array(
			'№',
			'ФИО клиента',
			'ФИО мастера',
			'Прическа',
			'Время',
			'Дата',
			'',
			''
		);
	}
}