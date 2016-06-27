<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{mychanges [max=Number] [bydate=1]}}

if (!isset($title))		$title = '';
if (!isset($bydate))	$bydate = '';
if (!isset($max))		$max = null;
$cur_char	= '';
$cur_day	= '';

if ($user_id = $this->get_user_id())
{
	$limit		= $this->get_list_count($max);
	$prefix		= $this->config['table_prefix'];

	if(isset($_GET['byname']) && $_GET['byname'] == 1)
	{
		echo $this->get_translation('MyChangesTitle2').
		" [<a href=\"".$this->href('', '', 'mode=mychanges&amp;bydate=1')."#list\">".
		$this->get_translation('OrderChange')."</a>].</strong><br /><br />\n";

		$count	= $this->load_single(
				"SELECT COUNT(tag) AS n ".
				"FROM {$prefix}page ".
				"WHERE user_id = '".(int)$user_id."' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=mychanges&amp;byname=1#list');

		if ($pages = $this->load_all(
				"SELECT tag, title, modified ".
				"FROM {$prefix}page ".
				"WHERE user_id = '".(int)$user_id."' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0' ".
				"ORDER BY tag ASC, modified DESC ".
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

				// print entry
				echo '<li>'.$this->compose_link_to_page($page['tag'], 'revisions', $this->get_time_formatted($page['modified']), 0, $this->get_translation('RevisionTip')).' &mdash; '.$this->compose_link_to_page($page['tag'], '', '', 0)."</li>\n";
			}

			echo "</ul>\n</li>\n</ul>\n";

			$this->print_pagination($pagination);
		}
		else
		{
			echo $this->get_translation('DidntEditAnyPage');
		}
	}
	else
	{
		echo '<ul class="menu">'."\n".
				'<li class="active">'.$this->get_translation('MyChangesTitle1')."</li>\n".
				'<li>'." [<a href=\"".$this->href('', '', 'mode=mychanges&amp;byname=1', '', 'list')."\">".$this->get_translation('OrderABC')."</a>]"."</li>\n".
				"</ul>\n";

		$count	= $this->load_single(
				"SELECT COUNT(tag) AS n ".
				"FROM {$prefix}page ".
				"WHERE user_id = '".(int)$user_id."' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=mychanges&amp;bydate=1#list');

		if ($pages = $this->load_all(
				"SELECT tag, title, modified, edit_note ".
				"FROM {$prefix}page ".
				"WHERE user_id = '".(int)$user_id."' ".
				"AND deleted <> '1' ".
				"AND comment_on_id = '0' ".
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
				list($day, $time) = explode(" ", $time_tz);

				if ($day != $cur_day)
				{
					if ($cur_day)
					{
						echo "</ul>\n<br /></li>\n";
					}

					echo "<li><strong>$day:</strong><ul>\n";
					$cur_day = $day;
				}

				if ($page['edit_note'])
				{
					$edit_note = ' <span class="editnote">['.$page['edit_note'].']</span>';
				}
				else
				{
					$edit_note = '';
				}

				// print entry
				echo "<li>".$this->compose_link_to_page($page['tag'], 'revisions', date($this->config['time_format_seconds'], strtotime( $time )), 0, $this->get_translation('RevisionTip'))." &mdash; ".$this->compose_link_to_page($page['tag'], '', '', 0).$edit_note."</li>\n";


			}

			echo "</ul>\n</li>\n</ul>\n";

			$this->print_pagination($pagination);
		}
		else
		{
			echo $this->get_translation('DidntEditAnyPage');
		}
	}
}
else
{
	echo $this->get_translation('NotLoggedInThusEdited');
}

?>
