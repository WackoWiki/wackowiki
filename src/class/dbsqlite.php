<?php

if (!defined('IN_WACKO'))
{
	exit;
}

class DbSqlite implements DbInterface
{
	private $dblink;
	private $config;
	private $result;

	function __construct(&$config)
	{
		$this->config = & $config;

		// Check if the file exists before trying to open it
		if (!file_exists($config->db_name))
		{
			die('Error: Database file ' . $config->db_name . ' does not exist.');
		}

		if (!is_readable($config->db_name) || !is_writeable($config->db_name))
		{
			die('Error: SQLite database file ' . $config->db_name . ' is not writable.');
		}

		try
		{
			$this->dblink = new \SQLite3($config->db_name);

			$this->dblink->enableExceptions(true);
		}
		catch (Exception $e)
		{
			if ($this->config->debug > 2)
			{
				die('Error opening database: ' . $e->getMessage() . ' ' . $e->getCode());
			}
			else
			{
				die('Error loading WackoWiki DBAL: could not establish database connection.');
			}
		}
	}

	function query($query)
	{
		try
		{
			$this->result = $this->dblink->query($query);
		}
		catch (Exception $e)
		{
			ob_end_clean();

			if ($this->config->debug > 2)
			{
				#die('Query failed: ' . $e->getMessage()  . ' (' . $e->getCode() . ') -> ' . $query);
				die('Query failed: ' . $query . ' (' . $this->dblink->lastErrorCode() . ': ' . $this->dblink->lastErrorMsg() . ')');
			}
			else
			{
				die('DBAL error: SQL query failed.');
			}
		}

		return $this->result;
	}

	function quote($string): string
	{
		$string ??= '';

		return $this->dblink->escapeString($string);
	}

	function free_result($results)
	{
		#$this->result->finalize(); // FIXME: fetchArray() The SQLite3Result object has not been correctly initialised or is already closed
	}

	function fetch_assoc($results)
	{
		return $this->result->fetchArray(SQLITE3_ASSOC);
	}

	// $results only required for pdo
	function affected_rows($results)
	{
		return $this->dblink->changes();
	}

}
