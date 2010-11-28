<?php
/*
Default theme.
Common footer file.
*/
if ($this->get_user()){
?>
<div class="footer">
<?php

// If User has rights to edit page, show Edit link
echo $this->has_access('write') ? "<a href=\"".$this->href('edit')."\" accesskey=\"E\" title=\"".$this->get_translation('EditTip')."\">".$this->get_translation('EditText')."</a> |\n" : "";

// Revisions link
echo $this->page['modified'] ? "<a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".$this->get_page_time_formatted()."</a> |\n" : "";

// If this page exists
if ($this->page)
{
 // If owner is current user
 if ($this->user_is_owner())
 {
   print($this->get_translation('YouAreOwner'));

   // Rename link
   print(" <a href=\"".$this->href('rename')."\"><img src=\"".$this->config['theme_url']."icons/rename.gif\" title=\"".$this->get_translation('RenameText')."\" alt=\"".$this->get_translation('RenameText')."\" align=\"middle\" border=\"0\" /></a>");
//   if (!$this->config['remove_onlyadmins'] || $this->is_admin()) print(" <a href=\"".$this->href('remove')."\"><img src=\"".$this->config['theme_url']."icons/delete.gif\" title=\"".$this->get_translation('DeleteTip')."\" alt=\"".$this->get_translation('DeleteText')."\" align=\"middle\" border=\"0\" /></a>");

   //Edit ACLs link
   print(" | <a href=\"".$this->href('permissions')."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"").">".$this->get_translation('ACLText')."</a>");
 }
 // If owner is NOT current user
 else
 {
   // Show Owner of this page
   if ($owner = $this->get_page_owner())
   {
     print($this->get_translation('Owner').": ".$this->link($owner));
   } else if (!$this->page['comment_on_id']) {
     print($this->get_translation('Nobody').($this->get_user() ? " (<a href=\"".$this->href('claim')."\">".$this->get_translation('TakeOwnership')."</a>)" : ""));
   }
 }

 // Rename link
 if ($this->check_acl($this->get_user_name(),$this->config['rename_globalacl']) && !$this->user_is_owner())
 {
   print(" <a href=\"".$this->href('rename')."\"><img src=\"".$this->config['theme_url']."icons/rename.gif\" title=\"".$this->get_translation('RenameText')."\" alt=\"".$this->get_translation('RenameText')."\" align=\"middle\" border=\"0\" /></a>");
 }

 // Remove link (shows only for Admins)
 if ($this->is_admin())
 {
   print(" <a href=\"".$this->href('remove')."\"><img src=\"".$this->config['theme_url']."icons/delete.gif\" title=\"".$this->get_translation('DeleteTip')."\" alt=\"".$this->get_translation('DeleteText')."\"  align=\"middle\" border=\"0\" /></a>");
 }

 // Page  settings link
 print(" | <a href=\"".$this->href('properties'). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"").">".$this->get_translation('SettingsText')."</a> | ");
print("<a href=\"".$this->href('referrers')."\"><img src=\"".$this->config['theme_url']."icons/referer.gif\" title=\"".$this->get_translation('ReferrersTip')."\" alt=\"".$this->get_translation('ReferrersText')."\" border=\"0\" align=\"middle\" /></a> |");
}
?>
<?php
// Watch/Unwatch icon
echo ($this->iswatched === true ? "<a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/unwatch.gif\" title=\"".$this->get_translation('RemoveWatch')."\" alt=\"".$this->get_translation('RemoveWatch')."\"  align=\"middle\" border=\"0\" /></a>" : "<a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/watch.gif\" title=\"".$this->get_translation('SetWatch')."\" alt=\"".$this->get_translation('SetWatch')."\"  align=\"middle\" border=\"0\" /></a>" )
?> |
<?php
// Print icon
echo"<a href=\"".$this->href('print')."\" target=\"_blank\"><img src=\"".$this->config['theme_url']."icons/print.gif\" title=\"".$this->get_translation('PrintVersion')."\" alt=\"".$this->get_translation('PrintVersion')."\"  align=\"middle\" border=\"0\" /></a>";

?>

</div>
<?php
}
?>
<div id="credits">
<?php
/*
if ($this->get_user()){
	echo $this->get_translation('PoweredBy').' '.$this->link('WackoWiki:WackoWiki', '', 'WackoWiki '.$this->get_wacko_version());
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