<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// restore
// TODO: delete sql cache ?

if ($this->config['store_deleted_pages'] && $this->is_admin() && $this->page['deleted'])
{
	$page_id = $this->page['page_id'];
	$message = '';

	if ($this->restore_page($page_id))
	{
		$message .= $this->_t('PageRestored');
	}

	if ($this->restore_file($page_id))
	{
		$message .= $this->_t('LocalFilesRestored');
	}

	// set message
	$this->set_message($message, 'info');
}

$this->show_must_go_on();
