<?php echo $this->FormOpen("", $this->GetTranslation("TextSearchPage"), "get"); ?>
<div class="footer"><?php
echo $this->HasAccess("write") ? "<a href=\"".$this->href("edit")."\" accesskey=\"E\" title=\"".$this->GetTranslation("EditTip")."\">".$this->GetTranslation("EditText")."</a> |\n" : "";

// if this page exists
if ($this->page)
{
	// Revisions link
	echo $this->GetPageTime() ? "<a href=\"".$this->href("revisions")."\" title=\"".$this->GetTranslation("RevisionTip")."\">".$this->GetPageTime()."</a> |\n" : "";

	// if owner is current user
	if ($this->UserIsOwner())
	{
		print($this->GetTranslation("YouAreOwner"));
		print(" <a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetTranslation("RenameText")."\" alt=\"".$this->GetTranslation("RenameText")."\" /></a>");
		//      if (!$this->GetConfigValue("remove_onlyadmins") || $this->IsAdmin()) print(" <a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/del.gif\" title=\"".$this->GetTranslation("DeleteTip")."\" alt=\"".$this->GetTranslation("DeleteText")."\" /></a>");
		print(" | <a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").">".$this->GetTranslation("EditACLText")."</a>");
	}
	else
	{
		if ($owner = $this->GetPageOwner())
		{
			print($this->GetTranslation("Owner").$this->Link($owner));
		}
		else if (!$this->page["comment_on_id"])
		{
			print($this->GetTranslation("Nobody").($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">".$this->GetTranslation("TakeOwnership")."</a>)" : ""));
		}
	}

	if ($this->CheckACL($this->GetUserName(),$this->config["rename_globalacl"]) && !$this->UserIsOwner())
	{
		print(" <a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetTranslation("RenameText")."\" alt=\"".$this->GetTranslation("RenameText")."\" /></a>");

		// Edit ACLs link (shows also for Admins)
		print(" | <a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").">".$this->GetTranslation("EditACLText")."</a>");
	}

	if ($this->IsAdmin())
	{
		print(" <a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/del.gif\" title=\"".$this->GetTranslation("DeleteTip")."\" alt=\"".$this->GetTranslation("DeleteText")."\" /></a>");
	}

	if($this->HasAccess("write") && $this->GetUser() || $this->IsAdmin())
	{
		print(" | <a href=\"".$this->href("settings"). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditSettingsConfirm")."');\"":"").">".$this->GetTranslation("EditSettingsText")."</a> | ");
	}
}
?> <?php
if ($this->GetUser()){
	// Watch/Unwatch icon
	echo ($this->IsWatched($this->GetUserId(), $this->GetPageId()) ? "<a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/unvisibl.gif\" title=\"".$this->GetTranslation("RemoveWatch")."\" alt=\"".$this->GetTranslation("RemoveWatch")."\"  /></a>" : "<a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/visibl.gif\" title=\"".$this->GetTranslation("SetWatch")."\" alt=\"".$this->GetTranslation("SetWatch")."\" /></a>");
}
?> | <?php
// Print icon
echo"<a href=\"".$this->href("print")."\" target=\"_new\"><img src=\"".$this->GetConfigValue("theme_url")."icons/print.gif\" title=\"".$this->GetTranslation("PrintVersion")."\" alt=\"".$this->GetTranslation("PrintVersion")."\" /></a>";?>
|
<div class="searchbar"><span class="nobr"><?php echo $this->GetTranslation("SearchText") ?><input
	type="text" name="phrase" size="15" /></span></div>
</div>

<?php echo $this->FormClose(); ?>

<div id="credits"><?php
if ($this->GetUser())
{
	echo $this->GetTranslation("PoweredBy")." ".$this->Link("WackoWiki:HomePage", "", "WackoWiki ".$this->GetWackoVersion());
}
?></div>

<?php

//don't place final </body></html> here. Wacko closes HTML automatically.
?>