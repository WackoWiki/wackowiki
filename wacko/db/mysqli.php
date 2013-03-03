<?php

if (!defined('IN_WACKO'))
{
	exit;
}

function connect($db_host, $db_user, $db_pass, $db_name, $collation = false, $driver, $db_port = '')
{
	$dblink = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

	if ($collation)
	{
		mysqli_query($dblink, "SET NAMES '".$collation."'");
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

function free_result($rs)
{
	return mysqli_free_result($rs);
}

function fetch_assoc($rs)
{
	return mysqli_fetch_assoc($rs);
}

?>