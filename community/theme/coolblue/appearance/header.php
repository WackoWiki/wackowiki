<?php
/*
CoolBlue theme.

*/

require (Ut::join_path(THEME_DIR, '_common/_header.php'));

?>
<body>
<div id="head">
  <?php
// Searchbar
echo $this->form_open('search', ['form_method' => 'get', 'tag' => $this->_t('TextSearchPage')]); ?>
  <input type="search" name="phrase" id="search" />
  <?php
// Search form close
echo $this->form_close();
?>
</div>
<div id="container">
<div id="navi">
  <?php
// outputs bookmarks menu
	echo '<div id="menu-user">';
	echo "<ol>\n";
	// main page
	echo "<li>" . $this->compose_link_to_page($this->db->root_page) . "</li>\n";

	// menu
	if ($menu = $this->get_menu())
	{
		foreach ($menu as $menu_item)
		{
			$formatted_menu = $this->format($menu_item[2], 'post_wacko');

			if ($this->page['page_id'] == $menu_item[0])
			{
				echo '<li class="active">';
			}
			else
			{
				echo '<li>';
			}

			echo $formatted_menu . "</li>\n";
		}
	}

	if ($this->get_user())
	{
		// determines what it should show: "add to bookmarks" or "remove from bookmarks" icon
		if (!in_array($this->page['page_id'], $this->get_menu_links()))
		{
			echo '<li><a href="' .  $this->href('', '', 'addbookmark=yes')
				 . '"><img src="' .  $this->db->theme_url
				. 'icon/bookmark1.png" alt="+" title="' .
				$this->_t('AddToBookmarks')  . '"/></a></li>';
		}
		else
		{
			echo '<li><a href="' .  $this->href('', '', 'removebookmark=yes')
				 . '"><img src="' .  $this->db->theme_url
				. 'icon/bookmark2.png" alt="-" title="' .
				$this->_t('RemoveFromBookmarks')  . '"/></a></li>';
		}
	}
	echo "\n</ol></div>";
?>
  <hr noshade="noshade" />
  <?php
// If user are logged, Wacko shows "You are UserName"
if ($this->get_user()) { ?>
  <?php echo $this->_t('YouAre') . " " . $this->link($this->db->users_page . '/' . $this->get_user_name(), '', $this->get_user_name()) ?><br />
  <small>
  <?php
      echo $this->compose_link_to_page($this->_t('AccountLink'), "", $this->_t('AccountText'), 0); ?>
  <br />
  <a onclick="return confirm('<?php echo $this->_t('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->_t('LoginPage'), 'action=logout&amp;goback=' . $this->slim_url($this->tag));?>"><?php echo $this->_t('LogoutLink'); ?></a></small>
  <?php
// Else Wacko shows login's controls
} else {
?>
  <br />
  <?php
// Begin Login form
echo $this->form_open('login', ['tag' => $this->_t('LoginPage')]); ?>
  <input type="hidden" name="action" value="login" />
  <input type="hidden" name="goback" value="<?php echo $this->slim_url($this->tag);?>" />
  <?php echo $this->_t('LoginWelcome') ?>:<br />
  <input type="text" name="name" size="12" class="login" alt="username" />
  <br />
  <?php echo $this->_t('LoginPassword') ?>:<br />
  <input type="password" name="password" class="login" size="8" alt="password" />
  <input type="image" src="<?php echo $this->db->theme_url ?>icon/login.png" alt=">>>" align="top" />
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
 if ($this->is_owner())
 {
   print($this->_t('YouAreOwner') . "<br /> \n");

   // Rename link
   print(" <a href=\"" . $this->href('rename') . "\">" . $this->_t('RenameText') . "</a><br /> \n");

   //Edit ACLs link
   print("<a href=\"" . $this->href('permissions') . "\"" . (($this->method=='edit')?" onclick=\"return window.confirm('" . $this->_t('EditACLConfirm') . "');\"":"") . ">" . $this->_t('ACLText') . "</a>");
 }
 // If owner is NOT current user
 else
 {
   // Show Owner of this page
   if ($owner = $this->get_page_owner())
   {
     print($this->_t('Owner') . ": " . $this->link($owner));
   } else if (!$this->page['comment_on']) {
     print($this->_t('Nobody').($this->get_user() ? " (<a href=\"" . $this->href('claim') . "\">" . $this->_t('TakeOwnership') . "</a>)" : ""));
   }
 }
// If User has rights to edit page, show Edit link
echo $this->has_access('write') ? "<br /><a href=\"" . $this->href('edit') . "\" accesskey=\"E\" title=\"" . $this->_t('EditTip') . "\">" . $this->_t('EditText') . "</a>" : "";
?>
  <br />
  <?php
// Watch/Unwatch icon
echo ($this->is_watched === true ? "<a href=\"" . $this->href('watch') . "\">" . $this->_t('RemoveWatch') . "</a>\n" : "<a href=\"" . $this->href('watch') . "\">" . $this->_t('SetWatch') . "</a>" );
?>
  <br />
  <?php
 // Rename link
 if ($this->check_acl($this->get_user_name(),$this->db->rename_globalacl) && !$this->is_owner())
 {
   print("<a href=\"" . $this->href('rename') . "\">" . $this->_t('RenameText') . "</a><br />");
 }
 // Page  settings link
 print("<a href=\"" . $this->href('properties'). "\"" . (($this->method=='edit')?" onclick=\"return window.confirm('" . $this->_t('EditACLConfirm') . "');\"":"") . ">" . $this->_t('SettingsText') . "</a><br />");
}
// Remove link (shows only for Admins)
if ($this->is_admin()){
	print("<a href=\"" . $this->href('remove') . "\">" . $this->_t('DeleteTip') . "</a>");
}
?><hr noshade="noshade" />
<?php
	// Revisions link
	echo (( $this->db->hide_revisions == false || ($this->db->hide_revisions == 1 && $this->get_user()) || ($this->db->hide_revisions == 2 && $this->is_owner()) || $this->is_admin() )
			? "<li><a href=\"" . $this->href('revisions') . "\" title=\"" . $this->_t('RevisionTip') . "\">" . $this->get_time_formatted($this->page['modified']) . "</a></li>\n"
			: "<li>" . $this->get_time_formatted($this->page['modified']) . "</li>\n"
		);
		?>
</div>
<div id="content">
<?php
// here we show messages
$this->output_messages();
?>
<loc><?php echo $this->db->site_name ?>: <?php echo $this->get_page_path(); ?></loc>
