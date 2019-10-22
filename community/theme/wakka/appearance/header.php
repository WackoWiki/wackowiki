<?php
/*
 Wakka theme.
 Common header file.
*/

require (Ut::join_path(THEME_DIR, '_common/_header.php'));

?>
<body>
<div id="mainwrapper">
	<div id="header">
		<div id="header-main">
			<div id="header-top">
			<strong><?php echo $this->db->site_name ?>: </strong><?php echo (isset($this->page['title']) ? $this->page['title'] : $this->get_page_path()); ?>
		</div>
		<div id="login">
<?php
// If user are logged, Wacko shows "You are UserName"
if ($this->get_user())
{ ?> <span class="nobr"><?php echo $this->_t('YouAre') . " " . $this->link($this->db->users_page . '/' . $this->get_user_name(), '', $this->get_user_name()) ?></span><small> ( <span class="nobr Tune"><?php
echo $this->compose_link_to_page($this->_t('AccountLink'), "", $this->_t('AccountText')); ?>
 | <a onclick="return confirm('<?php echo $this->_t('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->_t('LoginPage'), 'action=logout&amp;goback=' . $this->slim_url($this->tag));?>"><?php echo $this->_t('LogoutLink'); ?></a></span>
)</small>
<?php
// Else Wacko shows login's controls
}
else
{
	// Show Register / Login link
	echo "<ul>\n<li>" . $this->compose_link_to_page($this->_t('LoginPage'), '', $this->_t('LoginPage'), '', null, 'goback=' . $this->slim_url($this->tag)) . "</li>\n";
	echo "<li>" . $this->compose_link_to_page($this->_t('RegistrationPage'), '', $this->_t('RegistrationPage')) . "</li>\n</ul>";
}

// End if
?></div>
		</div>
<div id="navigation">
<?php
// Outputs Bookmarks AKA QuickLinks
	echo '<div id="menu-user">';
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
	echo "\n</ol></div>";
?>
<div id="search">
<?php
// Opens Search form
echo $this->form_open('search', ['form_method' => 'get', 'tag' => $this->_t('TextSearchPage')]);

// Searchbar
?>
<span class="search nobr"><label for="phrase"><?php echo $this->_t('SearchText'); ?></label><input
	type="search" name="phrase" id="phrase" size="20"><input type="submit" class="submitinput" title="<?php echo $this->_t('SearchButtonText') ?>" alt="<?php echo $this->_t('SearchButtonText') ?>" value="<?php echo $this->_t('SearchButtonText') ?>"></span>
<?php

// Search form close
echo $this->form_close();
?>
</div>
</div>
</div>
<div id="content">
<?php
// here we show messages
$this->output_messages();
?>