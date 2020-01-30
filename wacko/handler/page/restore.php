<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// restore
// TODO: delete sql cache ?

if ($this->db->store_deleted_pages && $this->is_admin() && $this->page['deleted'])
{
	$page_id = $this->page['page_id'];
	$message = '';

	if ($this->restore_page($page_id))
	{
		$message .= $this->_t('PageRestored');
	}

	if ($this->restore_files_perpage($page_id))
	{
		$message .= $this->_t('LocalFilesRestored');
	}

	// set message
	$this->set_message($message);
}

$this->show_must_go_on();
