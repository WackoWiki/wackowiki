<?php

// Approval feature
// TODO: delete sql cache ?

if ($this->config['review'] && $this->is_reviewer() && $this->page)
{
	$page_id = $this->page['page_id'];
	$user_id = $this->get_user_id();

	$this->set_review($user_id, $page_id);

	// set message
	if ($this->page['reviewed'] == 0)
	{
		$message = $this->get_translation('SetAsReviewed');
	}
	else if ($this->page['reviewed'] == 1)
	{
		$message = $this->get_translation('SetAsUnreviewed');
	}

	$this->set_message($message);
}

// redirect back to page
$this->redirect($this->href());

?>