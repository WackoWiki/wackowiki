<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Displays a list of the changed "observed" pages.

Usage:
	{{mychangeswatches}}

Options:
	[max=Number]
	[title=1]
EOD;

// set defaults
$help		??= 0;
$max		??= null;
$profile	??= ''; // user action
$title		??= 0;

if ($help)
{
	$tpl->help	= $this->action('help', ['info' => $info, 'action' => 'mychangeswatches']);
	return;
}

if ($user_id = $this->get_user_id())
{
	$tpl->enter('user_');

	$profile	= ($profile? ['profile' => $profile] : []);
	$prefix		= $this->prefix;

	$tpl->href	= $this->href('', '', $profile + ['mode' => 'mychangeswatches', 'reset' => 1, '#' => 'list']);

	$selector =
		"FROM {$prefix}page AS p, {$prefix}watch AS w " .
		'WHERE p.page_id = w.page_id ' .
			'AND p.modified > w.watch_time ' .
			'AND w.user_id = ' . (int) $user_id . ' ' .
			'AND p.user_id <> ' . (int) $user_id . ' ';

	$count	= $this->db->load_single(
		'SELECT COUNT(p.page_id) AS n ' .
		$selector .
		'GROUP BY p.tag ', true);

	$pagination = $this->pagination($count['n'], $max, 'p', $profile);

	$pages = $this->db->load_all(
		'SELECT p.page_id, p.tag, p.title, p.modified, p.edit_note, p.user_id ' .
		$selector .
		'GROUP BY p.tag, p.page_id, p.modified, w.user_id ' .
		'ORDER BY p.modified DESC, p.tag ASC ' .
		$pagination['limit'], true);

	if ((isset($_GET['reset']) && $_GET['reset'] == 1) && $pages)
	{
		foreach ($pages as $page)
		{
			$this->db->sql_query(
				'UPDATE ' . $prefix . 'watch SET ' .
					'watch_time = UTC_TIMESTAMP() ' .
				'WHERE page_id = ' . (int) $page['page_id'] . ' ' .
					'AND user_id = ' . (int) $user_id);
		}

		$this->db->invalidate_sql_cache();
		$this->http->redirect($this->href('', '', $profile + ['mode' => 'mychangeswatches', '#' => 'list']));
	}

	$tpl->pagination_text = $pagination['text'];

	if ($pages)
	{
		foreach ($pages as $page)
		{
			$this->cache_page($page, true);
			$page_ids[]	= $page['page_id'];
		}

		$this->preload_acl($page_ids);

		$tpl->enter('page_');

		foreach ($pages as $page)
		{
			if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
			{
				$text = $title ? $page['title'] : $page['tag'];
				$alt  = $title ? $page['tag'] : $page['title'];

				$this->sql2datetime($page['modified'], $day, $time);

				if ($day != $cur_day)
				{
					$tpl->day = $cur_day = $day;
				}

				$tpl->l_link	= $this->compose_link_to_page($page['tag'], '', $text, $alt);
				$tpl->l_user	= $this->user_link($page['user_name'], true, false);
				$tpl->l_t_time	= $this->compose_link_to_page($page['tag'], 'revisions', $time, $this->_t('RevisionTip'));

				if ($page['edit_note'])
				{
					$tpl->l_edit_note = $page['edit_note'];
				}
			}
		}

		$tpl->leave(); // page_
	}
	else
	{
		$tpl->none	= true;
	}

	$tpl->leave();
}
else
{
	$tpl->guest	= true;
}
