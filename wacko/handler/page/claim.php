<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// only claim ownership if this page has no owner, and if user is logged in.
if ($this->page && !$this->page['owner_id'] && $this->get_user() && !$this->page['comment_on_id'])
{
	$this->set_page_owner($this->page['page_id'], $this->get_user_id());
	$this->set_message($this->_t('YouAreNowTheOwner'), 'success');
	$this->log(4, Ut::perc_replace($this->_t('LogPageOwnershipClaimed', SYSTEM_LANG), $this->tag . ' ' . $this->page['title']));
}

$this->show_must_go_on();
