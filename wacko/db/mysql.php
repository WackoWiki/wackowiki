<?php

if (!defined('IN_WACKO'))
{
	exit;
}

//Primitive DBAL for mysql

function connect($db_host, $db_user, $db_pass, $db_name, $collation = false, $driver, $db_port = '')
{
	if(!extension_loaded("mysql"))
	{
		dl("mysql.so");
	}

	$dblink = mysql_connect($db_host.($db_port == '' ? '' : ':'.$db_port), $db_user, $db_pass);
	mysql_select_db($db_name, $dblink);

	if ($collation)
	{
		mysql_query("SET NAMES '".$collation."'", $dblink);
	}

	return $dblink;
}

//All DBALs (mysql excluded) must replace LIMIT with some other instruction.
function sql_query($dblink, $query, $debug)
{
	$result = mysql_query($query, $dblink);

	if (mysql_errno())
	{
		ob_end_clean();

		if ($debug > 2)
		{
			die("Query failed:<br /><br />".
					"==============================<br />".
					$query.
					"<br />".
					"==============================<br /><br />".
					"Error ".mysql_errno().": ".mysql_error());
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
	return mysql_real_escape_string($string);
}

function free_result($rs)
{
	return mysql_free_result($rs);
}

function fetch_assoc($rs)
{
	return mysql_fetch_assoc($rs);
}

?>