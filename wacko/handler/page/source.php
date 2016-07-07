<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	the source text will be shown with exception of those fragments which are hidden by formatters %%(comment)..%%

	TODO: add config option to set an treshhold or to disable the source handler
*/

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->redirect($this->href());
}

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->page['tag']));
}

if ($this->has_access('read'))
{
	if (!$this->page['latest'])
	{
		$message = Ut::perc_replace($this->get_translation('Revision'),
			$this->href(),
			$this->tag,
			$this->get_time_formatted($this->page['modified']),
			$this->user_link($this->page['user_name'], '', true, false));

		$this->show_message($message, 'revisioninfo');
	}

	echo $this->format($this->page['body'], 'source', ['copy_button' => true]);
}
else
{
	$this->show_message($this->get_translation('ReadAccessDenied'), 'info');
}
