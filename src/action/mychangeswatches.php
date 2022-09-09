<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// TODO: add user and change notes

// set defaults
$profile	??= ''; // user action
$max		??= null;

if ($user_id = $this->get_user_id())
{
	$tpl->enter('user_');

	$profile	= ($profile? ['profile' => $profile] : []);
	$prefix		= $this->prefix;

	$tpl->href	= $this->href('', '', $profile + ['mode' => 'mychangeswatches', 'reset' => 1, '#' => 'list']);

	$count	= $this->db->load_single(
			"SELECT COUNT(p.page_id) AS n " .
			"FROM {$prefix}page AS p, {$pref}watch AS w " .
			"WHERE p.page_id = w.page_id " .
				"AND p.modified > w.watch_time " .
				"AND w.user_id = " . (int) $user_id . " " .
				"AND p.user_id <> " . (int) $user_id . " " .
			"GROUP BY p.tag ", true);

	$pagination = $this->pagination($count['n'], $max, 'p', $profile);

	$pages = $this->db->load_all(
			"SELECT p.page_id, p.tag, p.modified, w.user_id " .
			"FROM {$prefix}page AS p, {$pref}watch AS w " .
			"WHERE p.page_id = w.page_id " .
				"AND p.modified > w.watch_time " .
				"AND w.user_id = " . (int) $user_id . " " .
				"AND p.user_id <> " . (int) $user_id . " " .
			"GROUP BY p.tag " .
			"ORDER BY p.modified DESC, p.tag ASC " .
			$pagination['limit'], true);

	if ((isset($_GET['reset']) && $_GET['reset'] == 1) && $pages)
	{
		foreach ($pages as $page)
		{
			$this->db->sql_query(
				"UPDATE " . $prefix . "watch SET " .
					"watch_time = UTC_TIMESTAMP() " .
				"WHERE page_id = " . (int) $page['page_id'] . " " .
					"AND user_id = " . (int) $user_id);
		}

		$this->db->invalidate_sql_cache();
		$this->http->redirect($this->href('', '', $profile + ['mode' => 'mychangeswatches', '#' => 'list']));
	}

	$tpl->pagination_text = $pagination['text'];

	if ($pages)
	{
		foreach ($pages as $page)
		{
			if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
			{
				$text = $page['tag'];

				$tpl->l_time	= $this->compose_link_to_page($page['tag'], 'revisions', $this->sql_time_formatted($page['modified']), $this->_t('History'));
				$tpl->l_link	= $this->compose_link_to_page($page['tag'], '', $text);
			}
		}
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
