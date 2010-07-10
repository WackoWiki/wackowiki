<?php

if (!isset($stat)) $stat = "";
if (!isset($max)) $max = "";

if (isset($stat) && $stat == 0)
	$limit = 1000;
else
	$limit = 100;

if (!$max || $limit < $max)
	$max = $limit;

$last_users = $this->LoadAll(
				"SELECT user_id, user_name, signup_time ".
				"FROM ".$this->config["user_table"]." ".
				"WHERE account_type = '0' ".
				"ORDER BY signup_time DESC ".
				"LIMIT ".(int)$max);

foreach($last_users as $user)
{
	if ($stat !== "0") $num = $this->LoadSingle(
				"SELECT COUNT(*) AS n ".
				"FROM ".$this->config["table_prefix"]."page ".
				"WHERE owner_id='".quote($this->dblink, $user["user_id"])."'");

	print("(<span class=\"dt\">".$this->GetTimeStringFormatted($user["signup_time"]).")</span> ".$this->Link("/".$user["user_name"],"",$user["user_name"]).($stat!=="0"?" . . . (".$num["n"].")":"")."<br />\n");
}

?>