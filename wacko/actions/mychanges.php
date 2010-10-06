<?php

// {{MyChanges [max="Number"] [bydate="1"]}}

if (!isset($bydate)) $bydate = '';
if (!isset($max)) $max = '';
$curChar = '';
$curday = '';

if ($user_id = $this->get_user_id())
{
	if ($max) $limit = $max;
	else $limit	= 100;
	$prefix = $this->config['table_prefix'];

	if(isset($_GET['bydate']) && $_GET['bydate'] == 1)
	{
		print($this->get_translation('MyChangesTitle1')." [<a href=\"".
			$this->href('', '', 'mode=mychanges')."#list\">".$this->get_translation('OrderABC')."</a>].<br /><br />\n");
			#.($this->config['rewrite_mode'] ? "?" : "&amp;").

		$count	= $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE user_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id = '0'", 1);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=mychanges&amp;bydate=1#list');

		if ($pages = $this->load_all(
			"SELECT tag, modified, edit_note ".
			"FROM {$prefix}page ".
			"WHERE user_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id = '0' ".
			"ORDER BY modified DESC, tag ASC ".
			"LIMIT {$pagination['offset']}, $limit", 1))
		{
			echo "<ul class=\"ul_list\">\n";

			foreach ($pages as $page)
			{
				// day header
				list($day, $time) = explode(" ", $page['modified']);
				if ($day != $curday)
				{
					if ($curday)
					{
						print("</ul>\n<br /></li>\n");
					}
					print("<li><strong>$day:</strong><ul>\n");
					$curday = $day;
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
				print("<li>$time (".$this->compose_link_to_page($page['tag'], 'revisions', $this->get_translation('History'), 0).") ".$this->compose_link_to_page($page['tag'], '', '', 0).$edit_note."</li>\n");


			}
			echo "</ul>\n</li>\n</ul>\n";

			// pagination
			if (isset($pagination['text']))
				echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
		}
		else
		{
			echo $this->get_translation('DidntEditAnyPage');
		}
	}
	else
	{
		print($this->get_translation('MyChangesTitle2')." [<a href=\"".
			$this->href('', '', 'mode=mychanges&amp;bydate=1')."#list\">". #($this->config['rewrite_mode'] ? "?" : "&amp;")."bydate=true\">".
			$this->get_translation('OrderChange')."</a>].</strong><br /><br />\n");

		$count	= $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE user_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id = '0'", 1);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=mychanges#list');

		if ($pages = $this->load_all(
			"SELECT tag, modified ".
			"FROM {$prefix}page ".
			"WHERE user_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id = '0' ".
			"ORDER BY tag ASC, modified DESC ".
			"LIMIT {$pagination['offset']}, $limit", 1))
		{
			echo "<ul class=\"ul_list\">\n";

			foreach ($pages as $page)
			{
				$firstChar = strtoupper($page['tag'][0]);

				if (!preg_match('/'.$this->language['ALPHA'].'/', $firstChar))
				{
					$firstChar = '#';
				}

				if ($firstChar != $curChar)
				{
					if ($curChar)
					{
						print("</ul>\n<br /></li>\n");
					}
					print("<li><strong>$firstChar</strong><ul>\n");
					$curChar = $firstChar;
				}

				// print entry
				print("<li>".$this->get_time_string_formatted($page['modified'])." (".$this->compose_link_to_page($page['tag'], 'revisions', $this->get_translation('History'), 0).") ".$this->compose_link_to_page($page['tag'], '', '', 0)."</li>\n");


			}
			echo "</ul>\n</li>\n</ul>\n";

			// pagination
			if (isset($pagination['text']))
				echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
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