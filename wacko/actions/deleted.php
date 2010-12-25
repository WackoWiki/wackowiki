<?php

if (!isset($max) || $max > 1000) $max = 1000;

$pages = $this->load_recently_deleted($max);

if ($pages == true)
{
	$i = 0;

	echo "<ul class=\"ul_list\">\n";

	foreach ($pages as $page)
	{
		$i++;
		if ($this->config['hide_locked'])
			$access = $this->has_access('read', $page['page_id']);
		else
			$access = true;

		if ($access === true)
		{
			// day header
			list($day, $time) = explode(' ', $page['date']);
			if (!isset($curday)) $curday = '';

			if ($day != $curday)
			{
				if ($curday) echo "</ul>\n<br /></li>\n";
				echo "<li><strong>".date($this->config['date_format'], strtotime($day)).":</strong>\n<ul>\n";
				$curday = $day;
			}

			// print entry
			echo "<li>".
					"<span style=\"text-align:left\">".
						"<small>".date($this->config['time_format_seconds'], strtotime($time))."</small>  &mdash; ".
						$this->compose_link_to_page($page['tag'], 'revisions', '', 0).
					"</span>".
				"</li>\n";
		}
		if ($i >= $max) break;
	}
	echo "</ul>\n</li>\n</ul>";
}
else
{
	echo $this->get_translation('NoRecentlyDeleted');
}

?>