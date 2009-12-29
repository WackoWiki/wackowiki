<?php
if ($user = $this->GetUser())
{
	$max = $user["changescount"];
}
else
{
	$max = 50;
}

if ($this->NpjTranslit($this->config["allrecentchanges_page"]) != $this->NpjTranslit($this->tag))
{
	echo "<em>".$this->GetTranslation("ActionDenied")."</em> ";
}
else
if ($pages = $this->LoadRecentlyChanged($max))
{
	print("<a href=\"".$this->GetConfigValue("root_url")."xml/changes_".preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wacko_name"))).".xml\"><img src=\"".$this->GetConfigValue("theme_url")."icons/xml.gif"."\" title=\"".$this->GetTranslation("RecentChangesXMLTip")."\" alt=\"XML\" /></a><br /><br />");

	foreach ($pages as $i => $page)
	{
		if (($i < $max) || !$max)
		{
			// day header
			list($day, $time) = explode(" ", $page["modified"]);
			if ($day != $curday)
			{
				if ($curday) print("<br />\n");
				print("<b>$day:</b><br />\n");
				$curday = $day;
			}

			// print entry
			print("&nbsp;&nbsp;&nbsp;<span class=\"dt\">".$time."</span> &mdash; (".
			$this->ComposeLinkToPage($page["tag"], "revisions", $this->GetTranslation("History"), 0).") ".
			$this->Link( $page["tag"] )." . . . . . . . . . . . . . . . . <small>".
			($this->IsWikiName($page["user"]) ? $this->Link($page["user"]) : $page["user"])."</small><br />\n");
		}
	}
}
?>
