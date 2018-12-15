<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	the source text will be shown with exception of those fragments which are hidden by formatters %%(comment)..%%

	TODO: add config option to set an treshhold or to disable the source handler
*/

$this->ensure_page();

if ($this->has_access('read'))
{
	if (!$this->page['latest'])
	{
		$message = Ut::perc_replace($this->_t('Revision'),
			$this->href(),
			$this->tag,
			$this->get_time_formatted($this->page['modified']),
			$this->user_link($this->page['user_name'], '', true, false));

		$this->show_message($message, 'revision-info');
	}

	echo $this->format($this->page['body'], 'source', ['copy_button' => true]);
}
else
{
	$this->show_message($this->_t('ReadAccessDenied'), 'error');
}
