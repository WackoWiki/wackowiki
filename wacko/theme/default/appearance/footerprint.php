<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$tpl->year = date('Y');
$this->db->terms_page && $tpl->terms_url = $this->href('', $this->db->terms_page);
