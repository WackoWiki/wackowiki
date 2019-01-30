<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($this->get_user() && $this->page)
{
	$tpl->action	= $this->action('watchers', ['nomark' => 1]);
}
