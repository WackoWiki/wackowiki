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
		$driver = $config->database_driver;

		if ($driver == 'mysql_pdo')
		{
			$driver = 'mysql';
		}

		$dsn = $driver . ':';

		switch ($driver)
		{
			case 'pgsql': // host=localhost;port=5432;dbname=testdb;user=bruce;password=mypass
				$dsn .= "host=" . $config->database_host . ";port=" . $config->database_port . ";dbname=" . $config->database_database;
				break;
			case 'sqlite':
				$dsn .= $config->database_database;
				break;
			default:
				$dsn .= "host=" . $config->database_host .
					($config->database_port? ";port=" . $config->database_port  : '') .
					";dbname=" . $config->database_database .
					($config->database_charset? ";charset=" . $config->database_charset : '');
				break;
		}

		try
		{
			$this->dblink = new PDO($dsn, $config->database_user, $config->database_password);
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
					die('Query failed: '.$query.' ('.$result->errorCode().': '.$result->errorInfo().')');
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
		// return $dblink->quote($string);

		// Manually string quoting since pdo::quote is double escaping single quotes which is causing chaos
		// Got this from: http://www.gamedev.net/community/forums/topic.asp?topic_id=448909
		// More reading: http://www.sitepoint.com/forums/showthread.php?t=337881
		return strtr($string, [
						"\x00" => '\x00',
						"\n" => '\n',
						"\r" => '\r',
						'\\' => '\\\\',
						"'" => "\'",
						'"' => '\"',
						"\x1a" => '\x1a'
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
