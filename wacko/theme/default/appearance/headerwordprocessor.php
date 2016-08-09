<?php

if (!defined('IN_WACKO'))
{
	exit;
}

header('Content-Type: text/html; charset=' . $this->get_charset());

$tpl->lang = $this->page_lang;
$tpl->charset = $this->get_charset();
$tpl->title = !Ut::is_empty(@$this->page['title'])? $this->page['title'] : $this->tag;
$this->db->policy_page and $tpl->policy_url = $this->href('', $this->db->policy_page);
