<?php

if (!defined('IN_WACKO'))
{
	exit;
}

header('Content-Type: text/html; charset=' . $this->get_charset());

$tpl->lang		= $this->page_lang;
$tpl->charset	= $this->get_charset();
$tpl->title		= !Ut::is_empty(@$this->page['title'])? $this->page['title'] : $this->tag;
$tpl->favicon	= $this->db->site_favicon
	? $this->db->base_path . Ut::join_path(IMAGE_DIR, $this->db->site_favicon)
	: $this->db->theme_url . 'icon/favicon.ico';
$this->db->terms_page and $tpl->terms_url = $this->href('', $this->db->terms_page);
$tpl->ver_mtime	= @$this->page['modified'];
$tpl->path		= $this->get_page_path();
