<?php

$str  = "SELECT tag, user ";
$str .= "FROM ".$this->config["table_prefix"]."pagewatches ";
$str .= "WHERE user='".quote($this->dblink, $this->GetUserName())."'";

if ($pages = $this->LoadAll($str))
{
	$s = '';
	foreach ($pages as $page)
	if (!$this->config["hide_locked"] || $this->HasAccess("read",$page["tag"]))
	{
		$s = $this->Link("/".$page["tag"],"",$page["tag"]);

		if ($s != '')
		print $s.". . . . . . . . . . . . . . . . <small>".$this->ComposeLinkToPage("/".$page["tag"],"watch",$this->GetResourceValue("RemoveWatch"))."</small><br />\n";
	}
}
?>