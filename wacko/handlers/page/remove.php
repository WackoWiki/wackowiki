<div id="page">
<?php

// obviously do not allow to remove non-existent pages
if (!$this->page) $this->Redirect($this->href());

// check user permissions to delete
if ($this->IsAdmin() ||
(!$this->GetConfigValue("remove_onlyadmins") &&
(
$this->GetPageOwner($this->tag) == $this->GetUserName() ||
$this->GetPageOwnerFromComment() == $this->GetUserName()
)
)
)
{
	if (!$this->page)
	{
		print(str_replace("%1",$this->href("edit"),$this->GetTranslation("DoesNotExists")));
	}
	else
	{
		if ($_POST["delete"]==1) {

			if ($this->page["comment_on"])
			$comment_on = $this->page["comment_on"];

			// Remove page
			if ($this->RemoveReferrers($this->tag))
			{
				print(str_replace("%1",$this->tag,$this->GetTranslation("ReferrersRemoved"))."<br />\n");
			}
			if ($this->RemoveLinks($this->tag))
			{
				print(str_replace("%1",$this->tag,$this->GetTranslation("LinksRemoved"))."<br />\n");
			}
			if ($this->RemoveAcls($this->tag))
			{
				print(str_replace("%1",$this->tag,$this->GetTranslation("AclsRemoved"))."<br />\n");
			}
			if ($this->RemoveWatches($this->tag))
			{
				print(str_replace("%1",$this->tag,$this->GetTranslation("WatchesRemoved"))."<br />\n");
			}
			if ($this->RemoveComments($this->tag))
			{
				$this->WriteRecentCommentsXML();
				print(str_replace("%1",$this->tag,$this->GetTranslation("CommentsRemoved"))."<br />\n");
			}
			if ($this->RemoveFiles($this->tag))
			{
				print(str_replace("%1",$this->tag,$this->GetTranslation("FilesRemoved"))."<br />\n");
			}
			if ($this->RemovePage($this->tag))
			{
				$this->WriteRecentChangesXML();
				$this->WriteRecentCommentsXML();
				print(str_replace("%1",$this->tag,$this->GetTranslation("PageRemoved"))."<br />\n");
			}

			print($this->GetTranslation("ThisActionHavenotUndo")."\n");

	  // return to commented page
		if ($comment_on)
		{
			echo "<br />".$this->ComposeLinkToPage($comment_on."#comments", "", $this->GetTranslation("ReturnToCommented"), 0);
		}
		}
		else 
		{
			echo "<div class=\"warning\"><strong>".$this->GetTranslation("ReallyDelete".($this->page["comment_on"]?"Comment":""))."</strong></div>";
			echo $this->FormOpen("remove");
			
		// show backlinks
		if ($pages = $this->LoadPagesLinkingTo($this->getPageTag()))
		{
			print("<br /><fieldset><legend>".$this->GetTranslation("AlertReferringPages").":</legend>\n");
			foreach ($pages as $page)
			{
				if ($page["tag"])
				{
					if ($this->config["hide_locked"]) $access = $this->HasAccess("read",$page["tag"]);
					else $access = true;
					if ($access)
					{
						echo($this->ComposeLinkToPage($page["tag"])."<br />\n");
					}
				}
			}
			echo "</fieldset>\n";
		}

?>
  <br />
  <br />
  <input type="hidden" name="delete" value="1" />
  <input name="submit"
	class="OkBtn_Top" onmouseover='this.className="OkBtn_Top_";'
	onmouseout='this.className="OkBtn_Top";' type="submit" align="top"
	value="<?php echo $this->GetTranslation("RemoveButton"); ?>" />
  &nbsp;
  <input
	class="CancelBtn_Top" onmouseover='this.className="CancelBtn_Top_";'
	onmouseout='this.className="CancelBtn_Top";' type="button" align="top"
	value="<?php echo str_replace("\n"," ",$this->GetTranslation("EditCancelButton")); ?>"
	onclick="document.location='<?php echo addslashes($this->href(""))?>';" />
  <br />
  <?php echo $this->FormClose();
		}
	}
}
else
{
	print($this->GetTranslation("NotOwnerAndCanDelete"));
}
?>
</div>
