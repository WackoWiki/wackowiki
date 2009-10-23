<?php

if ($max) $limit = $max;
else $limit	= 50;

$count = $this->LoadSingle(
	"SELECT COUNT(tag) AS n ".
	"FROM {$this->config['table_prefix']}pages ".
	"WHERE comment_on_id = '0'", 1);

$pagination = $this->Pagination($count['n'], $limit);

//  collect data
if ($pages = $this->LoadAll(
	"SELECT {$this->pages_meta} ".
	"FROM {$this->config['table_prefix']}pages ".
	"WHERE comment_on_id = '0' ".
	"ORDER BY title ASC ".
	"LIMIT {$pagination['offset']}, ".(2 * $limit), 1))
{
	foreach ($pages as $page)
	{
		if ($this->config['hide_locked'])
			$access = $this->HasAccess('read', $page['tag']);
		else
			$access = true;

		if ($access)
		{
			$pages_to_display[$page['tag']] = $page;
			$cnt++;
		}

		if ($cnt >= $limit) break;
	}
}

//  display navigation
if ($pages_to_display)
	echo "<span class=\"pagination\">{$pagination['text']}</span><br /><br />\n";

//  display collected data
foreach ($pages_to_display as $page)
{
	$firstChar = strtoupper($page['title'][0]);

	if (preg_match('/[\W\d]/', $firstChar)) $firstChar = '#';

	if ($firstChar != $curChar)
	{
		if ($curChar) echo "<br />\n";

		echo "<strong>$firstChar</strong><br />\n";

		$curChar = $firstChar;
	}

	echo $this->ComposeLinkToPage($page['tag'], '', $page['title'], 0)."<br />\n";
}

//  display navigation
if ($pages_to_display)
	echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
else
	echo $this->GetTranslation('NoPagesFound');

?>