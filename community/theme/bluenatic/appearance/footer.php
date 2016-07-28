

<div id="footer"><?php // Show only if page exists ?>
<div class="footerlist">
<ul>
<?php

// If this page exists
if ($this->page)
{
	// Revisions link
	echo (( $this->hide_revisions === false || $this->is_admin() )
			? "<li>".$this->_t('SettingsRevisions').": <a href=\"".$this->href('revisions')."\" title=\"".$this->_t('RevisionTip')."\">".$this->get_time_formatted($this->page['modified'])."</a></li>\n"
			: "<li>".$this->get_time_formatted($this->page['modified'])."</li>\n"
		);

	// Show Owner of this page
	if ($owner = $this->get_page_owner())
	{
		if ($owner == 'System')
		{
			echo "<li>".$this->_t('Owner').": ".$owner."</li>\n";
		}
		else
		{
			echo "<li>".$this->_t('Owner').": ".$this->user_link($owner, $lang = '', true, false)."</li>\n";
		}
	}
	else if (!$this->page['comment_on_id'])
	{
		echo "<li>".$this->_t('Nobody').($this->get_user() ? " (<a href=\"".$this->href('claim')."\">".$this->_t('TakeOwnership')."</a>)</li>\n" : "");
	}

		?> <li><a href="<?php echo $this->href('properties'); ?>"><?php echo $this->_t('PropertiesText'); ?></a>
</li><li> <?php // Watch page ?> <a
	href="<?php echo $this->href('watch'); ?>"> <?php if($this->is_watched === true) { ?>
<img
	src="<?php echo $this->db->theme_url; ?>images/watch-remove.png"
	alt="<?php echo $this->_t('RemoveWatch'); ?>"
	title="<?php echo $this->_t('RemoveWatch'); ?>"
	width="16" height="16" /> <?php } else { ?> <img
	src="<?php echo $this->db->theme_url; ?>images/watch-add.png"
	alt="<?php echo $this->_t('SetWatch'); ?>"
	title="<?php echo $this->_t('SetWatch'); ?>" width="16"
	height="16" /> <?php } ?> </a></li><li><?php // Bookmark page ?> <?php if(in_array($this->page['page_id'], $this->get_menu_links())) { ?>
<a href="<?php echo $this->href('', '', "removebookmark=yes"); ?>"> <img
	src="<?php echo $this->db->theme_url; ?>images/bookmark-remove.png"
	alt="<?php echo $this->_t('RemoveFromBookmarks'); ?>"
	title="<?php echo $this->_t('RemoveFromBookmarks'); ?>"
	width="16" height="16" /> <?php } else { ?> <a
	href="<?php echo $this->href('', '', "addbookmark=yes"); ?>"> <img
	src="<?php echo $this->db->theme_url; ?>images/bookmark-add.png"
	alt="<?php echo $this->_t('AddToBookmarks'); ?>"
	title="<?php echo $this->_t('AddToBookmarks'); ?>"
	width="16" height="16" /> <?php } ?> </a></li> <?php }
	// End of "Page exists" ?> <?php
	if ($this->get_user()){
		echo "<li>".$this->_t('PoweredBy').' '.$this->link('WackoWiki:WackoWiki', '', 'WackoWiki')."</li>";
	}
	?></ul>
</div></div>
</div>
<?php
	// Don't place final </body></html> here. Wacko closes HTML automatically.
?>