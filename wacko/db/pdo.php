<?php

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

function query($dblink, $query, $debug)
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

function fetch_assoc($rs)
{
	return $rs->fetch(PDO::FETCH_ASSOC);
}

function free_result($rs)
{
	$rs->closeCursor();
}

function connect($host, $user, $password, $db, $collation = false, $driver, $port)
{
	$dsn = '';
	if ($driver == 'mysql_pdo') $driver = 'mysql';

	switch($driver)
	{
		case "firebird":
			$dsn = $driver.":dbname=".$host.":".$db.($port != '' ? ";port=".$port : '');
			break;
		case "ibm":
			$dsn = $driver.":DATABASE=".$host.";HOSTNAME=".$db.($port != '' ? ";PORT=".$port : '');
			break;
		case "informix":
			$dsn = $driver.":database=".$host.";host=".$db.($port != '' ? ";service=".$port : '');
			break;
		case "oci":
			$dsn = $driver.":dbname=//".$host.($port != '' ? ":".$port : '')."/".$db;
			break;
		default:
			$dsn = $driver.":dbname=".$db.";host=".$host.($port != '' ? ";port=".$port : '');
			break;
	}

	try
	{
		$dblink = new PDO($dsn, $user, $password);
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

// Note on various DB implementions: http://framework.zend.com/manual/en/zend.db.html#zend.db.adapter.write.lastinsertid
function last_insert_id($dblink)
{
	return $dblink->lastInsertId();
}
?>