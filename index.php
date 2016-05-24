<?php

require_once __DIR__.'/config/config.php';
require_once __DIR__.'/core/Db.class.php';
require_once __DIR__.'/core/Router.class.php';
require_once __DIR__.'/core/Loader.class.php';
require_once __DIR__.'/view/UserTemplate.class.php';
require_once __DIR__.'/view/Main.class.php';

@ini_set('display_errors', 1);
header('Content-Type: text/html; charset=UTF-8');

if (!isset($DB_CONNECT_PARAM) || !is_array($DB_CONNECT_PARAM)) {
	echo '<p>Не заданы настройки подключения к базе данных!</p>';
	exit(1);
}

$db     = new DB($DB_CONNECT_PARAM);
$router = new Router();
$loader = new Loader();

$router->map('GET', '/', 'main#render', 'main');
$match  = $router->match();

$call   = explode('#', $match['target']);
if ($match && is_callable(array($call[0], $call[1]))) {
	$classname = ucfirst($call[0]);
	$$call[0]  = new $classname($db, $router, $loader);
	call_user_func_array(array($$call[0], $call[1]), $match['params']); 
} else {
	// no route was matched
	header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
	print '404 Not Found';
	die();
}

// print $router->generate('main');

die();

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
