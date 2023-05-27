<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Unconditionally it redirects the user to another page.

Usage:
	{{redirect to="!/NewPage"}}

Options:
	[temporary=0|1]
	[mute=0|1]
EOD;

if (isset($page))		$to = $page;

// set defaults
$help		??= 0;
$mute		??= 0;
$temporary	??= 0;
$to			??= '';

if ($help)
{
	echo $this->action('help', ['info' => $info, 'action' => 'redirect']);
	return;
}

$permanent = $temporary ? 0 : 1;

if ($page = $this->unwrap_link($to))
{
	if ($this->load_page($page, 0, null, LOAD_CACHE, LOAD_META))
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
				$this->set_message(
					Ut::perc_replace(
						$this->_t('RedirectedFrom'),
						$this->compose_link_to_page($this->tag, '', $this->page['title'], $this->tag, false, ['redirect' => 'no'])
					));
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
		$this->show_message($this->_t('WrongPage4Redirect'));
	}
}
