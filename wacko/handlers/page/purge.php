<div id="page">
<h3><?php echo $this->GetTranslation("PurgePage") ?> <?php echo $this->ComposeLinkToPage($this->tag, "", "", 0) ?></h3>
<?php

// redirect to show method if page don't exists
if (!$this->page) $this->Redirect($this->href("show"));

// deny for comment
if ($this->page['comment_on_id'])
	$this->Redirect($this->href("", $this->GetCommentOnTag($this->page['comment_on_id']), "show_comments=1")."#".$this->page['tag']);
// and for forum page
else if ($this->forum === true)
	$this->Redirect($this->href());

// ToDo: config->owners_can_remove_comments ?
if ($this->UserIsOwner() || $this->IsAdmin())
{
	if (isset($_POST["purge"]) && $_POST["purge"] == 1)
	{
		// Purge page
		print("<br /><em>");
		if (isset($_POST["comments"]) && $_POST["comments"] == 1)
		{
			$this->RemoveComments($this->tag);
			$this->Log(1, str_replace("%1", $this->tag." ".$this->page['title'], $this->GetTranslation("LogRemovedAllComments", $this->config['language'])));
			echo $this->GetTranslation("CommentsPurged")."<br />\n";
		}
		if (isset($_POST["files"]) && $_POST["files"] == 1)
		{
			$this->RemoveFiles($this->tag);
			$this->Log(1, str_replace('%1', $this->tag." ".$this->page['title'], $this->GetTranslation("LogRemovedAllFiles", $this->config['language'])));
			echo $this->GetTranslation("FilesPurged")."<br />\n";
		}
		if (isset($_POST["revisions"]) && $_POST["revisions"] == 1 && $this->IsAdmin())
		{
			$this->RemoveRevisions($this->tag);
			$this->Log(1, str_replace("%1", $this->tag." ".$this->page['title'], $this->GetTranslation("LogRemovedAllRevisions", $this->config['language'])));
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