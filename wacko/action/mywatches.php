<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($user_id = $this->get_user_id())
{
	if (!isset($profile))		$profile = ''; // user action
	if (!isset($max))			$max = null;
	if (!isset($current_char))	$current_char = '';

	$profile		= ($profile? ['profile' => $profile] : []);
	$profile_mode	= htmlspecialchars(@$_GET['mode'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);
	$mode_selector	= 's';
	$mode			= @$_GET[$mode_selector];
	$p				= isset($_GET['p']) ? ['p' => (int) $_GET['p']] : [];
	$prefix			= $this->db->table_prefix;

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
				"AND w.user_id IS NULL ";

		$sql_count	=
			"SELECT COUNT(p.page_id) AS n " .
			$selector;

		$sql =
			"SELECT p.page_id, p.tag, p.supertag, p.page_lang " .
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

		$sql_count	=
			"SELECT COUNT( DISTINCT page_id ) as n " .
			"FROM {$prefix}watch " .
			"WHERE user_id = " . (int) $user_id . " ";

		$sql =
			"SELECT w.page_id, p.tag, p.supertag, p.page_lang " .
			"FROM {$prefix}watch AS w " .
			"LEFT JOIN {$prefix}page AS p " .
				"ON (p.page_id = w.page_id) " .
			"WHERE w.user_id = " . (int) $user_id . " " .
			"GROUP BY p.tag ";
	}

	// print tabs
	echo $this->tab_menu($tabs, $mode, '', $profile + ['mode' => $profile_mode, '#' => 'list'], $mode_selector);
	echo $info . '<br><br>';

	$count		= $this->db->load_single($sql_count, true);
	$pagination	= $this->pagination($count['n'], $max, 'p', $profile + $tab_mode + ['mode' => 'mywatches', '#' => 'list']);
	$pages		= $this->db->load_all($sql . $pagination['limit']);

	if (!empty($pages))
	{
		foreach ($pages as $page)
		{
			$this->cache_page($page, true);
			$page_ids[] = (int) $page['page_id'];
			// cache page_id for for has_access validation in link function
			$this->page_id_cache[$page['tag']] = $page['page_id'];
		}

		// cache acls
		$this->preload_acl($page_ids);

		foreach ($pages as $page)
		{
			if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
			{
				$first_char = strtoupper($page['tag'][0]);

				if (!preg_match('/' . $this->language['ALPHA'] . '/', $first_char))
				{
					$first_char = '#';
				}

				if ($first_char != $current_char)
				{
					if ($current_char)
					{
						echo "<br>\n";
					}

					echo '<strong>' . $first_char . "</strong><br>\n";
					$current_char = $first_char;
				}

				$text = $this->get_unicode_entities($page['tag'], $page['page_lang']);

				echo
					'<a href="' . $this->href('', '', $profile + $p + $tab_mode + ['mode' => 'mywatches', $action_mode => $page['page_id'], '#' => 'list']) . '" class="' . $icon_class . '">' .
						'<img src="' . $this->db->theme_url . 'icon/spacer.png" title="' . $icon_text . '" alt="' . $icon_text . '">' .
					'</a> ' .
					$this->compose_link_to_page($page['supertag'], '', $text) . "<br>\n";
			}
		}

		$this->print_pagination($pagination);
	}
	else
	{
		echo '<em>' . $none . '</em>';
	}
}
else
{
	echo '<em>' . $this->_t('NotLoggedInWatches') . '</em>';
}
