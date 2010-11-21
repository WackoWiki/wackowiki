


<div id="footer"><?php // Show only if page exists ?> <?php if ($this->page) {
	echo $this->get_translation('SettingsRevisions');
	echo ":"; ?> <a href="<?php echo $this->href('revisions'); ?>"><?php echo $this->get_page_time_formatted(); ?></a>
&nbsp;|&nbsp; <?php // Check if page has an owner - if not, add the claim text ?>
	<?php if($owner = $this->get_page_owner()) {
		echo $this->get_translation('Owner');
		echo $this->link($owner);
	} else if(!$this->page['comment_on_id']) {
		echo $this->get_translation('Nobody'); ?> <a
	href="<?php echo $this->href('claim'); ?>"><?php echo $this->get_translation('TakeOwnership'); ?></a>
		<?php } ?> &nbsp;|&nbsp; <a
	href="<?php echo $this->href('properties'); ?>"><?php echo $this->get_translation('PropertiesText'); ?></a>
&nbsp;|&nbsp; <?php // Watch page ?> <a
	href="<?php echo $this->href('watch'); ?>"> <?php if($this->iswatched === true) { ?>
<img
	src="<?php echo $this->config['theme_url']; ?>images/watch-remove.gif"
	alt="<?php echo $this->get_translation('RemoveWatch'); ?>"
	title="<?php echo $this->get_translation('RemoveWatch'); ?>"
	width="16" height="16" /> <?php } else { ?> <img
	src="<?php echo $this->config['theme_url']; ?>images/watch-add.gif"
	alt="<?php echo $this->get_translation('SetWatch'); ?>"
	title="<?php echo $this->get_translation('SetWatch'); ?>" width="16"
	height="16" /> <?php } ?> </a> <?php // Bookmark page ?> <?php if(in_array($this->tag, $this->get_bookmark_links())) { ?>
<a href="<?php echo $this->href('', '', "removebookmark=yes"); ?>"> <img
	src="<?php echo $this->config['theme_url']; ?>images/bookmark-remove.gif"
	alt="<?php echo $this->get_translation('RemoveFromBookmarks'); ?>"
	title="<?php echo $this->get_translation('RemoveFromBookmarks'); ?>"
	width="16" height="16" /> <?php } else { ?> <a
	href="<?php echo $this->href('', '', "addbookmark=yes"); ?>"> <img
	src="<?php echo $this->config['theme_url']; ?>images/bookmark-add.gif"
	alt="<?php echo $this->get_translation('AddToBookmarks'); ?>"
	title="<?php echo $this->get_translation('AddToBookmarks'); ?>"
	width="16" height="16" /> <?php } ?> </a> <?php }
	// End of "Page exists" ?> <?php
	if ($this->get_user()){
		echo "&nbsp;|&nbsp;".$this->get_translation('PoweredBy').' '.$this->link('WackoWiki:WackoWiki', '', 'WackoWiki '.$this->get_wacko_version());
	}
	?></div>
</div>
<?php
	// Don't place final </body></html> here. Wacko closes HTML automatically.
?>