<?php

if ($vars[0] && $vars[0]!=$vars["nomark"])
$tag = $this->UnwrapLink( $vars[0] );
else
$tag = $this->getPageTag();
if ($this->UserIsOwner($tag)){

	$watchers = $this->LoadAll("SELECT * FROM ".$this->config["table_prefix"]."pagewatches WHERE tag = '".quote($this->dblink, $tag)."' GROUP BY tag");
	if ($watchers){

		$title = $this->GetTranslation("Watchers");
		$title = str_replace("%1",  $this->Link("/".$tag,"",$tag),  $title);
		if (!$nomark)
		echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$title.":</span></p>\n";

		foreach ($watchers as $watcher)
		{
			$user = $watcher["user"];
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
}else{
	if (!$nomark)
	echo str_replace("%1",  $this->Link("/".$tag,"",$tag), $this->GetTranslation("NotOwnerAndViewWatchers"));
}
?>