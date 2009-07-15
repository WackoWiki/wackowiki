<div id="page">
<h3><?php echo $this->GetTranslation("PurgePage") ?> <?php echo $this->ComposeLinkToPage($this->tag, "", "", 0) ?></h3>
<?php

// redirect to show method if page don't exists
if (!$this->page) $this->Redirect($this->href("show"));

// deny for comment
if ($this->page["comment_on"])
	$this->Redirect($this->href("", $this->page["comment_on"], "show_comments=1")."#".$this->page["tag"]);

// ToDo: config->owners_can_remove_comments ?
if ($this->UserIsOwner() || $this->IsAdmin())
{
	if ($_POST["purge"] == 1)
	{
		// Purge page
		print("<br /><em>");
		if ($_POST["comments"] == 1)
		{
			$this->RemoveComments($this->tag);
			$this->Log(1, str_replace("%1", $this->tag." ".$this->page["title"], $this->GetTranslation("LogRemovedAllComments")));
			echo $this->GetTranslation("CommentsPurged")."<br />\n";
		}
		if ($_POST["files"] == 1)
		{
			$this->RemoveFiles($this->tag);
			$this->Log(1, str_replace('%1', $this->tag." ".$this->page["title"], $this->GetTranslation("LogRemovedAllFiles")));
			echo $this->GetTranslation("FilesPurged")."<br />\n";
		}
		if ($_POST["revisions"] == 1 && $this->IsAdmin())
		{
			$this->RemoveRevisions($this->tag);
			$this->Log(1, str_replace("%1", $this->tag." ".$this->page["title"], $this->GetTranslation("LogRemovedAllRevisions")));
			echo $this->GetTranslation("RevisionsPurged")."<br />\n";
		}
		print('</em>');
		print($this->GetTranslation("ThisActionHavenotUndo")."\n");
	}
	else
	{
		echo "<div class=\"warning\">".$this->GetTranslation("ReallyPurge")."</div><br />";
		echo $this->FormOpen("purge");
?>
		
		<strong><?php echo $this->GetTranslation("SelectPurgeOptions") ?></strong><br />
		<input id="purgecomments" type="checkbox" name="comments" value="1" />
		<label for="purgecomments"><?php echo $this->GetTranslation("PurgeComments") ?></label><br />
		<input id="purgefiles" type="checkbox" name="files" value="1" />
		<label for="purgefiles"><?php echo $this->GetTranslation("PurgeFiles") ?></label><br />
<?php
		if ($this->IsAdmin())
		{
?>
			<input id="purgerevisions" type="checkbox" name="revisions" value="1" />
			<label for="purgerevisions"><?php echo $this->GetTranslation("PurgeRevisions") ?></label><br />
<?php
		}
?>
		<br />
		<input type="hidden" name="purge" value="1" />
		<input id="submit" name="submit" type="submit" value="<?php echo $this->GetTranslation("PurgeButton"); ?>" />
		<input id="button" type="button" value="<?php echo $this->GetTranslation('EditCancelButton'); ?>" onclick="history.back();" />
		<br />

<?php	echo $this->FormClose();
	}
}
else
{
	echo "<em>".$this->GetTranslation("NotOwnerAndCantPurge")."</em>";
}
?>
</div>