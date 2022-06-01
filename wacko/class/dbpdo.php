<?php

if (!defined('IN_WACKO'))
{
	exit;
}

class DbPDO implements DbInterface
{
	private $config;
	private $dblink;

	function __construct(&$config)
	{
		$this->config = & $config;
		$driver = $config->db_driver;

		if ($driver == 'mysql_pdo')
		{
			$driver = 'mysql';
		}

		$dsn = $driver . ':';

		$dsn .= match ($driver)
		{
			'pgsql'		=> 'host=' . $config->db_host . ';port=' . $config->db_port . ';dbname=' . $config->db_name,
			'sqlite'	=> $config->db_name,
			default		=> 'host=' . $config->db_host .
						($config->db_port ?
							';port=' . $config->db_port : '') .
						';dbname=' . $config->db_name .
						($config->db_charset ?
							';charset=' . $config->db_charset : ''),
		};

		$options = match (DB_ERROR_MODE)
		{
			0	=> [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT],
			1	=> [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING],
			2	=> [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
		};

		try
		{
			$this->dblink = new PDO(
				$dsn,
				$config->db_user,
				$config->db_password,
				$options);
		}
		catch (PDOException $e)
		{
			die('PDO DSN Error: ' . $e->getMessage());
		}
	}

	function query($query)
	{
		$result = $this->dblink->query($query);

		if ($result)
		{
			if ($result->errorCode() != '00000')
			{
				ob_end_clean();

				if ($this->db->debug > 2)
				{
					die('Query failed: ' . $query . ' (' . $result->errorCode() . ': ' . $result->errorInfo() . ')');
				}
				else
				{
					die('DBAL error: SQL query failed.');
				}
			}
		}

		return $result;
	}

	function quote($string)
	{
		$string ??= '';

		// return $dblink->quote($string);

		// Manually string quoting since pdo::quote is double escaping single quotes which is causing chaos
		// Got this from: http://www.gamedev.net/community/forums/topic.asp?topic_id=448909
		// More reading: http://www.sitepoint.com/forums/showthread.php?t=337881
		return strtr($string, [
			"\x00"	=> '\x00',
			"\n"	=> '\n',
			"\r"	=> '\r',
			'\\'	=> '\\\\',
			"'"		=> "\'",
			'"'		=> '\"',
			"\x1a"	=> '\x1a'
		]);
	}

	function free_result($results)
	{
		$results->closeCursor();
	}

	function fetch_assoc($results)
	{
		return $results->fetch(PDO::FETCH_ASSOC);
	}

	function affected_rows($results)
	{
		return $results->rowCount();
	}
}
