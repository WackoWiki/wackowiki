<?php

if (!$max || $max > 1000) $max = 1000;

$pages = $this->LoadRecentlyDeleted($max);

if ($pages == true)
{
	$i = 0;

	echo "<ul>";

	foreach ($pages as $page)
	{
		$i++;
		if ($this->config["hide_locked"])
			$access = $this->HasAccess("read", $page["id"]);
		else
			$access = true;

		if ($access === true)
		{
			// day header
			list($day, $time) = explode(" ", $page["date"]);

			if ($day != $curday)
			{
				if ($curday) print("</ul>\n<br /></li>\n");
				echo "<li class=\"lined\"><strong>".date($this->config['date_format'],strtotime($day)).":</strong>\n<ul>\n";
				$curday = $day;
			}

			// print entry
			echo "<li>".
					"<span style=\"text-align:left\">".
						"<small>".date($this->config["time_format_seconds"], strtotime($time))."</small>  &mdash; ".
						$this->ComposeLinkToPage($page["tag"], "revisions", "", 0).
					"</span>".
				"</li>\n";
		}
		if ($i >= $max) break;
	}
	echo "</ul>\n</li>\n</ul>";
}
else
{
	echo $this->GetTranslation("NoRecentlyDeleted");
}

?>