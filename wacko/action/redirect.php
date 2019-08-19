<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{redirect to="!/NewPage" permanent=[0 or 1] mute=[0|1]}}

if (isset($page))		$to = $page;
if (!isset($to))		$to = '';
if (!isset($permanent))	$permanent = 0;
if (!isset($mute))		$mute = 0;

if (($page = $this->unwrap_link($to)))
{
	if ($this->load_page($page, 0, '', LOAD_CACHE, LOAD_META))
	{
		if (($user = $this->get_user()) && ($user['dont_redirect'] || @$_REQUEST['redirect'] == 'no'))
		{
			$this->show_message($this->_t('PageMoved') . ' ' . $this->link('/' . $page, '', $page));
		}
		else
		{
			// shows redirect hint on target page
			if (!$mute)
			{
				$this->set_message($this->_t('RedirectedFrom') . ' ' . $this->compose_link_to_page($this->tag, '', $this->page['title'], $this->tag, false, ['redirect' => 'no']));
			}

			// do not redirect a page to itself
			if ($this->tag == $page)
			{
				$this->set_message($this->_t('RedirectsToItself'), 'warning');
				return;
			}

			$this->http->redirect($this->href('', $page), $permanent);
			// NEVER BEEN HERE
		}
	}
	else
	{
		$this->show_message('<em>' . $this->_t('WrongPage4Redirect') . '</em>');
	}
}
