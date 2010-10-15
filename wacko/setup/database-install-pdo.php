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
?>