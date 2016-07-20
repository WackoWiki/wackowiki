<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{hashid}}

$hashids = new Hashids($this->config['hashid_seed']);

if (isset($this->page['version_id']))
{
	$version_id = $this->page['version_id'];
}
else
{
	$_old_version = $this->load_single(
		"SELECT version_id ".
		"FROM {$this->config['table_prefix']}revision ".
		"WHERE page_id = '".$this->page['page_id']."' ".
		"ORDER BY version_id DESC ".
		"LIMIT 1");
	$version_id = $_old_version['version_id'] + 1;
}

$ids = [$this->page['page_id'], $version_id];
sscanf(hash('sha1', $ids[0] . $this->config['hashid_seed'] . $ids[1]), '%7x', $ids[2]);

$id = $hashids->encode($ids);

// dbg('hashiding', $ids, '=>', $id);

echo '<a href="' . $this->href('', $id) . '" title="' . $this->_t('PermaLinkTip') . '" rel="nofollow">' . $this->_t('PermaLink') . '</a>';
