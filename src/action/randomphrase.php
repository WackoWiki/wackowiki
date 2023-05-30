<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Loads a random line of a page into the body of data.

Usage:
	{{randomphrase}}

Options:
	[page="PageName"]
	[useemptystring=1]
		indicates breaking up a page into blocks separated by an empty line rather than by lines
EOD;

// set defaults
$help		??= 0;
$page		??= '';

if ($help)
{
	$tpl->help	= $this->help($info, 'randomphrase');
	return;
}

$use_empty_string	= (int) ($useemptystring ?? 0);
$revision_id		= (int) ($_GET['revision_id'] ?? 0);

$tag				= $this->unwrap_link($page);
$page_id			= $this->get_page_id($tag);

if (!$this->has_access('read', $page_id))
{
	$tpl->noaccess = true;
}
else
{
	if (!($phrase_page = $this->load_page('', $page_id, $revision_id)))
	{
		$tpl->none_link	= $this->link('/' . $tag);
	}
	else
	{
		$strings		= preg_replace('/\{\{[^\}]+\}\}/u', '', $phrase_page['body']);
		$strings		= $this->format($strings);
		$strings		= $this->format($strings, 'post_wacko');
		$split_expr		= '|<br>|';

		if ($use_empty_string)
		{
			$split_expr = '|<br>[\n\r ]*<br>|u';
		}

		$lines = preg_split($split_expr, $strings);
		$lines = array_values(array_filter($lines, 'trim'));

		if (!empty($lines))
		{
			$tpl->phrase = $lines[Ut::rand(0, count($lines) - 1)];
		}
	}
}
