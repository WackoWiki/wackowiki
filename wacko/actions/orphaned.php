<?php

if (!isset($root)) $root = $this->UnwrapLink($vars[0]);
if (!isset($root)) $root = $this->page["tag"];

if ($pages = $this->LoadOrphanedPages($root))
{
	//!!!! unoptimized
	foreach ($pages as $page)
	if (!$this->config["hide_locked"] || $this->HasAccess("read",$page["tag"]))
	{
		print($this->Link("/".$page["tag"], "", "", 0)."<br />\n");
	}
}
else
{
	echo $this->GetResourceValue("NoOrphaned");
}

?>