<?php

/**
* 
*/
class Master extends UserTemplate {
	public function render() {
		$master = $this->db->select(
			'master',
			array(
				'id(i)',
				'name(b)',
				'qualification(q)'
			)
		);

		$this->placeholders = array(
			'render' => $this->loader->loadTable(
				'master',
				$master,
				array(
					'№',
					'ФИО',
					'Квалификация',
					'',
					'',
				)
			)
		);

		parent::render();
	}
}