<?php

// {{Redirect to="!/NewPage" permanent="0 or 1"}}

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
		header("HTTP/1.0 301 Moved Permanently");
	}

	if ($this->load_page($page, 0, '', LOAD_CACHE, LOAD_META))
	{
		if ($user = $this->get_user())
		{
			if ($user['dont_redirect'] == 1 || (isset($_POST['redirect']) && $_POST['redirect'] == 'no'))
			{
				echo '<div class="info">'.$this->get_translation('PageMoved')." ".$this->link('/'.$page).'</div>';
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
		echo '<div class="info"><i>'.$this->get_translation('WrongPage4Redirect').'</i></div>';
	}
};
?>