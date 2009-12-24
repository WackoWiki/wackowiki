<?php

if (!isset($root)) $root = $this->page["tag"];
else $root = $this->UnwrapLink($root);

if ($pages = $this->LoadOrphanedPages($root))
{
	echo "<ol>\n";
	//!!!! unoptimized
	if (is_array($pages))
	foreach ($pages as $page)
	if (!$this->config["hide_locked"] || $this->HasAccess("read",$page["page_id"]))
	{
		print("<li>".$this->Link("/".$page["tag"], "", "", 0)."</li>\n");
	}
	echo "</ol>\n";
}
else
{
	echo $this->GetTranslation("NoOrphaned");
}

?>