<?php

if (isset($stat) && $stat==0) $limit = 1000;
else $limit = 100;

if (!$max || $limit<$max)
$max = $limit;

$last_users = $this->LoadAll("SELECT name, signuptime FROM ".$this->config["user_table"]." ORDER BY signuptime DESC LIMIT ".(int)$max);

foreach($last_users as $user)
{
	if ($stat!=="0") $num = $this->LoadSingle("SELECT COUNT(*) AS n FROM ".$this->config["table_prefix"]."pages WHERE owner='".quote($this->dblink, $user["name"])."'");
	print("(<span class=\"dt\">".$user["signuptime"].")</span> ".$this->Link("/".$user["name"],"",$user["name"]).($stat!=="0"?" . . . (".$num["n"].")":"")."<br />\n");
}

?>