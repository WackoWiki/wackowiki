<?php

if (isset($stat) && $stat==0) $limit = 1000;
else $limit = 100;

if (!$max || $limit<$max)
$max = $limit;

$last_users = $this->LoadAll("select name, signuptime from ".$this->config["user_table"]." order by signuptime desc limit ".(int)$max);

foreach($last_users as $user)
{
	if ($stat!=="0") $num = $this->LoadSingle("select count(*) as n from ".$this->config["table_prefix"]."pages where owner='".quote($this->dblink, $user["name"])."'");
	print("(<span class=\"dt\">".$user["signuptime"].")</span> ".$this->Link("/".$user["name"],"",$user["name"]).($stat!=="0"?" . . . (".$num["n"].")":"")."<br />\n");
}

?>