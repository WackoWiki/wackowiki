<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->http->redirect($this->href());
}

if ($this->has_access('read'))
{
	if (!$this->page)
	{
		echo Ut::perc_replace($this->_t('DoesNotExists'), $this->href('edit'));
	}
	else
	{
		// comment header?
		if ($this->page['comment_on_id'])
		{
			$comment_on = $this->load_page('', $this->page['comment_on_id'], null, null, LOAD_META);
			$message = $this->msg_is_comment_on(
				$comment_on['tag'],
				$comment_on['title'],
				$this->page['user_name'],
				$this->page['modified']);
			$this->show_message($message, 'comment-info');
		}

		if (!$this->page['latest'])
		{
			echo '<div class="revision-info">' .
				Ut::perc_replace($this->_t('RevisionHint'), $this->href(), $this->tag, $this->page['modified']) .
				'</div>';
		}

		// display page
		$this->context[++$this->current_context] = $this->tag;

		$data = $this->format($this->page['body'], 'latex');

		echo '<pre class="code">' . $data . '</pre>';

		$this->current_context--;
	}
}
else
{
	$this->http->redirect($this->href());
}
