<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->http->redirect($this->href());
}

if ($this->get_user())
{
	$tpl->link		= $this->compose_link_to_page($this->tag, '', '');
	$tpl->action	= $this->action('watchers', ['nomark' => 1]);
}
