<?php

if (!defined('IN_WACKO'))
{
	exit;
}

function connect($db_host, $db_user, $db_pass, $db_name, $db_charset = false, $driver, $db_port)
{
	$dsn = '';

	if ($driver == 'mysql_pdo')
	{
		$driver = 'mysql';
	}

	switch($driver)
	{
		case 'pgsql':#host=localhost;port=5432;dbname=testdb;user=bruce;password=mypass
			$dsn = $driver.":host=".$db_host.";port=".$db_port.";dbname=".$db_name;
			break;
		case 'sqlite':
			$dsn = $driver.":".$db_name;
			break;
		default:
			$dsn = $driver.":host=".$db_host.($db_port != '' ? ";port=".$db_port : '').";dbname=".$db_name.($db_charset != '' ? ";charset=".$db_charset : '');
			break;
	}

	try
	{
		$dblink = new PDO($dsn, $db_user, $db_pass);
	}
	catch(PDOException $e)
	{
		die('PDO DSN Error: '.$e->getMessage());
	}

	return $dblink;
}

function sql_query($dblink, $query, $debug)
{
	$result = $dblink->query($query);

	if($result)
	{
		if ($result->errorCode() != '00000')
		{
			ob_end_clean();

			if ($debug > 2)
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

function quote($dblink, $string)
{
	// return $dblink->quote($string);

	// Manually string quoting since pdo::quote is double escaping single quotes which is causing chaos
	// Got this from: http://www.gamedev.net/community/forums/topic.asp?topic_id=448909
	// More reading: http://www.sitepoint.com/forums/showthread.php?t=337881
	return strtr($string, array(
					"\x00" => '\x00',
					"\n" => '\n',
					"\r" => '\r',
					'\\' => '\\\\',
					"'" => "\'",
					'"' => '\"',
					"\x1a" => '\x1a'
					));
}

function free_result($results)
{
	$results->closeCursor();
}

function fetch_assoc($results)
{
	return $results->fetch(PDO::FETCH_ASSOC);
}

function affected_rows($dblink, $results)
{
	// $dblink only required for mysqli
	return $results->rowCount();
}

?>