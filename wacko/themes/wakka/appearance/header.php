<?php
/*
 Wakka theme.
 Common header file.
*/

require ('themes/_common/_header.php');

?>
<body onload="all_init();">
<div id="mainwrapper">
	<div id="header">
		<div id="header-main">
			<div id="header-top">
			<strong><?php echo $this->config['site_name'] ?>: </strong><?php echo (isset($this->page['title']) ? $this->page['title'] : $this->get_page_path()); ?> <a class="Search" title="<?php echo $this->get_translation('SearchTitleTip')?>" href="<?php echo $this->config['base_url'].$this->get_translation('TextSearchPage').($this->config['rewrite_mode'] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a>
		</div>
		<div id="login">
<?php
// If user are logged, Wacko shows "You are UserName"
if ($this->get_user())
{ ?> <span class="nobr"><?php echo $this->get_translation('YouAre')." ".$this->link($this->get_user_name()) ?></span><small> ( <span class="nobr Tune"><?php
echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?>
 | <a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></span>
)</small>
<?php
// Else Wacko shows login's controls
}
else
{
	// Show Register / Login link
	echo "<ul>\n<li>".$this->compose_link_to_page($this->get_translation('LoginPage').($this->config['rewrite_mode'] ? "?" : "&amp;")."goback=".$this->slim_url($this->tag), "", $this->get_translation('LoginPage'), 0)."</li>\n";
	echo "<li>".$this->compose_link_to_page($this->get_translation('RegistrationPage'), "", $this->get_translation('RegistrationPage'), 0)."</li>\n</ul>";
}

// End if
?></div>
		</div>
<div id="navigation">
<?php
// Outputs Bookmarks AKA QuickLinks
	echo '<div id="usermenu">';
		echo "<ol>\n";
		// Main page
		echo "<li>".$this->compose_link_to_page($this->config['root_page'])."</li>\n";
		echo "<li>";
		// Bookmarks
		$formatted_bookmarks = $this->format($this->get_bookmarks_formatted(), "post_wacko");
		$formatted_bookmarks = str_replace ("<br />", "", $formatted_bookmarks);
		$formatted_bookmarks = str_replace ("\n", "</li>\n<li>", $formatted_bookmarks);
		echo $formatted_bookmarks;

		echo "</li>\n";

		if ($this->get_user())
		{
			// Here Wacko determines what it should show: "add to Bookmarks" or "remove from Bookmarks" icon
			if (!in_array($this->tag, $this->get_bookmark_links()))
				echo '<li><a href="'. $this->href('', '', "addbookmark=yes")
					.'"><img src="'. $this->config['theme_url']
					.'icons/bookmark1.gif" alt="+" title="'.
					$this->get_translation('AddToBookmarks') .'"/></a></li>';
			else
				echo '<li><a href="'. $this->href('', '', "removebookmark=yes")
					.'"><img src="'. $this->config['theme_url']
					.'icons/bookmark2.gif" alt="-" title="'.
					$this->get_translation('RemoveFromBookmarks') .'"/></a></li>';
			}
	echo "\n</ol></div>";
?>
<div id="search">
<?php
// Opens Search form
echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get');

// Searchbar
?>
<span class="search nobr"><label for="phrase"><?php echo $this->get_translation('SearchText'); ?></label><input
	type="text" name="phrase" id="phrase" size="20" /><input class="submitinput" type="submit" title="<?php echo $this->get_translation('SearchButtonText') ?>" alt="<?php echo $this->get_translation('SearchButtonText') ?>" value="<?php echo $this->get_translation('SearchButtonText') ?>"/></span>
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
if ($message = $this->get_message()) echo "<div class=\"info\">$message</div>";
?>