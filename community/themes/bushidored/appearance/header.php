<?php
/*
Bushido Alfeld e.V. theme
created by yourhp.de
Common header file.
*/

require ('themes/_common/_header.php');

?>
<body onload="all_init();">
<div id="container">
<?php
// Outputs page title
?>
<div id="header">
  <h1>&nbsp;</h1>
</div>
<div id="navigation">
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

// If user are logged, Wacko shows "You are UserName"
if ($this->get_user()) { ?>
  <span class="nobr"><?php echo $this->get_translation('YouAre')." ".$this->link($this->config['users_page'].'/'.$this->get_user_name(), '', $this->get_user_name()) ?></span><br />
  <small>( <span class="nobr Tune">
  <?php
      echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?>
  | <a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></span> )</small>
  <?php
// Else Wacko shows login's controls
} else {
?>
  <div class="nobr"> <br />
    <?php
// Begin Login form
echo $this->form_open('', $this->get_translation('LoginPage'), 'post'); ?>
    <input type="hidden" name="action" value="login" />
    <input type="hidden" name="goback" value="<?php echo $this->slim_url($this->tag);?>" />
    <?php echo $this->get_translation('LoginWelcome') ?>:<br />
    <input type="text" name="name" size="18" class="login" alt="username" />
    <br />
    <?php echo $this->get_translation('LoginPassword') ?>:<br />
    <input type="password" name="password" class="login" size="8" alt="password" />
    <br />
    <input type="image" src="<?php echo $this->config['theme_url'] ?>icons/login.gif" alt=">>>" align="top" />
    <?php // Closing Login form
echo $this->form_close();
?>
  </div>
  <?php
}
// End if
?>
  <br />
  <hr width="80%" noshade="noshade" />
  <?php
// If this page exists
if ($this->page)
{
 // If owner is current user
 if ($this->user_is_owner())
 {
   print($this->get_translation('YouAreOwner')."<br /> \n");

   // Rename link
   print(" <a href=\"".$this->href('rename')."\"><img src=\"".$this->config['theme_url']."icons/rename.gif\" title=\"".$this->get_translation('RenameText')."\" alt=\"".$this->get_translation('RenameText')."\" align=\"middle\" border=\"0\" />&nbsp;".$this->get_translation('RenameText')."</a><br /> \n");
//   if (!$this->config['remove_onlyadmins'] || $this->is_admin()) print(" <a href=\"".$this->href('remove')."\"><img src=\"".$this->config['theme_url']."icons/delete.gif\" title=\"".$this->get_translation('DeleteTip')."\" alt=\"".$this->get_translation('DeleteText')."\" align=\"middle\" border=\"0\" /></a>");

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
echo ($this->is_watched($this->get_user_name(), $this->tag) ? "<a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/unwatch.gif\" title=\"".$this->get_translation('RemoveWatch')."\" alt=\"".$this->get_translation('RemoveWatch')."\"  align=\"middle\" border=\"0\" />&nbsp;".$this->get_translation('RemoveWatch')."</a>" : "<a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/watch.gif\" title=\"".$this->get_translation('SetWatch')."\" alt=\"".$this->get_translation('SetWatch')."\"  align=\"middle\" border=\"0\" />&nbsp;".$this->get_translation('SetWatch')."</a>" );
?>
  <br />
  <?php
 // Rename link
 if ($this->check_acl($this->get_user_name(),$this->config['rename_globalacl']) && !$this->user_is_owner())
 {
   print("<a href=\"".$this->href('rename')."\"><img src=\"".$this->config['theme_url']."icons/rename.gif\" title=\"".$this->get_translation('RenameText')."\" alt=\"".$this->get_translation('RenameText')."\" align=\"middle\" border=\"0\" />&nbsp;".$this->get_translation('RenameText')."</a><br />");
 }
 // Page  settings link
 print("<a href=\"".$this->href('properties'). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"").">".$this->get_translation('SettingsText')."</a><br />");
// print("<a href=\"".$this->href('referrers')."\"><img src=\"".$this->config['theme_url']."icons/referer.gif\" title=\"".$this->get_translation('ReferrersTip')."\" alt=\"".$this->get_translation('ReferrersText')."\" border=\"0\" align=\"middle\" /></a> |");
}
// Print icon
echo"<a href=\"".$this->href('print')."\"><img src=\"".$this->config['theme_url']."icons/print.gif\" title=\"".$this->get_translation('PrintVersion')."\" alt=\"".$this->get_translation('PrintVersion')."\"  align=\"middle\" border=\"0\" />&nbsp;".$this->get_translation('PrintVersion')."</a><br />";
// Remove link (shows only for Admins)
if ($this->is_admin()){
	print("<a href=\"".$this->href('remove')."\"><img src=\"".$this->config['theme_url']."icons/delete.gif\" title=\"".$this->get_translation('DeleteTip')."\" alt=\"".$this->get_translation('DeleteText')."\"  align=\"middle\" border=\"0\" />&nbsp;".$this->get_translation('DeleteTip')."</a>");
}
// Searchbar
// Opens Search form
echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get'); ?>
  <p><?php echo $this->get_translation('SearchText') ?><br />
    <input type="text" name="phrase" size="15" class="searchbar" alt="searchbar" />
  </p>
  <?php
// Search form close
echo $this->form_close();
?>
</div>
<div id="content">
<?php
// here we show messages
if ($message = $this->get_message()) echo "<div class=\"info\">$message</div>";
?>
<div id="text">
<div class="Text">
<span class="main"><?php echo $this->config['site_name'] ?>:</span> <?php echo $this->get_page_path(); ?> <a class="Search" title="<?php echo $this->config['search_title_help']?>"
     href="<?php echo $this->config['base_url'].$this->get_translation('TextSearchPage').($this->config['rewrite_mode'] ? "?" : "&amp;") ?>phrase=<?php echo urlencode($this->tag); ?>">...</a>