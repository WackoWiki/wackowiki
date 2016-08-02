<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{mychanges [max=Number] [bydate=1]}}

if (!isset($title))		$title = '';
if (!isset($bydate))	$bydate = '';
if (!isset($max))		$max = null;

$by = function ($by) { return ['mode' => 'mychanges', '#' => 'list', 'by' . $by => 1]; };

if (($user_id = $this->get_user_id()))
{
	$prefix		= $this->db->table_prefix;

	if (@$_GET['byname'])
	{
		echo $this->_t('MyChangesTitle2').
		' [<a href="'.$this->href('', '', $by('date')).'">'.
		$this->_t('OrderChange')."</a>].</strong><br /><br />\n";

		$count	= $this->db->load_single(
				"SELECT COUNT(tag) AS n ".
				"FROM {$prefix}page ".
				"WHERE user_id = '".(int)$user_id."' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $max, 'p', $by('name'));

		if (($pages = $this->db->load_all(
				"SELECT tag, title, modified ".
				"FROM {$prefix}page ".
				"WHERE user_id = '".(int)$user_id."' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0' ".
				"ORDER BY tag ASC, modified DESC ".
				$pagination['limit'], true)))
		{
			echo '<ul class="ul_list">'."\n";

			$cur_char = '';
			foreach ($pages as $page)
			{
				$first_char = strtoupper($page['tag'][0]);

				if (!preg_match('/'.$this->language['ALPHA'].'/', $first_char))
				{
					$first_char = '#';
				}

				if ($first_char !== $cur_char)
				{
					if ($cur_char)
					{
						echo "</ul>\n<br /></li>\n";
					}

					echo "<li><strong>$first_char</strong><ul>\n";
					$cur_char = $first_char;
				}

				// print entry
				echo '<li>'.$this->compose_link_to_page($page['tag'], 'revisions', $this->get_time_formatted($page['modified']), 0, $this->_t('RevisionTip')).
					' &mdash; '.$this->compose_link_to_page($page['tag'], '', '', 0)."</li>\n";
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
		echo '<ul class="menu">'."\n".
				'<li class="active">'.$this->_t('MyChangesTitle1')."</li>\n".
				'<li>'." [<a href=\"".$this->href('', '', $by('name'))."\">".$this->_t('OrderABC')."</a>]"."</li>\n".
				"</ul>\n";

		$count	= $this->db->load_single(
				"SELECT COUNT(tag) AS n ".
				"FROM {$prefix}page ".
				"WHERE user_id = '".(int)$user_id."' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $max, 'p', $by('date'));

		if (($pages = $this->db->load_all(
				"SELECT tag, title, modified, edit_note ".
				"FROM {$prefix}page ".
				"WHERE user_id = '".(int)$user_id."' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0' ".
				"ORDER BY modified DESC, tag ASC ".
				$pagination['limit'], true)))
		{
			echo '<ul class="ul_list">'."\n";

			$cur_day = '';
			foreach ($pages as $page)
			{
				$this->sql2datetime($page['modified'], $day, $time);

				if ($day != $cur_day)
				{
					if ($cur_day)
					{
						echo "</ul>\n<br /></li>\n";
					}

					echo "<li><strong>$day:</strong><ul>\n";
					$cur_day = $day;
				}

				if (($edit_note = $page['edit_note']))
				{
					$edit_note = ' <span class="editnote">[' . $edit_note . ']</span>';
				}

				// print entry
				echo "<li>".$this->compose_link_to_page($page['tag'], 'revisions', $time, 0, $this->_t('RevisionTip')).
					" &mdash; ".$this->compose_link_to_page($page['tag'], '', '', 0).$edit_note."</li>\n";
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
