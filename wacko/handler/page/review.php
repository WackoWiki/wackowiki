<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Approval feature
// TODO: delete sql cache ?

if ($this->db->review && $this->is_reviewer() && $this->page)
{
	$page_id = $this->page['page_id'];
	$user_id = $this->get_user_id();

	$this->set_review($user_id, $page_id);

	// set message
	if ($this->page['reviewed'] == 0)
	{
		$message = $this->_t('SetAsReviewed');
	}
	else
	{
		$message = $this->_t('SetAsUnreviewed');
	}

	$this->set_message($message, 'success');
}

$this->show_must_go_on();
