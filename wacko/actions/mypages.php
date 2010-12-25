<?php

// actions/mypages.php
if (!isset($bydate)) $bydate = '';
if (!isset($max)) $max = '';
if (!isset($bychange)) $bychange = '';
$curChar = '';
$curday = '';

if ($user_id = $this->get_user_id())
{
	if ($max) $limit = $max;
	else $limit	= 100;
	$prefix = $this->config['table_prefix'];

	if ((isset($_GET['bydate']) && $_GET['bydate'] == 1) || $bydate == 1)
	{
		echo $this->get_translation('ListOwnedPages2');
		echo "<br />[<a href=\"".$this->href('', '', 'mode=mypages')."#list"."\">".
		$this->get_translation('OrderABC')."</a>] [<a href=\"".$this->href('', '', 'mode=mypages&amp;bychange=1')."".($this->config['rewrite_mode'] ? "?" : "&amp;")."#list"."\">".
		$this->get_translation('OrderChange')."</a>] <br /><br />\n";
		$count	= $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE owner_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id = '0'", 1);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=mypages&amp;bydate=1#list');

		if ($pages = $this->load_all(
		"SELECT tag, created ".
		"FROM {$prefix}page ".
		"WHERE owner_id = '".quote($this->dblink, $user_id)."' ".
			"AND comment_on_id = '0' ".
		"ORDER BY created DESC, tag ASC ".
		"LIMIT {$pagination['offset']}, $limit", 1))
		{
			echo "<ul class=\"ul_list\">\n";

			foreach ($pages as $page)
			{
				// day header
				list($day, $time) = explode(' ', $page['created']);
				if ($day != $curday)
				{
					if ($curday)
					{
						echo "</ul>\n<br /></li>\n";
					}
					echo "<li><strong>$day:</strong><ul>\n";
					$curday = $day;
				}

				// print entry
				echo "<li>$time (".$this->compose_link_to_page($page['tag'], "revisions", $this->get_translation('History'), 0).") ".$this->compose_link_to_page($page['tag'], "", "", 0)."</li>\n";


			}
			echo "</ul>\n</li>\n</ul>\n";
			// pagination
			if (isset($pagination['text']))
				echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
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
					"AND p.owner_id = '".quote($this->dblink, $user_id)."') ".
			"WHERE p.comment_on_id = '0' ".
				"AND r.comment_on_id = '0'", 1);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=mypages&amp;bychange=1#list');

		echo $this->get_translation('ListOwnedPages3').'.';
		echo '<br />[<a href="'.
			$this->href('', '', 'mode=mypages').'#list">'.$this->get_translation('OrderABC').
			'</a>] [<a href="'.$this->href('', '', 'mode=mypages&amp;bydate=1').'#list">'.
			$this->get_translation('OrderDate')."</a>]<br /><br />\n";

		if ($pages = $this->load_all(
			"SELECT p.tag AS tag, p.modified AS modified ".
			"FROM {$prefix}page AS p ".
			"LEFT JOIN {$prefix}revision AS r ".
				"ON (p.page_id = r.page_id ".
					"AND p.owner_id = '".quote($this->dblink, $user_id)."') ".
			"WHERE p.comment_on_id = '0' ".
				"AND r.comment_on_id = '0' ".
			"GROUP BY tag ".
			"ORDER BY modified DESC, tag ASC ".
			"LIMIT {$pagination['offset']}, $limit", 1))
		{
			echo "<ul class=\"ul_list\">\n";

			foreach ($pages as $page)
			{
				// day header
				list($day, $time) = explode(' ', $page['modified']);
				if ($day != $curday)
				{
					if ($curday)
					{
						echo "</ul>\n<br /></li>\n";
					}
					echo "<li><strong>$day:</strong><ul>\n";
					$curday = $day;
				}

				// print entry
				echo "<li>".$this->get_time_string_formatted($time)." (".$this->compose_link_to_page($page['tag'], 'revisions', $this->get_translation('History'), 0).") ".$this->compose_link_to_page($page['tag'], '', '', 0)."</li>\n";

			}
			echo "</ul>\n</li>\n</ul>\n";
			// pagination
			if (isset($pagination['text']))
				echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
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
			"WHERE owner_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id = '0'", 1);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=mypages#list');

		echo $this->get_translation('ListOwnedPages');
		echo "<br />[<a href=\"".$this->href('', '', 'mode=mypages&amp;bydate=1')."#list"."\">".
		$this->get_translation('OrderDate')."</a>] [<a href=\"".$this->href('', '', 'mode=mypages&amp;bychange=1')."".($this->config['rewrite_mode'] ? "?" : "&amp;")."#list"."\">".
		$this->get_translation('OrderChange')."</a>] <br /><br />\n";

		if ($pages = $this->load_all(
			"SELECT tag, modified ".
			"FROM {$prefix}page ".
			"WHERE owner_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id = '0' ".
			"ORDER BY tag ASC ".
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
						echo "</ul>\n<br /></li>\n";
					}
					echo "<li><strong>$firstChar</strong><ul>\n";
					$curChar = $firstChar;
				}

				echo "<li>".$this->compose_link_to_page($page['tag'])."</li>\n";
			}
			echo "</ul>\n</li>\n</ul>\n";
			// pagination
			if (isset($pagination['text']))
				echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
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