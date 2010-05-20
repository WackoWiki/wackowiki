<?php

if (!isset($nomark)) $nomark = "";

if (isset($vars['for']))
{
	$tag = $this->UnwrapLink($vars[0]);
	$page_id = $this->GetPageId($tag);
}
else
{
	$tag = $this->tag;
	$page_id = $this->getPageId();
}
if ($this->UserIsOwner($page_id))
{
	$watchers = $this->LoadAll(
		"SELECT w.*, u.user_name ".
		"FROM ".$this->config["table_prefix"]."watch w ".
			"LEFT JOIN ".$this->config["table_prefix"]."user u ON (w.user_id = u.user_id) ".
		"WHERE w.page_id = '".quote($this->dblink, $page_id)."' ".
		"");

	if ($watchers)
	{
		$title = $this->GetTranslation("Watchers");
		$title = str_replace("%1",  $this->Link("/".$tag,"",$tag),  $title);
		if (!$nomark)
			echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$title.":</span></p>\n";

		foreach ($watchers as $watcher)
		{
			$user = $watcher["user_name"];
			echo $this->Link("/".$user, "", $user)."<br />";
		}
		if (!$nomark)
			echo "</div>\n";
	}
	else
	{
		if (!$nomark)
			echo str_replace("%1",  $this->Link("/".$tag,"",$tag), $this->GetTranslation("NoWatchers"));
	}
}
else
{
	if (!$nomark)
		echo str_replace("%1",  $this->Link("/".$tag,"",$tag), $this->GetTranslation("NotOwnerAndViewWatchers"));
}

?>