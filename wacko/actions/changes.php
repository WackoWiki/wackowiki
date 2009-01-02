<?php

if (!isset($root)) $root = $this->UnwrapLink($vars[0]);
if (!isset($root)) $root = $this->page["tag"];
if (!$date) $date = $_GET["date"];

if ($user = $this->GetUser())
$usermax = $user["changescount"];
else
$usermax = 50;
if (!$max || $usermax < $max)
$max = $usermax;

if ($pages = $this->LoadRecentlyChanged((int)$max, $root, $date))
{
	if ($root == "" && !(int)$noxml)  print("<a href=\"".$this->GetConfigValue("root_url")."xml/recentchanges_".preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wakka_name"))).".xml\"><img src=\"".$this->GetConfigValue("theme_url")."icons/xml.gif"."\" title=\"".$this->GetResourceValue("RecentChangesXMLTip")."\" alt=\"XML\" /></a><br /><br />");

	$count = 0;
	$access = true;
	foreach ($pages as $i => $page)
	{
		if ($this->config["hide_locked"]) $access = $this->HasAccess("read",$page["tag"]);
		else $access = true;
		if ($access && ($count < $max))
		{
			$count++;
			// day header
			list($day, $time) = explode(" ", $page["time"]);
			if ($day != $curday)
			{
				if ($curday) print("<br />\n");
				print("<b>$day:</b><br />\n");
				$curday = $day;
			}

			// print entry
			print("&nbsp;&nbsp;&nbsp;<span class=\"dt\">".$time."</span> &mdash; (".
			$this->ComposeLinkToPage($page["tag"], "revisions", $this->GetResourceValue("History"), 0).") ".
			$this->Link( "/".$page["tag"], "", $page["tag"] )." . . . . . . . . . . . . . . . . <small>".
			($this->IsWikiName($page["user"])?$this->Link("/".$page["user"],"",$page["user"]):$page["user"])."</small><br />\n");
		}
	}
}
?>