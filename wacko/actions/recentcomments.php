<?php

if (!function_exists('LoadRecentComments')){
	function LoadRecentComments(&$wacko, $for = "", $limit = 50)
	{
		return
		$wacko->LoadAll("select ".$wacko->pages_meta." from ".$wacko->config["table_prefix"]."pages where ".
		($for?"super_comment_on like '".quote($this->dblink, $wacko->NpjTranslit($for))."/%' ":"comment_on != '' ").
                    "AND latest = 'Y' order by time desc LIMIT ".(int)$limit);
	}
}

if (!isset($root)) $root = $this->UnwrapLink($vars[0]);
if (!isset($root)) $root = $this->page["tag"];
if (!$max) $max = 50;

if ($comments = LoadRecentComments($this, $root, (int)$max))
{
	foreach ($comments as $comment)
	{
		if ($this->config["hide_locked"]) $access = $this->HasAccess("read",$comment["comment_on"]);
		else $access = true;

		if ($access && $this->UserAllowedComments())
		{
			// day header
			list($day, $time) = explode(" ", $comment["time"]);
			if ($day != $curday)
			{
				if ($curday) print("<br />\n");
				print("<strong>$day:</strong><br />\n");
				$curday = $day;
			}

			// print entry
			print("&nbsp;&nbsp;&nbsp;(".$comment["time"].") <a href=\"".$this->href("", $comment["comment_on"], "show_comments=1")."#".$comment["tag"]."\">".$comment["comment_on"]."</a> . . . . <small>".
			($this->IsWikiName($comment["user"])?$this->Link("/".$comment["user"],"",$comment["user"]):$comment["user"])."</small><br />\n");
		}
	}
}
else
{
	echo $this->GetResourceValue("NoRecentComments");
}

?>