<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{hits}}
// take $this->page['hits'] in the first place

if (!isset($page))		$page	= '';
$result = 0;

if ($page)
{
	$tag = $this->unwrap_link($page);

	$rs = $this->db->load_single(
		"SELECT hits " .
		"FROM " . $this->prefix . "page " .
		"WHERE tag = " . $this->db->q($tag) . " " .
		"LIMIT 1");

	if (isset($rs['hits']))
	{
		$result = $rs['hits'];
	}
}
else
{
	$result = $this->page['hits'];
}

echo number_format($result, 0, ',', '.');
