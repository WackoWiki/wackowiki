<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// restore
// TODO: delete sql cache ?
$param = null;

if ($this->db->store_deleted_pages
	&& $this->is_admin())
{
	$page_id		= $this->page['page_id'];
	$revision_id	= (int) ($_POST['revision_id'] ?? null);
	$message		= '';

	if ($revision_id)
	{
		if ($this->restore_revision($page_id, $revision_id))
		{
			$message	= $this->_t('RevisionRestored');
			// redirect to restored revision
			$param		= ['revision_id' => $revision_id];
		}
	}
	else if ($this->page['deleted'])
	{
		if ($this->restore_page($page_id))
		{
			$message .= $this->_t('PageRestored');
		}

		if ($this->restore_files_perpage($page_id))
		{
			$message .= $this->_t('LocalFilesRestored');
		}
	}

	// set message
	$this->set_message($message);
}

$this->show_must_go_on($param);
