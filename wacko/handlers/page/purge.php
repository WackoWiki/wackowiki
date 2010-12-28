<div id="page">
<h3><?php echo $this->get_translation('PurgePage') ?> <?php echo $this->compose_link_to_page($this->tag, '', '', 0) ?></h3>
<?php

// redirect to show method if page don't exists
if (!$this->page) $this->redirect($this->href('show'));

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag_by_id($this->page['comment_on_id']), 'show_comments=1')."#".$this->page['tag']);
}
// and for forum page
else if ($this->forum === true)
{
	$this->redirect($this->href());
}

// TODO: config->owners_can_remove_comments ?
if ($this->user_is_owner() || $this->is_admin())
{
	if (isset($_POST['purge']) && $_POST['purge'] == 1)
	{
		// Purge page
		echo "<br /><em>";

		if (isset($_POST['comments']) && $_POST['comments'] == 1)
		{
			$this->remove_comments($this->tag);
			$this->log(1, str_replace('%1', $this->tag." ".$this->page['title'], $this->get_translation('LogRemovedAllComments', $this->config['language'])));
			echo $this->get_translation('CommentsPurged')."<br />\n";
		}
		if (isset($_POST['files']) && $_POST['files'] == 1)
		{
			$this->remove_files($this->tag);
			$this->log(1, str_replace('%1', $this->tag." ".$this->page['title'], $this->get_translation('LogRemovedAllFiles', $this->config['language'])));
			echo $this->get_translation('FilesPurged')."<br />\n";
		}
		if (isset($_POST['revisions']) && $_POST['revisions'] == 1 && $this->is_admin())
		{
			$this->remove_revisions($this->tag);
			$this->log(1, str_replace('%1', $this->tag." ".$this->page['title'], $this->get_translation('LogRemovedAllRevisions', $this->config['language'])));
			echo $this->get_translation('RevisionsPurged')."<br />\n";
		}
		echo '</em>';
		echo $this->get_translation('ThisActionHavenotUndo')."\n";
	}
	else
	{
		echo "<div class=\"warning\">".$this->get_translation('ReallyPurge')."</div><br />";
		echo $this->form_open('purge');
?>

		<strong><?php echo $this->get_translation('SelectPurgeOptions') ?></strong><br />
		<input id="purgecomments" type="checkbox" name="comments" value="1" />
		<label for="purgecomments"><?php echo $this->get_translation('PurgeComments') ?></label><br />
		<input id="purgefiles" type="checkbox" name="files" value="1" />
		<label for="purgefiles"><?php echo $this->get_translation('PurgeFiles') ?></label><br />
<?php
		if ($this->is_admin())
		{
?>
			<input id="purgerevisions" type="checkbox" name="revisions" value="1" />
			<label for="purgerevisions"><?php echo $this->get_translation('PurgeRevisions') ?></label><br />
<?php
		}
?>
		<br />
		<input type="hidden" name="purge" value="1" />
		<input id="submit" name="submit" type="submit" value="<?php echo $this->get_translation('PurgeButton'); ?>" />
		<input id="button" type="button" value="<?php echo $this->get_translation('EditCancelButton'); ?>" onclick="history.back();" />
		<br />

<?php	echo $this->form_close();
	}
}
else
{
	echo "<em>".$this->get_translation('NotOwnerAndCantPurge')."</em>";
}
?>
</div>