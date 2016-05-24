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

$router->map(
	'POST',
	'/api/[a:action]/[i:id]/',
	function ($action, $id) use (&$loader) {
		switch ($action) {
			case 'delete':
				// $db->delete('customer', array('id' => $POST['id']));
				$reason = ' удалена';
				break;
			case 'edit':
				$reason = ' изменена';
				break;
			default:
				$reason = ' не изменена<br>Причина: неизвестное действие';
				break;
		}

		$output = $loader->loadView('notify/default');
		$output = $loader->setPlaceholders(
			$output,
			array(
				'id'     => $id,
				'action' => $action,
				'reason' => $reason
			)
		);

		print $output;
	}
);

$router->map('GET', '/', 'main#render', 'main');
$match  = $router->match();

if (is_string($match['target']) && strpos($match['target'], '#') !== false) {
	$call = explode('#', $match['target']);
	if ($match && is_callable(array($call[0], $call[1]))) {
		$classname = ucfirst($call[0]);
		$$call[0]  = new $classname($db, $router, $loader);
		call_user_func_array(array($$call[0], $call[1]), $match['params']); 
	} else {
		header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
		print '404 Not Found';
		die();
	}
} elseif (is_object($match['target'])) {
	call_user_func_array($match['target'], $match['params']); 
} else {
	var_dump($match);
}

die();
