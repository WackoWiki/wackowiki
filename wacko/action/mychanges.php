<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{mychanges [max=Number] [bydate=1]}}

if (!isset($title))		$title = '';
if (!isset($bydate)) $bydate = '';
if (!isset($max)) $max = '';
$cur_char = '';
$cur_day = '';

if ($user_id = $this->get_user_id())
{
	if ($max)
	{
		$limit = $max;
	}
	else
	{
		$limit	= 100;
	}

	$prefix = $this->config['table_prefix'];

	if(isset($_GET['bydate']) && $_GET['bydate'] == 1)
	{
		echo $this->get_translation('MyChangesTitle1')." [<a href=\"".
			$this->href('', '', 'mode=mychanges')."#list\">".$this->get_translation('OrderABC')."</a>].<br /><br />\n";
			#.($this->config['rewrite_mode'] ? "?" : "&amp;").

		$count	= $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE user_id = '".(int)$user_id."' ".
				"AND comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=mychanges&amp;bydate=1#list');

		if ($pages = $this->load_all(
			"SELECT tag, title, modified, edit_note ".
			"FROM {$prefix}page ".
			"WHERE user_id = '".(int)$user_id."' ".
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
					$edit_note = " <span class=\"editnote\">[".$page['edit_note']."]</span>";
				}
				else
				{
					$edit_note = '';
				}

				// print entry
				echo "<li>$time (".$this->compose_link_to_page($page['tag'], 'revisions', $this->get_translation('History'), 0).") ".$this->compose_link_to_page($page['tag'], '', '', 0).$edit_note."</li>\n";


			}

			echo "</ul>\n</li>\n</ul>\n";

			// pagination
			if (isset($pagination['text']))
			{
				echo '<br /><span class="pagination">'.$pagination['text']."</span>\n";
			}
		}
		else
		{
			echo $this->get_translation('DidntEditAnyPage');
		}
	}
	else
	{
		echo $this->get_translation('MyChangesTitle2')." [<a href=\"".
			$this->href('', '', 'mode=mychanges&amp;bydate=1')."#list\">". #($this->config['rewrite_mode'] ? "?" : "&amp;")."bydate=true\">".
			$this->get_translation('OrderChange')."</a>].</strong><br /><br />\n";

		$count	= $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE user_id = '".(int)$user_id."' ".
				"AND comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=mychanges#list');

		if ($pages = $this->load_all(
			"SELECT tag, title, modified ".
			"FROM {$prefix}page ".
			"WHERE user_id = '".(int)$user_id."' ".
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
				echo "<li>".$this->get_time_string_formatted($page['modified'])." (".$this->compose_link_to_page($page['tag'], 'revisions', $this->get_translation('History'), 0).") ".$this->compose_link_to_page($page['tag'], '', '', 0)."</li>\n";
			}

			echo "</ul>\n</li>\n</ul>\n";

			// pagination
			if (isset($pagination['text']))
			{
				echo '<br /><span class="pagination">'.$pagination['text']."</span>\n";
			}
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