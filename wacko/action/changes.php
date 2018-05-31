<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$viewed = '';

if (!isset($for))		$for	= ''; // depreciated
if ($for)				$page	= $for;

if (!isset($page))		$page = '';
if (!isset($root) && isset($page))	$root = $this->unwrap_link($page);
if (!isset($root))		$root = '';
if (!isset($date))		$date = @$_GET['date'];
if (!isset($hide_minor_edit)) $hide_minor_edit = @$_GET['minor_edit'];
if (!isset($noxml))		$noxml = 0;
if (!isset($title))		$title = 0;
if (!isset($max))		$max = null;

$user	= $this->get_user();

// process 'mark read' - reset session time
if (isset($_GET['markread']) && $user)
{
	$this->update_last_mark($user);
	$this->set_user_setting('last_mark', date('Y-m-d H:i:s'));
}

if (list ($pages, $pagination) = $this->load_changed($max, $root, $date, $hide_minor_edit))
{
	if ($user)
	{
		$tpl->mark_href = $this->href('', '', ['markread' => 1]);
	}

	if (!$root && !(int) $noxml)
	{
		$tpl->xml_href = $this->db->base_url . XML_DIR . '/changes_' . preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->db->site_name)) . '.xml';
	}

	$tpl->pagination_text = $pagination['text'];

	$curday = '';

	foreach ($pages as $i => $page)
	{
		if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
		{
			$this->sql2datetime($page['modified'], $day, $time);

			if ($day != $curday)
			{
				$tpl->page_day = $curday = $day;
			}

			$review = $viewed = '';

			// do unicode entities
			$page_lang = ($this->page['page_lang'] != $page['page_lang']) ? $page['page_lang'] : '';

			// cache page_id for for has_access validation in link function
			$this->page_id_cache[$page['tag']] = $page['page_id'];

			// page_size change
			$size_delta = $page['page_size'] - $page['parent_size'];

			// print entry
			$tpl->page_l_revisions =
				(!$this->hide_revisions
					? $this->compose_link_to_page($page['tag'], 'revisions', $time, $this->_t('RevisionTip')) . ' '
					: $time
				);
			$tpl->page_l_page =
				($title == 1
					? $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1, $page_lang, 0)
					: $this->link('/' . $page['tag'], '', $page['tag'], $page['title'], 0, 1, $page_lang, 0)
				);

			$tpl->page_l_user = $this->user_link($page['user_name'], '', true, false);

			if (isset($user['last_mark']) && $user['last_mark']
				&& $page['user_name'] != $user['user_name']
				&& $page['modified'] > $user['last_mark'])
			{
				$tpl->page_l_viewed = ' viewed';
			}

			// review
			if ($this->db->review && $this->is_reviewer() && !$page['reviewed'])
			{
				$tpl->page_l_review_href = $this->compose_link_to_page($page['tag'], 'revisions', $this->_t('Review'));
			}

			if (($edit_note = $page['edit_note']))
			{
				if ($page_lang)
				{
					$edit_note = $this->do_unicode_entities($edit_note, $page_lang);
				}

				$tpl->page_l_edit_note = $edit_note;
			}

			# $tpl->l_delta =  $this->delta_formatted($size_delta); // TODO: looks odd here
		}
	}
}
else
{
	$tpl->nopages = true;
}
