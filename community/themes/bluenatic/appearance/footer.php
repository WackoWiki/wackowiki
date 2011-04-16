

<div id="footer"><?php // Show only if page exists ?>
<div class="footerlist">
<ul>
<?php

// If this page exists
if ($this->page)
{
	// Revisions link
	echo (( $this->hide_revisions === false || $this->is_admin() )
			? "<li>".$this->get_translation('SettingsRevisions').": <a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".$this->get_time_string_formatted($this->page['modified'])."</a></li>\n"
			: "<li>".$this->get_time_string_formatted($this->page['modified'])."</li>\n"
		);

	// Show Owner of this page
	if ($owner = $this->get_page_owner())
	{
		if ($owner == 'System')
		{
			echo "<li>".$this->get_translation('Owner').": ".$owner."</li>\n";
		}
		else
		{
			echo "<li>".$this->get_translation('Owner').": "."<a href=\"".$this->href('', $this->config['users_page'], 'profile='.$owner)."\">".$owner."</a>"."</li>\n";
		}
	}
	else if (!$this->page['comment_on_id'])
	{
		echo "<li>".$this->get_translation('Nobody').($this->get_user() ? " (<a href=\"".$this->href('claim')."\">".$this->get_translation('TakeOwnership')."</a>)</li>\n" : "");
	}

		?> <li><a href="<?php echo $this->href('properties'); ?>"><?php echo $this->get_translation('PropertiesText'); ?></a>
</li><li> <?php // Watch page ?> <a
	href="<?php echo $this->href('watch'); ?>"> <?php if($this->iswatched === true) { ?>
<img
	src="<?php echo $this->config['theme_url']; ?>images/watch-remove.gif"
	alt="<?php echo $this->get_translation('RemoveWatch'); ?>"
	title="<?php echo $this->get_translation('RemoveWatch'); ?>"
	width="16" height="16" /> <?php } else { ?> <img
	src="<?php echo $this->config['theme_url']; ?>images/watch-add.gif"
	alt="<?php echo $this->get_translation('SetWatch'); ?>"
	title="<?php echo $this->get_translation('SetWatch'); ?>" width="16"
	height="16" /> <?php } ?> </a></li><li><?php // Bookmark page ?> <?php if(in_array($this->page['page_id'], $this->get_menu_links())) { ?>
<a href="<?php echo $this->href('', '', "removebookmark=yes"); ?>"> <img
	src="<?php echo $this->config['theme_url']; ?>images/bookmark-remove.gif"
	alt="<?php echo $this->get_translation('RemoveFromBookmarks'); ?>"
	title="<?php echo $this->get_translation('RemoveFromBookmarks'); ?>"
	width="16" height="16" /> <?php } else { ?> <a
	href="<?php echo $this->href('', '', "addbookmark=yes"); ?>"> <img
	src="<?php echo $this->config['theme_url']; ?>images/bookmark-add.gif"
	alt="<?php echo $this->get_translation('AddToBookmarks'); ?>"
	title="<?php echo $this->get_translation('AddToBookmarks'); ?>"
	width="16" height="16" /> <?php } ?> </a></li> <?php }
	// End of "Page exists" ?> <?php
	if ($this->get_user()){
		echo "<li>".$this->get_translation('PoweredBy').' '.$this->link('WackoWiki:WackoWiki', '', 'WackoWiki '.$this->get_wacko_version())."</li>";
	}
	?></ul>
</div></div>
</div>
<?php
	// Don't place final </body></html> here. Wacko closes HTML automatically.
?>