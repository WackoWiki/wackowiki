<?php

if (!defined('IN_WACKO'))
{
	exit;
}

echo ADD_NO_DIV . '<article class="page">' . "\n";
$include_tail = '</article>';

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->http->redirect($this->href());
}

if ($this->has_access('read'))
{
	// comment header?
	if ($this->page['comment_on_id'])
	{
		$comment_on = $this->load_page('', $this->page['comment_on_id'], '', '', LOAD_META);
		$message = $this->msg_is_comment_on(
			$comment_on['tag'],
			$comment_on['title'],
			$this->page['user_name'],
			$this->page['modified']);
		$this->show_message($message, 'comment-info');
	}

	if (!$this->page['latest'])
	{
		$message = Ut::perc_replace($this->_t('RevisionHint'),
			$this->href(),
			$this->tag,
			$this->get_time_formatted($this->page['modified']),
			$this->user_link($this->page['user_name'], true, false));
		$this->show_message($message, 'revision-info');
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
	$this->http->status(403);

	$this->show_message($this->_t('ReadAccessDenied'), 'error');
}
