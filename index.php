<?php

require_once __DIR__.'/config/config.php';
require_once __DIR__.'/core/Db.class.php';
require_once __DIR__.'/core/Router.class.php';
require_once __DIR__.'/core/Loader.class.php';
require_once __DIR__.'/controller/UserTemplate.class.php';

@ini_set('display_errors', 1);
header('Content-Type: text/html; charset=UTF-8');

if (!isset($DB_CONNECT_PARAM) || !is_array($DB_CONNECT_PARAM)) {
	echo '<p>Не заданы настройки подключения к базе данных!</p>';
	exit(1);
}

/*
 * Создаем объект подключения к базе данных. Используем драйвер PDO
 * Параметры подключения берутся из конфига
 */
$db     = new DB($DB_CONNECT_PARAM);

// Класс, отвечающий за роутинг (разбор URL адреса и реализацию REST API) http://altorouter.com
$router = new Router();

$loader = new Loader();

$router->map(
	'DELETE',
	'/api/[a:table]/[a:action]/[i:id]/',
	function ($table, $action, $id) use (&$loader) {
		// $db->delete($table, array('id' => $id));
		$reason = ' удалена';

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

$router->map(
	'POST',
	'/api/[a:table]/[a:action]/[i:id]/',
	function ($table, $action, $id) use (&$loader) { // анонимная функция, выполнится при совпадений условий
		switch ($action) {
			case 'delete':
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

// Правило map отвечает за то, какой метод будет обрабатывать данный url
$router->map('GET|POST|PATCH|PUT|DELETE', '/',          'order#controller',     'order');
$router->map('GET|POST|PATCH|PUT|DELETE', '/customer',  'customer#controller',  'customer');
$router->map('GET|POST|PATCH|PUT|DELETE', '/master',    'master#controller',    'master');
$router->map('GET|POST|PATCH|PUT|DELETE', '/hairstyle', 'hairstyle#controller', 'hairstyle');

// Метод match() проверяет все правила адресации на совпадения
$match  = $router->match();

if (is_string($match['target']) && strpos($match['target'], '#') !== false) {
	$call      = explode('#', $match['target']); // explode разбивает сроку по символу #, получаем массив
	$classname = ucfirst($call[0]); // делаем заглавной первую букву 0-го элемента массива
	require __DIR__."/controller/{$classname}.class.php"; // подключаем файл, к которому указан путь
	$$call[0]  = new $classname($db, $router, $loader); // передаем объекты $db, $router, $loader как параметры в конструктор
	if ($match && is_callable(array($call[0], $call[1]))) {
		call_user_func_array(array($$call[0], $call[1]), $match['params']); // Вызывает пользовательский метод c параметрами
	} else {
		header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
		echo '404 Not Found';
		die();
	}
} elseif (is_object($match['target'])) {
	call_user_func_array($match['target'], $match['params']); // вместо объекта и метода передается только объект (анонимная функция)
} else {
	var_dump($match);
}

