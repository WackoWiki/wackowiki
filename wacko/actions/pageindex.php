<?php

$cnt = "";
$curChar = "";
if (!isset($title)) $title = "";
if (!isset($max)) $max = "";
if ($max) $limit = $max;
else $limit	= 50;

$count = $this->load_single(
	"SELECT COUNT(tag) AS n ".
	"FROM {$this->config['table_prefix']}page ".
	"WHERE comment_on_id = '0'", 1);

$pagination = $this->pagination($count['n'], $limit);

//  collect data
if ($pages = $this->load_all(
	"SELECT page_id, tag, title ".
	"FROM {$this->config['table_prefix']}page ".
	"WHERE comment_on_id = '0' ".
	"ORDER BY ".($title == 1
		? "title ASC "
		: "tag ASC ").
	"LIMIT {$pagination['offset']}, ".(2 * $limit), 1))
{
	foreach ($pages as $page)
	{
		if ($this->config['hide_locked'])
			$access = $this->has_access('read', $page['page_id']);
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
{
	//  display navigation
	if ($pages_to_display)
		echo "<span class=\"pagination\">{$pagination['text']}</span><br /><br />\n";

	echo "<ul class=\"ul_list\">\n";

	//  display collected data
	foreach ($pages_to_display as $page)
	{
		if ($title == 1)
			$firstChar = strtoupper($page['title'][0]);
		else
			$firstChar = strtoupper($page['tag'][0]);

		if (preg_match('/[\W\d]/', $firstChar)) $firstChar = '#';

		if ($firstChar != $curChar)
		{
			if ($curChar) echo "</ul></li>\n";

			echo "\n<li><strong>$firstChar</strong>\n<ul>\n";

			$curChar = $firstChar;
		}

		echo "<li>";
		if ($title == 1)
			echo $this->compose_link_to_page($page['tag'], '', $page['title'], 0);
		else
			echo $this->compose_link_to_page($page['tag'], '', $page['tag'], 0);
		echo "</li>\n";

	}
	// close list
	if ($curChar)
		echo "</ul>\n</li>\n";

	echo "</ul>\n";

	//  display navigation
	if ($pages_to_display)
		echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
}
else
{
	echo $this->get_translation("NoPagesFound");
}

?>