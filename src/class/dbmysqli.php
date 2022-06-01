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

		$this->dblink = mysqli_connect($config->db_host, $config->db_user, $config->db_password, $config->db_name, $config->db_port);

		if (!$this->dblink)
		{
			die('Error loading WackoWiki DBAL: could not establish database connection.');
		}

		if ($config->db_charset)
		{
			mysqli_set_charset($this->dblink, $config->db_charset);
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
