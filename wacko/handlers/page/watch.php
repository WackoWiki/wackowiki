<?php

$page_id = $this->get_page_id();
$user_id = $this->get_user_id();

if ($this->get_user() && $this->page)
{
	if ($this->is_watched($user_id, $page_id))
	{
		$this->clear_watch($user_id, $page_id);
	}
	else
	{
		$this->set_watch($user_id, $page_id);
	}
}

$this->redirect($this->href());

?>