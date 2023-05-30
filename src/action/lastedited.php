<?php
if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Print last editor of the page.

	Last edited by: SomeUser (22.12.2018 13:08 ) fixed two typos

Usage:
	{{lastedited}}

Options:
	[icon=0|1]
		show icon
	[label=0|1]
		show 'Last edited by:' label
	[note=0|1]
		show edit note
EOD;

// set defaults
$help		??= 0;
$icon		??= false;
$label		??= true;
$note		??= false;

if ($help)
{
	$tpl->help	= $this->action('help', ['info' => $info, 'action' => 'lastedited']);
	return;
}

if ($mtime = $this->page['modified'])
{
	// revisions link
	if ($this->hide_revisions)
	{
		$tpl->modHide_modified_time = $mtime;
	}
	else
	{
		$tpl->mod_href			= $this->href('revisions');
		$tpl->mod_modified_time	= $mtime;
	}

	if ($note)
	{
		$tpl->notes		= $this->page['edit_note'];
	}

	$tpl->user_link = $this->user_link($this->page['user_name'], true, false);

	if ($label)
	{
		$tpl->label	= true;
	}

	if ($icon || !$label)
	{
		$tpl->icon	= true;
	}
}