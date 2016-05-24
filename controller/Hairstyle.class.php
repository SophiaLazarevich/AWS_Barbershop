<?php

/**
* 
*/
class Hairstyle extends UserTemplate {
	protected $table = 'hairstyle';

	public function controller() {
		$this->query = $this->db->select(
			$this->table,
			array(
				'id(i)',
				'name(b)',
				'price(p)',
				'time(t)'
			)
		);

		$this->headers = array(
			'№',
			'Название',
			'Цена',
			'Время',
			'',
			'',
		);
	}
}