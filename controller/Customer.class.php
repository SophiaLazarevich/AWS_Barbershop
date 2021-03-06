<?php

/**
* 
*/
class Customer extends UserTemplate {
	protected $table = 'customer';

	public function controller() { //форма добавления полей
		$this->fields = array(
			'i' => array(
				'type'       => 'id',
				'labelName'  => '№',
				'labelWidth' => 3,
				'fieldWidth' => 9,
			),
			'b' => array(
				'type'      => 'text',
				'labelName' => 'ФИО',
				'labelWidth' => 3,
				'fieldWidth' => 9,
			),
			't' => array(
				'type'      => 'select',
				'labelName' => 'Длина волос',
				'labelWidth' => 3,
				'fieldWidth' => 9,
				'options'   => 'SELECT * FROM `about` ORDER BY `id` ASC;'
			),
			'a' => array(
				'type'      => 'number',
				'labelName' => 'Возраст',
				'labelWidth' => 3,
				'fieldWidth' => 9,
				'fieldValue' => 234,
			),
		);

		$this->query  = $this->db->select( //запрос к БД, представляет из себя простейшую модель
			$this->table,
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

		$this->headers = array( //задаются названия столбцов
			'№',
			'ФИО',
			'Длина волос',
			'Возраст',
			'',
			'',
		);
	}
}