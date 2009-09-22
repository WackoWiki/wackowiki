<?php
/*
 Default theme.
 Common footer file.
 */
?>
</div>
<div id="footer">
<div class="footer">
<div class="footerlist">
<ul>
<?php
// If User has rights to edit page, show Edit link
echo $this->HasAccess("write") ? "<li><a href=\"".$this->href("edit")."\" accesskey=\"E\" title=\"".$this->GetTranslation("EditTip")."\">".$this->GetTranslation("EditText")."</a></li>\n" : "";

// If this page exists
if ($this->page)
{
	// Revisions link
	echo $this->GetPageTime() ? "<li><a href=\"".$this->href("revisions")."\" title=\"".$this->GetTranslation("RevisionTip")."\">".$this->GetPageTime()."</a></li>\n" : "";

	// If owner is current user
	if ($this->UserIsOwner())
	{
		print("<li>".$this->GetTranslation("YouAreOwner")."</li>\n");

		// Add page link
		(($this->method == 'new')
			? ""
			: print("<li><a href=\"".$this->href("new")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/add.gif\" title=\"".$this->GetTranslation("CreateNewPage")."\" alt=\"".$this->GetTranslation("CreateNewPage")."\" /></a></li>\n")
		);

		// Rename link
		print("<li><a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetTranslation("RenameText")."\" alt=\"".$this->GetTranslation("RenameText")."\" /></a></li>\n");

		// Remove link (shows only for page owner if allowed)
		if (!$this->GetConfigValue("remove_onlyadmins")) print("<li><a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/del.gif\" title=\"".$this->GetTranslation("DeleteTip")."\" alt=\"".$this->GetTranslation("DeleteText")."\" /></a></li>\n");

		//Edit ACLs link
		print("<li><a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").">".$this->GetTranslation("EditACLText")."</a></li>\n");
	}
	// If owner is NOT current user
	else
	{
		// Show Owner of this page
		if ($owner = $this->GetPageOwner())
		{
			print("<li>".$this->GetTranslation("Owner").$this->Link($owner)."</li>\n");
		}
		else if (!$this->page["comment_on_id"])
		{
			print("<li>".$this->GetTranslation("Nobody").($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">".$this->GetTranslation("TakeOwnership")."</a></li>\n)" : ""));
		}

		// Add page link
		(($this->method == 'new')
			? ""
			: print("<li><a href=\"".$this->href("new")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/add.gif\" title=\"".$this->GetTranslation("CreateNewPage")."\" alt=\"".$this->GetTranslation("CreateNewPage")."\" /></a></li>\n")
		);
	}

	// Rename link
	if ($this->CheckACL($this->GetUserName(),$this->config["rename_globalacl"]) && !$this->UserIsOwner())
	{
		print("<li><a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetTranslation("RenameText")."\" alt=\"".$this->GetTranslation("RenameText")."\" /></a></li>\n");
	}
	// Remove link (shows only for Admins)
	if ($this->IsAdmin() && !$this->UserIsOwner())
	{
		print("<li><a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/del.gif\" title=\"".$this->GetTranslation("DeleteTip")."\" alt=\"".$this->GetTranslation("DeleteText")."\" /></a></li>\n");

		// Edit ACLs link (shows also for Admins)
		print("<li><a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").">".$this->GetTranslation("EditACLText")."</a></li>\n");
	}

	if($this->HasAccess("write") && $this->GetUser() || $this->IsAdmin())
	{
		// Page  settings link
		print("<li><a href=\"".$this->href("settings"). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditSettingsConfirm")."');\"":"").">".$this->GetTranslation("EditSettingsText")."</a></li>\n");

		// referrers icon
		print("<li><a href=\"".$this->href("referrers")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/referer.gif\" title=\"".$this->GetTranslation("ReferrersTip")."\" alt=\"".$this->GetTranslation("ReferrersText")."\" /></a></li>\n");
	}

	if ($this->GetUser())
	{
		// Watch/Unwatch icon
		echo ($this->IsWatched($this->GetUserId(), $this->GetPageId()) ? "<li><a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/unvisibl.gif\" title=\"".$this->GetTranslation("RemoveWatch")."\" alt=\"".$this->GetTranslation("RemoveWatch")."\"  /></a></li>\n" : "<li><a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/visibl.gif\" title=\"".$this->GetTranslation("SetWatch")."\" alt=\"".$this->GetTranslation("SetWatch")."\" /></a></li>\n");
	}

	// Print icon
	echo"<li><a href=\"".$this->href("print")."\" target=\"_new\"><img src=\"".$this->GetConfigValue("theme_url")."icons/print.gif\" title=\"".$this->GetTranslation("PrintVersion")."\" alt=\"".$this->GetTranslation("PrintVersion")."\" /></a></li>\n";
}

?>
</ul>
</div>
</div>
<div id="credits"><?php
if ($this->GetUser())
{
	echo $this->GetTranslation("PoweredBy")." ".$this->Link("WackoWiki:HomePage", "", "WackoWiki ".$this->GetWackoVersion());
}
?></div>
</div>
</div>
<?php

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>