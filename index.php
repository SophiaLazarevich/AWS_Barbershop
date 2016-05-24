<?php

require_once 'config/config.php';
require_once 'core/db.class.php';
require_once 'core/loader.class.php';

@ini_set('display_errors', 0);
header('Content-Type: text/html; charset=UTF-8');

$db     = new DB($DB_CONNECT_PARAM);
$loader = new Loader();

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	switch ($_POST['action']) {
		case 'delete':
			$action = 'удалена.';

			$db->delete('customer', array('id' => $id));
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

// print_r($customers);
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
			<td><a href="#" data-id="{$value['i']}" data-action="edit">Изменить</a></td>
			<td><a href="#" data-id="{$value['i']}" data-action="delete">Удалить</a></td>
EOT;
	$tr .= <<< EOT
		<tr>
{$data}
		</tr>
EOT;
}

$customers = <<< EOT
<table border="1">
{$tr}
	</table>
EOT;

$output = $loader->setPlaceholders(
	$output,
	'customer',
	$customers
);

print $output;
// var_dump($db->log());
