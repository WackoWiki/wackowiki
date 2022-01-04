<?php

if (!defined('IN_WACKO'))
{
	exit;
}

class DbMysqli implements DbInterface
{
	private $dblink;
	private $config;

	function __construct(&$config)
	{
		$this->config = & $config;

		$options = match (DB_ERROR_MODE)
		{
			0	=> MYSQLI_REPORT_OFF,
			1	=> MYSQLI_REPORT_ERROR,
			2	=> MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT,
		};
		mysqli_report($options);

		try
		{
			$this->dblink = new mysqli(
				$config->db_host,
				$config->db_user,
				$config->db_password,
				$config->db_name,
				$config->db_port);

			if ($config->db_charset)
			{
				$this->dblink->set_charset($config->db_charset);
			}
		}
		catch (\mysqli_sql_exception $e)
		{
			die('Error loading WackoWiki DBAL: could not establish database connection.');

			#throw new \mysqli_sql_exception($e->getMessage(), $e->getCode());
		}
	}

	function query($query)
	{
		$result = mysqli_query($this->dblink, $query);

		if (mysqli_connect_errno())
		{
			ob_end_clean();

			if ($this->db->debug > 2)
			{
				die('Query failed: ' . $query . ' (' . mysqli_connect_errno() . ': ' . mysqli_connect_error() . ')');
			}
			else
			{
				die('DBAL error: SQL query failed.');
			}
		}

		return $result;
	}

	function quote($string)
	{
		$string ??= '';

		return mysqli_real_escape_string($this->dblink, $string);
	}

	function free_result($results)
	{
		return mysqli_free_result($results);
	}

	function fetch_assoc($results)
	{
		return mysqli_fetch_assoc($results);
	}

	// $results only required for pdo
	function affected_rows($results)
	{
		return mysqli_affected_rows($this->dblink);
	}

}
