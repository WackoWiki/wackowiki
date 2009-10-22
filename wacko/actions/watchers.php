<?php

if ($vars[0] && $vars[0]!=$vars["nomark"])
	$tag = $this->UnwrapLink( $vars[0] );
else
	$tag = $this->getPageTag();
	$page_id = $this->getPageId();
if ($this->UserIsOwner($tag))
{

	$watchers = $this->LoadAll(
		"SELECT * ".
		"FROM ".$this->config["table_prefix"]."watches ".
		"WHERE page_id = '".quote($this->dblink, $page_id)."' ".
		"");

	if ($watchers)
	{
		$title = $this->GetTranslation("Watchers");
		$title = str_replace("%1",  $this->Link("/".$tag,"",$tag),  $title);
		if (!$nomark)
			echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$title.":</span></p>\n";

		foreach ($watchers as $watcher)
		{
			$user = $this->GetUserNameById($watcher["user_id"]);
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