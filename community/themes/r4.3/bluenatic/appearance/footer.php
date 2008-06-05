


		<div id="footer">
			<?php // Show only if page exists ?>
			<?php if ($this->page) {
			echo $this->GetResourceValue("SettingsRevisions");
			echo ":"; ?>
			<a href="<?php echo $this->href("revisions"); ?>"><?php echo $this->GetPageTime(); ?></a>
			&nbsp;|&nbsp;
			<?php // Check if page has an owner - if not, add the claim text ?>
			<?php if($owner = $this->GetPageOwner()) {
			echo $this->GetResourceValue("Owner");
			echo $this->Link($owner);
			} else if(!$this->page["comment_on"]) {
			echo $this->GetResourceValue("Nobody"); ?>
			<a href="<?php echo $this->href("claim"); ?>"><?php echo $this->GetResourceValue("TakeOwnership"); ?></a>
			<?php } ?>
			&nbsp;|&nbsp;
			<a href="<?php echo $this->href("settings"); ?>"><?php echo $this->GetResourceValue("SettingsText"); ?></a>
			&nbsp;|&nbsp;
			<?php // Watch page ?>
			<a href="<?php echo $this->href("watch"); ?>">
			<?php if($this->IsWatched($this->GetUserName(), $this->GetPageTag())) { ?>
				<img src="<?php echo $this->GetConfigValue("theme_url"); ?>images/watch-remove.gif" alt="<?php echo $this->GetResourceValue("RemoveWatch"); ?>" title="<?php echo $this->GetResourceValue("RemoveWatch"); ?>" width="16" height="16"/>
			<?php } else { ?>
				<img src="<?php echo $this->GetConfigValue("theme_url"); ?>images/watch-add.gif" alt="<?php echo $this->GetResourceValue("SetWatch"); ?>" title="<?php echo $this->GetResourceValue("SetWatch"); ?>" width="16" height="16" />
			<?php } ?>
			</a>
			<?php // Bookmark page ?>
			<?php if(in_array($this->GetPageSuperTag(),$this->GetBookmarkLinks())) { ?>
			<a href="<?php echo $this->Href('', '', "removebookmark=yes"); ?>">
				<img src="<?php echo $this->GetConfigValue("theme_url"); ?>images/bookmark-remove.gif" alt="<?php echo $this->GetResourceValue("RemoveFromBookmarks"); ?>" title="<?php echo $this->GetResourceValue("RemoveFromBookmarks"); ?>" width="16" height="16" />
			<?php } else { ?>
			<a href="<?php echo $this->Href('', '', "addbookmark=yes"); ?>">
				<img src="<?php echo $this->GetConfigValue("theme_url"); ?>images/bookmark-add.gif" alt="<?php echo $this->GetResourceValue("AddToBookmarks"); ?>" title="<?php echo $this->GetResourceValue("AddToBookmarks"); ?>" width="16" height="16" />
			<?php } ?>
			</a>
			&nbsp;|&nbsp;
			<?php } // End of "Page exists" ?>
			Powered by <?php echo $this->Link("WackoWiki:WackoWiki", "", "WackoWiki ".$this->GetWackoVersion()); ?></a>
		</div>
	</div>
<?php // Debug Querylog.
if ($this->GetConfigValue("debug")>=2)
{
print("<span style=\"font-size: 11px; color: #888888\">");
print("<strong>Query log:</strong><br />\n");
foreach ($this->queryLog as $query)
{
  print($query["query"]." (".$query["time"].")<br />\n");
  $zz++;
}
print("<b>total: $zz</b>");
print("</span>");
}

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>

