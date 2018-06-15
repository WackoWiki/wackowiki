<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$this->ensure_page(true);


// show attachments for current page
if ($this->has_access('read')
		&& ((	$this->db->attachments_handler == 2 && $this->get_user())
			||	$this->db->attachments_handler == 1)
)
{
	// tab navigation
	$mod_selector	= 'files';
	$tabs			= [
				'linked'	=> 'AttachmentsLinked',
				''			=> 'AttachmentsToPage',
				'global'	=> 'AttachmentsGlobal',
				'all'		=> 'AttachmentsAll',
			];
	$mode			= @$_GET[$mod_selector];

	if (!array_key_exists($mode, $tabs))
	{
		$mode = '';
	}

	$tpl->enter('a_');

	$tpl->upload	= $this->can_upload();
	$tpl->header	= $this->_t($tabs[$mode]);
	$tpl->tabs		= $this->tab_menu($tabs, $mode, 'attachments', [], $mod_selector);

	if ($mode == 'global')
	{
		$tpl->files	= $this->action('files', ['global' => 1, 'picture' => 1, 'nomark' => 1, 'method' => 'attachments', 'form' => 1, 'params' => ['files' => 'global']]);
	}
	else if ($mode == 'all')
	{
		$tpl->files	= $this->action('files', ['all' => 1, 'picture' => 1, 'nomark' => 1, 'method' => 'attachments', 'form' => 1, 'params' => ['files' => 'all']]);
	}
	else if ($mode == 'linked')
	{
		$tpl->files	= $this->action('files', ['linked' => 1, 'picture' => 1, 'nomark' => 1, 'method' => 'attachments', 'form' => 1, 'params' => ['files' => 'linked']]);
	}
	else
	{
		// to page
		$tpl->files	= $this->action('files', ['picture' => 1, 'nomark' => 1, 'method' => 'attachments', 'form' => 1]);
	}

	$tpl->leave();
}

