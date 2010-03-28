<?php
/*
Default theme.
Common footer file.
*/
if ($this->GetUser()){
?>
<div class="footer">
<?php

// If User has rights to edit page, show Edit link
echo $this->HasAccess("write") ? "<a href=\"".$this->href("edit")."\" accesskey=\"E\" title=\"".$this->GetTranslation("EditTip")."\">".$this->GetTranslation("EditText")."</a> |\n" : "";

// Revisions link
echo $this->GetPageTime() ? "<a href=\"".$this->href("revisions")."\" title=\"".$this->GetTranslation("RevisionTip")."\">".$this->GetPageTimeFormatted()."</a> |\n" : "";

// If this page exists
if ($this->page)
{
 // If owner is current user
 if ($this->UserIsOwner())
 {
   print($this->GetTranslation("YouAreOwner"));

   // Rename link
   print(" <a href=\"".$this->href("rename")."\"><img src=\"".$this->config["theme_url"]."icons/rename.gif\" title=\"".$this->GetTranslation("RenameText")."\" alt=\"".$this->GetTranslation("RenameText")."\" align=\"middle\" border=\"0\" /></a>");
//   if (!$this->config["remove_onlyadmins"] || $this->IsAdmin()) print(" <a href=\"".$this->href("remove")."\"><img src=\"".$this->config["theme_url"]."icons/delete.gif\" title=\"".$this->GetTranslation("DeleteTip")."\" alt=\"".$this->GetTranslation("DeleteText")."\" align=\"middle\" border=\"0\" /></a>");

   //Edit ACLs link
   print(" | <a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").">".$this->GetTranslation("EditACLText")."</a>");
 }
 // If owner is NOT current user
 else
 {
   // Show Owner of this page
   if ($owner = $this->GetPageOwner())
   {
     print($this->GetTranslation("Owner").": ".$this->Link($owner));
   } else if (!$this->page["comment_on_id"]) {
     print($this->GetTranslation("Nobody").($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">".$this->GetTranslation("TakeOwnership")."</a>)" : ""));
   }
 }

 // Rename link
 if ($this->CheckACL($this->GetUserName(),$this->config["rename_globalacl"]) && !$this->UserIsOwner())
 {
   print(" <a href=\"".$this->href("rename")."\"><img src=\"".$this->config["theme_url"]."icons/rename.gif\" title=\"".$this->GetTranslation("RenameText")."\" alt=\"".$this->GetTranslation("RenameText")."\" align=\"middle\" border=\"0\" /></a>");
 }

 // Remove link (shows only for Admins)
 if ($this->IsAdmin())
 {
   print(" <a href=\"".$this->href("remove")."\"><img src=\"".$this->config["theme_url"]."icons/delete.gif\" title=\"".$this->GetTranslation("DeleteTip")."\" alt=\"".$this->GetTranslation("DeleteText")."\"  align=\"middle\" border=\"0\" /></a>");
 }

 // Page  settings link
 print(" | <a href=\"".$this->href("settings"). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").">".$this->GetTranslation("SettingsText")."</a> | ");
print("<a href=\"".$this->href("referrers")."\"><img src=\"".$this->config["theme_url"]."icons/referer.gif\" title=\"".$this->GetTranslation("ReferrersTip")."\" alt=\"".$this->GetTranslation("ReferrersText")."\" border=\"0\" align=\"middle\" /></a> |");
}
?>
<?php
// Watch/Unwatch icon
echo ($this->iswatched === true ? "<a href=\"".$this->href("watch")."\"><img src=\"".$this->config["theme_url"]."icons/unwatch.gif\" title=\"".$this->GetTranslation("RemoveWatch")."\" alt=\"".$this->GetTranslation("RemoveWatch")."\"  align=\"middle\" border=\"0\" /></a>" : "<a href=\"".$this->href("watch")."\"><img src=\"".$this->config["theme_url"]."icons/watch.gif\" title=\"".$this->GetTranslation("SetWatch")."\" alt=\"".$this->GetTranslation("SetWatch")."\"  align=\"middle\" border=\"0\" /></a>" )
?> |
<?php
// Print icon
echo"<a href=\"".$this->href("print")."\" target=\"_new\"><img src=\"".$this->config["theme_url"]."icons/print.gif\" title=\"".$this->GetTranslation("PrintVersion")."\" alt=\"".$this->GetTranslation("PrintVersion")."\"  align=\"middle\" border=\"0\" /></a>";

?>

</div>
<?php
}
?>
<div id="credits">
<?php
/*
if ($this->GetUser()){
	echo $this->GetTranslation("PoweredBy")." ".$this->Link("WackoWiki:WackoWiki", "", "WackoWiki ".$this->GetWackoVersion());
}
*/
?>
</div>

<?php

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>

</td>
              </tr>
            </table>