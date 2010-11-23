<?php

if ($this->config['review'] && $this->is_reviewer() && $this->page)
{
	$page_id = $this->page['page_id'];
	$user_id = $this->get_user_id();

	$this->set_review($user_id, $page_id);

	#$this->set_message($message);
}

// redirect back to page
$this->redirect($this->href());

?>