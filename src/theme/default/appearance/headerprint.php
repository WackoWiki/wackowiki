<?php

if (!defined('IN_WACKO'))
{
	exit;
}

header('Content-Type: text/html; charset=utf-8');

$tpl->lang			= $this->page_lang;
$tpl->charset		= $this->get_charset();
$tpl->title			= !Ut::is_empty(@$this->page['title'])? $this->page['title'] : $this->tag;
$tpl->favicon		= $this->get_favicon();
$this->db->terms_page && $tpl->terms_url = $this->href('', $this->db->terms_page);
$tpl->ver_version	= @$this->page['version_id'];
$tpl->ver_mtime		= @$this->page['modified'];
$tpl->path			= $this->get_page_path();
