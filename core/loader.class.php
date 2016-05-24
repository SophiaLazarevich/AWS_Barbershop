<?php

/**
* 
*/
class Loader
{
	function __construct() {}

	public function setPlaceholders($str, $array, $to = '') {
		if (is_array($array) && !empty($array)) {
			foreach ($array as $key => $value) {
				$str = str_replace('{{'.$key.'}}', $value, $str);
			}
		} else {
			$str = str_replace('{{'.$array.'}}', $to, $str);
		}

		return $str;
	}

	public function loadView($path) {
		// Указываем путь к файлу в файловой системе
		$path     = "view/{$path}.tpl";
		$includes = null;

		// Проверяем существование файла в ФС
		if (is_file($path)) {
			// Кэшируем вывод в буфер
			ob_start();
			// Читаем файл из ФС
			include_once $path;
			// Присваиваем вывод переменной
			$output = ob_get_clean();

			// Ищем в файле все вхождения {{include ...}}
			if (preg_match_all('/(?:{{include )(.*?)(?:}})/', $output, $includes)) {
				// Перебираем каждое вхождение
				foreach ($includes[0] as $key => $value) {
					/*
					 * Делаем рекурсивный вызов этой же функции c параметрами для 
					 * Заменяем каждое вхождение на 
					 */
					$output = str_replace($value, $this->loadView($includes[1][$key]), $output);
				}
			}

			return $output;
		} else {
			return "<p>{{File of template does not found: {$path}}}</p>".PHP_EOL;
		}
	}

	public function loadTable($name, $array, $headers = null) {
		$strings = null;
		$cells   = null;
		$header  = null;

		foreach ($array as $value) {
			$cells = null;
			foreach ($value as $v) {
				$cells .= <<< EOT
						<td>{$v}</td>
EOT
.PHP_EOL;
			}
			$cells .= <<< EOT
						<td>
							<a href="#" data-table="{$name}" data-action="edit" data-id="{$value['i']}" data-toggle="modal" data-target="#modal">
								<i class="glyphicon glyphicon-pencil text-info"></i>
							</a>
						</td>
						<td>
							<a href="#" data-table="{$name}" data-action="delete" data-id="{$value['i']}">
								<i class="glyphicon glyphicon-remove text-danger"></i>
							</a>
						</td>
EOT;
			$strings .= <<< EOT
					<tr>
{$cells}					</tr>
EOT
.PHP_EOL;
		}

		$cells = null;

		if (is_array($headers) && !empty($headers)) {
			foreach ($headers as $key => $value) {
				$cells .= <<< EOT
						<td>{$value}</td>
EOT
.PHP_EOL;
			}

			$header = <<< EOT
				<thead>
					<tr>
{$cells}
					</tr>
				</thead>
EOT;
		}

		$output = <<< EOT
			<div class="margin-bottom pull-right">
				<a class="btn btn-success" href="#" data-toggle="modal" data-target="#modal"><i class="glyphicon glyphicon-plus"></i> Добавить</a>
			</div>
			<table class="table table-responsive table-striped table-hover margin-bottom">
{$header}
				<tbody>
{$strings}
				</tbody>
			</table>
EOT;

		return $output;
	}
}
