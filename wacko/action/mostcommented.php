<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
 Most Commented Pages Action

 All arguments are optional, the "dontrecurse" argument is only used when the "page" argument is used and even then it's still optional

 {{mostcommented
	[max=50] // maximum number of pages to retrieve
	[page="PageName"] // page name to start from in the page hierarchy
	[title=1] // shows the page title
	[nomark=1] // makes it possible to hide frame around
	[dontrecurse="true|false"] // if set to true the list will only include pages that are direct children of the "page" cluster
 }}
 */

if (!isset($for))			$for = ''; // depreciated
if ($for)					$page = $for;

if (!isset($page))			$page = '';
if (!isset($nomark))		$nomark = 0;
if (!isset($max))			$max = null;
if (!isset($legend))		$legend = '';
if (!isset($title))			$title = 0;
if (!isset($dontrecurse))	$dontrecurse = false;

if (!$max)				$max = 25;
if ($max > 500)			$max = 500;

// check for first param (for what mostpopular is built)
if (!empty($page))
{
	$page		= $this->unwrap_link($page);
	$ppage		= '/' . $page;
	$context	= $page;
	$_page		= $this->load_page($page);
	if (!$legend)
		$legend = $page;
	if (isset($_page['tag']))
		$link		= $this->href('', $_page['tag']);
}
else
{
	$page		= '';
	$ppage		= '';
	$context	= $this->tag;
	$_page		= $this->page;
	$link		= '';
}

if (!$nomark)
{
	echo '<div class="layout-box"><p><span>' . $this->_t('MostCommentedPages') . ": " . $this->link($ppage, '', $legend) . "</span></p>\n";
}

if (!$page)
{
	$selector =
		"FROM " . $this->db->table_prefix . "page " .
		"WHERE comments >= 1 ";

	$sql_count	=
		"SELECT COUNT(page_id) AS n " .
		$selector;

	$sql	=
		"SELECT page_id, tag, title, comments " .
		$selector .
		"ORDER BY comments DESC ";
}
else
{
	$page = $this->unwrap_link($page);

	// $recurse
	//	true	- recurses and includes all the sub pages of sub pages (and so on) in the listing
	//	false	- display only pages directly under the selected page, not their kids and grandkids
	(!$dontrecurse || strtolower($dontrecurse) == 'false')
		? $recurse = true
		: $recurse = false;

	$selector =
		"FROM " . $this->db->table_prefix . "page a, " . $this->db->table_prefix . "page_link l " .
			"INNER JOIN " . $this->db->table_prefix . "page b ON (l.from_page_id = b.page_id) " .
			"INNER JOIN " . $this->db->table_prefix . "page c ON (l.to_page_id = c.page_id) " .
		"WHERE a.tag <> " . $this->db->q($page) . " " .
			"AND a.tag = c.tag " .
			($recurse
				? "AND INSTR(b.tag, " . $this->db->q($page) . ") = 1 "
				: "AND b.tag = " . $this->db->q($page) . " ") .
			"AND INSTR(c.tag, " . $this->db->q($page) . ") = 1 " .
			"AND a.comments >= 1 ";

	$sql_count	=
		"SELECT COUNT(DISTINCT a.page_id) AS n " .
		$selector;

	$sql	=
		"SELECT DISTINCT a.page_id, a.tag, a.title, a.comments " .
		$selector .
		"ORDER BY a.comments DESC ";
}

$count		= $this->db->load_single($sql_count, true);
$pagination	= $this->pagination($count['n'], $max, 'p', []);
$pages		= $this->db->load_all($sql . $pagination['limit'], true);

$num		= $pagination['offset'] ; // + 1

if (!empty($pages))
{
	foreach ($pages as $page)
	{
		$page_ids[] = (int) $page['page_id'];
		// cache page_id for for has_access validation in link function
		$this->page_id_cache[$page['tag']] = $page['page_id'];
	}

	// cache acls
	$this->preload_acl($page_ids);

	echo '<table class="">' . "\n";

	foreach ($pages as $page)
	{
		if ($this->db->hide_locked)
		{
			$access = $this->has_access('read', $page['page_id']);
		}
		else
		{
			$access = true;
		}

		if ($access)
		{
			// print entry
			$num++;

			if ($title == 1)
			{
				$_link = $this->link('/' . $page['tag'], '', $page['title']);
			}
			else
			{
				$_link = $this->link('/' . $page['tag'], '', $page['tag']);
			}

			echo "<tr><td>&nbsp;&nbsp;" . $num.".</td><td>" . $_link . "</td>" .
				"<td>&nbsp;&nbsp;</td><td>" .
				'<a href="' . $this->href('', $page['tag'], ['show_comments' => 1]) . '#header-comments">' . $page['comments'] . '</a></td></tr>' . "\n";
		}
	}

	echo "</table>\n";

	$this->print_pagination($pagination);
}

if (!$nomark)
{
	echo "</div>\n";
}

?>