<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($max))		$max = null;
if (!isset($current_char)) $current_char = '';

if ($user_id = $this->get_user_id())
{
	if (@$_GET['unwatch'])
	{
		$this->clear_watch($user_id, $_GET['unwatch']);
	}
	else if (@$_GET['setwatch'])
	{
		$this->set_watch($user_id, $_GET['setwatch']);
	}

	$prefix		= $this->db->table_prefix;

	if (@$_GET['unwatched'])
	{
		$count	= $this->db->load_single(
			"SELECT COUNT(p.tag) AS n ".
			"FROM {$prefix}page AS p ".
			"LEFT JOIN {$prefix}watch AS w ".
				"ON (p.page_id = w.page_id ".
					"AND w.user_id = '".(int) $user_id."') ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.deleted <> '1' ".
				"AND w.user_id IS NULL", true);

		$pagination = $this->pagination($count['n'], $max, 'p', 'mode=mywatches&amp;unwatched=1#list');

		echo $this->_t('UnwatchedPages').' (<a href="'.
			$this->href('', '', 'mode='.htmlspecialchars($_GET['mode'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)).'#list">'.
			$this->_t('ViewWatchedPages').'</a>).<br /><br />';

		if ($pages = $this->db->load_all(
			"SELECT p.tag AS pagetag, p.page_id AS page_id ".
			"FROM {$prefix}page AS p ".
			"LEFT JOIN {$prefix}watch AS w ".
				"ON (p.page_id = w.page_id ".
					"AND w.user_id = '".(int) $user_id."') ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.deleted <> '1' ".
				"AND w.user_id IS NULL ".
			"ORDER BY pagetag ASC ".
			$pagination['limit']))
		{
			foreach ($pages as $page)
			{
				if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
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
						'<img src="'.$this->db->theme_url.'icon/spacer.png" title="'.$this->_t('SetWatch').'" alt="'.$this->_t('SetWatch').'"  />'.'</a> '.$this->compose_link_to_page($page['pagetag'], '', '', 0)."<br />\n";
				}
			}

			$this->print_pagination($pagination);
		}
		else
		{
			echo '<em>'.$this->_t('NoUnwatchedPages').'</em>';
		}
	}
	else
	{
		$count	= $this->db->load_single(
			"SELECT COUNT( DISTINCT page_id ) as n ".
			"FROM {$prefix}watch ".
			"WHERE user_id = '".(int) $user_id."'", true);

		$pagination = $this->pagination($count['n'], $max, 'p', 'mode=mywatches#list');

		echo $this->_t('WatchedPages').' (<a href="'.
			$this->href('', '', (isset($_GET['mode']) ? 'mode='.htmlspecialchars($_GET['mode'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'&amp;unwatched=1' : '')).'#list">'.
			$this->_t('ViewUnwatchedPages').'</a>).<br /><br />';

		if ($pages = $this->db->load_all(
			"SELECT w.page_id, p.tag AS tag ".
			"FROM {$prefix}watch AS w ".
			"LEFT JOIN {$prefix}page AS p ".
				"ON (p.page_id = w.page_id) ".
			"WHERE w.user_id = '".(int) $user_id."' ".
			"GROUP BY tag ".
			$pagination['limit']))
		{
			foreach ($pages as $page)
			{
				if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
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
						'<img src="'.$this->db->theme_url.'icon/spacer.png" title="'.$this->_t('RemoveWatch').'" alt="'.$this->_t('RemoveWatch').'" />'.'</a> '.$this->compose_link_to_page($page['tag'], '', '', 0)."<br />\n";

				}
			}

			$this->print_pagination($pagination);
		}
		else
		{
			echo '<em>'.$this->_t('NoWatchedPages').'</em>';
		}
	}
}
else
{
	echo '<em>'.$this->_t('NotLoggedInWatches').'</em>';
}
