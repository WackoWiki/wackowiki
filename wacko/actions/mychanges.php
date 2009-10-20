<?php

// {{MyChanges [max="Number"] [bydate="1"]}}

if ($user = $this->GetUserName())
{
	if ($max) $limit = $max;
	else $limit	= 100;
	$prefix = $this->config['table_prefix'];

	if($_GET["bydate"] == 1)
	{
		print($this->GetTranslation("MyChangesTitle1")." (<a href=\"".
			$this->href("", "", "mode=mychanges")."#list\">".$this->GetTranslation("OrderABC")."</a>).<br /><br />\n");
			#.($this->GetConfigValue("rewrite_mode") ? "?" : "&amp;").

		$count	= $this->LoadSingle(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}pages ".
			"WHERE user = '".quote($this->dblink, $user)."' ".
				"AND comment_on_id = '0'", 1);
		
		$pagination = $this->Pagination($count['n'], $limit, 'p', 'mode=mychanges&amp;bydate=1#list');

		if ($pages = $this->LoadAll(
			"SELECT tag, time, edit_note ".
			"FROM {$prefix}pages ".
			"WHERE user = '".quote($this->dblink, $user)."' ".
				"AND comment_on_id = '0' ".
			"ORDER BY time DESC, tag ASC ".
			"LIMIT {$pagination['offset']}, $limit", 1))
		{
			echo "<ul>\n";

			foreach ($pages as $page)
			{
				// day header
				list($day, $time) = explode(" ", $page["time"]);
				if ($day != $curday)
				{
					if ($curday)
					{
						print("</ul>\n<br /></li>\n");
					}
					print("<li><strong>$day:</strong><ul>\n");
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
				print("<li>$time (".$this->ComposeLinkToPage($page["tag"], "revisions", $this->GetTranslation("History"), 0).") ".$this->ComposeLinkToPage($page["tag"], "", "", 0).$edit_note."</li>\n");


			}
			echo "</ul>\n</li>\n</ul>\n";

			// pagination
			echo "<br /><small>{$pagination['text']}</small>\n";
		}
		else
		{
			echo $this->GetTranslation("DidntEditAnyPage");
		}
	}
	else
	{
		print($this->GetTranslation("MyChangesTitle2")." (<a href=\"".
			$this->href("", "", "mode=mychanges&amp;bydate=1")."#list\">". #($this->GetConfigValue("rewrite_mode") ? "?" : "&amp;")."bydate=true\">".
			$this->GetTranslation("OrderChange")."</a>).</strong><br /><br />\n");

		$count	= $this->LoadSingle(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}pages ".
			"WHERE user = '".quote($this->dblink, $user)."' ".
				"AND comment_on_id = '0'", 1);

		$pagination = $this->Pagination($count['n'], $limit, 'p', 'mode=mychanges#list');

		if ($pages = $this->LoadAll(
			"SELECT tag, time ".
			"FROM {$prefix}pages ".
			"WHERE user = '".quote($this->dblink, $user)."' ".
				"AND comment_on_id = '0' ".
			"ORDER BY tag ASC, time DESC ".
			"LIMIT {$pagination['offset']}, $limit", 1))
		{
			echo "<ul>\n";

			foreach ($pages as $page)
			{
				$firstChar = strtoupper($page["tag"][0]);

				if (!preg_match("/".$this->language["ALPHA"]."/", $firstChar))
				{
					$firstChar = "#";
				}

				if ($firstChar != $curChar)
				{
					if ($curChar)
					{
						print("</ul>\n<br /></li>\n");
					}
					print("<li><strong>$firstChar</strong><ul>\n");
					$curChar = $firstChar;
				}

				// print entry
				print("<li>".$page["time"]." (".$this->ComposeLinkToPage($page["tag"], "revisions", $this->GetTranslation("History"), 0).") ".$this->ComposeLinkToPage($page["tag"], "", "", 0)."</li>\n");


			}
			echo "</ul>\n</li>\n</ul>\n";

			// pagination
			echo "<br /><small>{$pagination['text']}</small>\n";
		}
		else
		{
			echo $this->GetTranslation("DidntEditAnyPage");
		}
	}
}
else
{
	echo $this->GetTranslation("NotLoggedInThusEdited");
}

?>