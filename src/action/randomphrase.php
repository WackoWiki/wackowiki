<?php

if (!defined('IN_WACKO'))
{
	exit;
}
$use_empty_string	= (int) ($useemptystring ?? 0);
$revision_id		= (int) ($_GET['revision_id'] ?? 0);

// set defaults
$page		??= '';

$tag		= $this->unwrap_link($page);
$page_id	= $this->get_page_id($tag);

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
		$splitexpr		= '|<br>|';

		if ($use_empty_string)
		{
			$splitexpr = '|<br>[\n\r ]*<br>|u';
		}

		$lines = preg_split($splitexpr, $strings);
		$lines = array_values(array_filter($lines, 'trim'));

		if (!empty($lines))
		{
			$tpl->phrase = $lines[Ut::rand(0, count($lines) - 1)];
		}
	}
}
