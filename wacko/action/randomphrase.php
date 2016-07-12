<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$revision_id = @$_GET['revision_id'];
if (!isset($use_empty_string)) $use_empty_string = '';
if (!isset($page)) $page = '';

$page = $this->unwrap_link($page);
$page_id = $this->get_page_id($page);

if (!$this->has_access('read', $page_id))
{
	echo $this->get_translation('NoAccessToSourcePage');
}
else
{
	if (!($phrase_page = $this->load_page($page, 0, $revision_id)))
	{
		echo '<em> ' . $this->get_translation('SourcePageDoesntExist') . '(' . $page . ')</em>';
	}
	else
	{
		$strings	= preg_replace('/\{\{[^\}]+\}\}/', '', $phrase_page['body']);
		$strings	= $this->format($strings);
		$splitexpr	= '|<br />|';

		if ($use_empty_string)
		{
			$splitexpr = '|<br />[\n\r ]*<br />|';
		}

		$lines = preg_split($splitexpr, $strings);
		$lines = array_values(array_filter($lines, 'trim'));

		echo $lines[Ut::rand(0, count($lines) - 1)];
	}
}
