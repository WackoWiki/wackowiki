<?php

if (!defined('IN_WACKO'))
{
	exit;
}

header('Content-Type: text/html; charset=' . $this->get_charset());

$tpl->lang		= $this->page_lang;
$tpl->charset	= $this->get_charset();
$tpl->title		= !Ut::is_empty(@$this->page['title'])? $this->page['title'] : $this->tag;
$this->db->terms_page and $tpl->terms_url = $this->href('', $this->db->terms_page);
