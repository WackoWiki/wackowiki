<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Shows the number of hits for a page.

Usage:
	{{hits}}

Options:
	[page="PageName"]
EOD;

// set defaults
$help		??= 0;
$page		??= '';

if ($help)
{
	echo $this->action('help', ['info' => $info, 'action' => 'hits']);
	return;
}

$result		= 0;

if ($page)
{
	$tag = $this->unwrap_link($page);

	$rs = $this->db->load_single(
		'SELECT hits ' .
		'FROM ' . $this->prefix . 'page ' .
		'WHERE tag = ' . $this->db->q($tag) . ' ' .
		'LIMIT 1');

	if (isset($rs['hits']))
	{
		$result = $rs['hits'];
	}
}
else
{
	$result = $this->page['hits'];
}

echo $this->number_format($result);
