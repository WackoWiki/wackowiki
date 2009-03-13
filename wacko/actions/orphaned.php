<?php

if (!isset($root)) $root = $this->page["tag"];
else $root = $this->UnwrapLink($root);

if ($pages = $this->LoadOrphanedPages($root))
{
	//!!!! unoptimized
	if (is_array($pages))
	foreach ($pages as $page)
	if (!$this->config["hide_locked"] || $this->HasAccess("read",$page["tag"]))
	{
		print($this->Link("/".$page["tag"], "", "", 0)."<br />\n");
	}
}
else
{
	echo $this->GetTranslation("NoOrphaned");
}

?>