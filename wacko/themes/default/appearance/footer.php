<?php
/*
 Default theme.
 Common footer file.
 */

// Opens Search form
echo $this->FormOpen("", $this->GetResourceValue("TextSearchPage"), "get"); ?>
<div class="footer"><?php

// If User has rights to edit page, show Edit link
echo $this->HasAccess("write") ? "<a href=\"".$this->href("edit")."\" accesskey=\"E\" title=\"".$this->GetResourceValue("EditTip")."\">".$this->GetResourceValue("EditText")."</a> \n" : "";

// Revisions link
echo $this->GetPageTime() ? "| <a href=\"".$this->href("revisions")."\" title=\"".$this->GetResourceValue("RevisionTip")."\">".$this->GetPageTime()."</a> |\n" : "";

// If this page exists
if ($this->page)
{
	// If owner is current user
	if ($this->UserIsOwner())
	{
		print($this->GetResourceValue("YouAreOwner"));

		// Rename link
		print(" <a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetResourceValue("RenameText")."\" alt=\"".$this->GetResourceValue("RenameText")."\" /></a>");
		
		// Remove link (shows only for page owner if allowed)
		if (!$this->GetConfigValue("remove_onlyadmins")) print(" | <a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1del.gif\" title=\"".$this->GetResourceValue("DeleteTip")."\" alt=\"".$this->GetResourceValue("DeleteText")."\" /></a>");

		//Edit ACLs link
		print(" | <a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetResourceValue("EditACLConfirm")."');\"":"").">".$this->GetResourceValue("EditACLText")."</a>");
	}
	// If owner is NOT current user
	else
	{
		// Show Owner of this page
		if ($owner = $this->GetPageOwner())
		{
			print($this->GetResourceValue("Owner").$this->Link($owner));
		} else if (!$this->page["comment_on"]) {
			print($this->GetResourceValue("Nobody").($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">".$this->GetResourceValue("TakeOwnership")."</a>)" : ""));
		}
	}

	// Rename link
	if ($this->CheckACL($this->GetUserName(),$this->config["rename_globalacl"]) && !$this->UserIsOwner())
	{
		print(" <a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetResourceValue("RenameText")."\" alt=\"".$this->GetResourceValue("RenameText")."\" /></a>");
	}	
	// Remove link (shows only for Admins)
	if ($this->IsAdmin() && !$this->UserIsOwner())
	{
		print(" | <a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1del.gif\" title=\"".$this->GetResourceValue("DeleteTip")."\" alt=\"".$this->GetResourceValue("DeleteText")."\" /></a>");
		
		// Edit ACLs link (shows also for Admins)
		print(" | <a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetResourceValue("EditACLConfirm")."');\"":"").">".$this->GetResourceValue("EditACLText")."</a>");
	}
	
	if($this->HasAccess("write") || $this->IsAdmin())
	{
		// Page  settings link
		print(" | <a href=\"".$this->href("settings"). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetResourceValue("EditSettingsConfirm")."');\"":"").">".$this->GetResourceValue("EditSettingsText")."</a> | ");
// referrers icon
print("<a href=\"".$this->href("referrers")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/referer.gif\" title=\"".$this->GetResourceValue("ReferrersTip")."\" alt=\"".$this->GetResourceValue("ReferrersText")."\" border=\"0\" align=\"middle\" /></a>");
	}

?> <?php
if ($this->GetUser()){
	// Watch/Unwatch icon
	echo ($this->IsWatched($this->GetUserName(), $this->GetPageTag()) ? " | <a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1unvisibl.gif\" title=\"".$this->GetResourceValue("RemoveWatch")."\" alt=\"".$this->GetResourceValue("RemoveWatch")."\"  /></a>" : " | <a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/visibl.gif\" title=\"".$this->GetResourceValue("SetWatch")."\" alt=\"".$this->GetResourceValue("SetWatch")."\" /></a>");
}
?> | <?php
// Print icon
echo"<a href=\"".$this->href("print")."\" target=\"_new\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1print.gif\" title=\"".$this->GetResourceValue("PrintVersion")."\" alt=\"".$this->GetResourceValue("PrintVersion")."\" /></a>";

}
// Searchbar
?> | <span class="searchbar nobr"><?php echo $this->GetResourceValue("SearchText") ?><input
	type="text" name="phrase" size="15" /></span></div>
<?php

// Search form close
echo $this->FormClose();
?>

<div class="copyright"><?php 
if ($this->GetUser()){
	echo $this->GetResourceValue("PoweredBy")." ".$this->Link("WackoWiki:WackoWiki", "", "WackoWiki ".$this->GetWackoVersion());
}
?></div>

<?php

//Debug Querylog.
if ($this->GetConfigValue("debug")>=2)
{
	print("<span class=\"debug\">");
	print("<strong>Query log:</strong><br />\n");
	foreach ($this->queryLog as $query)
	{
		print($query["query"]." (".$query["time"].")<br />\n");
		$zz++;
	}
	print("<b>total: $zz</b>");
	print("</span>");
}

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>