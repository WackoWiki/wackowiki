<?php

if (!isset($root)) $root = $this->UnwrapLink($vars[0]);
if (!isset($root)) $root = $this->page["tag"];
if (!isset($date)) $date = isset($_GET["date"]) ? $_GET["date"] :"";
if (!isset($hide_minor_edit)) $hide_minor_edit = isset($_GET["minor_edit"]) ? $_GET["minor_edit"] :"";
if (!isset($noxml)) $noxml = 0;

if ($user = $this->GetUser())
	$usermax = $user["changes_count"];
else
	$usermax = 50;
if (!isset($max) || $usermax < $max)
	$max = $usermax;

if ($pages = $this->LoadRecentlyChanged((int)$max, $root, $date, $hide_minor_edit))
{
	$count = 0;
	if ($root == "" && !(int)$noxml)
	{
		echo "<a href=\"".$this->config["base_url"]."xml/changes_".preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->config["wacko_name"])).".xml\"><img src=\"".$this->config["theme_url"]."icons/xml.gif"."\" title=\"".$this->GetTranslation("RecentChangesXMLTip")."\" alt=\"XML\" /></a><br /><br />\n";
	}

	echo "<ul class=\"ul_list\">\n";
	$access = true;

	foreach ($pages as $i => $page)
	{
		if ($this->config["hide_locked"])
			$access = $this->HasAccess("read",$page["page_id"]);
		else
			$access = true;

		if ($access && ($count < $max))
		{
			$count++;

			// day header
			list($day, $time) = explode(" ", $page["modified"]);
			if (!isset($curday)) $curday = "";

			if ($day != $curday)
			{
				if ($curday)
				{
					print("</ul>\n<br /></li>\n");
				}

				print("<li><b>".date($this->config["date_format"],strtotime($day)).":</b>\n<ul>\n");
				$curday = $day;
			}

			if ($page["edit_note"])
			{
				$edit_note = " <span class=\"editnote\">[".$page["edit_note"]."]</span>";
			}
			else
			{
				$edit_note = "";
			}

			// print entry
			print("<li><span class=\"dt\">".date($this->config["time_format_seconds"], strtotime( $time ))."</span> &mdash; (".
			$this->ComposeLinkToPage($page["tag"], "revisions", $this->GetTranslation("History"), 0).") ".
			$this->Link( "/".$page["tag"], "", $page["tag"] )." . . . . . . . . . . . . . . . . <small>".
			($page["user"]
				? ($this->IsWikiName($page["user"])
					? $this->Link("/".$page["user"],"",$page["user"])
					: $page["user"])
				: $this->GetTranslation("Guest")).
			$edit_note.
			"</small></li>\n");
		}
	}
	echo "</ul>\n</li>\n</ul>\n";
}
else
	echo $this->GetTranslation("NoPagesFound");

?>