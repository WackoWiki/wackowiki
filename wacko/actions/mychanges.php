<?php

// {{MyChanges [max="Number"] [bydate="1"]}}

if (!$max) $max = 50;
$bydate = isset($bydate) ? $bydate == "true" ? true : false : true;

echo "Here: ".$_GET["bydate"];

if ($user = $this->GetUser())
{
	$my_edits_count = 0;

	if($_GET["bydate"] == "true" || ($bydate && !isset($_GET["bydate"])))
	{
		print("<strong>".$this->GetTranslation("MyChangesTitle1")." (<a href=\"".$this->href("", $tag).($this->GetConfigValue("rewrite_mode")?"?":"&amp;")."bydate=false\">".$this->GetTranslation("OrderABC")."</a>).</strong><br /><br />\n");

		if ($pages = $this->LoadAll("SELECT tag, time FROM ".$this->config["table_prefix"]."pages WHERE user = '".quote($this->dblink, $this->GetUserName())."' AND tag NOT LIKE 'Comment%' ORDER BY time ASC, tag ASC", 1))
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

				if ($page["edit_note"])
				{
					$edit_note = " <span class=\"editnote\">[".$page["edit_note"]."]</span>";
				}
				else
				{
					$edit_note = "";
				}

				// print entry
				print("&nbsp;&nbsp;&nbsp;($time) (".$this->ComposeLinkToPage($page["tag"], "revisions", $this->GetTranslation("History"), 0).") ".$this->ComposeLinkToPage($page["tag"], "", "", 0).$edit_note."<br />\n");

				$my_edits_count++;

				if ($my_edits_count>=(int)$max) break;
			}

			if ($my_edits_count == 0)
			{
				echo $this->GetTranslation("DidntEditAnyPage");
			}
		}
		else
		{
			echo $this->GetTranslation("NoPagesFound");
		}
	}
	else
	{
		print("<strong>".$this->GetTranslation("MyChangesTitle2")." (<a href=\"".$this->href("", $tag).($this->GetConfigValue("rewrite_mode")?"?":"&amp;")."bydate=true\">".$this->GetTranslation("OrderChange")."</a>).</strong><br /><br />\n");

		if ($pages = $this->LoadAll("SELECT tag, time FROM ".$this->config["table_prefix"]."pages WHERE user = '".quote($this->dblink, $this->GetUserName())."' AND tag NOT LIKE 'Comment%' ORDER BY tag ASC, time DESC", 1))
		{
			foreach ($pages as $page)
			{
				if ($last_tag != $page["tag"]) {
					$last_tag = $page["tag"];
					$firstChar = strtoupper($page["tag"][0]);
					if (!preg_match("/[".$this->language["ALPHA"]."]/", $firstChar)) {
						$firstChar = "#";
					}

					if ($firstChar != $curChar) {
						if ($curChar) print("<br />\n");
						print("<strong>$firstChar</strong><br />\n");
						$curChar = $firstChar;
					}

					// print entry
					print("&nbsp;&nbsp;&nbsp;(".$page["time"].") (".$this->ComposeLinkToPage($page["tag"], "revisions", $this->GetTranslation("History"), 0).") ".$this->ComposeLinkToPage($page["tag"], "", "", 0)."<br />\n");

					$my_edits_count++;
					if ($my_edits_count>=(int)$max) break;
				}
			}

			if ($my_edits_count == 0)
			{
				echo $this->GetTranslation("DidntEditAnyPage");
			}
		}
		else
		{
			echo $this->GetTranslation("NoPagesFound");
		}
	}
}
else
{
	echo $this->GetTranslation("NotLoggedInThusEdited");
}

?>