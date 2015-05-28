<?php
/*
CoolBlue theme.

*/

require ('themes/_common/_header.php');

?>
<body onload="all_init();">
<div id="head">
  <?php
// Searchbar
echo $this->form_open('search', '', 'get', $this->get_translation('TextSearchPage')); ?>
  <input name="phrase" type="text" id="search" />
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
				.'icons/bookmark1.png" alt="+" title="'.
				$this->get_translation('AddToBookmarks') .'"/></a></li>';
		}
		else
		{
			echo '<li><a href="'. $this->href('', '', 'removebookmark=yes')
				.'"><img src="'. $this->config['theme_url']
				.'icons/bookmark2.png" alt="-" title="'.
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
      echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?>
  <br />
  <a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></small>
  <?php
// Else Wacko shows login's controls
} else {
?>
  <br />
  <?php
// Begin Login form
echo $this->form_open('login', '', 'post', $this->get_translation('LoginPage')); ?>
  <input type="hidden" name="action" value="login" />
  <input type="hidden" name="goback" value="<?php echo $this->slim_url($this->tag);?>" />
  <?php echo $this->get_translation('LoginWelcome') ?>:<br />
  <input type="text" name="name" size="12" class="login" alt="username" />
  <br />
  <?php echo $this->get_translation('LoginPassword') ?>:<br />
  <input type="password" name="password" class="login" size="8" alt="password" />
  <input type="image" src="<?php echo $this->config['theme_url'] ?>icons/login.png" alt=">>>" align="top" />
  <?php // Closing Login form
echo $this->form_close();
?>
  <?php
}
// End if
?>
  <hr noshade="noshade" />
  <br />
  <?php
// If this page exists
if ($this->page)
{
 // If owner is current user
 if ($this->user_is_owner())
 {
   print($this->get_translation('YouAreOwner')."<br /> \n");

   // Rename link
   print(" <a href=\"".$this->href('rename')."\">".$this->get_translation('RenameText')."</a><br /> \n");

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
   } else if (!$this->page['comment_on']) {
     print($this->get_translation('Nobody').($this->get_user() ? " (<a href=\"".$this->href('claim')."\">".$this->get_translation('TakeOwnership')."</a>)" : ""));
   }
 }
// If User has rights to edit page, show Edit link
echo $this->has_access('write') ? "<br /><a href=\"".$this->href('edit')."\" accesskey=\"E\" title=\"".$this->get_translation('EditTip')."\">".$this->get_translation('EditText')."</a>" : "";
?>
  <br />
  <?php
// Watch/Unwatch icon
echo ($this->is_watched === true ? "<a href=\"".$this->href('watch')."\">".$this->get_translation('RemoveWatch')."</a>\n" : "<a href=\"".$this->href('watch')."\">".$this->get_translation('SetWatch')."</a>" );
?>
  <br />
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
	print("<a href=\"".$this->href('remove')."\">".$this->get_translation('DeleteTip')."</a>");
}
?><hr noshade="noshade" />
<?php
	// Revisions link
	echo (( $this->config['hide_revisions'] == false || ($this->config['hide_revisions'] == 1 && $this->get_user()) || ($this->config['hide_revisions'] == 2 && $this->user_is_owner()) || $this->is_admin() )
			? "<li><a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".$this->get_time_string_formatted($this->page['modified'])."</a></li>\n"
			: "<li>".$this->get_time_string_formatted($this->page['modified'])."</li>\n"
		);
		?>
</div>
<div id="content">
<?php
// here we show messages
$this->output_messages();
?>
<loc><?php echo $this->config['site_name'] ?>: <?php echo $this->get_page_path(); ?><a title="<?php echo $this->config['search_title_help']?>" href="<?php echo $this->config['base_url'].$this->get_translation('TextSearchPage').($this->config['rewrite_mode'] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a></loc>