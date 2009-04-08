<?php
try
{
	test($lang["TestConnectionString"], $dblink = @new PDO($dsn, $config["database_user"], $config["database_password"]), $lang["ErrorDBConnection"]);
	$dblink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	test($lang["TestConnectionString"], false, "PDO Error: ".$e->getMessage());
	$fatal_error = true;
}
?>