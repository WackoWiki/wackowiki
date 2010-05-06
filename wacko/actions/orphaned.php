<?php

if (!function_exists('LoadOrphanedPages'))
{
	function LoadOrphanedPages(&$engine, $for = "")
	{
		$pref = $engine->config["table_prefix"];
		$sql = "SELECT DISTINCT page_id, tag FROM ".$pref."pages p ".
			"LEFT JOIN ".$pref."links l ON ".
			"((l.to_tag = p.tag ".
				"AND l.to_supertag = '') ".
				"OR l.to_supertag = p.supertag) ".
		"WHERE ".
			($for
				? "p.tag LIKE '".quote($engine->dblink, $for)."/%' AND "
				: "").
			"l.to_page_id is NULL ".
			"AND p.comment_on_id = '0' ".
		"ORDER BY tag ".
		"LIMIT 200";

		return $engine->LoadAll($sql);
	}
}

if (!isset($root)) $root = $this->page["tag"];
else $root = $this->UnwrapLink($root);

if ($pages = LoadOrphanedPages($this, $root))
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