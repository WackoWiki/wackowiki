<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{mychanges [max=Number] [bydate=1]}}

if (!isset($title))		$title = 0;
if (!isset($bydate))	$bydate = '';
if (!isset($profile))	$profile = null; // user action
if (!isset($max))		$max = null;

$title			= (int) $title;
$profile		= ($profile? ['profile' => $profile] : []);
$profile_mode	= Ut::html(@$_GET['mode']);
$mod_selector	= 's';

$by = function ($by) use ($profile, $mod_selector)
{
	// TODO: mode is optional $_GET['mode']

	return $profile + ['mode' => 'mychanges', $mod_selector => $by, '#' => 'list'];
};

if (($user_id = $this->get_user_id()))
{
	$tpl->enter('u_');

	$tabs	= [
				''			=> 'OrderChange',
				'byname'	=> 'OrderABC',
			];
	$mode	= @$_GET[$mod_selector];

	if (!array_key_exists($mode, $tabs))
	{
		$mode = '';
	}

	// print navigation
	$tpl->tabs	= $this->tab_menu($tabs, $mode, '', $profile + ['mode' => $profile_mode, '#' => 'list'], $mod_selector);

	$prefix		= $this->db->table_prefix;

	if ($mode == 'byname')
	{
		$selector =
			"FROM {$prefix}page " .
			"WHERE user_id = " . (int) $user_id . " " .
				"AND deleted <> 1 " .
				"AND comment_on_id = 0 ";

		$count	= $this->db->load_single(
			"SELECT COUNT(page_id) AS n " .
			$selector, true);

		$pagination = $this->pagination($count['n'], $max, 'p', $by('byname'));

		if ($pages = $this->db->load_all(
			"SELECT page_id, tag, supertag, title, modified, page_lang " .
			$selector .
			"ORDER BY tag ASC, modified DESC " .
			$pagination['limit'], true))
		{
			$tpl->pagination_text = $pagination['text'];

			$cur_char = '';

			$tpl->enter('page_');

			foreach ($pages as $page)
			{
				$this->cache_page($page, true);

				$first_char = strtoupper($page['tag'][0]);

				if (!preg_match('/' . $this->language['ALPHA'] . '/', $first_char))
				{
					$first_char = '#';
				}

				if ($first_char !== $cur_char)
				{
					$tpl->char = $cur_char = $first_char;
				}

				$text = $page['tag'];

				// print entry
				$tpl->l_link	= $this->compose_link_to_page($page['supertag'], '', $text);
				$tpl->l_t_time	= $this->compose_link_to_page($page['tag'], 'revisions', $this->get_time_formatted($page['modified']), $this->_t('RevisionTip'));
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
			"WHERE user_id = " . (int) $user_id . " " .
				"AND deleted <> 1 " .
				"AND comment_on_id = 0 ";

		$count	= $this->db->load_single(
			"SELECT COUNT(tag) AS n " .
			$selector, true);

		$pagination = $this->pagination($count['n'], $max, 'p', $by('date'));

		if (($pages = $this->db->load_all(
			"SELECT page_id, tag, supertag, title, modified, edit_note, page_lang " .
			$selector .
			"ORDER BY modified DESC, tag ASC " .
			$pagination['limit'], true)))
		{
			$tpl->pagination_text = $pagination['text'];

			$cur_day = '';

			$tpl->enter('page_');

			foreach ($pages as $page)
			{
				$this->cache_page($page, true);

				$this->sql2datetime($page['modified'], $day, $time);

				if ($day != $cur_day)
				{
					$tpl->day = $cur_day = $day;
				}

				$text = $page['tag'];

				// print entry
				$tpl->l_link	= $this->compose_link_to_page($page['supertag'], '', $text);
				$tpl->l_t_time	= $this->compose_link_to_page($page['tag'], 'revisions', $time, $this->_t('RevisionTip'));

				if ($page['edit_note'])
				{
					$tpl->l_e_note	= $page['edit_note'];
				}
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
