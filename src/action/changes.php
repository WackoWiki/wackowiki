<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// set defaults
$date				??= $_GET['date'] ?? '';
$minor_edit			??= (bool) ($_GET['minor_edit'] ?? true);
$max				??= null;
$noxml				??= 0;
$page				??= '';
$title				??= 0;

$tag	= $this->unwrap_link($page);
$user	= $this->get_user();

if ($date && !$this->validate_date($date))
{
	$date = '';
}

// process 'mark read'
$this->mark_read($user);

if ([$pages, $pagination] = $this->load_changed($max, $tag, $date, $minor_edit))
{
	if ($user)
	{
		$tpl->mark_href = $this->href('', '', ['markread' => 1]);
	}

	if (!$tag && !(int) $noxml)
	{
		$tpl->xml_href = $this->get_xml_file('changes');
	}

	$tpl->pagination_text = $pagination['text'];

	$curday = '';

	$tpl->enter('page_');

	foreach ($pages as $page)
	{
		if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
		{
			$this->sql2datetime($page['modified'], $day, $time);

			if ($day != $curday)
			{
				$tpl->day = $curday = $day;
			}

			$this->page_id_cache[$page['tag']] = $page['page_id'];

			// print entry
			$tpl->l_revisions =
				(!$this->hide_revisions
					? $this->compose_link_to_page($page['tag'], 'revisions', $time, $this->_t('RevisionTip')) . ' '
					: $time
				);
			$tpl->l_page =
				($title == 1
					? $this->link('/' . $page['tag'], '', $page['title'], '', false, true, false)
					: $this->link('/' . $page['tag'], '', $page['tag'], $page['title'], false, true, false)
				);

			$tpl->l_user = $this->user_link($page['user_name'], true, false);

			if (isset($user['last_mark']) && $user['last_mark']
				&& $page['user_name'] != $user['user_name']
				&& $page['modified'] > $user['last_mark'])
			{
				$tpl->l_viewed = ' class="viewed"';
			}

			// review
			if ($this->db->review && $this->is_reviewer() && !$page['reviewed'])
			{
				$tpl->l_review_href = $this->compose_link_to_page($page['tag'], 'revisions', $this->_t('Review'));
			}

			if ($page['edit_note'])
			{
				$tpl->l_edit_note = $page['edit_note'];
			}

			// page_size change
			# $size_delta = $page['page_size'] - $page['parent_size'];
			# $tpl->l_delta =  $this->delta_formatted($size_delta); // TODO: looks odd here
		}
	}

	$tpl->leave(); // page_
}
else
{
	$tpl->nopages = true;
}
