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
		$path     = "tpl/{$path}.tpl";
		$includes = null;

		if (is_file($path)) {
			ob_start();
			include_once $path;
			$output = ob_get_clean();

			if (preg_match_all('/(?:{{include )(.*?)(?:}})/', $output, $includes)) {
				foreach ($includes[0] as $key => $value) {
					$output = str_replace($value, $this->loadView($includes[1][$key]), $output);
				}
			}

			return $output;
		} else {
			return "<p>{{File of template does not found: {$path}}}</p>".PHP_EOL;
		}
	}

	public function loadTable($array, $headers = null) {
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
							<a href="#" data-id="{$value['i']}" data-action="edit" data-toggle="modal" data-target="#modal"><i class="glyphicon glyphicon-pencil text-info"></i></a>
						</td>
						<td>
							<a href="#" data-id="{$value['i']}" data-action="delete"><i class="glyphicon glyphicon-remove text-danger"></i></a>
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
			<table class="table table-responsive table-striped table-hover">
{$header}
				<tbody>
{$strings}
				</tbody>
			</table>
EOT;

		return $output;
	}
}
