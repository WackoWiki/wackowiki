<div class="pageBefore"><img
	src="<?php echo $this->GetConfigValue("root_url"); ?>images/z.gif"
	width="1" height="1" border="0" alt="" style="display: block"
	align="top" /></div>
<div class="page"><?php

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
		print(str_replace("%1",$this->href("edit"),$this->GetResourceValue("DoesNotExists")));
	}
	else
	{
		if ($_POST["delete"]==1) {

			if ($this->page["comment_on"])
			$comment_on = $this->page["comment_on"];

			// Remove page
			if ($this->RemoveReferrers($this->tag))
			{
				print(str_replace("%1",$this->tag,$this->GetResourceValue("ReferrersRemoved"))."<br />\n");
			}
			if ($this->RemoveLinks($this->tag))
			{
				print(str_replace("%1",$this->tag,$this->GetResourceValue("LinksRemoved"))."<br />\n");
			}
			if ($this->RemoveAcls($this->tag))
			{
				print(str_replace("%1",$this->tag,$this->GetResourceValue("AclsRemoved"))."<br />\n");
			}
			if ($this->RemovePage($this->tag))
			{
				$this->WriteRecentChangesXML();
				$this->WriteRecentCommentsXML();
				print(str_replace("%1",$this->tag,$this->GetResourceValue("PageRemoved"))."<br />\n");
			}
			if ($this->RemoveWatches($this->tag))
			{
				print("\n");
			}
			if ($this->RemoveComments($this->tag))
			{
				$this->WriteRecentCommentsXML();
				print("\n");
			}

			print($this->GetResourceValue("ThisActionHavenotUndo")."\n");

	  // return to commented page
	  if ($comment_on)
	  {
	  	echo "<br />".$this->ComposeLinkToPage($comment_on."#comments", "", $this->GetResourceValue("ReturnToCommented"), 0);
	  }
		}
		else {
			echo "<h1>".$this->GetResourceValue("ReallyDelete".($this->page["comment_on"]?"Comment":""))."</h1>";
			echo $this->FormOpen("remove");

			if ($pages = $this->LoadPagesLinkingTo($this->getPageTag()))
			{
				print("<fieldset><legend>".$this->GetResourceValue("AlertReferringPages").":</legend>\n");
				foreach ($pages as $page)
				{
					echo($this->ComposeLinkToPage($page["tag"])."<br />\n");
				}
				echo "</fieldset>\n";
			}

			?> <br />
<br />
<input type="hidden" name="delete" value="1" /> <input name="submit"
	class="OkBtn_Top" onmouseover='this.className="OkBtn_Top_";'
	onmouseout='this.className="OkBtn_Top";' type="submit" align="top"
	value="<?php echo $this->GetResourceValue("RemoveButton"); ?>" /> <img
	src="<?php echo $this->GetConfigValue("root_url");?>images/z.gif"
	width="100" height="1" alt="" border="0" /> <input
	class="CancelBtn_Top" onmouseover='this.className="CancelBtn_Top_";'
	onmouseout='this.className="CancelBtn_Top";' type="button" align="top"
	value="<?php echo str_replace("\n"," ",$this->GetResourceValue("EditCancelButton")); ?>"
	onclick="document.location='<?php echo addslashes($this->href(""))?>';" /><br />
			<?php echo $this->FormClose();
}
}
}
else
{
	print($this->GetResourceValue("NotOwnerAndCanDelete"));
}
?></div>
