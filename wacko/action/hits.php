<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{hits}}
// take $this->page['hits'] in the first place

if (isset($for))
{
	$tag = $this->unwrap_link($for);

	$rs = $this->db->load_single(
		"SELECT hits ".
		"FROM ".$this->db->table_prefix."page ".
		"WHERE tag = ".$this->db->q($tag)." LIMIT 1"
	);

	if (isset($rs['hits']))
	{
		echo $rs['hits'];
	}
}
else
{
	echo $this->page['hits'];
}
