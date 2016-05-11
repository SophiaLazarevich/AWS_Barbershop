<?php

include_once 'core/db.class.php';
include_once 'core/loader.class.php';

$db     = new DB();
$loader = new Loader();
$hairstyle = null;
$master    = null;
$tr        = null;
$data      = null;

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	switch ($_POST['action']) {
		case 'delete':
			$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
			$action = 'удалена.';

			$db->delete('customer', $id);
			break;
		case 'edit':
		default:
			$action = 'Действие: изменить';
			break;
	}
	$output = $loader->loadView('formUpdate');

	$output = $loader->setPlaceholders(
		$output,
		'id',
		$_POST['id']
	);
	$output = $loader->setPlaceholders(
		$output,
		'action',
		$action
	);
	print $output;
	die();
}

$output = $loader->loadView('index');

$output = $loader->setPlaceholders(
	$output,
	'customer',
	$db->show('SELECT
			`customer`.`id` as `i`,
			`customer`.`name` as `b`,
			`about`.`type` as `t`,
			`customer`.`Age` as `a`
		FROM `customer`
		INNER JOIN `about`
		ON `customer`.`type` = `about`.`id`;'
	)
);

print $output;
