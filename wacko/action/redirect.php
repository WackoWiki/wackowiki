<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{redirect to="!/NewPage" permanent="0 or 1"}}

if (isset($page))		$to = $page;
if (!isset($to))		$to = '';
if (!isset($permanent))	$permanent = 0;

if (($page = $this->unwrap_link($to)))
{
	if ($permanent)
	{
		if (!headers_sent())
		{
			header('HTTP/1.1 301 Moved Permanently');
		}
	}

	if ($this->load_page($page, 0, '', LOAD_CACHE, LOAD_META))
	{
		if (($user = $this->get_user()) && ($user['dont_redirect'] || @$_POST['redirect'] == 'no'))
		{
			$this->show_message($this->get_translation('PageMoved') . ' ' . $this->link('/' . $page));
		}
		else
		{
			$this->redirect($this->href('', $page));
			// NEVER BEEN HERE
		}
	}
	else
	{
		$this->show_message('<em>' . $this->get_translation('WrongPage4Redirect') . '</em>');
	}
}
