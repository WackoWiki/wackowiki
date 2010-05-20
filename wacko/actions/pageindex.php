<?php

$cnt = "";
$curChar = "";
if (!isset($title)) $title = "";
if (!isset($max)) $max = "";
if ($max) $limit = $max;
else $limit	= 50;

$count = $this->LoadSingle(
	"SELECT COUNT(tag) AS n ".
	"FROM {$this->config['table_prefix']}page ".
	"WHERE comment_on_id = '0'", 1);

$pagination = $this->Pagination($count['n'], $limit);

//  collect data
if ($pages = $this->LoadAll(
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
			$access = $this->HasAccess('read', $page['page_id']);
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
		echo $this->ComposeLinkToPage($page["tag"], '', $page["title"], 0);
	else
		echo $this->ComposeLinkToPage($page["tag"], '', $page["tag"], 0);
	echo "</li>\n";

}
// close list
if ($curChar)	echo "</ul>\n</li>\n";

//  display navigation
if ($pages_to_display)

	echo "</ul>\n<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
else
	echo $this->GetTranslation("NoPagesFound");

?>