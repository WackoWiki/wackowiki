<?php

if (!defined('IN_WACKO'))
{
	exit;
}

function connect($db_host, $db_user, $db_pass, $db_name, $db_charset = false, $driver, $db_port = '')
{
	$dblink = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

	if ($db_charset)
	{
		mysqli_set_charset($dblink, $db_charset);
	}

	return $dblink;
}

function sql_query($dblink, $query, $debug)
{
	$result = mysqli_query($dblink, $query);

	if (mysqli_connect_errno())
	{
		ob_end_clean();

		if ($debug > 2)
		{
			die("Query failed: ".$query." (".mysqli_connect_errno().": ".mysqli_connect_error().")");
		}
		else
		{
			die("DBAL error: SQL query failed.");
		}
	}

	return $result;
}

function quote($dblink, $string)
{
	if (!empty ($dblink))
	{
		return mysqli_real_escape_string($dblink, $string);
	}
}

function free_result($results)
{
	return mysqli_free_result($results);
}

function fetch_assoc($results)
{
	return mysqli_fetch_assoc($results);
}

function affected_rows($dblink, $results = null)
{
	// $results only required for pdo
	return mysqli_affected_rows($dblink);
}

?>