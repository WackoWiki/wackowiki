<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Shows hidden content based on user group or user name.

Usage:
	{{hashid}}

Options:
	[version=0|1]
		0 - link to the page
		1 - link to the current page version (default)
EOD;

// set defaults
$help		??= 0;
$version	??= 1;

if ($help)
{
	$tpl->help	= $this->help($info, 'hiddencontent');
	return;
}

// import the Hashids class into the global namespace
use Hashids\Hashids;

if (    $this->db->show_permalink == 1
	|| ($this->db->show_permalink == 2 && $this->get_user()) )
{
	$hashids = new Hashids($this->db->hashid_seed);

	if (!$version)
	{
		$version_id = 0;
	}
	else if (isset($this->page['version_id']))
	{
		$version_id = $this->page['version_id'];
	}
	else
	{
		$old_version = $this->db->load_single(
			'SELECT version_id ' .
			'FROM ' . $this->prefix . 'revision ' .
			'WHERE page_id = ' . (int) $this->page['page_id'] . ' ' .
			'ORDER BY version_id DESC ' .
			'LIMIT 1');
		$version_id = $old_version['version_id'] + 1;
	}

	$ids = [$this->page['page_id'], $version_id];
	sscanf(hash('sha1', $ids[0] . $this->db->hashid_seed . $ids[1]), '%7x', $ids[2]);

	$id = $hashids->encode($ids);

	// dbg('hashiding', $ids, '=>', $id);

	$tpl->a_title	= $this->_t($version ? 'PermaLinkTip' : 'PermaLink0Tip');
	$tpl->a_url		= $this->href('', $id, '', '', '', false);
}
