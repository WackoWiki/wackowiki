<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	the source text will be shown with exception to those fragments which are hidden by formatters %%(comment)..%%
*/

# $this->ensure_page(true); // we allow also comments, like we do in edit handler

if (!$this->page)
{
	$this->http->status(404);
	$this->http->redirect($this->href());
}

if ($this->has_access('read')
	&& ((	$this->db->source_handler == 2 && $this->get_user())
		||	$this->db->source_handler == 1)
)
{
	$tpl->h_head = Ut::perc_replace($this->_t('SourceFor'), $this->compose_link_to_page($this->tag, '', $this->page['title'], $this->tag));

	// is comment?
	if ($this->page['comment_on_id'])
	{
		$comment_on = $this->load_page('', $this->page['comment_on_id'], null, null, LOAD_META);

		// comment header
		$message = $this->msg_is_comment_on(
			$comment_on['tag'],
			$comment_on['title'],
			$this->page['user_name'],
			$this->page['modified']);
		$tpl->message = $this->show_message($message, 'comment-info', false);
	}

	if (!$this->page['latest'])
	{
		$message = Ut::perc_replace($this->_t('RevisionHint'),
			$this->href(),
			$this->tag,
			$this->sql_time_format($this->page['modified']),
			$this->user_link($this->page['user_name'], true, false));

		$tpl->message = $this->show_message($message, 'revision-info', false);
	}

	$tpl->body	= $this->format($this->page['body'], 'source', ['copy_button' => true]); // -> [ ' body | pre ' ]
}
else
{
	$this->http->status(403);

	$tpl->message = $this->show_message($this->_t('ReadAccessDenied'), 'error', false);
}
