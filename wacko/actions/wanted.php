<?php

if (!isset($root))
	$root = $this->page["tag"];
else
	$root = $this->UnwrapLink($root);

if ($linking_to = (isset($_GET["linking_to"]) ? $_GET["linking_to"] : ""))
{
	if ($pages = $this->LoadPagesLinkingTo($linking_to, $root))
	{
		echo $this->GetTranslation("PagesLinkingTo")." ".$this->Link($linking_to).":<br />\n";
		echo "<ul>\n";

		foreach ($pages as $page)
		{
			if (!$this->config["hide_locked"] || $this->HasAccess("read", $page["page_id"]))
			{
				echo "<li>".$this->Link("/".$page["tag"],"","/".$page["tag"])."</li>\n";
			}
		}
		echo "</ul>\n";
	}
	else
	{
		echo "<em>".$this->GetTranslation("NoPageLinkingTo")." ".$this->Link($linking_to).".</em>";
	}
}
else
{
	$for = $root;
	$pref = $this->config["table_prefix"];
	$sql = "SELECT DISTINCT l.to_tag AS wanted_tag ".
		"FROM ".$pref."links l ".
			"LEFT JOIN ".$pref."pages p ON ".
			"((l.to_tag = p.tag ".
				"AND l.to_supertag = '') ".
				"OR l.to_supertag = p.supertag) ".
		"WHERE ".
			($for
				? "l.to_tag LIKE '".quote($this->dblink, $for)."/%' AND "
				: "").
		"p.tag is NULL GROUP BY wanted_tag ".
		"ORDER BY wanted_tag ASC";

	if ($pages = $this->LoadAll($sql))
	{
		if (is_array($pages))
		{
			echo "<ol>\n";

			foreach($pages as $page)
			{
				$page_parent = substr($page["wanted_tag"], 0, strrpos($page["wanted_tag"], "/"));

				if(!$this->config["hide_locked"] || $this->HasAccess("read", $page_parent))
				{
					// Update the referrer count for the WantedPage, we need to take pages the user is not allowed to view out of the total
					$count = 0;

					if($referring_pages = $this->LoadPagesLinkingTo($page["wanted_tag"], $root))
					{
						foreach ($referring_pages as $referrer_page)
						{
							if(!$this->config["hide_locked"] || $this->HasAccess("read", $referrer_page["tag"]))
							{
								$count++;
							}
						}
					}

					// If no pages are referring to the WantedPage it means the referrers are all locked so don't show the link at all
					if($count > 0)
					{
						echo "<li>".$this->Link("/".$page["wanted_tag"])." (<a href=\"".$this->href().($this->config["rewrite_mode"] ? "?" : "&amp;")."linking_to=".$page["wanted_tag"]."\">".$count."</a>)</li>\n";
					}
				}
			}
			echo "</ol>\n";
		}
	}
	else
	{
		echo $this->GetTranslation("NoWantedPages");
	}
}

?>