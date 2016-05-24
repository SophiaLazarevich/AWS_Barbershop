<?php

/**
* Class for connect DB
*/
class DB
{
	public $dbserver  = null;
	public $dbname    = null;
	public $dblogin   = null;
	public $dbpass    = null;
	public $connect   = null;

	function __construct()
	{
		$this->dbserver = 'localhost';
		$this->dbname   = 'hairstyle';
		$this->dblogin  = 'hairstyle';
		$this->dbpass   = 'mxCuSLSv4GR6hL49';
		try {
		$this->connect  = new PDO(
			sprintf(
				'mysql:host=%s;dbname=%s',
				$this->dbserver,
				$this->dbname
			),
			$this->dblogin,
			$this->dbpass
		);
		} catch (Exception $e) {
			echo "<p>Не удалось подключиться к серверу базы данных: {$e->getMessage()}<p>";
			exit(1);
		}
	}

	public function delete($value='', $id)
	{
		$result = $this->connect->prepare("DELETE FROM `{$value}` WHERE `id`={$id};");
		$result->execute();

		return $result->rowCount();
	}

	public function query($value='')
	{
		$result = $this->connect->query($value);

		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public function select($FROM)
	{
		$result = $this->connect->query(
			sprintf(
				'SELECT
					*
				FROM `%s`'
				,$FROM
			)
		);

		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public function show($name, $isSelect = false)
	{
		$result = $isSelect
			? $this->select($name)
			: $this->query($name);

		$tr   = null;
		$data = null;

		foreach ($result as $value) {
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

		return <<< EOT
	<table border="1">
{$tr}
	</table>
EOT;
	}
}

