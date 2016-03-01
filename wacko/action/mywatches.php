<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($max))		$max = null;
if (!isset($current_char)) $current_char = '';

if ($user_id = $this->get_user_id())
{
	if (isset($_GET['unwatch']) && $_GET['unwatch'] != '')
	{
		$this->clear_watch($user_id, $_GET['unwatch']);
	}
	else if (isset($_GET['setwatch']) && $_GET['setwatch'] != '')
	{
		$this->set_watch($user_id, $_GET['setwatch']);
	}

	$limit		= $this->get_list_count($max);
	$prefix		= $this->config['table_prefix'];

	if (isset($_GET['unwatched']) && $_GET['unwatched'] == 1)
	{
		$count	= $this->load_single(
			"SELECT COUNT(p.tag) AS n ".
			"FROM {$prefix}page AS p ".
			"LEFT JOIN {$prefix}watch AS w ".
				"ON (p.page_id = w.page_id ".
					"AND w.user_id = '".(int)$user_id."') ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.deleted <> '1' ".
				"AND w.user_id IS NULL", true);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=mywatches&amp;unwatched=1#list');

		echo $this->get_translation('UnwatchedPages').' (<a href="'.
			$this->href('', '', 'mode='.htmlspecialchars($_GET['mode'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)).'#list">'.
			$this->get_translation('ViewWatchedPages').'</a>).<br /><br />';

		$cnt = 0;
		if ($pages = $this->load_all(
			"SELECT p.tag AS pagetag, p.page_id AS page_id ".
			"FROM {$prefix}page AS p ".
			"LEFT JOIN {$prefix}watch AS w ".
				"ON (p.page_id = w.page_id ".
					"AND w.user_id = '".(int)$user_id."') ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.deleted <> '1' ".
				"AND w.user_id IS NULL ".
			"ORDER BY pagetag ASC ".
			"LIMIT {$pagination['offset']}, ".($limit * 2)))
		{
			foreach ($pages as $page)
			{
				if (!$this->config['hide_locked'] || $this->has_access('read', $page['page_id']))
				{
					$first_char = strtoupper($page['pagetag'][0]);

					if (!preg_match('/'.$this->language['ALPHA'].'/', $first_char))
					{
						$first_char = '#';
					}

					if ($first_char != $current_char)
					{
						if ($current_char)
						{
							echo "<br />\n";
						}

						echo "<strong>$first_char</strong><br />\n";
						$current_char = $first_char;
					}

					echo '<a href="'.$this->href('', '', (isset($_GET['p']) ? 'p='.htmlspecialchars($_GET['p'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'&amp;' : '').'mode=mywatches&amp;unwatched=1&amp;setwatch='.$page['page_id']).'#list" class="watch-on">'.
						'<img src="'.$this->config['theme_url'].'icon/spacer.png" title="'.$this->get_translation('SetWatch').'" alt="'.$this->get_translation('SetWatch').'"  />'.'</a> '.$this->compose_link_to_page($page['pagetag'], '', '', 0)."<br />\n";
					$cnt++;
				}

				if ($cnt >= $limit)
				{
					break;
				}
			}

			// pagination
			if (isset($pagination['text']))
			{
				echo '<br /><nav class="pagination">'.$pagination['text']."</nav>\n";
			}
		}
		else
		{
			echo '<em>'.$this->get_translation('NoUnwatchedPages').'</em>';
		}
	}
	else
	{
		$count	= $this->load_single(
			"SELECT COUNT( DISTINCT page_id ) as n ".
			"FROM {$prefix}watch ".
			"WHERE user_id = '".(int)$user_id."'", true);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=mywatches#list');

		echo $this->get_translation('WatchedPages').' (<a href="'.
			$this->href('', '', (isset($_GET['mode']) ? 'mode='.htmlspecialchars($_GET['mode'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'&amp;unwatched=1' : '')).'#list">'.
			$this->get_translation('ViewUnwatchedPages').'</a>).<br /><br />';

		$cnt = 0;

		if ($pages = $this->load_all(
			"SELECT w.page_id, p.tag AS tag ".
			"FROM {$prefix}watch AS w ".
			"LEFT JOIN {$prefix}page AS p ".
				"ON (p.page_id = w.page_id) ".
			"WHERE w.user_id = '".(int)$user_id."' ".
			"GROUP BY tag ".
			"LIMIT {$pagination['offset']}, $limit"))
		{
			foreach ($pages as $page)
			{
				if (!$this->config['hide_locked'] || $this->has_access('read', $page['page_id']))
				{
					$first_char = strtoupper($page['tag'][0]);

					if (!preg_match('/'.$this->language['ALPHA'].'/', $first_char))
					{
						$first_char = '#';
					}

					if ($first_char != $current_char)
					{
						if ($current_char)
						{
							echo "<br />\n";
						}

						echo "<strong>$first_char</strong><br />\n";
						$current_char = $first_char;
					}

					echo '<a href="'.$this->href('', '', (isset($_GET['p']) ? 'p='.htmlspecialchars($_GET['p'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'&amp;' : '').'mode=mywatches&amp;unwatch='.$page['page_id']).'#list" class="watch-off">'.
						'<img src="'.$this->config['theme_url'].'icon/spacer.png" title="'.$this->get_translation('RemoveWatch').'" alt="'.$this->get_translation('RemoveWatch').'" />'.'</a> '.$this->compose_link_to_page($page['tag'], '', '', 0)."<br />\n";

					$cnt++;
				}

				if ($cnt >= $limit) break;
			}

			// pagination
			if (isset($pagination['text']))
			{
				echo '<br /><nav class="pagination">'.$pagination['text']."</nav>\n";
			}
		}
		else
		{
			echo '<em>'.$this->get_translation('NoWatchedPages').'</em>';
		}
	}
}
else
{
	echo '<em>'.$this->get_translation('NotLoggedInWatches').'</em>';
}

?>