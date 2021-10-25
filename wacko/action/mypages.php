<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// action/mypages.php

// set defaults
$title			??= 0;
$bydate			??= '';
$profile		??= ''; // user action
$max			??= null;
$bychange		??= '';

$current_char	= '';
$title			= (int) $title;

$profile		= ($profile? ['profile' => $profile] : []);
$profile_mode	= Ut::html(@$_GET['mode']);
$mod_selector	= 's';

$by = function ($by) use ($profile, $mod_selector)
{
	// TODO: mode is optional $_GET['mode']

	return $profile + ['mode' => 'mypages', $mod_selector => $by, '#' => 'list'];
};

// navigation
$tabs	= [
			''			=> 'OrderABC',
			'bydate'	=> 'OrderDate',
			'bychange'	=> 'OrderChange',
		];
$mode	= @$_GET[$mod_selector];

if (!array_key_exists($mode, $tabs))
{
	$mode = '';
}

if ($user_id = $this->get_user_id())
{
	$tpl->enter('u_');

	// print navigation
	$tpl->tabs	= $this->tab_menu($tabs, $mode, '', $profile + ['mode' => $profile_mode, '#' => 'list'], $mod_selector);

	$prefix		= $this->db->table_prefix;

	if ($mode == 'bydate' || $bydate)
	{
		$selector =
			"FROM {$prefix}page " .
			"WHERE owner_id = " . (int) $user_id . " " .
				"AND deleted <> 1 " .
				"AND comment_on_id = 0 ";

		$count	= $this->db->load_single(
			"SELECT COUNT(page_id) AS n " .
			$selector, true);

		$pagination = $this->pagination($count['n'], $max, 'p', $by('bydate'));

		if ($pages = $this->db->load_all(
			"SELECT page_id, owner_id, user_id, tag, title, created, page_lang " .
			$selector .
			"ORDER BY created DESC, tag ASC " .
			$pagination['limit'], true))
		{
			$tpl->pagination_text = $pagination['text'];

			$current_day = '';

			$tpl->enter('page_');

			foreach ($pages as $page)
			{
				$this->cache_page($page, true);

				$this->sql2datetime($page['created'], $day, $time);

				if ($day != $current_day)
				{
					$tpl->day = $current_day = $day;
				}

				$text = $page['tag'];

				// print entry
				$tpl->l_link	= $this->compose_link_to_page($page['tag'], '', $text);
				$tpl->l_t_time	= $this->compose_link_to_page($page['tag'], 'revisions', $time, $this->_t('RevisionTip'));
			}

			$tpl->leave();
		}
		else
		{
			$tpl->nopages = true;
		}
	}
	else if ($mode == 'bychange' || $bychange == 1)
	{
		$selector =
			"FROM {$prefix}page AS p " .
			"LEFT JOIN {$prefix}revision AS r " .
				"ON (p.page_id = r.page_id " .
					"AND p.owner_id = " . (int) $user_id . ") " .
			"WHERE p.comment_on_id = 0 " .
				"AND p.deleted <> 1 " .
				"AND r.comment_on_id = 0 ";

		$count	= $this->db->load_single(
			"SELECT COUNT( DISTINCT p.tag ) AS n " .
			$selector, true);

		$pagination = $this->pagination($count['n'], $max, 'p', $by('bychange'));

		if ($pages = $this->db->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.modified, p.page_lang " .
			$selector .
			"GROUP BY tag " .
			"ORDER BY modified DESC, tag ASC " .
			$pagination['limit'], true))
		{
			$tpl->pagination_text = $pagination['text'];

			$current_day = '';

			$tpl->enter('page_');

			foreach ($pages as $page)
			{
				$this->cache_page($page, true);

				$this->sql2datetime($page['modified'], $day, $time);

				if ($day != $current_day)
				{
					$tpl->day = $current_day = $day;
				}

				$text = $page['tag'];

				// print entry
				$tpl->l_link	= $this->compose_link_to_page($page['tag'], '', $text);
				$tpl->l_t_time	= $this->compose_link_to_page($page['tag'], 'revisions', $time, $this->_t('RevisionTip'));
			}

			$tpl->leave();
		}
		else
		{
			$tpl->nopages = true;
		}
	}
	else
	{
		$selector =
			"FROM {$prefix}page " .
			"WHERE owner_id = " . (int) $user_id . " " .
				"AND deleted <> 1 " .
				"AND comment_on_id = 0 ";

		$count	= $this->db->load_single(
			"SELECT COUNT(tag) AS n " .
			$selector, true);

		$pagination = $this->pagination($count['n'], $max, 'p', $by(''));

		if ($pages = $this->db->load_all(
			"SELECT page_id, owner_id, user_id, tag, title, modified, page_lang " .
			$selector .
			"ORDER BY tag COLLATE utf8mb4_unicode_520_ci ASC " .
			$pagination['limit'], true))
		{
			$tpl->pagination_text = $pagination['text'];

			$tpl->enter('page_');

			foreach ($pages as $page)
			{
				$this->cache_page($page, true);

				$first_char = mb_strtoupper(mb_substr($page['tag'], 0, 1));

				if (!preg_match('/' . $this->language['ALPHA'] . '/u', $first_char))
				{
					$first_char = '#';
				}

				if ($first_char != $current_char)
				{
					$tpl->char = $current_char = $first_char;
				}

				$text = $page['tag'];

				$tpl->l_link	= $this->compose_link_to_page($page['tag'], '', $text);
			}

			$tpl->leave();
		}
		else
		{
			$tpl->nopages = true;
		}
	}

	$tpl->leave();
}
else
{
	$tpl->guest	= true;
}
