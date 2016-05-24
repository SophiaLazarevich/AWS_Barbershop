<?php

/**
* 
*/
class Hairstyle extends UserTemplate {
	public function render() {
		$hairstyle = $this->db->select(
			'hairstyle',
			array(
				'id(i)',
				'name(b)',
				'price(p)',
				'time(t)'
			)
		);

		$this->placeholders = array(
			'render' => $this->loader->loadTable(
				'hairstyle',
				$hairstyle,
				array(
					'№',
					'Название',
					'Цена',
					'Время',
					'',
					'',
				)
			)
		);

		parent::render();
	}
}