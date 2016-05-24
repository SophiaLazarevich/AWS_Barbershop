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

$ajaxHeader = filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH', FILTER_SANITIZE_SPECIAL_CHARS);
$POST   = filter_input_array(INPUT_POST);
$postAction = $POST['action'];

if(!empty($ajaxHeader) && strtolower($ajaxHeader) == 'xmlhttprequest') {
	switch ($postAction) {
		case 'delete':
			// $db->delete('customer', array('id' => $POST['id']));
			$action = 'удалена';
			break;
		case 'edit':
		default:
			$action = 'изменена';
			break;
	}

	$output = $loader->loadView('notify/'.$postAction);
	$output = $loader->setPlaceholders(
		$output,
		array(
			'id'         => $POST['id'],
			'action'     => $action,
			'postAction' => $postAction
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

$data = null;
$tr   = null;
foreach ($customers as $value) {
	$data = null;
	foreach ($value as $v) {
		$data .= <<< EOT
				<td>{$v}</td>
EOT
.PHP_EOL;
	}
	$data .= <<< EOT
				<td>
					<a href="#" data-id="{$value['i']}" data-action="edit"><i class="glyphicon glyphicon-pencil text-info"></i></a>
				</td>
				<td>
					<a href="#" data-id="{$value['i']}" data-action="delete"><i class="glyphicon glyphicon-remove text-danger"></i></a>
				</td>
EOT;
	$tr .= <<< EOT
			<tr>
{$data}
			</tr>
EOT
.PHP_EOL;
}

$customers = <<< EOT
<table class="table table-responsive table-striped table-hover">
		<thead>
			<tr>
				<td class="text-center">№</td>
				<td class="text-center">ФИО</td>
				<td>Длина волос</td>
				<td>Возраст</td>
				<td></td>
				<td></td>
			</tr>
		</thead>
		<tbody>
{$tr}
		</tbody>
	</table>
EOT;

$output = $loader->setPlaceholders(
	$output,
	array(
		'customer' => $customers,
	)
);

print $output;
