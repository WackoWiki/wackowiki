<?php

if (!defined('IN_WACKO'))
{
	exit;
}

function connect($db_host, $db_user, $db_pass, $db_name, $collation = false, $driver, $db_port)
{
	$dsn = '';

	if ($driver == 'mysql_pdo')
	{
		$driver = 'mysql';
	}

	switch($driver)
	{
		case "firebird":
			$dsn = $driver.":dbname=".$db_host.":".$db_name.($db_port != '' ? ";port=".$db_port : '');
			break;
		case "ibm":
			$dsn = $driver.":DATABASE=".$db_host.";HOSTNAME=".$db_name.($db_port != '' ? ";PORT=".$db_port : '');
			break;
		case "informix":
			$dsn = $driver.":database=".$db_host.";host=".$db_name.($db_port != '' ? ";service=".$db_port : '');
			break;
		case "oci":
			$dsn = $driver.":dbname=//".$db_host.($db_port != '' ? ":".$db_port : '')."/".$db_name;
			break;
		default:
			$dsn = $driver.":dbname=".$db_name.";host=".$db_host.($db_port != '' ? ";port=".$db_port : '');
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

	if ($collation)
	{
		$dblink->query("SET NAMES '".$collation."'");
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
				die("Query failed: ".$query." (".$result->errorCode().": ".$result->errorInfo().")");
			}
			else
			{
				die("DBAL error: SQL query failed.");
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

function free_result($rs)
{
	$rs->closeCursor();
}

function fetch_assoc($rs)
{
	return $rs->fetch(PDO::FETCH_ASSOC);
}

?>