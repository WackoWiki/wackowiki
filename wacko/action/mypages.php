<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// action/mypages.php
if (!isset($title))		$title = '';
if (!isset($bydate))	$bydate = '';
if (!isset($profile))	$profile = ''; // user action
if (!isset($max))		$max = null;
if (!isset($bychange))	$bychange = '';
$cur_char		= '';

$profile = ($profile? ['profile' => $profile] : []);
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

if (($user_id = $this->get_user_id()))
{
	// print navigation
	echo $this->tab_menu($tabs, $mode, '', $profile + ['mode' => htmlspecialchars($_GET['mode'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET), '#' => 'list'], $mod_selector);

	$prefix		= $this->db->table_prefix;

	if ($mode == 'bydate' || $bydate)
	{
		$count	= $this->db->load_single(
			"SELECT COUNT(page_id) AS n " .
			"FROM {$prefix}page " .
			"WHERE owner_id = " . (int) $user_id . " " .
				"AND deleted <> 1 " .
				"AND comment_on_id = 0", true);

		$pagination = $this->pagination($count['n'], $max, 'p', $by('date'));

		if ($pages = $this->db->load_all(
			"SELECT tag, title, created " .
			"FROM {$prefix}page " .
			"WHERE owner_id = " . (int) $user_id . " " .
				"AND deleted <> 1 " .
				"AND comment_on_id = 0 " .
			"ORDER BY created DESC, tag ASC " .
			$pagination['limit'], true))
		{
			echo '<ul class="ul_list">' . "\n";

			$current_day = '';
			foreach ($pages as $page)
			{
				$this->sql2datetime($page['created'], $day, $time);

				if ($day != $current_day)
				{
					if ($current_day)
					{
						echo "</ul>\n<br></li>\n";
					}

					echo '<li><strong>' . $day . ":</strong><ul>\n";
					$current_day = $day;
				}

				// print entry
				echo '<li>' . $this->compose_link_to_page($page['tag'], 'revisions', $time, 0, $this->_t('RevisionTip')) . ' &mdash; ' . $this->compose_link_to_page($page['tag'], '', '', 0) . "</li>\n";
			}

			echo "</ul>\n</li>\n</ul>\n";

			$this->print_pagination($pagination);
		}
		else
		{
			echo $this->_t('NoPagesFound');
		}
	}
	else if ($mode == 'bychange' || $bychange == 1)
	{
		$count	= $this->db->load_single(
			"SELECT COUNT( DISTINCT p.tag ) AS n " .
			"FROM {$prefix}page AS p " .
			"LEFT JOIN {$prefix}revision AS r " .
				"ON (p.page_id = r.page_id " .
					"AND p.owner_id = " . (int) $user_id . ") " .
			"WHERE p.comment_on_id = 0 " .
				"AND p.deleted <> 1 " .
				"AND r.comment_on_id = 0", true);

		$pagination = $this->pagination($count['n'], $max, 'p', $by('change'));

		if ($pages = $this->db->load_all(
			"SELECT p.tag, p.title, p.modified " .
			"FROM {$prefix}page AS p " .
			"LEFT JOIN {$prefix}revision AS r " .
				"ON (p.page_id = r.page_id " .
					"AND p.owner_id = " . (int) $user_id . ") " .
			"WHERE p.comment_on_id = 0 " .
				"AND p.deleted <> 1 " .
				"AND r.comment_on_id = 0 " .
			"GROUP BY tag " .
			"ORDER BY modified DESC, tag ASC " .
			$pagination['limit'], true))
		{
			echo '<ul class="ul_list">' . "\n";

			$current_day = '';
			foreach ($pages as $page)
			{
				$this->sql2datetime($page['modified'], $day, $time);

				if ($day != $current_day)
				{
					if ($current_day)
					{
						echo "</ul>\n<br></li>\n";
					}

					echo "<li><strong>$day:</strong><ul>\n";
					$current_day = $day;
				}

				// print entry
				echo '<li>' . $this->compose_link_to_page($page['tag'], 'revisions', $time, 0, $this->_t('RevisionTip')) .
					' &mdash; ' . $this->compose_link_to_page($page['tag'], '', '', 0) . "</li>\n";

			}

			echo "</ul>\n</li>\n</ul>\n";

			$this->print_pagination($pagination);
		}
		else
		{
			echo $this->_t('NoPagesFound');
		}
	}
	else
	{
		$count	= $this->db->load_single(
			"SELECT COUNT(tag) AS n " .
			"FROM {$prefix}page " .
			"WHERE owner_id = " . (int) $user_id . " " .
				"AND deleted <> 1 " .
				"AND comment_on_id = 0", true);

		$pagination = $this->pagination($count['n'], $max, 'p', $by(''));

		if (($pages = $this->db->load_all(
			"SELECT tag, title, modified " .
			"FROM {$prefix}page " .
			"WHERE owner_id = " . (int) $user_id . " " .
				"AND deleted <> 1 " .
				"AND comment_on_id = 0 " .
			"ORDER BY tag ASC " .
			$pagination['limit'], true)))
		{
			echo '<ul class="ul_list">' . "\n";

			foreach ($pages as $page)
			{
				$first_char = strtoupper($page['tag'][0]);

				if (!preg_match('/' . $this->language['ALPHA'] . '/', $first_char))
				{
					$first_char = '#';
				}

				if ($first_char != $cur_char)
				{
					if ($cur_char)
					{
						echo "</ul>\n<br></li>\n";
					}

					echo '<li><strong>' . $first_char . "</strong><ul>\n";
					$cur_char = $first_char;
				}

				echo '<li>' . $this->compose_link_to_page($page['tag']) . "</li>\n";
			}

			echo "</ul>\n</li>\n</ul>\n";

			$this->print_pagination($pagination);
		}
		else
		{
			echo $this->_t('NoPagesFound');
		}
	}

	if ($pages == false)
	{
		echo $this->_t('YouDontOwn');
	}
}
else
{
	echo $this->_t('NotLoggedInThusOwned');
}
