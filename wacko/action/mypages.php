<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// action/mypages.php
if (!isset($title))		$title = '';
if (!isset($bydate))	$bydate = '';
if (!isset($max))		$max = null;
if (!isset($bychange))	$bychange = '';
$cur_char		= '';

$by = function ($by) { return ['mode' => 'mypages', 'by' . $by => 1, '#' => 'list']; };

if (($user_id = $this->get_user_id()))
{
	$prefix		= $this->db->table_prefix;

	if (@$_GET['bydate'] || $bydate)
	{
		echo '<strong>' . $this->_t('ListOwnedPages2') . '</strong>';
		echo '<br />[<a href="' . $this->href('', '', $by('')) . '">' . 
			$this->_t('OrderABC') . '</a>] [<a href="' . $this->href('', '', $by('change')) . '">' . 
			$this->_t('OrderChange') . "</a>] <br /><br />\n";

		$count	= $this->db->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE owner_id = '" . (int) $user_id . "' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $max, 'p', $by('date'));

		if ($pages = $this->db->load_all(
			"SELECT tag, title, created ".
			"FROM {$prefix}page ".
			"WHERE owner_id = '" . (int) $user_id . "' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0' ".
			"ORDER BY created DESC, tag ASC ".
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
						echo "</ul>\n<br /></li>\n";
					}

					echo "<li><strong>$day:</strong><ul>\n";
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
	else if ((isset($_GET['bychange']) && $_GET['bychange'] == 1) || $bychange == 1)
	{
		$count	= $this->db->load_single(
			"SELECT COUNT( DISTINCT p.tag ) AS n ".
			"FROM {$prefix}page AS p ".
			"LEFT JOIN {$prefix}revision AS r ".
				"ON (p.page_id = r.page_id ".
					"AND p.owner_id = '" . (int) $user_id . "') ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.deleted <> '1' ".
				"AND r.comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $max, 'p', $by('change'));

		echo '<strong>' . $this->_t('ListOwnedPages3') . '</strong>';
		echo '<br />[<a href="' . 
			$this->href('', '', $by('')) . '">' . $this->_t('OrderABC').
			'</a>] [<a href="' . $this->href('', '', $by('date')) . '">' . 
			$this->_t('OrderDate') . "</a>]<br /><br />\n";

		if ($pages = $this->db->load_all(
			"SELECT p.tag, p.title, p.modified ".
			"FROM {$prefix}page AS p ".
			"LEFT JOIN {$prefix}revision AS r ".
				"ON (p.page_id = r.page_id ".
					"AND p.owner_id = '" . (int) $user_id . "') ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.deleted <> '1' ".
				"AND r.comment_on_id = '0' ".
			"GROUP BY tag ".
			"ORDER BY modified DESC, tag ASC ".
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
						echo "</ul>\n<br /></li>\n";
					}

					echo "<li><strong>$day:</strong><ul>\n";
					$current_day = $day;
				}

				// print entry
				echo '<li>' . $this->compose_link_to_page($page['tag'], 'revisions', $time, 0, $this->_t('RevisionTip')).
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
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE owner_id = '" . (int) $user_id . "' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $max, 'p', $by(''));

		echo '<strong>' . $this->_t('ListOwnedPages') . '</strong>';
		echo "<br />[<a href=\"" . $this->href('', '', $by('date')) . "\">".
		$this->_t('OrderDate') . "</a>] [<a href=\"" . $this->href('', '', $by('change')) . "\">".
		$this->_t('OrderChange') . "</a>] <br /><br />\n";

		if (($pages = $this->db->load_all(
			"SELECT tag, title, modified ".
			"FROM {$prefix}page ".
			"WHERE owner_id = '" . (int) $user_id . "' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0' ".
			"ORDER BY tag ASC ".
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
						echo "</ul>\n<br /></li>\n";
					}

					echo "<li><strong>$first_char</strong><ul>\n";
					$cur_char = $first_char;
				}

				echo "<li>" . $this->compose_link_to_page($page['tag']) . "</li>\n";
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
