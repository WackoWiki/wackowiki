<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$tpl->year = date('Y');
$this->db->policy_page and $tpl->policy_url = $this->href('', $this->db->policy_page);
