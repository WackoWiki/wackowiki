<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<div id="page">
<h3><?php echo $this->get_translation('PurgePage').' '.$this->compose_link_to_page($this->tag, '', '', 0); ?></h3>
<?php

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->redirect($this->href());
}

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag($this->page['comment_on_id']), 'show_comments=1')."#".$this->page['tag']);
}
// and for forum page
else if ($this->forum === true)
{
	$this->redirect($this->href());
}

// TODO: config->owners_can_remove_comments ?
if ($this->is_owner() || $this->is_admin())
{
	if (isset($_POST['purge']) && $_POST['purge'] == 1)
	{
		// purge page
		$message = "<ol><em>";

		if (isset($_POST['comments']) && $_POST['comments'] == 1)
		{
			$this->remove_comments($this->tag);
			$this->log(1, str_replace('%1', $this->tag." ".$this->page['title'], $this->get_translation('LogRemovedAllComments', $this->config['language'])));
			$message .= "<li>".$this->get_translation('CommentsPurged')."</li>\n";
		}

		if (isset($_POST['files']) && $_POST['files'] == 1)
		{
			$this->remove_files($this->tag);
			$this->log(1, str_replace('%1', $this->tag." ".$this->page['title'], $this->get_translation('LogRemovedAllFiles', $this->config['language'])));
			$message .= "<li>".$this->get_translation('FilesPurged')."</li>\n";
		}

		if (isset($_POST['revisions']) && $_POST['revisions'] == 1 && $this->is_admin())
		{
			$this->remove_revisions($this->tag);
			$this->log(1, str_replace('%1', $this->tag." ".$this->page['title'], $this->get_translation('LogRemovedAllRevisions', $this->config['language'])));
			$message .= "<li>".$this->get_translation('RevisionsPurged')."</li>\n";
		}

		// purge related page cache
		if ($this->config['cache'])
		{
			$this->cache->invalidate_page($this->supertag);
			$message .= '<li>'.$this->get_translation('PageCachePurged')."</li>\n";
		}

		$message .= '</em></ol><br />';
		$message .= $this->get_translation('ThisActionHavenotUndo')."\n";

		$this->show_message($message, 'success');
	}
	else
	{
		echo '<div class="warning">'.$this->get_translation('ReallyPurge').'</div><br />';
		echo $this->form_open('purge_data', 'purge');
?>

		<strong><?php echo $this->get_translation('SelectPurgeOptions') ?></strong><br />
		<input type="checkbox" id="purgecomments" name="comments" value="1" />
		<label for="purgecomments"><?php echo $this->get_translation('PurgeComments') ?></label><br />
		<input type="checkbox" id="purgefiles" name="files" value="1" />
		<label for="purgefiles"><?php echo $this->get_translation('PurgeFiles') ?></label><br />
<?php
		if ($this->is_admin())
		{
?>
			<input type="checkbox" id="purgerevisions" name="revisions" value="1" />
			<label for="purgerevisions"><?php echo $this->get_translation('PurgeRevisions') ?></label><br />
<?php
		}
?>
		<br />
		<input type="hidden" name="purge" value="1" />
		<input type="submit" id="submit" name="submit" value="<?php echo $this->get_translation('PurgeButton'); ?>" />
		<a href="<?php echo $this->href('properties');?>" style="text-decoration: none;"><input type="button" id="button" value="<?php echo $this->get_translation('EditCancelButton'); ?>" /></a>
		<br />

<?php	echo $this->form_close();
	}
}
else
{
	$message = "<em>".$this->get_translation('NotOwnerAndCantPurge')."</em>";
	$this->show_message($message, 'info');
}
?>
</div>
