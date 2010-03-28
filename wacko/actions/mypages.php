<?php

// actions/mypages.php

if ($user_id = $this->GetUserId())
{
	if ($max) $limit = $max;
	else $limit	= 100;
	$prefix = $this->config['table_prefix'];

	if ($_GET["bydate"] == 1 || $bydate == 1)
	{
		print($this->GetTranslation("ListOwnedPages2"));
		print("<br />[<a href=\"".$this->href("", "", "mode=mypages")."#list"."\">".
		$this->GetTranslation("OrderABC")."</a>] [<a href=\"".$this->href("", "", "mode=mypages&amp;bychange=1")."".($this->config["rewrite_mode"] ? "?" : "&amp;")."#list"."\">".
		$this->GetTranslation("OrderChange")."</a>] <br /><br />\n");
		$count	= $this->LoadSingle(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}pages ".
			"WHERE owner_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id = '0'", 1);

		$pagination = $this->Pagination($count['n'], $limit, 'p', 'mode=mypages&amp;bydate=1#list');

		if ($pages = $this->LoadAll(
		"SELECT tag, created ".
		"FROM {$prefix}pages ".
		"WHERE owner_id = '".quote($this->dblink, $user_id)."' ".
			"AND comment_on_id = '0' ".
		"ORDER BY created DESC, tag ASC ".
		"LIMIT {$pagination['offset']}, $limit", 1))
		{
			echo "<ul class=\"ul_list\">\n";

			foreach ($pages as $page)
			{
				// day header
				list($day, $time) = explode(" ", $page["created"]);
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
				print("<li>$time (".$this->ComposeLinkToPage($page["tag"], "revisions", $this->GetTranslation("History"), 0).") ".$this->ComposeLinkToPage($page["tag"], "", "", 0)."</li>\n");


			}
			echo "</ul>\n</li>\n</ul>\n";
			// pagination
			echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
		}
		else
		{
			echo $this->GetTranslation("NoPagesFound");
		}
	}
	else if ($_GET["bychange"] == 1 || $bychange == 1)
	{
		$count	= $this->LoadSingle(
			"SELECT COUNT( DISTINCT p.tag ) AS n ".
			"FROM {$prefix}pages AS p ".
			"LEFT JOIN {$prefix}revisions AS r ".
				"ON (p.page_id = r.page_id ".
					"AND p.owner_id = '".quote($this->dblink, $user_id)."') ".
			"WHERE p.comment_on_id = '0' ".
				"AND r.comment_on_id = '0'", 1);

		$pagination = $this->Pagination($count['n'], $limit, 'p', 'mode=mypages&amp;bychange=1#list');

		print($this->GetTranslation('ListOwnedPages3').'.');
		print('<br />[<a href="'.
			$this->href('', '', 'mode=mypages').'#list">'.$this->GetTranslation('OrderABC').
			'</a>] [<a href="'.$this->href('', '', 'mode=mypages&amp;bydate=1').'#list">'.
			$this->GetTranslation('OrderDate')."</a>]<br /><br />\n");

		if ($pages = $this->LoadAll(
			"SELECT p.tag AS tag, p.modified AS modified ".
			"FROM {$prefix}pages AS p ".
			"LEFT JOIN {$prefix}revisions AS r ".
				"ON (p.page_id = r.page_id ".
					"AND p.owner_id = '".quote($this->dblink, $user_id)."') ".
			"WHERE p.comment_on_id = '0' ".
				"AND r.comment_on_id = '0' ".
			"GROUP BY tag ".
			"ORDER BY modified DESC, tag ASC ".
			"LIMIT {$pagination['offset']}, $limit", 1))
		{
			echo "<ul class=\"ul_list\">\n";

			foreach ($pages as $page)
			{
				// day header
				list($day, $time) = explode(" ", $page["modified"]);
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
				print("<li>".$this->GetTimeStringFormatted($time)." (".$this->ComposeLinkToPage($page["tag"], "revisions", $this->GetTranslation("History"), 0).") ".$this->ComposeLinkToPage($page["tag"], "", "", 0)."</li>\n");

			}
			echo "</ul>\n</li>\n</ul>\n";
			// pagination
			echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
		}
		else
		{
			echo $this->GetTranslation("NoPagesFound");
		}
	}
	else
	{
		$count	= $this->LoadSingle(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}pages ".
			"WHERE owner_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id = '0'", 1);

		$pagination = $this->Pagination($count['n'], $limit, 'p', 'mode=mypages#list');

		print($this->GetTranslation("ListOwnedPages"));
		print("<br />[<a href=\"".$this->href("", "", "mode=mypages&amp;bydate=1")."#list"."\">".
		$this->GetTranslation("OrderDate")."</a>] [<a href=\"".$this->href("", "", "mode=mypages&amp;bychange=1")."".($this->config["rewrite_mode"] ? "?" : "&amp;")."#list"."\">".
		$this->GetTranslation("OrderChange")."</a>] <br /><br />\n");

		if ($pages = $this->LoadAll(
			"SELECT tag, modified ".
			"FROM {$prefix}pages ".
			"WHERE owner_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id = '0' ".
			"ORDER BY tag ASC ".
			"LIMIT {$pagination['offset']}, $limit", 1))
		{
			echo "<ul class=\"ul_list\">\n";

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

				print("<li>".$this->ComposeLinkToPage($page["tag"])."</li>\n");
			}
			echo "</ul>\n</li>\n</ul>\n";
			// pagination
			echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
		}
		else
		{
			echo $this->GetTranslation("NoPagesFound");
		}
	}

	if ($pages == false)
	{
		echo $this->GetTranslation("YouDontOwn");
	}
}
else
{
	echo $this->GetTranslation("NotLoggedInThusOwned");
}

?>