<?php

// only claim ownership if this page has no owner, and if user is logged in.
if ($this->page && !$this->page['owner_id'] && $this->get_user() && !$this->page['comment_on_id'])
{
	$this->set_page_owner($this->page['page_id'], $this->get_user_id());
	$this->set_message($this->get_translation('YouAreNowTheOwner'));
	// log event
	$this->log(4, str_replace('%1', $this->tag.' '.$this->page['title'], $this->get_translation('LogPageOwnershipClaimed', $this->config['language'])));
}

$this->redirect($this->href());

?>