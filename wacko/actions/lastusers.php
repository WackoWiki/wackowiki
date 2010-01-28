<?php

if (isset($stat) && $stat == 0)
	$limit = 1000;
else
	$limit = 100;

if (!$max || $limit < $max)
	$max = $limit;

$last_users = $this->LoadAll(
				"SELECT user_id, user_name, signuptime ".
				"FROM ".$this->config["user_table"]." ".
				"ORDER BY signuptime DESC ".
				"LIMIT ".(int)$max);

foreach($last_users as $user)
{
	if ($stat !== "0") $num = $this->LoadSingle(
				"SELECT COUNT(*) AS n ".
				"FROM ".$this->config["table_prefix"]."pages ".
				"WHERE owner_id='".quote($this->dblink, $user["user_id"])."'");

	print("(<span class=\"dt\">".$user["signuptime"].")</span> ".$this->Link("/".$user["user_name"],"",$user["user_name"]).($stat!=="0"?" . . . (".$num["n"].")":"")."<br />\n");
}

?>