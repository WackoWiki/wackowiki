<?php 
/*
Default theme.
Common footer file.
*/

// Opens Search form
?>
<div class="footer">
<?php

// If User has rights to edit page, show Edit link
echo $this->HasAccess("write") ? "<a href=\"".$this->href("edit")."\" accesskey=\"E\" title=\"".$this->GetTranslation("EditTip")."\">".$this->GetTranslation("EditText")."</a> |\n" : "";

// Revisions link
echo $this->GetPageTime() ? "<a href=\"".$this->href("revisions")."\" title=\"".$this->GetTranslation("RevisionTip")."\">".$this->GetPageTime()."</a> |\n" : "";

// If this page exists
if ($this->page)
{
 // If owner is current user
 if ($this->UserIsOwner())
 {
   print($this->GetTranslation("YouAreOwner"));

   // Rename link
   print(" <a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetTranslation("RenameText")."\" alt=\"".$this->GetTranslation("RenameText")."\" /></a>");
//   if (!$this->GetConfigValue("remove_onlyadmins") || $this->IsAdmin()) print(" <a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1del.gif\" title=\"".$this->GetTranslation("DeleteTip")."\" alt=\"".$this->GetTranslation("DeleteText")."\" /></a>");

   //Edit ACLs link
   print(" | <a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").">".$this->GetTranslation("EditACLText")."</a>");
 }
 // If owner is NOT current user
 else
 {
   // Show Owner of this page
   if ($owner = $this->GetPageOwner())
   {
     print($this->GetTranslation("Owner").$this->Link($owner));
   } else if (!$this->page["comment_on"]) {
     print($this->GetTranslation("Nobody").($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">".$this->GetTranslation("TakeOwnership")."</a>)" : ""));
   }
 }

 // Rename link
 if ($this->CheckACL($this->GetUserName(),$this->config["rename_globalacl"]) && !$this->UserIsOwner())
 {
   print(" <a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetTranslation("RenameText")."\" alt=\"".$this->GetTranslation("RenameText")."\" /></a>");
 }

 // Remove link (shows only for Admins)
 if ($this->IsAdmin())
 {
   print(" <a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1del.gif\" title=\"".$this->GetTranslation("DeleteTip")."\" alt=\"".$this->GetTranslation("DeleteText")."\" /></a>");
 }

 // Page  settings link
 print(" | <a href=\"".$this->href("settings"). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").">".$this->GetTranslation("SettingsText")."</a> | ");
print("<a href=\"".$this->href("referrers")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/referer.gif\" title=\"".$this->GetTranslation("ReferrersTip")."\" alt=\"".$this->GetTranslation("ReferrersText")."\" /></a> |");
}
?>
<?php 
// Watch/Unwatch icon
echo ($this->IsWatched($this->GetUserName(), $this->GetPageTag()) ? "<a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1unvisibl.gif\" title=\"".$this->GetTranslation("RemoveWatch")."\" alt=\"".$this->GetTranslation("RemoveWatch")."\"  /></a>" : "<a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/visibl.gif\" title=\"".$this->GetTranslation("SetWatch")."\" alt=\"".$this->GetTranslation("SetWatch")."\" /></a>" ) 
?> | 
<?php 
// Print icon
echo"<a href=\"".$this->href("print")."\" target=\"_new\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1print.gif\" title=\"".$this->GetTranslation("PrintVersion")."\" alt=\"".$this->GetTranslation("PrintVersion")."\" /></a>";
?>

</div>

<div id="credits">
<?php 
if ($this->GetUser()){
	echo $this->GetTranslation("PoweredBy")." ".$this->Link("WackoWiki:HomePage", "", "WackoWiki ".$this->GetWackoVersion());
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