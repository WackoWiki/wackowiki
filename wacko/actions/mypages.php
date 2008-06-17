<?php

// actions/mypages.php
// written by Carlo Zottmann

if ($user = $this->GetUser())
{
	$my_pages_count = 0;

	if ($_GET["bydate"] == 1 || $bydate==1)
	{
		print("<strong>".$this->GetResourceValue("ListOwnedPages2").".</strong>");
		print("<br /><small><strong>(<a href=\"".$this->href("", $tag)."\">".$this->GetResourceValue("OrderABC")."</a>) (<a href=\"".$this->href("", $tag)."".($this->GetConfigValue("rewrite_mode")?"?":"&amp;")."bychange=1\">".$this->GetResourceValue("OrderChange")."</a>) </strong></small><br /><br />\n");

		if ($pages = $this->LoadAll("SELECT tag, time FROM ".$this->config["table_prefix"]."revisions WHERE owner = '".quote($this->dblink, $this->GetUserName())."' AND tag NOT LIKE 'Comment%' ORDER BY time DESC, tag ASC"))
		{

			foreach ($pages as $page)
			{
				$edited_pages[$page["tag"]] = $page["time"];
			}

			$pages = $this->LoadAll("SELECT tag, time FROM ".$this->config["table_prefix"]."pages WHERE owner = '".quote($this->dblink, $this->GetUserName())."' AND tag NOT LIKE 'Comment%' ORDER BY time DESC, tag ASC");
			foreach ($pages as $page)
			{
				if (!$edited_pages[$page["tag"]]) $edited_pages[$page["tag"]] = $page["time"];
			}

			//      $edited_pages = array_reverse($edited_pages);
			arsort($edited_pages);

			foreach ($edited_pages as $page["tag"] => $page["time"])
			{
				// day header
				list($day, $time) = explode(" ", $page["time"]);
				if ($day != $curday)
				{
					if ($curday) print("<br />\n");
					print("<strong>$day:</strong><br />\n");
					$curday = $day;
				}

				// print entry
				print("&nbsp;&nbsp;&nbsp;($time) (".$this->ComposeLinkToPage($page["tag"], "revisions", $this->GetResourceValue("History"), 0).") ".$this->ComposeLinkToPage($page["tag"], "", "", 0)."<br />\n");

				$my_pages_count++;
			}
		}
		else
		{
			echo $this->GetResourceValue("NoPagesFound");
		}
	}
	else if ($_GET["bychange"] == 1 || $bychange==1)
	{
		print("<strong>".$this->GetResourceValue("ListOwnedPages3")."</strong>.");
		print("<br /><small><strong>(<a href=\"".$this->href("", $tag)."\">".$this->GetResourceValue("OrderABC")."</a>) (<a href=\"".$this->href("", $tag)."".($this->GetConfigValue("rewrite_mode")?"?":"&amp;")."bydate=1\">".$this->GetResourceValue("OrderDate")."</a>)</strong></small><br /><br />\n");

		if ($pages = $this->LoadAll("SELECT tag, time FROM ".$this->config["table_prefix"]."pages WHERE owner = '".quote($this->dblink, $this->GetUserName())."' AND tag NOT LIKE 'Comment%' ORDER BY time ASC, tag ASC"))
		{
			foreach ($pages as $page)
			{
				$edited_pages[$page["tag"]] = $page["time"];
			}

			$edited_pages = array_reverse($edited_pages);

			foreach ($edited_pages as $page["tag"] => $page["time"])
			{
				// day header
				list($day, $time) = explode(" ", $page["time"]);
				if ($day != $curday)
				{
					if ($curday) print("<br />\n");
					print("<strong>$day:</strong><br />\n");
					$curday = $day;
				}

				// print entry
				print("&nbsp;&nbsp;&nbsp;($time) (".$this->ComposeLinkToPage($page["tag"], "revisions", $this->GetResourceValue("History"), 0).") ".$this->ComposeLinkToPage($page["tag"], "", "", 0)."<br />\n");

				$my_pages_count++;
			}
		}
		else
		{
			echo $this->GetResourceValue("NoPagesFound");
		}
	}
	else {
		print("<strong>".$this->GetResourceValue("ListOwnedPages").".</strong>\n");
		print("<br /><small><strong>(<a href=\"".$this->href("", $tag)."".($this->GetConfigValue("rewrite_mode")?"?":"&amp;")."bydate=1\">".$this->GetResourceValue("OrderDate")."</a>) (<a href=\"".$this->href("", $tag)."".($this->GetConfigValue("rewrite_mode")?"?":"&amp;")."bychange=1\">".$this->GetResourceValue("OrderChange")."</a>) </strong></small><br /><br />\n");

		if ($pages = $this->LoadAll("SELECT tag, time FROM ".$this->config["table_prefix"]."pages WHERE owner = '".quote($this->dblink, $this->GetUserName())."' AND tag NOT LIKE 'Comment%' AND latest='Y' ORDER BY tag ASC"))
		{
			foreach ($pages as $page)
			{
				$firstChar = strtoupper($page["tag"][0]);
				if (!preg_match("/".$this->language["ALPHA"]."/", $firstChar)) {
					$firstChar = "#";
				}

				if ($firstChar != $curChar) {
					if ($curChar) print("<br />\n");
					print("<strong>$firstChar</strong><br />\n");
					$curChar = $firstChar;
				}

				print($this->ComposeLinkToPage($page["tag"])."<br />\n");

				$my_pages_count++;
			}
		}
		else
		{
			echo $this->GetResourceValue("NoPagesFound");
		}
	}

	if ($my_pages_count == 0)
	{
		echo $this->GetResourceValue("YouDontOwn");
	}

}
else
{
	echo $this->GetResourceValue("NotLoggedInThusOwned");
}

?>