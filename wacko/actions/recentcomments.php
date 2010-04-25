<?php

if (!function_exists('LoadRecentComments'))
{
	function LoadRecentComments(&$wacko, $for = "", $limit = 50)
	{
		return
		$wacko->LoadAll(
			"SELECT b.tag as comment_on_page, a.tag, b.supertag, a.user, a.modified, a.comment_on_id ".
			"FROM ".$wacko->config["table_prefix"]."pages a ".
				"INNER JOIN ".$wacko->config["table_prefix"]."pages b ON (a.comment_on_id = b.page_id)".
			"WHERE ".
			($for
				? "b.supertag LIKE '".quote($wacko->dblink, $wacko->NpjTranslit($for))."/%' "
				: "a.comment_on_id != '0' ").
			"ORDER BY a.modified DESC LIMIT ".(int)$limit);
	}
}

if (!isset($root)) $root = (isset($vars['for']) ? $this->UnwrapLink($vars['for']) : "");
if (!isset($root)) $root = $this->page["tag"];
if (!isset($max)) $max = "";
if (!$max) $max = 50;

if ($comments = LoadRecentComments($this, $root, (int)$max))
{
	echo "<ul>\n";

	foreach ($comments as $comment)
	{
		if ($this->config["hide_locked"]) $access = $this->HasAccess("read",$comment["comment_on_id"]);
		else $access = true;

		if ($access && $this->UserAllowedComments())
		{
			// day header
			list($day, $time2) = explode(" ", $comment["modified"]);
			if ($day != $curday)
			{
				if ($curday)
				{
					print("</ul>\n<br /></li>\n");
				}
				print("<li><strong>$day:</strong><ul>\n");
				$curday = $day;
			}

			// print entry
			print("<li><span class=\"dt\">".$time2."</span> &mdash; (<a href=\"".$this->href("", $comment["tag"], "")."\">".$comment["comment_on_page"]."</a>) . . . . . . . . . . . . . . . . <small>".
			($this->IsWikiName($comment["user"])?$this->Link("/".$comment["user"],"",$comment["user"]):$comment["user"])."</small></li>\n");
		}
	}
	echo "</ul>\n</li>\n</ul>\n";
}
else
{
	echo $this->GetTranslation("NoRecentComments");
}

?>