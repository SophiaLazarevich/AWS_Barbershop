<?php

include_once 'core/db.class.php';
include_once 'core/loader.class.php';

@ini_set('display_errors', 0);
header('Content-Type: text/html; charset=UTF-8');

$db     = new DB();
$loader = new Loader();
$hairstyle = null;
$master    = null;
$tr        = null;
$data      = null;

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	switch ($_POST['action']) {
		case 'delete':
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
		array(
			'id'     => $id,
			'action' => $action,
		)
	);

	print $output;
	die();
}

$output = $loader->loadView('index');

$output = $loader->setPlaceholders(
	$output,
	'customer',
	$db->show('SELECT
			`customer`.`id`   AS `i`,
			`customer`.`name` AS `b`,
			`about`.`type`    AS `t`,
			`customer`.`age`  AS `a`
		FROM `customer`
		INNER JOIN `about`
		ON `customer`.`type` = `about`.`id`;'
	)
);

print $output;
