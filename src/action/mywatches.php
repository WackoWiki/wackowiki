<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($user_id = $this->get_user_id())
{
	// set defaults
	$current_char	??= '';
	$max			??= null;
	$profile		??= ''; // user action
	$title			??= 0;

	$profile		= ($profile? ['profile' => $profile] : []);
	$profile_mode	= Ut::html(@$_GET['mode']);
	$mode_selector	= 's';
	$mode			= @$_GET[$mode_selector];
	$p				= isset($_GET['p']) ? ['p' => (int) $_GET['p']] : [];
	$prefix			= $this->db->table_prefix;
	$title			= (int) $title;

	// navigation
	$tabs	= [
				''			=> 'ViewWatchedPages',
				'unwatched'	=> 'ViewUnwatchedPages',
			];

	if (!array_key_exists($mode, $tabs))
	{
		$mode = '';
	}

	if (@$_GET['unwatch'])
	{
		$this->clear_watch($user_id, (int) $_GET['unwatch']);
	}
	else if (@$_GET['setwatch'])
	{
		$this->set_watch($user_id, (int) $_GET['setwatch']);
	}

	if ($mode == 'unwatched')
	{
		$info			= $this->_t('UnwatchedPages');
		$none			= $this->_t('NoUnwatchedPages');

		$action_mode	= 'setwatch';
		$tab_mode		= [$mode_selector => 'unwatched'];

		$icon_text		= $this->_t('SetWatch');
		$icon_class		= 'watch-on';

		$selector =
			"FROM {$prefix}page AS p " .
				"LEFT JOIN {$prefix}watch AS w " .
					"ON (p.page_id = w.page_id " .
						"AND w.user_id = " . (int) $user_id . ") " .
			"WHERE p.comment_on_id = 0 " .
				"AND p.deleted <> 1 " .
				"AND p.owner_id <> " . (int) $this->db->system_user_id . " " .
				"AND w.user_id IS NULL ";

		$sql_count	=
			"SELECT COUNT(p.page_id) AS n " .
			$selector;

		$sql =
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title " .
			$selector .
			"ORDER BY p.tag ASC ";
	}
	else
	{
		$info			= $this->_t('WatchedPages');
		$none			= $this->_t('NoWatchedPages');

		$action_mode	= 'unwatch';
		$tab_mode		= [];

		$icon_text		= $this->_t('RemoveWatch');
		$icon_class		= 'watch-off';

		$selector =
			"WHERE w.user_id = " . (int) $user_id . " ";

		$sql_count	=
			"SELECT COUNT( DISTINCT w.page_id ) as n " .
			"FROM {$prefix}watch w " .
			$selector;

		$sql =
			"SELECT MAX(w.page_id) AS page_id, p.owner_id, p.user_id, p.tag, p.title " .
			"FROM {$prefix}watch AS w " .
				"LEFT JOIN {$prefix}page AS p " .
					"ON (p.page_id = w.page_id) " .
			$selector .
			"GROUP BY p.tag ";
	}

	// print tabs
	$tpl->tabs	= $this->tab_menu($tabs, $mode, '', $profile + ['mode' => $profile_mode, '#' => 'list'], $mode_selector);
	$tpl->title	=  $info;

	$count		= $this->db->load_single($sql_count, true);
	$pagination	= $this->pagination($count['n'], $max, 'p', $profile + $tab_mode + ['mode' => 'mywatches', '#' => 'list']);
	$pages		= $this->db->load_all($sql . $pagination['limit']);

	$tpl->w_pagination_text = $pagination['text'];

	if (!empty($pages))
	{
		foreach ($pages as $page)
		{
			$page_ids[] = (int) $page['page_id'];

			$this->page_id_cache[$page['tag']] = $page['page_id'];
			$this->cache_page($page, true);
		}

		// cache acls
		$this->preload_acl($page_ids);

		$char_changed	= 0;
		$char_display	= '';
		$n				= 1;
		$skip			= 0;
		$break			= 1;

		$r_count		= count($pages);
		$total			= ceil($r_count / 3);

		$tpl->enter('w_page_');

		foreach ($pages as $page)
		{
			if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
			{
				$first_char = mb_strtoupper(mb_substr($page['tag'], 0, 1));

				if (!preg_match('/' . $this->lang['ALPHA'] . '/u', $first_char))
				{
					$first_char = '#';
				}

				if ($first_char != $current_char)
				{
					if (!$break)
					{
						$tpl->e = true;
					}

					$tpl->ch = $current_char = $first_char;

					$break				= 0;
					$char_show_again	= 0;
					$char_changed		= 1;
				}
				else if ($char_show_again)
				{
					$tpl->ch = $first_char; # . '+';

					$break				= 0;
					$char_show_again	= 0;
					$skip				= 0;
				}

				$text	= $page['tag'];
				$title	= $page['title'];

				$tpl->l_class	= $icon_class;
				$tpl->l_title	= $icon_text;
				$tpl->l_href	= $this->href('', '', $profile + $p + $tab_mode + ['mode' => 'mywatches', $action_mode => $page['page_id'], '#' => 'list']);
				$tpl->l_link	= $this->compose_link_to_page($page['tag'], '', $text, $title);
			}

			if ($n < $r_count)
			{
				// modulus operator: every n loop add a break
				if ($n % $total == 0)
				{
					$tpl->l_m = true;

					if ($char_changed)
					{
						$skip			= 1;
					}
					else
					{
						$skip			= 0;
					}

					$break				= 1;
					$char_show_again	= 1;
					$char_changed		= 0;
				}
			}

			$n++;
		}

		$tpl->e = true;

		$tpl->leave();
	}
	else
	{
		$tpl->none_text = $none;
	}
}
else
{
	$tpl->denied;
}
