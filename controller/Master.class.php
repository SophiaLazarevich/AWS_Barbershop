<?php

/**
* 
*/
class Master extends UserTemplate {
	protected $table = 'master';

	public function controller() {
		$this->query = $this->db->select(
			$this->table,
			array(
				'id(i)',
				'name(b)',
				'qualification(q)'
			)
		);

		$this->headers = array(
			'№',
			'ФИО',
			'Квалификация',
			'',
			'',
		);
	}
}