<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->redirect($this->href('show'));
}

if ($this->has_access('read'))
{
	// comment header?
	if ($this->page['comment_on_id'])
	{
		$message = $this->get_translation('ThisIsCommentOn').' '.$this->compose_link_to_page($this->get_page_tag($this->page['comment_on_id']), '', '', 0).', '.$this->get_translation('PostedBy').' '.'<a href="'.$this->href('', $this->config['users_page'], 'profile='.$this->page['user_name']).'">'.$this->page['user_name'].'</a>'.' '.$this->get_translation('At').' '.$this->get_time_string_formatted($this->page['modified']);
		$this->show_message($message, 'commentinfo');
	}

	if ($this->page['latest'] == 0)
	{
		$message =
			str_replace('%1', $this->href(),
			str_replace('%2', $this->tag,
			str_replace('%3', $this->get_page_time_formatted(),
			str_replace('%4', '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$this->page['user_name']).'">'.$this->page['user_name'].'</a>',
			$this->get_translation('Revision')))));
		$this->show_message($message, 'revisioninfo');
	}

	// display page
	$this->context[++$this->current_context] = $this->tag;
	$data = $this->format($this->page['body'], 'msword');
	$data = $this->numerate_toc($data); //  numerate toc if needed


	echo $data;
	$this->current_context--;
}
else
{
	$message = $this->get_translation('ReadAccessDenied');
	$this->show_message($message, 'info');
}
?>
</div>