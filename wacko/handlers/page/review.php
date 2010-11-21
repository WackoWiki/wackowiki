<?php

$page_id = $this->page['page_id'];
$user_id = $this->get_user_id();

if ($this->is_reviewer() && $this->page)
{
	$this->set_review($user_id, $page_id);
}

$this->redirect($this->href());

?>