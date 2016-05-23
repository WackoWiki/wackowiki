<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<article class="page">
<?php

// redirect to show method if page don't exists
if (!$this->page || !$this->has_access('read'))
{
	$this->redirect($this->href());
}

if ($this->has_access('read'))
{
	// comment header?
	if ($this->page['comment_on_id'])
	{
		$message = $this->get_translation('ThisIsCommentOn').' '.$this->compose_link_to_page($this->get_page_tag($this->page['comment_on_id']), '', '', 0).', '.$this->get_translation('PostedBy').' '.$this->user_link($this->page['user_name'], $lang = '', true, false).' '.$this->get_translation('At').' '.$this->get_time_formatted($this->page['modified']);
		$this->show_message($message, 'comment-info');
	}

	if ($this->page['latest'] == 0)
	{
		$message =
			str_replace('%1', $this->href(),
			str_replace('%2', $this->tag,
			str_replace('%3', $this->get_time_formatted($this->page['modified']),
			str_replace('%4', $this->user_link($this->page['user_name'], $lang = '', true, false),
			$this->get_translation('Revision')))));
		$this->show_message($message, 'revisioninfo');
	}

	// display page
	$this->context[++$this->current_context] = $this->tag;
	$data = $this->format($this->page['body'], 'wordprocessor');
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
</article>