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

$isAjax = filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH', FILTER_SANITIZE_SPECIAL_CHARS);
$POST   = filter_input_array(INPUT_POST);
$postAction = $POST['action'];

if(!empty($isAjax) && strtolower($isAjax) == 'xmlhttprequest') {
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
EOT;
	}
	$data .= <<< EOT
			<td><a href="#" data-id="{$value['i']}" data-action="edit"><i class="glyphicon glyphicon-pencil text-info"></a></td>
			<td><a href="#" data-id="{$value['i']}" data-action="delete"><i class="glyphicon glyphicon-remove text-danger"></i></a></td>
EOT;
	$tr .= <<< EOT
		<tr>
{$data}
		</tr>
EOT;
}

$customers = <<< EOT
<table class="table table-striped table-hover">
{$tr}
	</table>
EOT;

$output = $loader->setPlaceholders(
	$output,
	'customer',
	$customers
);

print $output;
