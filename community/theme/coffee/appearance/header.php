<?php
/*
 Coffee theme.
 Common header file.
*/

require (Ut::join_path(THEME_DIR, '_common/_header.php'));

?>
<body>

	<?php echo $this->form_open('login', ['tag' => $this->_t('LoginPage')]); ?>
<input type="hidden" name="action" value="login">

<div class="header">
<div class="user"><?php if ($this->get_user()) { ?> <span class="nobr"><?php echo $this->_t('YouAre'); ?>
<img
	src="<?php echo $this->db->theme_url ?>icon/user.png"
	width="12" height="12" style="vertical-align: baseline;"
	alt=""><?php echo $this->link($this->db->users_page . '/' . $this->get_user_name(), '', $this->get_user_name()) ?></span><br>
<span class="small">( <span class="nobr Tune"><?php echo $this->compose_link_to_page($this->_t('AccountLink'), "", $this->_t('AccountText')); ?>
| <a
	onclick="return confirm('<?php echo $this->_t('LogoutAreYouSure');?>');"
	href="<?php echo $this->href('', $this->_t('LoginPage'), 'action=logout&amp;goback=' . $this->slim_url($this->tag));?>"><?php echo $this->_t('LogoutLink'); ?></a></span>
)</span> <?php } else { ?> <span class="nobr"><input type="hidden"
	name="goback" value="<?php echo $this->slim_url($this->tag);?>"><strong><?php echo $this->_t('LoginWelcome') ?>:&nbsp;</strong><input
	type="text" name="name" size="18" class="login">&nbsp;<?php echo $this->_t('LoginPassword') ?>:&nbsp;<input
	type="password" name="password" class="login" size="8">&nbsp;<input
	type="submit" value="Ok"></span> <?php } ?></div>
<div class="title"><?php echo $this->db->site_name ?>: <?php echo (isset($this->page['title']) ? $this->page['title'] : $this->get_page_path()); ?>
</div>
</div>

<div class="bookmarks"><?php
	echo '<div id="bookmarks">';
	echo "<ol>\n";
	// Main page
	echo "<li>" . $this->compose_link_to_page($this->db->root_page) . "</li>\n";
	echo "<li>";

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
				$this->_t('AddBookmark')  . '"></a></li>';
		}
		else
		{
			echo '<li><a href="' .  $this->href('', '', 'removebookmark=yes')
				 . '"><img src="' .  $this->db->theme_url
				. 'icon/bookmark2.png" alt="-" title="' .
				$this->_t('RemoveBookmark')  . '"></a></li>';
		}
	}
	echo "\n</ol></div>"; ?><br style="clear: both;"></div>

<?php echo $this->form_close(); ?>
<?php
// here we show messages
$this->output_messages();
?>
