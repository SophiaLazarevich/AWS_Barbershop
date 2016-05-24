<?php

/**
* 
*/
class Main extends UserTemplate {
	public function render() {
		print_r($this->db->select('customer', array('id')));
	}
}