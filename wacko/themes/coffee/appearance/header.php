<?php
/*
 Coffee theme.
 Common header file.
*/

require ('themes/_common/_header.php');

?>
<body onload="all_init();">

	<?php echo $this->form_open('', $this->get_translation('LoginPage'), 'post'); ?>
<input type="hidden" name="action" value="login" />

<div class="header">
<div class="user"><?php if ($this->get_user()) { ?> <span class="nobr"><?php echo $this->get_translation('YouAre'); ?>
<img
	src="<?php echo $this->config['theme_url'] ?>icons/user.gif"
	width="12" height="12" border="0" style="vertical-align: baseline;"
	alt="" /><?php echo $this->link($this->get_user_name()) ?></span><br />
<span class="small">( <span class="nobr Tune"><?php echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?>
| <a
	onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');"
	href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></span>
)</span> <?php } else { ?> <span class="nobr"><input type="hidden"
	name="goback" value="<?php echo $this->slim_url($this->tag);?>" /><strong><?php echo $this->get_translation('LoginWelcome') ?>:&nbsp;</strong><input
	type="text" name="name" size="18" class="login" />&nbsp;<?php echo $this->get_translation('LoginPassword') ?>:&nbsp;<input
	type="password" name="password" class="login" size="8" />&nbsp;<input
	type="submit" value="Ok" /></span> <?php } ?></div>
<div class="title"><?php echo $this->config['wacko_name'] ?>: <?php echo (isset($this->page['title']) ? $this->page['title'] : $this->get_page_path()); ?>
<a class="Search"
	title="<?php echo $this->get_translation('SearchTitleTip')?>"
	href="<?php echo $this->config['base_url'].$this->get_translation('TextSearchPage').($this->config['rewrite_mode'] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a>
</div>
</div>

<div class="bookmarks"><?php
	echo '<div id="bookmarks">';
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
	echo "\n</ol></div>"; ?><br style="clear: both;"></div>

<?php echo $this->form_close(); ?>
<?php
// here we show messages
if ($message = $this->get_message()) echo "<div class=\"info\">$message</div>";
?>