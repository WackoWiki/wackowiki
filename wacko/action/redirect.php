<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{redirect to="!/NewPage" permanent="0 or 1"}}

if (isset($vars['page']))
{
	$vars['to'] = $vars['page'];
}

$page			= $this->unwrap_link(isset($vars['to']) ? $vars['to'] : '');
$is_permanent	= (isset($vars['permanent']) ? $vars['permanent'] : 0);

if ($page)
{
	if ($is_permanent)
	{
		if (!headers_sent())
		{
			header('HTTP/1.1 301 Moved Permanently');
		}
	}

	if ($this->load_page($page, 0, '', LOAD_CACHE, LOAD_META))
	{
		if ($user = $this->get_user())
		{
			if ($user['dont_redirect'] == 1 || (isset($_POST['redirect']) && $_POST['redirect'] == 'no'))
			{
				$this->show_message( $this->get_translation('PageMoved')." ".$this->link('/'.$page) );
			}
			else
			{
				$this->redirect($this->href('', $page));
			}
		}
		else
		{
			$this->redirect($this->href('', $page));
		}
	}
	else
	{
		$this->show_message('<em>'.$this->get_translation('WrongPage4Redirect').'</em>');
	}
};
?>