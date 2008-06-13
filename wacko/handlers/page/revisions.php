<div class="pageBefore">&nbsp;</div>
<div class="page">
  <?php
if ($this->HasAccess("read")) {
	// load revisions for this page
	if ($pages = $this->LoadRevisions($this->tag))
	{
		$this->context[++$this->current_context] = "";
		$output .= $this->FormOpen("diff", "", "get");
		$output .= "<p>\n";
		$output .= "<input type=\"submit\" value=\"".$this->GetResourceValue("ShowDifferencesButton")."\" />";
		$output .= "&nbsp;&nbsp;&nbsp;<input type=\"checkbox\" name=\"fastdiff\" />\n".$this->GetResourceValue("SimpleDiff");
		$output .= "&nbsp;&nbsp;&nbsp;<a href=\"".$this->href("revisions.xml")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/xml.gif"."\" title=\"".$this->GetResourceValue("RevisionXMLTip")."\" alt=\"XML\" /></a>";
		$output .= "</p>\n";
		$output .= "<p>\n";
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
			if (($c <= $max) || !$max)
			{
				$output .= "<input type=\"radio\" name=\"a\" value=\"".($c==1?"-1":$page["id"])."\" ".($c == 1 ? "checked=\"checked\"" : "")." />";
				$output .= "&nbsp;&nbsp;&nbsp;<input type=\"radio\" name=\"b\" value=\"".($c==1?"-1":$page["id"])."\" ".($c == 2 ? "checked=\"checked\"" : "")." />";
				$output .= "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"".$this->href("show").($this->GetConfigValue("rewrite_mode")?"?":"&amp;")."time=".urlencode($page["time"])."\">".$page["time"]."</a>";
				$output .= "&nbsp;&nbsp;&nbsp;&nbsp;".$this->GetResourceValue("By")." ".($this->IsWikiName($page["user"])?$this->Link($page["user"]):$page["user"])."";
			}
		}
		$output .= "</p><br />\n";
		if (!$this->GetConfigValue("revisions_hide_cancel")) $output .= "<input type=\"button\" value=\"".$this->GetResourceValue("CancelDifferencesButton")."\" onclick=\"document.location='".addslashes($this->href(""))."';\" />\n";
		$output .= $this->FormClose()."\n";
	}
	print($output);
	$this->current_context--;
} else {
	print($this->GetResourceValue("ReadAccessDenied"));
}
?>
</div>
