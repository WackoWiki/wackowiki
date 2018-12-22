<?php
if (!defined('IN_WACKO'))
{
	exit;
}
/*
	print last editor of the page

	Last edited by: SomeUser (22.12.2018 13:08 ) fixed two typos

	{{lastedit [label=0|1] [note=0|1]}}

	label	= show 'Last edited by:' label
	note	= show edit note
*/

if (!isset($label))		$label		= true;
if (!isset($note))		$note		= false;

if (($mtime = $this->page['modified']))
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

	$tpl->user_link = $this->user_link($this->page['user_name'], '', true, false);

	if ($label)
	{
		$tpl->label	= true;
	}
	else
	{
		$tpl->icon	= true;
	}
}