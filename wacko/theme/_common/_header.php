<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// HTTP header with right Charset settings
header('Content-Type: text/html; charset=' . $this->get_charset());
header_remove('X-Powered-By');

$tpl->h_lang	= $this->page_lang;
$tpl->h_charset	= $this->get_charset();

!Ut::is_empty($tpl->h_title = @$this->page['title']) or $tpl->h_tag = $this->add_spaces($this->tag);
$this->method == 'show' or $tpl->h_method = $this->method;

// We don't need search robots to index subordinate pages, if indexing is disabled globally or per page
$tpl->h_norobots = ($this->method != 'show' || $this->db->noindex || !$this->page || !$this->page['latest'] || $this->page['noindex']);

if ($this->has_access('read'))
{
	$tpl->h_page_keywords		= $this->get_keywords();
	$tpl->h_page_description	= $this->get_description();
}

if ($this->db->allow_x11colors)
{
	$tpl_h_x11_colors = $this->db->base_url . Ut::join_path(THEME_DIR, '_common/X11colors.css');
}

if ($this->db->site_favicon)
{
	$tpl->h_favicon = $this->db->base_url . Ut::join_path(IMAGE_DIR, $this->db->site_favicon);
}
else
{
	$tpl->h_favicon = $this->db->theme_url . 'icon/favicon.ico';
}

if ($this->db->policy_page)
{
	$tpl->h_policy_href = $this->href('', $this->db->policy_page);
}

if ($this->db->license)
{
	# $tpl->h_license_href = $this->href('', $this->db->policy_page);
}

if ($this->db->enable_feeds)
{
	$tpl->h_rss_url = $url =
		[
			$this->db->base_url . XML_DIR . '/',
			'_' . preg_replace('/[^0-9a-z]/', '', strtolower($this->db->site_name)) . '.xml'
		];

	if ($this->db->news_cluster)
	{
		$tpl->h_rss_news_url = $url;
	}

	if (!$this->hide_revisions)
	{
		$tpl->h_rss_revisions_tag	= $this->tag;
		$tpl->h_rss_revisions_href	= $this->href('revisions.xml');
	}
}

// set Bad Behavior "screener" cookie for advanced protection
if (!empty($this->db->ext_bad_behavior))
{
	$tpl->h_bb2 = bb2_insert_head();
}

if ($this->method == 'edit')
{
	$tpl->h_edit_lang = $this->user_lang;
}

// Doubleclick edit feature.
// Enabled only for registered users who don't switch it off (requires class=page in show handler).
if (($user = $this->get_user()))
{
	$doubleclick = @$user['doubleclick_edit'];
}
else
{
	$doubleclick = $this->has_access('write');
}

if ($doubleclick)
{
	$tpl->h_doubleclick_href = $this->href('edit');
}

$tpl->h_additions = $this->html_head;
