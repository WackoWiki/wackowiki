<?php

global $dblink;

function test_pdo($text, $query, $errorText = '')
{
	global $dblink;

	try
	{
		test($text, $dblink->query($query), $errorText);
	}
	catch(PDOException $e)
	{
		test($text, false, $errorText);
	}
	catch(Exception $e)
	{
		test($text, false, $errorText);
	}
}

// Do the initial database connection test seperately as it is a special case.
try
{
	test($lang['TestConnectionString'], $dblink = @new PDO($dsn, $config['database_user'], $config['database_password']), $lang['ErrorDBConnection']);
	$dblink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	test($lang['TestConnectionString'], false, "PDO Error: ".$e->getMessage());
	$fatal_error = true;
}

// set SESSION sql_mode
if (isset($config['sql_mode_strict']) && $config['sql_mode_strict'])
{
	$sql_modes = SQL_MODE_STRICT;
}
else
{
	$sql_modes = SQL_MODE_PERMISSIVE;
}

$dblink->query("SET SESSION sql_mode='$sql_modes'");

?>