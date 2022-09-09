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
		''			=> 'AttachmentsLinked',
		'local'		=> 'AttachmentsToPage',
		#'cluster'	=> 'AttachmentsToCluster',
		'global'	=> 'AttachmentsGlobal',
		'all'		=> 'AttachmentsAll',
	];
	$mode			= (string) ($_GET[$mod_selector] ?? '');
	$dir			= (string) ($_GET['dir'] ?? '');
	$lang			= (string) ($_GET['lang'] ?? '');
	$order			= (string) ($_GET['order'] ?? '');
	$phrase			= (string) ($_GET['phrase'] ?? '');

	$mode			= array_key_exists($mode, $tabs) ? $mode : '';
	$dir			= in_array($dir, ['asc', 'desc']) ? $dir : 'asc';
	$lang			= $this->known_language($lang) ? $lang : '';
	$order			= in_array($order, ['ext', 'name', 'size', 'time']) ? $order : 'name';

	$p_dir			= $dir		? ['dir'	=> $dir]	: [];
	$p_lang			= $lang		? ['lang'	=> $lang]	: [];
	$p_order		= $order	? ['order'	=> $order]	: [];
	$p_phrase		= $phrase	? ['phrase'	=> $phrase]	: [];

	$tpl->enter('a_');

	$tpl->upload	= $this->can_upload();
	$tpl->header	= $this->_t($tabs[$mode]);
	$tpl->tabs		= $this->tab_menu($tabs, $mode, 'attachments', $p_dir + $p_lang + $p_order + $p_phrase, $mod_selector);

	if ($mode)
	{
		$tpl->files	= $this->action('files', [$mode => 1, 'media' => 1, 'nomark' => 1, 'method' => 'attachments', 'form' => 1, 'params' => ['files' => $mode]]);
	}
	else
	{
		// linked to page
		$tpl->files	= $this->action('files', ['linked' => 1, 'media' => 1, 'nomark' => 1, 'method' => 'attachments', 'form' => 1]);
	}

	$tpl->leave();
}
else
{
	$this->http->status(403);

	$tpl->message = $this->show_message($this->_t('ReadAccessDenied'), 'error', false);
}
