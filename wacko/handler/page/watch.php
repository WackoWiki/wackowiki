<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($this->get_user() && $this->page)
{
	$page_id = $this->page['page_id'];
	$user_id = $this->get_user_id();

	if ($this->is_watched)
	{
		$this->clear_watch($user_id, $page_id);
	}
	else
	{
		$this->set_watch($user_id, $page_id);
	}
}

$this->show_must_go_on();
