


<div id="footer"><?php // Show only if page exists ?> <?php if ($this->page) {
	echo $this->GetTranslation("SettingsRevisions");
	echo ":"; ?> <a href="<?php echo $this->href("revisions"); ?>"><?php echo $this->GetPageTimeFormatted(); ?></a>
&nbsp;|&nbsp; <?php // Check if page has an owner - if not, add the claim text ?>
	<?php if($owner = $this->GetPageOwner()) {
		echo $this->GetTranslation("Owner");
		echo $this->Link($owner);
	} else if(!$this->page["comment_on_id"]) {
		echo $this->GetTranslation("Nobody"); ?> <a
	href="<?php echo $this->href("claim"); ?>"><?php echo $this->GetTranslation("TakeOwnership"); ?></a>
		<?php } ?> &nbsp;|&nbsp; <a
	href="<?php echo $this->href("settings"); ?>"><?php echo $this->GetTranslation("SettingsText"); ?></a>
&nbsp;|&nbsp; <?php // Watch page ?> <a
	href="<?php echo $this->href("watch"); ?>"> <?php if($this->iswatched === true) { ?>
<img
	src="<?php echo $this->GetConfigValue("theme_url"); ?>images/watch-remove.gif"
	alt="<?php echo $this->GetTranslation("RemoveWatch"); ?>"
	title="<?php echo $this->GetTranslation("RemoveWatch"); ?>"
	width="16" height="16" /> <?php } else { ?> <img
	src="<?php echo $this->GetConfigValue("theme_url"); ?>images/watch-add.gif"
	alt="<?php echo $this->GetTranslation("SetWatch"); ?>"
	title="<?php echo $this->GetTranslation("SetWatch"); ?>" width="16"
	height="16" /> <?php } ?> </a> <?php // Bookmark page ?> <?php if(in_array($this->GetPageSuperTag(),$this->GetBookmarkLinks())) { ?>
<a href="<?php echo $this->Href('', '', "removebookmark=yes"); ?>"> <img
	src="<?php echo $this->GetConfigValue("theme_url"); ?>images/bookmark-remove.gif"
	alt="<?php echo $this->GetTranslation("RemoveFromBookmarks"); ?>"
	title="<?php echo $this->GetTranslation("RemoveFromBookmarks"); ?>"
	width="16" height="16" /> <?php } else { ?> <a
	href="<?php echo $this->Href('', '', "addbookmark=yes"); ?>"> <img
	src="<?php echo $this->GetConfigValue("theme_url"); ?>images/bookmark-add.gif"
	alt="<?php echo $this->GetTranslation("AddToBookmarks"); ?>"
	title="<?php echo $this->GetTranslation("AddToBookmarks"); ?>"
	width="16" height="16" /> <?php } ?> </a> <?php }
	// End of "Page exists" ?> <?php
	if ($this->GetUser()){
		echo "&nbsp;|&nbsp;".$this->GetTranslation("PoweredBy")." ".$this->Link("WackoWiki:WackoWiki", "", "WackoWiki ".$this->GetWackoVersion());
	}
	?></div>
</div>
<?php
	// Don't place final </body></html> here. Wacko closes HTML automatically.
?>