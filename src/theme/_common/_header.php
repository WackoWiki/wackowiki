<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// HTTP header with right charset settings
header('Content-Type: text/html; charset=utf-8');
header_remove('X-Powered-By');

$tpl->enter('h_');

$tpl->lang			= $this->page_lang;
$tpl->dir			= $this->get_direction($this->page_lang);

!Ut::is_empty($tpl->title = @$this->page['title']) || $tpl->tag = $this->add_spaces($this->tag);
$this->method == 'show' || $tpl->method = $this->method;

$tpl->theme_color	= $this->db->theme_color;

// We don't need search robots to index subordinate pages, if indexing is disabled globally or per page
$tpl->norobots = (
		   $this->method != 'show'
		|| $this->db->noindex
		|| !$this->page
		|| !$this->page['latest']
		|| $this->page['noindex']);

if (!$tpl->norobots)
{
	$tpl->index_canonical	= $this->href('', $this->tag, null, false, '', true, true, true);
}

if ($this->has_access('read'))
{
	$tpl->page_keywords		= $this->get_keywords();
	$tpl->page_description	= $this->page['description'] ?? null;
}

if ($this->db->allow_x11colors)
{
	$tpl->x11_colors = $this->db->base_path . Ut::join_path(THEME_DIR, '_common/X11colors.css');
}

$tpl->favicon = $this->get_favicon();

if ($this->db->terms_page)
{
	$tpl->license_href = $this->href('', $this->db->terms_page);
}

if ($this->db->license)
{
	# $tpl->license_href = $this->href('', $this->db->terms_page);
}

if ($this->db->opensearch)
{
	$tpl->os_href = $this->db->base_path . XML_DIR . '/';
}

if ($this->db->enable_feeds)
{
	$tpl->rss_url = $url =
		[
			$this->db->base_path . XML_DIR . '/',
			'_' . preg_replace('/[^a-z\d]/', '', mb_strtolower($this->db->site_name)) . '.xml'
		];

	if ($this->db->news_cluster)
	{
		$tpl->rss_news_url = $url;
	}

	if (!$this->hide_revisions)
	{
		$tpl->rss_revisions_tag		= $this->tag;
		$tpl->rss_revisions_href	= $this->href('revisions.xml');
	}
}

// display Bad Behavior timer
if (!empty($this->db->ext_bad_behavior))
{
	$tpl->bb2 = bb2_timer();
}

// Doubleclick edit feature.
// Enabled only for registered users who don't turn it off (requires class=page in show handler).
$user = $this->get_user();
$doubleclick = $user
	? @$user['doubleclick_edit']
	: $this->has_access('write');

if ($doubleclick && $this->method == 'show')
{
	$tpl->doubleclick_href = $this->href('edit');
}

if ($this->method == 'edit')
{
	$tpl->edit_lang	= $this->user_lang;

	// Autocomplete, enabled only for registered users who turn it on.
	if (@$user['autocomplete'])
	{
		$tpl->edit_ac = true;
	}
}

$tpl->additions = $this->get_html_addition('header');

$tpl->leave();	// h_
