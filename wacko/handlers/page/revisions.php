<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page) $this->Redirect($this->href("show"));

if ($this->HasAccess("read")) {
	// load revisions for this page
	if ($pages = $this->LoadRevisions($this->tag))
	{
		$this->context[++$this->current_context] = "";
		$output .= $this->FormOpen("diff", "", "get");
		$output .= "<p>\n";
		$output .= "<input type=\"submit\" value=\"".$this->GetTranslation("ShowDifferencesButton")."\" />";
		$output .= "&nbsp;&nbsp;&nbsp;<input type=\"checkbox\" id=\"fastdiff\" name=\"fastdiff\" />\n <label for=\"fastdiff\">".$this->GetTranslation("SimpleDiff")."</label>";
		$output .= "&nbsp;&nbsp;&nbsp;<a href=\"".$this->href("revisions.xml")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/xml.gif"."\" title=\"".$this->GetTranslation("RevisionXMLTip")."\" alt=\"XML\" /></a>";
		$output .= "</p>\n<ul>\n";

		if ($user = $this->GetUser())
		{
			$max = $user["revisioncount"];
		}
		else
		{
			$max = 20;
		}

		$c = 0;

		foreach ($pages as $page)
		{
			$c++;

			if ($page["edit_note"])
			{
				$edit_note = " <span class=\"editnote\">[".$page["edit_note"]."]</span>";
			}
			else
			{
				$edit_note = "";
			}

			if (($c <= $max) || !$max)
			{
				$output .= "<li><input type=\"radio\" name=\"a\" value=\"".($c == 1 ? "-1" : $page["id"])."\" ".($c == 1 ? "checked=\"checked\"" : "")." />";
				$output .= "&nbsp;&nbsp;&nbsp;<input type=\"radio\" name=\"b\" value=\"".($c == 1 ? "-1" : $page["id"])."\" ".($c == 2 ? "checked=\"checked\"" : "")." />";
				$output .= "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"".$this->href("show").($this->GetConfigValue("rewrite_mode") ? "?" : "&amp;")."time=".urlencode($page["time"])."\">".$page["time"]."</a>";
				$output .= "&nbsp;&nbsp;&nbsp;&nbsp;".$this->GetTranslation("By")." ".($this->IsWikiName($page["user"]) ? $this->Link($page["user"]) : $page["user"]).$edit_note."";
				$output .= "</li>\n";
			}
		}
		$output .= "</ul>\n<br />\n";

		if (!$this->GetConfigValue("revisions_hide_cancel")) $output .= "<input type=\"button\" value=\"".$this->GetTranslation("CancelDifferencesButton")."\" onclick=\"document.location='".addslashes($this->href(""))."';\" />\n";
		$output .= $this->FormClose()."\n";
	}
	print($output);
	$this->current_context--;
}
else
{
	echo $this->GetTranslation("ReadAccessDenied");
}
?>
</div>
