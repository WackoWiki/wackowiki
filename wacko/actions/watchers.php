<?php

if ($vars[0] && $vars[0]!=$vars["nomark"])
$tag = $this->UnwrapLink( $vars[0] );
else
$tag = $this->getPageTag();
if ($this->UserIsOwner($tag)){

	$watchers = $this->LoadAll("select * from ".$this->config["table_prefix"]."pagewatches where tag = '".quote($this->dblink, $tag)."'");
	if ($watchers){

		$title = $this->GetResourceValue("Watchers");
		$title = str_replace("%1",  $this->Link("/".$tag,"",$tag),  $title);
		if (!$nomark)
		echo "<fieldset><legend>".$title.":</legend>\n";

		foreach ($watchers as $watcher)
		{
			$user = $watcher["user"];
			echo $this->Link("/".$user, "", $user)."<br />";
		}
		if (!$nomark)
		echo "</fieldset>\n";
	}
	else
	{
		if (!$nomark)
		echo str_replace("%1",  $this->Link("/".$tag,"",$tag), $this->GetResourceValue("NoWatchers"));
	}
}else{
	if (!$nomark)
	echo str_replace("%1",  $this->Link("/".$tag,"",$tag), $this->GetResourceValue("NotOwnerAndViewWatchers"));
}
?>