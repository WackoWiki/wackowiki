<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// restore
// TODO: delete sql cache ?

$message = '';

if ($this->config['store_deleted_pages'] && $this->is_admin() && $this->page['deleted'])
{
	if ($this->page['deleted'] == 1)
	{
		$page_id = $this->page['page_id'];
		$user_id = $this->get_user_id();

		if ($this->restore_page($page_id))
		{
			$message .= $this->get_translation('PageRestored');
		}

		if ($this->restore_file($page_id))
		{
			$message .= $this->get_translation('LocalFilesRestored');
		}

		// set message
		$this->set_message($message);
	}
}

// redirect back to page
$this->redirect($this->href());

?>