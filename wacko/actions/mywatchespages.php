<?php

$str = "SELECT tag, user ".
		"FROM ".$this->config["table_prefix"]."pagewatches ".
		"WHERE user='".quote($this->dblink, $this->GetUserName())."'";

if ($pages = $this->LoadAll($str))
{
	$s = '';
	foreach ($pages as $page)
	if (!$this->config["hide_locked"] || $this->HasAccess("read",$page["tag"]))
	{
		$s = $this->Link("/".$page["tag"],"",$page["tag"]);

		if ($s != '')
		print $s.". . . . . . . . . . . . . . . . <small>".$this->ComposeLinkToPage("/".$page["tag"],"watch",$this->GetTranslation("RemoveWatch"))."</small><br />\n";
	}
}

?>