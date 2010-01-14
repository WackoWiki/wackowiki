<?php

if (!function_exists('LoadRecentlyCommented'))
{
	function LoadRecentlyCommented(&$wacko, $for = "", $limit = 50)
	{
		// NOTE: this is really stupid. Maybe my SQL-Fu is too weak, but apparently there is no easier way to simply select
		if ($ids = $wacko->LoadAll(
			"SELECT a.page_id, MAX(a.created) as latest, a.comment_on_id ".
			"FROM ".$wacko->config["table_prefix"]."pages a ".
			($for
				? 	"INNER JOIN ".$wacko->config["table_prefix"]."pages b ON (a.comment_on_id = b.page_id) ".
					"WHERE ".
						"b.supertag LIKE '".quote($wacko->dblink, $wacko->NpjTranslit($for))."/%' "
				: 	"WHERE a.comment_on_id <> '0' ").
			($for
				? 	"GROUP BY b.supertag, a.id ORDER BY latest DESC"
				:	"GROUP BY a.comment_on_id, a.page_id ORDER BY latest DESC")
			, 1));
			{
				// load complete comments
				if ($ids)
				foreach ($ids as $id)
				{
					$comment = $wacko->LoadSingle(
						"SELECT b.tag as comment_on_page, b.supertag, a.tag, a.user_id, u.name AS user, a.modified ".
						"FROM ".$wacko->config["table_prefix"]."pages a ".
							"INNER JOIN ".$wacko->config["table_prefix"]."pages b ON (a.comment_on_id = b.page_id) ".
							"LEFT OUTER JOIN ".$wacko->config["table_prefix"]."users u ON (a.user_id = u.user_id) ".
						" WHERE a.page_id = '".$id["page_id"]."' LIMIT 1");
					if (!isset($comments[$comment["comment_on_page"]]) && $num < $limit)
					{
						$comments[$comment["comment_on_page"]] = $comment;
						$num++;
					}
				}

			// now load pages
			if ($comments)
			{
				// now using these ids, load the actual pages
				foreach ($comments as $comment)
				{
					$page = $wacko->LoadPage($comment["comment_on_page"]);
					$page["comment_user"] = $comment["user"];
					$page["comment_time"] = $comment["modified"];
					$page["comment_on_tag"] = $comment["comment_on_page"];
					$page["comment_tag"] = $comment["tag"];
					$pages[] = $page;
				}
			}
		}
		return $pages;
	}
}

if (!isset($root))	$root	= $this->UnwrapLink($vars[0]);
if (!isset($root))	$root	= $this->page["tag"];
if (!isset($noxml)) $noxml	= 0;
if ($max == false)	$max	= $user['changescount'];
if ($max == false)	$max	= 50;
if ($max > 100)		$max	= 100;

if ($pages = LoadRecentlyCommented($this, $root, (int)$max))
{
	if ($root == "" && !(int)$noxml)
	{
		echo "<a href=\"".$this->GetConfigValue("root_url")."xml/comments_".preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wacko_name"))).".xml\"><img src=\"".$this->GetConfigValue("theme_url")."icons/xml.gif"."\" title=\"".$this->GetTranslation("RecentCommentsXMLTip")."\" alt=\"XML\" /></a><br /><br />\n";
	}

	echo "<ul>\n";

	foreach ($pages as $page)
	{
		if ($this->config["hide_locked"])
			$access = $this->HasAccess("read", $page["page_id"]);
		else
			$access = true;

		if ($access && $this->UserAllowedComments())
		{
			// day header
			list($day, $time) = explode(" ", $page["comment_time"]);

			if (!isset($curday)) $curday = "";
			if ($day != $curday)
			{
				if ($curday)
				{
					echo "</ul>\n<br /></li>\n";
				}
				echo "<li><b>".date($this->config["date_format"],strtotime($day)).":</b>\n<ul>\n";
				$curday = $day;
			}

			// print entry
			echo "<li><span class=\"dt\">".date($this->config["time_format_seconds"], strtotime( $time ))."</span> &mdash; (<a href=\"".
			$this->href("", $page["comment_tag"], "")."\">".$page["comment_on_tag"]."</a>".
			") . . . . . . . . . . . . . . . . <small>".$this->GetTranslation("LatestCommentBy")." ".
			($page["comment_user"]
				? ($this->IsWikiName($page["comment_user"])
					? $this->Link("/".$page["comment_user"],"",$page["comment_user"] )
					: $page["comment_user"])
				: $this->GetTranslation("Guest")).
			"</small></li>\n";
		}
	}
	echo "</ul>\n</li>\n</ul>\n";
}
else
{
	echo $this->GetTranslation("NoRecentlyCommented");
}

?>