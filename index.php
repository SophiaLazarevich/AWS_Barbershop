<?php

require_once 'config/config.php';
require_once 'core/db.class.php';
require_once 'core/loader.class.php';

@ini_set('display_errors', 0);
header('Content-Type: text/html; charset=UTF-8');

if (!isset($DB_CONNECT_PARAM) || !is_array($DB_CONNECT_PARAM)) {
	echo '<p>Не заданы настройки подключения к базе данных!</p>';
	exit(1);
}

$db     = new DB($DB_CONNECT_PARAM);
$loader = new Loader();

$ajaxHeader = filter_input(
	INPUT_SERVER,
	'HTTP_X_REQUESTED_WITH',
	FILTER_SANITIZE_SPECIAL_CHARS
);
$POST       = filter_input_array(INPUT_POST);
$postAction = $POST['action'];

if(!empty($ajaxHeader) && strtolower($ajaxHeader) == 'xmlhttprequest') {
	switch ($postAction) {
		case 'delete':
			// $db->delete('customer', array('id' => $POST['id']));
			$action = 'удалена';
			break;
		case 'edit':
			$action = 'изменена';
			break;
		default:
			$action = 'не изменена<br>Причина: неизвестное действие';
			break;
	}

	$output = $loader->loadView('notify/default');
	$output = $loader->setPlaceholders(
		$output,
		array(
			'postAction' => $postAction,
			'id'         => $POST['id'],
			'action'     => $action
		)
	);

	print $output;
	die();
}

$output = $loader->loadView('index');

$customers = $db->select(
	'customer',
	array(
		'[><]about' => array(
			'type' => 'id'
		),
	),
	array(
		'customer.id(i)',
		'customer.name(b)',
		'about.type(t)',
		'customer.age (a)'
	)
);

$output = $loader->setPlaceholders(
	$output,
	array(
		'customer' => $loader->loadTable(
			$customers,
			array(
				'№',
				'ФИО',
				'Длина волос',
				'Возраст',
				'',
				'',
			)
		)
	)
);

print $output;
