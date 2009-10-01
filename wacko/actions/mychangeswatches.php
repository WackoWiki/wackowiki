<?php

if (!$max) $max = 50;

$str = "SELECT p.tag, w.user ".
		"FROM ".$this->config["table_prefix"]."pages AS p, ".$this->config["table_prefix"]."pagewatches AS w ".
		"WHERE p.tag = w.tag ".
			"AND p.time > w.time ".
			"AND w.user='".quote($this->dblink, $this->GetUserName())."'".
			"AND p.user<>'".quote($this->dblink, $this->GetUserName())."' ".
		"LIMIT ".(int)$max;

if ($pages = $this->LoadAll($str))
{
	$s = '';
	foreach ($pages as $page)
	if (!$this->config["hide_locked"] || $this->HasAccess("read",$page["tag"]))
	{
		$s = $this->Link("/".$page["tag"],"",$page["tag"])."<br />\n";

		if ($s != '') echo $s;
	}
}
?>