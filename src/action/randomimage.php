<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
Random Image Action

 {{randomimage
  [global=0|1]				// attached to page or global
  [owner="UserName"]
  [category="category"]
  [caption=0|1]				// show caption
 }}
 */

if (!isset($category))	$category	= '';
if (!isset($global))	$global		= 0;	// global attachments
if (!isset($owner))		$owner		= '';
if (!isset($caption))	$caption	= 0;

if ($caption)	$param[]	= 'caption';

$track		= false;
$prefix		= $this->db->table_prefix;

$selector =
	($category
		? "INNER JOIN " . $prefix . "category_assignment AS k ON (k.object_id = f.file_id) " .
		  "LEFT JOIN " . $prefix . "category c ON (k.category_id = c.category_id) "
		: "") . " " .
		"WHERE " .
			"(f.picture_w <> 0 OR f.file_ext = 'svg') " .
		"AND f.deleted <> 1 " .
	($owner
		? "AND u.user_name = " . $this->db->q($owner) . " "
		: '') .
	($global
		? "AND f.page_id = 0 "
		: "AND f.page_id = " . (int) $this->page['page_id'] . " "
		);

	if ($category)
	{
		$selector .= "AND c.category IN ( " . $this->db->q($category) . " ) " .
					 "AND k.object_type_id = " . OBJECT_FILE . " ";
	}

$count = $this->db->load_single(
	"SELECT COUNT(f.file_id) AS n " .
	"FROM " . $prefix . "file f " .
	$selector, true);

if ($count['n'])
{
	$file = $this->db->load_single(
		"SELECT f.file_id, f.page_id, f.file_name, p.tag " .
		"FROM " . $prefix . "file f " .
			"LEFT JOIN  " . $prefix . "page p ON (f.page_id = p.page_id) " .
			"INNER JOIN " . $prefix . "user u ON (f.user_id = u.user_id) " .
		$selector .
		"LIMIT " . Ut::rand(0, $count['n'] - 1) . ", 1"
		, true);

	$path1	= 'file:/';

	// check for local file
	if ($file['page_id'])
	{
		// absolute file path: file:/path/
		$path2	= $path1 . $file['tag'] . '/';
	}
	else
	{
		// global file
		$path2	= $path1;
	}

	// TODO: allow adding media parameters
	$file_name	= $file['file_name'] . '';
	$link		= $this->link($path2 . $file_name, '', '', '', $track);

	// display file
	$tpl->link	= $link;
}
else
{
	$tpl->none	= true;
}
