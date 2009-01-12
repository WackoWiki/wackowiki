<?php
/*
Default theme.
Common footer file.
*/
?>
</div>
<div class="footer">
<div class="footerlist">
<ul>
<?php
// If User has rights to edit page, show Edit link
echo $this->HasAccess("write") ? "<li><a href=\"".$this->href("edit")."\" accesskey=\"E\" title=\"".$this->GetResourceValue("EditTip")."\">".$this->GetResourceValue("EditText")."</a></li>\n" : "";

// If this page exists
if ($this->page)
{
	// Revisions link
	echo $this->GetPageTime() ? "<li><a href=\"".$this->href("revisions")."\" title=\"".$this->GetResourceValue("RevisionTip")."\">".$this->GetPageTime()."</a></li>\n" : "";

	// If owner is current user
	if ($this->UserIsOwner())
	{
		print("<li>".$this->GetResourceValue("YouAreOwner")."</li>\n");

		// Rename link
		print("<li><a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetResourceValue("RenameText")."\" alt=\"".$this->GetResourceValue("RenameText")."\" /></a></li>\n");
		
		// Remove link (shows only for page owner if allowed)
		if (!$this->GetConfigValue("remove_onlyadmins")) print("<li><a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1del.gif\" title=\"".$this->GetResourceValue("DeleteTip")."\" alt=\"".$this->GetResourceValue("DeleteText")."\" /></a></li>\n");

		//Edit ACLs link
		print("<li><a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetResourceValue("EditACLConfirm")."');\"":"").">".$this->GetResourceValue("EditACLText")."</a></li>\n");
	}
	// If owner is NOT current user
	else
	{
		// Show Owner of this page
		if ($owner = $this->GetPageOwner())
		{
			print("<li>".$this->GetResourceValue("Owner").$this->Link($owner)."</li>\n");
		} else if (!$this->page["comment_on"]) {
			print("<li>".$this->GetResourceValue("Nobody").($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">".$this->GetResourceValue("TakeOwnership")."</a></li>\n)" : ""));
		}
	}

	// Rename link
	if ($this->CheckACL($this->GetUserName(),$this->config["rename_globalacl"]) && !$this->UserIsOwner())
	{
		print("<li><a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetResourceValue("RenameText")."\" alt=\"".$this->GetResourceValue("RenameText")."\" /></a></li>\n");
	}	
	// Remove link (shows only for Admins)
	if ($this->IsAdmin() && !$this->UserIsOwner())
	{
		print("<li><a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1del.gif\" title=\"".$this->GetResourceValue("DeleteTip")."\" alt=\"".$this->GetResourceValue("DeleteText")."\" /></a></li>\n");
		
		// Edit ACLs link (shows also for Admins)
		print("<li><a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetResourceValue("EditACLConfirm")."');\"":"").">".$this->GetResourceValue("EditACLText")."</a></li>\n");
	}
	
	if($this->HasAccess("write") && $this->GetUser() || $this->IsAdmin())
	{
		// Page  settings link
		print("<li><a href=\"".$this->href("settings"). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetResourceValue("EditSettingsConfirm")."');\"":"").">".$this->GetResourceValue("EditSettingsText")."</a></li>\n");
// referrers icon
print("<li><a href=\"".$this->href("referrers")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/referer.gif\" title=\"".$this->GetResourceValue("ReferrersTip")."\" alt=\"".$this->GetResourceValue("ReferrersText")."\" /></a></li>\n");
	}

if ($this->GetUser()){
	// Watch/Unwatch icon
	echo ($this->IsWatched($this->GetUserName(), $this->GetPageTag()) ? "<li><a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1unvisibl.gif\" title=\"".$this->GetResourceValue("RemoveWatch")."\" alt=\"".$this->GetResourceValue("RemoveWatch")."\"  /></a></li>\n" : "<li><a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/visibl.gif\" title=\"".$this->GetResourceValue("SetWatch")."\" alt=\"".$this->GetResourceValue("SetWatch")."\" /></a></li>\n");
}

// Print icon
echo"<li><a href=\"".$this->href("print")."\" target=\"_new\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1print.gif\" title=\"".$this->GetResourceValue("PrintVersion")."\" alt=\"".$this->GetResourceValue("PrintVersion")."\" /></a></li>\n";

}
?>
<li>
<?php
// Opens Search form
echo $this->FormOpen("", $this->GetResourceValue("TextSearchPage"), "get");

// Searchbar
?>
<span class="searchbar nobr"><label for="phrase"><?php echo $this->GetResourceValue("SearchText"); ?></label><input
	type="text" name="phrase" id="phrase" size="15" /><input class="submitinput" type="submit" title="<?php echo $this->GetResourceValue("SearchButtonText") ?>" alt="<?php echo $this->GetResourceValue("SearchButtonText") ?>" value="»"/></span>
<?php

// Search form close
echo $this->FormClose();
?>
</li>
</ul>
</div>
</div>
<div class="copyright"><?php 
if ($this->GetUser()){
	echo $this->GetResourceValue("PoweredBy")." ".$this->Link("WackoWiki:HomePage", "", "WackoWiki ".$this->GetWackoVersion());
}
?>
</div>
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