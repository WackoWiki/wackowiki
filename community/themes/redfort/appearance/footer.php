<?php
/*
Default theme.
Common footer file.

Updated by Pavel Fedotov.
*/
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="1" align="left" valign="top" background="<?php echo $this->config['theme_url']."icons/bottom_line.gif"; ?>"><img src="<?php echo $this->config['theme_url']."icons/bottom_line.gif"; ?>" width="61" height="41"></td>
  </tr>
  <tr>
    <td align="left" valign="top" bgcolor="#990000">

<!-- !! -->
<?php
if ($this->method == 'show') {

	// files code starts
	if ($this->has_access('read') && $this->config['footer_files'] == 1 || ($this->config['footer_files'] == 2 && $this->get_user()))
	{
		require_once('handlers/page/_files.php');
	}

	// comments form output  starts
	if ($this->has_access('read') && ($this->config['footer_comments'] == 1 || ($this->config['footer_comments'] == 2 && $this->get_user()) ) && $this->user_allowed_comments())
	{
		require_once('handlers/page/_comments.php');
	}

	// rating form output begins
	if ($this->has_access('read') && $this->page && $this->config['footer_rating'] == 1 || ($this->config['footer_rating'] == 2 && $this->get_user()))
	{
		require_once('handlers/page/_rating.php');
	}
} //end of $this->method==show

?>
<!-- !!! -->
<?php
// Opens Search form
echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get'); ?>
<div class="footer">
<?php

// If User has rights to edit page, show Edit link
echo $this->has_access('write') ? "<a href=\"".$this->href('edit')."\" accesskey=\"E\" title=\"".$this->get_translation('EditTip')."\">".$this->get_translation('EditText')."</a> |\n" : "";

// Revisions link
echo (( $this->config['hide_revisions'] == false || ($this->config['hide_revisions'] == 1 && $this->get_user()) || ($this->config['hide_revisions'] == 2 && $this->user_is_owner()) || $this->is_admin() )
		? "<li><a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".$this->get_time_string_formatted($this->page['modified'])."</a></li>\n"
		: "<li>".$this->get_time_string_formatted($this->page['modified'])."</li>\n"
	);

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
// print("<a href=\"".$this->href('referrers')."\"><img src=\"".$this->config['theme_url']."icons/referer.gif\" title=\"".$this->get_translation('ReferrersTip')."\" alt=\"".$this->get_translation('ReferrersText')."\" border=\"0\" align=\"middle\" /></a> |");
}
?>
<?php
// Watch/Unwatch icon
echo ($this->iswatched === true ? "<a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/unwatch.gif\" title=\"".$this->get_translation('RemoveWatch')."\" alt=\"".$this->get_translation('RemoveWatch')."\"  align=\"middle\" border=\"0\" /></a>" : "<a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/watch.gif\" title=\"".$this->get_translation('SetWatch')."\" alt=\"".$this->get_translation('SetWatch')."\"  align=\"middle\" border=\"0\" /></a>" )
?> |
<?php
// Print icon
echo"<a href=\"".$this->href('print')."\"><img src=\"".$this->config['theme_url']."icons/print.gif\" title=\"".$this->get_translation('PrintVersion')."\" alt=\"".$this->get_translation('PrintVersion')."\"  align=\"middle\" border=\"0\" /></a>";

// Searchbar
?> |
  <span class="searchbar nobr"><?php echo $this->get_translation('SearchText') ?><input type="text" name="phrase" size="15" style="border: none; border-bottom: 1px solid #CCCCAA; padding: 0px; margin: 0px;" /></span>
<?php

// Search form close
echo $this->form_close();
?>
</div>
<div id="credits"><?php
if ($this->get_user()){
	echo $this->get_translation('PoweredBy').' '.$this->link('WackoWiki:HomePage', '', 'WackoWiki');
}
?>
</div>
	  </td>
  </tr>
</table>

<?php

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>