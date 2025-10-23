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

		$driver = match ($driver)
		{
			'mysql_pdo'		=> 'mysql',
			'sqlite_pdo'	=> 'sqlite',
		};

		$dsn = $driver . ':';

		$dsn .= match ($driver)
		{
			'pgsql'			=> 'host=' . $config->db_host . ';port=' . $config->db_port . ';dbname=' . $config->db_name,
			'sqlite'		=> $config->db_name,
			default			=> 'host=' . $config->db_host .
							($config->db_port
								? ';port=' . $config->db_port
								: '') .
							';dbname=' . $config->db_name .
							($config->db_charset
								? ';charset=' . $config->db_charset
								: ''),
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
			if ($this->config->debug > 2)
			{
				die('PDO DSN Error: [' . $e->getCode() . '] ' . $e->getMessage());
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
			$result = $this->dblink->query($query);
		}
		catch (PDOException $e)
		{
			ob_end_clean();

			if ($this->config->debug > 2)
			{
				# $e->getTraceAsString()
				die('Query failed: [' . $e->getCode() . '] ' . $e->getMessage()  . ' -> ' . $query);
			}
			else
			{
				die('DBAL error: SQL query failed.');
			}
		}

		return $result;
	}

	function quote($string): string
	{
		$string ??= '';

		// return $dblink->quote($string);

		// Manually string quoting since pdo::quote is double escaping single quotes which is causing chaos
		// Got this from: http://www.gamedev.net/community/forums/topic.asp?topic_id=448909
		// More reading: http://www.sitepoint.com/forums/showthread.php?t=337881
		return match ($this->config->db_driver) {
			'sqlite_pdo'	=> strtr((string) $string, [
					"'"		=> "''",
				]),
			default			=> strtr((string) $string, [
					"\x00"	=> '\x00',
					"\n"	=> '\n',
					"\r"	=> '\r',
					'\\'	=> '\\\\',
					"'"		=> "\'",
					'"'		=> '\"',
					"\x1a"	=> '\x1a'
				])
		};
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
