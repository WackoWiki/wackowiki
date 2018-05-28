<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$tpl->year = date('Y');
$this->db->terms_page and $tpl->policy_url = $this->href('', $this->db->terms_page);
