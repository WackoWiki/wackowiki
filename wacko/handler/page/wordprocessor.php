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
		$message = $this->_t('ThisIsCommentOn') . ' ' .
			$this->compose_link_to_page($comment_on['tag'], '', $comment_on['title'], $comment_on['tag']) . ', ' .
			$this->_t('PostedBy') . ' ' . $this->user_link($this->page['user_name'], '', true, false) . ' ' .
			$this->_t('At') . ' ' . $this->get_time_formatted($this->page['modified']);
		$this->show_message($message, 'comment-info');
	}

	if (!$this->page['latest'])
	{
		$message = Ut::perc_replace($this->_t('Revision'),
			$this->href(),
			$this->tag,
			$this->get_time_formatted($this->page['modified']),
			$this->user_link($this->page['user_name'], '', true, false));
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
	$this->show_message($this->_t('ReadAccessDenied'), 'error');
}
