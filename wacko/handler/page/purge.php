<?php

if (!defined('IN_WACKO'))
{
	exit;
}

echo '<h3>' . $this->get_translation('PurgePage') . ' ' . $this->compose_link_to_page($this->tag, '', '', 0) . "</h3>\n";

$this->ensure_page();

// TODO: config->owners_can_remove_comments ?
if (!($this->is_owner() || $this->is_admin()))
{
	$this->set_message('<em>' . $this->get_translation('NotOwnerAndCantPurge') . '</em>', 'error');
	$this->show_must_go_on();
}

if (@$_POST['_action'] === 'purge_data')
{
	// purge page
	$message = "<ol><em>";

	if (isset($_POST['comments']))
	{
		$this->remove_comments($this->tag);
		$this->log(1, str_replace('%1', $this->tag." ".$this->page['title'], $this->get_translation('LogRemovedAllComments', $this->config['language'])));
		$message .= "<li>".$this->get_translation('CommentsPurged')."</li>\n";
	}

	if (isset($_POST['files']))
	{
		$this->remove_files($this->tag);
		$this->log(1, str_replace('%1', $this->tag." ".$this->page['title'], $this->get_translation('LogRemovedAllFiles', $this->config['language'])));
		$message .= "<li>".$this->get_translation('FilesPurged')."</li>\n";
	}

	if (isset($_POST['revisions']) && $this->is_admin())
	{
		$this->remove_revisions($this->tag);
		$this->log(1, str_replace('%1', $this->tag." ".$this->page['title'], $this->get_translation('LogRemovedAllRevisions', $this->config['language'])));
		$message .= "<li>".$this->get_translation('RevisionsPurged')."</li>\n";
	}

	// purge related page cache
	if ($this->http->invalidate_page($this->supertag))
	{
		$message .= '<li>'.$this->get_translation('PageCachePurged')."</li>\n";
	}

	$message .= '</em></ol><br />';
	$message .= $this->get_translation('ThisActionHavenotUndo')."\n";

	$this->show_message($message, 'success');
}
else
{
	echo '<div class="warning">'.$this->get_translation('ReallyPurge').'</div><br />';
	echo $this->form_open('purge_data', ['page_method' => 'purge']);
?>

	<strong><?php echo $this->get_translation('SelectPurgeOptions') ?></strong><br />
	<input type="checkbox" id="purgecomments" name="comments" />
	<label for="purgecomments"><?php echo $this->get_translation('PurgeComments') ?></label><br />
	<input type="checkbox" id="purgefiles" name="files" />
	<label for="purgefiles"><?php echo $this->get_translation('PurgeFiles') ?></label><br />
<?php
	if ($this->is_admin())
	{
?>
		<input type="checkbox" id="purgerevisions" name="revisions" />
		<label for="purgerevisions"><?php echo $this->get_translation('PurgeRevisions') ?></label><br />
<?php
	}
?>
	<br />
	<input type="submit" id="submit" name="submit" value="<?php echo $this->get_translation('PurgeButton'); ?>" />
	<a href="<?php echo $this->href('properties');?>" style="text-decoration: none;"><input type="button" id="button" value="<?php echo $this->get_translation('EditCancelButton'); ?>" /></a>
	<br />

<?php	echo $this->form_close();
}
