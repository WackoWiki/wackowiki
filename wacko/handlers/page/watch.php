<?php

if ($this->get_user() && $this->page)
{
	$page_id = $this->page['page_id'];
	$user_id = $this->get_user_id();

	if ($this->is_watched($user_id, $page_id))
	{
		$this->clear_watch($user_id, $page_id);
	}
	else
	{
		$this->set_watch($user_id, $page_id);
	}
}

// redirect back to page
$this->redirect($this->href());

?>