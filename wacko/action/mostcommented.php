<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
 Most Commented Pages Action

 All arguments are optional, the "dontrecurse" argument is only used when the "for" argument is used and even then it's still optional

 {{mostcommented
 [max=50] // maximum number of pages to retrieve
 [for|page="PageName"] // page name to start from in the page hierarchy
 [nomark=1] // makes it possible to hide frame around
 [dontrecurse="true|false"] // if set to true the list will only include pages that are direct children of the "for" page
 }}
 */

if (!isset($for))		$for = '';  // depreciated
if ($for)				$page = $for;

if (!isset($page))		$page = '';
if (!isset($nomark))	$nomark = '';
if (!isset($max))		$max = '';
if (!isset($legend))	$legend = '';
if (!isset($title))		$title = '';
if (!isset($dontrecurse)) $dontrecurse = false;

if (!$max)				$max = 25;
if ($max > 500)			$max = 500;

// check for first param (for what mostpopular is built)
if (!empty($page))
{
	$page		= $this->unwrap_link($page);
	$ppage		= '/'.$page;
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

if(!$nomark)
{
	echo '<div class="layout-box"><p class="layout-box"><span>'.$this->_t('MostCommentedPages').": ".$this->link($ppage, '', $legend)."</span></p>\n";
}

if(!$page)
{
	$pages = $this->db->load_all(
		"SELECT page_id, tag, title, comments ".
		"FROM ".$this->db->table_prefix."page ".
		"WHERE comments >= 1 ".
		"ORDER BY comments DESC ".
		"LIMIT {$max}");
}
else
{
	$page = $this->unwrap_link($page);

	if(!$dontrecurse || strtolower($dontrecurse) == 'false')
	{
		// We want to recurse and include all the sub pages of sub pages (and so on) in the listing
		$pages = $this->db->load_all(
			"SELECT DISTINCT a.page_id, a.tag, a.title, a.comments ".
			"FROM ".$this->db->table_prefix."page a, ".$this->db->table_prefix."link l ".
			"INNER JOIN ".$this->db->table_prefix."page b ON (l.from_page_id = b.page_id) ".
			"INNER JOIN ".$this->db->table_prefix."page c ON (l.to_page_id = c.page_id) ".
			"WHERE a.tag <> '".$page."' ".
				"AND a.tag = c.tag ".
				"AND INSTR(b.tag, '".$page."') = 1 ".
				"AND INSTR(c.tag, '".$page."') = 1 ".
				"AND a.comments >= 1 ".
			"ORDER BY a.comments DESC ".
			"LIMIT {$max}");
	}
	else
	{
		// The only pages we want to display are those directly under the selected page, not their kids and grandkids
		$pages = $this->db->load_all(
			"SELECT DISTINCT a.page_id, a.tag, a.title, a.comments ".
			"FROM ".$this->db->table_prefix."page a, ".$this->db->table_prefix."link l ".
				"INNER JOIN ".$this->db->table_prefix."page b ON (l.from_page_id = b.page_id) ".
				"INNER JOIN ".$this->db->table_prefix."page c ON (l.to_page_id = c.page_id) ".
			"WHERE a.tag <> '".$page."' ".
				"AND a.tag = c.tag ".
				"AND b.tag = ".$this->db->q($page)." ".
				"AND INSTR(c.tag, ".$this->db->q($page).") = 1 ".
				"AND a.comments >= 1 ".
			"ORDER BY a.comments DESC ".
			"LIMIT {$max}");
	}
}

$num = 0;

echo "<table>";

foreach ($pages as $page)
{
	if ($num < $max)
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
				$_link = $this->link('/'.$page['tag'], '', $page['title']);
			}
			else
			{
				$_link = $this->link('/'.$page['tag'], '', $page['tag']);
			}

			echo "<tr><td>&nbsp;&nbsp;".$num.".&nbsp;".$_link."</td><td>".
				$this->_t('Shown')."</td><td>".
				'<a href="'.$this->href('', $page['tag'], 'show_comments=1').'#header-comments">'.$page['comments'].'</a></td></tr>'."\n";
		}
	}
}

echo "</table>\n";

if(!$nomark)
{
	echo "</div>\n";
}

?>