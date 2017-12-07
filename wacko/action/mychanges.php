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
$profile_mode	= htmlspecialchars(@$_GET['mode'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);
$mod_selector	= 's';

$by = function ($by) use ($profile, $mod_selector)
{
	// TODO: mode is optional $_GET['mode']

	return $profile + ['mode' => 'mychanges', $mod_selector => $by, '#' => 'list'];
};

$do_unicode_entities = function ($string, $lang)
{
	if ($this->page['page_lang'] != $lang)
	{
		return $this->do_unicode_entities($string, $lang);
	}
};

if (($user_id = $this->get_user_id()))
{
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
	echo $this->tab_menu($tabs, $mode, '', $profile + ['mode' => $profile_mode, '#' => 'list'], $mod_selector);

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
			"SELECT tag, title, modified, page_lang " .
			$selector .
			"ORDER BY tag ASC, modified DESC " .
			$pagination['limit'], true))
		{
			echo '<ul class="ul_list">' . "\n";

			$cur_char = '';
			foreach ($pages as $page)
			{
				$first_char = strtoupper($page['tag'][0]);

				if (!preg_match('/' . $this->language['ALPHA'] . '/', $first_char))
				{
					$first_char = '#';
				}

				if ($first_char !== $cur_char)
				{
					if ($cur_char)
					{
						echo "</ul>\n<br></li>\n";
					}

					echo '<li><strong>' . $first_char . "</strong>\n<ul>\n";
					$cur_char = $first_char;
				}

				$text = $do_unicode_entities($page['tag'], $page['page_lang']);

				// print entry
				echo '<li>' . $this->compose_link_to_page($page['tag'], 'revisions', $this->get_time_formatted($page['modified']), $this->_t('RevisionTip')) .
					' &mdash; ' . $this->compose_link_to_page($page['tag'], '', $text) . "</li>\n";
			}

			echo "</ul>\n</li>\n</ul>\n";

			$this->print_pagination($pagination);
		}
		else
		{
			echo $this->_t('DidntEditAnyPage');
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
			"SELECT tag, title, modified, edit_note, page_lang " .
			$selector .
			"ORDER BY modified DESC, tag ASC " .
			$pagination['limit'], true)))
		{
			echo '<ul class="ul_list">' . "\n";

			$cur_day = '';
			foreach ($pages as $page)
			{
				$this->sql2datetime($page['modified'], $day, $time);

				if ($day != $cur_day)
				{
					if ($cur_day)
					{
						echo "</ul>\n<br></li>\n";
					}

					echo '<li><strong>' . $day . ":</strong><ul>\n";
					$cur_day = $day;
				}

				if (($edit_note = $page['edit_note']))
				{
					$edit_note = ' <span class="editnote">[' . $edit_note . ']</span>';
				}

				$text = $do_unicode_entities($page['tag'], $page['page_lang']);

				// print entry
				echo '<li>' . $this->compose_link_to_page($page['tag'], 'revisions', $time, $this->_t('RevisionTip')) .
					" &mdash; " . $this->compose_link_to_page($page['tag'], '', $text) . $edit_note . "</li>\n";
			}

			echo "</ul>\n</li>\n</ul>\n";

			$this->print_pagination($pagination);
		}
		else
		{
			echo $this->_t('DidntEditAnyPage');
		}
	}
}
else
{
	echo $this->_t('NotLoggedInThusEdited');
}
