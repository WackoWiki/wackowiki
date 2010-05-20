<div id="page">
<?php

$max = "";
$output = "";

// redirect to show method if page don't exists
#if (!$this->page) $this->Redirect($this->href("show"));

// deny for comment
if ($this->page["comment_on_id"])
	$this->Redirect($this->href("", $this->GetCommentOnTag($this->page["comment_on_id"]), "show_comments=1")."#".$this->page["tag"]);

if (!isset($hide_minor_edit)) $hide_minor_edit = isset($_GET["minor_edit"]) ? $_GET["minor_edit"] :"";
// get page_id for deleted but stored page
if (!isset($this->page["page_id"]))
{
	$tag = trim($_GET['page'],'/revisions'); //
	// Returns Array ( [id] => Value )
	$get_page_ID = $this->LoadSingle(
			"SELECT page_id ".
			"FROM ".$this->config["table_prefix"]."revision ".
			"WHERE tag = '".quote($this->dblink, $tag)."' LIMIT 1");

	// Get the_ID value
	$this->page["page_id"] = $get_page_ID['page_id'];
	echo "BACKUP of deleted page!"; // TODO: localize and add description: to restore the page you ...
}

if ($this->HasAccess("read"))
{
	// load revisions for this page
	if ($pages = $this->LoadRevisions($this->page["page_id"], $hide_minor_edit))
	{
		$this->context[++$this->current_context] = "";
		$output .= $this->FormOpen("diff", "", "get");
		$output .= "<p>\n";
		$output .= "<input type=\"submit\" value=\"".$this->GetTranslation("ShowDifferencesButton")."\" />";
		#$output .= "<input type=\"button\" value=\"".$this->GetTranslation("CancelDifferencesButton")."\" onclick=\"document.location='".addslashes($this->href(""))."';\" />\n";
		$output .= "&nbsp;&nbsp;&nbsp;<input type=\"checkbox\" id=\"fastdiff\" name=\"fastdiff\" />\n <label for=\"fastdiff\">".$this->GetTranslation("SimpleDiff")."</label>";
		$output .= "&nbsp;&nbsp;&nbsp;<input type=\"checkbox\" id=\"source\" name=\"source\" />\n <label for=\"source\">".$this->GetTranslation("SourceDiff")."</label>";
		$output .= "&nbsp;&nbsp;&nbsp;<a href=\"".$this->href("revisions.xml")."\"><img src=\"".$this->config["theme_url"]."icons/xml.gif"."\" title=\"".$this->GetTranslation("RevisionXMLTip")."\" alt=\"XML\" /></a>";
		if ($this->config["minor_edit"])
		{
			$output .= "<br />".(!$_GET['minor_edit'] == '1' ? "<a href=\"".$this->href("revisions", "", "minor_edit=1")."\">".$this->GetTranslation("MinorEditHide")."</a>" : "<a href=\"".$this->href("revisions", "", "minor_edit=0")."\">".$this->GetTranslation("MinorEditShow")."</a>");
		}
		$output .= "</p>\n<ul class=\"revisions\">\n";

		if (isset($_GET["show"]) && $_GET["show"] == "all")
			$max = 0;
		else if ($user = $this->GetUser())
		{
			$max = $user["revisions_count"];
		}
		else
		{
			$max = 20;
		}

		$c = 0;
		$t = $a = count($pages);
		foreach ($pages as $page)
		{
			if ($page["edit_note"])
			{
				$edit_note = " <span class=\"editnote\">[".$page["edit_note"]."]</span>";
			}
			else
			{
				$edit_note = "";
			}

			if (++$c <= $max || !$max)
			{
				$output .= "<li>";
				$output .= "".($t--).".";
				$output .= "&nbsp;&nbsp;&nbsp;<input type=\"radio\" name=\"a\" value=\"".($c == 1 ? "-1" : $page["revision_m_id"])."\" ".($c == 1 ? "checked=\"checked\"" : "")." />";
				$output .= "&nbsp;&nbsp;&nbsp;<input type=\"radio\" name=\"b\" value=\"".($c == 1 ? "-1" : $page["revision_m_id"])."\" ".($c == 2 ? "checked=\"checked\"" : "")." />";
				$output .= "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"".$this->href("show").($this->config["rewrite_mode"] ? "?" : "&amp;")."time=".urlencode($page["modified"])."\">".$this->GetTimeStringFormatted($page["modified"])."</a>";
				$output .= " — id ".$page["revision_m_id"]." ";
				$output .= "&nbsp;&nbsp;&nbsp;&nbsp;".$this->GetTranslation("By")." ".
				($page["user"]
					? ($this->IsWikiName($page["user"])
						? $this->Link("/".$page["user"],"",$page["user"])
						: $page["user"])
					: $this->GetTranslation("Guest"))."";
				$output .= "".$edit_note."";
				$output .= " ".($page["minor_edit"] ? "m" : "");
				$output .= "</li>\n";
			}
		}
		$output .= "</ul>\n<br />\n";

		if (!$this->config["revisions_hide_cancel"]) $output .= "<input type=\"button\" value=\"".$this->GetTranslation("CancelDifferencesButton")."\" onclick=\"document.location='".addslashes($this->href(""))."';\" />\n";
		$output .= $this->FormClose()."\n";
	}
	print($output);
	$this->current_context--;

	if ($max && $a > $max)
		echo "<a href=\"".$this->href("revisions", "", "show=all")."\">".$this->GetTranslation("RevisionsShowAll")."</a>";
}
else
{
	echo $this->GetTranslation("ReadAccessDenied");
}
?>
</div>
