<?php

if (!isset($root)) $root = $this->UnwrapLink($vars[0]);
if (!isset($root)) $root = $this->page["tag"];

if ($linking_to = $_REQUEST["linking_to"])
{
	if ($pages = $this->LoadPagesLinkingTo($linking_to,$root))
	{
		echo $this->GetResourceValue("PagesLinkingTo")." ".$this->Link($linking_to).":<br />\n";
		foreach ($pages as $page)
		{
			print($this->Link("/".$page["tag"],"","/".$page["tag"])."<br />\n");
		}
	}
	else
	{
		echo "<em>".$this->GetResourceValue("NoPageLinkingTo")." ".$this->Link($linking_to).".</em>";
	}
}
else
{
	if ($pages = $this->LoadWantedPages($root))
	{
		foreach ($pages as $page)
		{
			print($this->Link("/".$page["tag"])." (<a href=\"".$this->href().($this->config["rewrite_mode"] ? "?" : "&amp;")."linking_to=".$page["tag"]."\">".$page["count"]."</a>)<br />\n");
		}
	}
	else
	{
		echo $this->GetResourceValue("NoWantedPages");
	}
}

?>