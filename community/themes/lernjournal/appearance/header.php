<?php
/*
lernjournal theme.
*/

require ('themes/_common/_header.php');

?>
<body onload="all_init();">
<div id="head">
  <div id="wikititle"><?php echo $this->config['site_name'] ?></div>
  <?php
// Searchbar
echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get'); ?>
  <div id="search"><?php echo $this->get_translation('SearchText') ?><input name="phrase" type="text" size="12" style="border: none; padding: 0px; margin: 0px;" /></div>
  <?php
// Search form close
echo $this->form_close();
?>
</div>
<div id="container">
<div id="navi">
<?php
// outputs bookmarks menu
	echo '<div id="usermenu">';
	echo "<ol>\n";
	// main page
	echo "<li>".$this->compose_link_to_page($this->config['root_page'])."</li>\n";

	// menu
	if ($menu = $this->get_menu())
	{
		foreach ($menu as $menu_item)
		{
			$formatted_menu = $this->format($menu_item[1], 'post_wacko');

			if ($this->page['page_id'] == $menu_item[0])
			{
				echo '<li class="active">';
			}
			else
			{
				echo '<li>';
			}

			echo $formatted_menu."</li>\n";
		}
	}

	if ($this->get_user())
	{
		// determines what it should show: "add to bookmarks" or "remove from bookmarks" icon
		if (!in_array($this->page['page_id'], $this->get_menu_links()))
		{
			echo '<li><a href="'. $this->href('', '', 'addbookmark=yes')
				.'"><img src="'. $this->config['theme_url']
				.'icons/bookmark1.gif" alt="+" title="'.
				$this->get_translation('AddToBookmarks') .'"/></a></li>';
		}
		else
		{
			echo '<li><a href="'. $this->href('', '', 'removebookmark=yes')
				.'"><img src="'. $this->config['theme_url']
				.'icons/bookmark2.gif" alt="-" title="'.
				$this->get_translation('RemoveFromBookmarks') .'"/></a></li>';
		}
	}
	echo "\n</ol></div>";
?>
  <hr noshade="noshade" />
  <?php
// If user are logged, Wacko shows "You are UserName"
if ($this->get_user()) { ?>
  <?php echo $this->get_translation('YouAre')." ".$this->link($this->config['users_page'].'/'.$this->get_user_name(), '', $this->get_user_name()) ?><br />
  <small>
  <?php
      echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?><br />
  <a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></small>
  <?php
// Else Wacko shows login's controls
} else {
?><br />
  <?php
// Begin Login form
echo $this->form_open('', $this->get_translation('LoginPage'), 'post'); ?>
  <input type="hidden" name="action" value="login" />
  <input type="hidden" name="goback" value="<?php echo $this->slim_url($this->tag);?>" />
  <?php echo $this->get_translation('LoginWelcome') ?>:<br />
  <input type="text" name="name" size="12" class="login" alt="username" /><br />
  <?php echo $this->get_translation('LoginPassword') ?>:<br />
  <input type="password" name="password" class="login" size="8" alt="password" />
  <input type="image" src="<?php echo $this->config['theme_url'] ?>icons/login.gif" alt=">>>" align="top" />
  <?php // Closing Login form
echo $this->form_close();
?>
  <?php
}
// End if
?>
  <hr noshade="noshade" /><br />
  <?php
// If this page exists
if ($this->page)
{
 // If owner is current user
 if ($this->user_is_owner())
 {
   print($this->get_translation('YouAreOwner')."<br /> \n");

   // Rename link: Hinzugefügt: if ($this->is_admin())
 if ($this->is_admin())  {
 print(" <a href=\"".$this->href('rename')."\">".$this->get_translation('RenameText')."</a><br /> \n");}

   //Edit ACLs link
   print("<a href=\"".$this->href('permissions')."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"").">".$this->get_translation('ACLText')."</a>");
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
// If User has rights to edit page, show Edit link
echo $this->has_access('write') ? "<br /><a href=\"".$this->href('edit')."\" accesskey=\"E\" title=\"".$this->get_translation('EditTip')."\"><strong>".$this->get_translation('EditText')."</strong></a>" : "";
?><br />
  <?php
// Watch/Unwatch icon
echo ($this->iswatched === true ? "<a href=\"".$this->href('watch')."\">".$this->get_translation('RemoveWatch')."</a>" : "<a href=\"".$this->href('watch')."\">".$this->get_translation('SetWatch')."</a>" );
?><br />
  <?php
 // Rename link
 if ($this->check_acl($this->get_user_name(),$this->config['rename_globalacl']) && !$this->user_is_owner())
 {
   print("<a href=\"".$this->href('rename')."\">".$this->get_translation('RenameText')."</a><br />");
 }
 // Page  settings link
 print("<a href=\"".$this->href('properties'). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"").">".$this->get_translation('SettingsText')."</a><br />");
}
// Remove link (shows only for Admins)
if ($this->is_admin()){
	print("<a href=\"".$this->href('remove')."\">".$this->get_translation('DeleteTip')."</a><br />");
}
?>
<?php
// Print icon
echo"<a href=\"".$this->href('print')."\"><img src=\"".$this->config['theme_url']."icons/print.gif\" title=\"".$this->get_translation('PrintVersion')."\" alt=\"".$this->get_translation('PrintVersion')."\"  align=\"middle\" border=\"0\" /></a>";

?>

<hr noshade="noshade" />
<?php
// Revisions link
	echo (( $this->config['hide_revisions'] == false || ($this->config['hide_revisions'] == 1 && $this->get_user()) || ($this->config['hide_revisions'] == 2 && $this->user_is_owner()) || $this->is_admin() )
			? "<li><a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".$this->get_time_string_formatted($this->page['modified'])."</a></li>\n"
			: "<li>".$this->get_time_string_formatted($this->page['modified'])."</li>\n"
		);
?>
</div>
<div id="content">
<span class="loc"><strong><?php echo $this->config['site_name'] ?>:</strong> <?php echo $this->get_page_path(); ?><a title="<?php echo $this->get_translation('SearchTitleTip')?>" href="<?php echo $this->config['base_url'].$this->get_translation('TextSearchPage').($this->config['rewrite_mode'] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a></span> <?php # if (mysql_num_rows(mysql_query("SELECT status FROM ".$this->config['table_prefix']."mail where UserTo='".$this->get_user_name()."' and folder='inbox' and status='nicht gelesen' and viewrecipient='Y' LIMIT 1"))!=0) {echo "&nbsp;&nbsp;&nbsp;<img src=\"images/newmessage1.gif\" alt=\"Neue Nachricht\" width=\"18\" height=\"18\" /> <a href='index.php?page=WikiMessenger' title='Du hast mindestens eine neue Nachricht erhalten.'><font color=orangered><strong>&nbsp;Neue Nachricht</strong></font></a>";} ?>

<?php # if ($user = $this->get_user()) { include('actions/popupchat.php'); } ?>
<?php
// here we show messages
if ($message = $this->get_message()) echo "<div class=\"info\">$message</div>";
?>