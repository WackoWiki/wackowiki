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
	if ($this->load_page($page, 0, '', LOAD_CACHE, LOAD_META))
	{
		if (($user = $this->get_user()) && ($user['dont_redirect'] || @$_POST['redirect'] == 'no'))
		{
			$this->show_message($this->_t('PageMoved') . ' ' . $this->link('/' . $page));
		}
		else
		{
			$this->http->redirect($this->href('', $page), $permanent);
			// NEVER BEEN HERE
		}
	}
	else
	{
		$this->show_message('<em>' . $this->_t('WrongPage4Redirect') . '</em>');
	}
}
