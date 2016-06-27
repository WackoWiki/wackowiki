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
$current_day	= '';

if ($user_id = $this->get_user_id())
{
	$limit		= $this->get_list_count($max);
	$prefix		= $this->config['table_prefix'];

	if ((isset($_GET['bydate']) && $_GET['bydate'] == 1) || $bydate == 1)
	{
		echo '<strong>'.$this->get_translation('ListOwnedPages2').'</strong>';
		echo "<br />[<a href=\"".$this->href('', '', 'mode=mypages')."#list"."\">".
		$this->get_translation('OrderABC')."</a>] [<a href=\"".$this->href('', '', 'mode=mypages&amp;bychange=1', '', 'list')."\">".
		$this->get_translation('OrderChange')."</a>] <br /><br />\n";

		$count	= $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE owner_id = '".(int)$user_id."' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=mypages&amp;bydate=1#list');

		if ($pages = $this->load_all(
			"SELECT tag, title, created ".
			"FROM {$prefix}page ".
			"WHERE owner_id = '".(int)$user_id."' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0' ".
			"ORDER BY created DESC, tag ASC ".
			"LIMIT {$pagination['offset']}, $limit", true))
		{
			echo '<ul class="ul_list">'."\n";

			foreach ($pages as $page)
			{
				// tz offset
				$time_tz = $this->get_time_tz( strtotime($page['created']) );
				$time_tz = date('Y-m-d H:i:s', $time_tz);

				// day header
				list($day, $time) = explode(' ', $time_tz);

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
				echo '<li>'.$this->compose_link_to_page($page['tag'], 'revisions', date($this->config['time_format_seconds'], strtotime( $time )), 0, $this->get_translation('RevisionTip')).' &mdash; '.$this->compose_link_to_page($page['tag'], '', '', 0)."</li>\n";


			}

			echo "</ul>\n</li>\n</ul>\n";

			$this->print_pagination($pagination);
		}
		else
		{
			echo $this->get_translation('NoPagesFound');
		}
	}
	else if ((isset($_GET['bychange']) && $_GET['bychange'] == 1) || $bychange == 1)
	{
		$count	= $this->load_single(
			"SELECT COUNT( DISTINCT p.tag ) AS n ".
			"FROM {$prefix}page AS p ".
			"LEFT JOIN {$prefix}revision AS r ".
				"ON (p.page_id = r.page_id ".
					"AND p.owner_id = '".(int)$user_id."') ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.deleted <> '1' ".
				"AND r.comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=mypages&amp;bychange=1#list');

		echo '<strong>'.$this->get_translation('ListOwnedPages3').'</strong>';
		echo '<br />[<a href="'.
			$this->href('', '', 'mode=mypages').'#list">'.$this->get_translation('OrderABC').
			'</a>] [<a href="'.$this->href('', '', 'mode=mypages&amp;bydate=1').'#list">'.
			$this->get_translation('OrderDate')."</a>]<br /><br />\n";

		if ($pages = $this->load_all(
			"SELECT p.tag, p.title, p.modified ".
			"FROM {$prefix}page AS p ".
			"LEFT JOIN {$prefix}revision AS r ".
				"ON (p.page_id = r.page_id ".
					"AND p.owner_id = '".(int)$user_id."') ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.deleted <> '1' ".
				"AND r.comment_on_id = '0' ".
			"GROUP BY tag ".
			"ORDER BY modified DESC, tag ASC ".
			"LIMIT {$pagination['offset']}, $limit", true))
		{
			echo '<ul class="ul_list">'."\n";

			foreach ($pages as $page)
			{
				// tz offset
				$time_tz = $this->get_time_tz( strtotime($page['modified']) );
				$time_tz = date('Y-m-d H:i:s', $time_tz);

				// day header
				list($day, $time) = explode(' ', $time_tz);

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
				echo '<li>'.$this->compose_link_to_page($page['tag'], 'revisions', date($this->config['time_format_seconds'], strtotime( $time )), 0, $this->get_translation('RevisionTip')).' &mdash; '.$this->compose_link_to_page($page['tag'], '', '', 0)."</li>\n";

			}

			echo "</ul>\n</li>\n</ul>\n";

			$this->print_pagination($pagination);
		}
		else
		{
			echo $this->get_translation('NoPagesFound');
		}
	}
	else
	{
		$count	= $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE owner_id = '".(int)$user_id."' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=mypages#list');

		echo '<strong>'.$this->get_translation('ListOwnedPages').'</strong>';
		echo "<br />[<a href=\"".$this->href('', '', 'mode=mypages&amp;bydate=1')."#list"."\">".
		$this->get_translation('OrderDate')."</a>] [<a href=\"".$this->href('', '', 'mode=mypages&amp;bychange=1', '', 'list')."\">".
		$this->get_translation('OrderChange')."</a>] <br /><br />\n";

		if ($pages = $this->load_all(
			"SELECT tag, title, modified ".
			"FROM {$prefix}page ".
			"WHERE owner_id = '".(int)$user_id."' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0' ".
			"ORDER BY tag ASC ".
			"LIMIT {$pagination['offset']}, $limit", true))
		{
			echo '<ul class="ul_list">'."\n";

			foreach ($pages as $page)
			{
				$first_char = strtoupper($page['tag'][0]);

				if (!preg_match('/'.$this->language['ALPHA'].'/', $first_char))
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

				echo "<li>".$this->compose_link_to_page($page['tag'])."</li>\n";
			}

			echo "</ul>\n</li>\n</ul>\n";

			$this->print_pagination($pagination);
		}
		else
		{
			echo $this->get_translation('NoPagesFound');
		}
	}

	if ($pages == false)
	{
		echo $this->get_translation('YouDontOwn');
	}
}
else
{
	echo $this->get_translation('NotLoggedInThusOwned');
}

?>
