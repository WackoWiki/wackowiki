<?php

/*
 Most Popular Pages Action

 All arguments are optional, the "dontrecurse" argument is only used when the "for" argument is used and even then it's still optional

 {{mostpopular
 [max="50"] // maximum number of pages to retrieve
 [for|page="PageName"] // page name to start from in the page hierarchy
 [nomark="1"] // makes it possible to hide frame around
 [dontrecurse="true|false"] // if set to true the list will only include pages that are direct children of the "for" page
 }}
 */

// TODO: should also work with parameter 'page', but didn't

if (!isset($for))		$for = '';
if (!isset($page))		$page = '';
if (!isset($nomark))	$nomark = '';
if (!isset($max))		$max = '';
if (!isset($legend))	$legend = '';
if (!isset($title))		$title = '';
if (!isset($dontrecurse)) $dontrecurse = false;

if (!$max)				$max = 25;
if ($max > 500)			$max = 500;

// check for first param (for what mostpopular is built)
if ($for)				$page = $for;

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
	echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->get_translation('MostPopularPages').": ".$this->link($ppage, '', $legend)."</span></p>\n";
}

if(!$for)
{
	$pages = $this->load_all(
		"SELECT page_id, tag, title, hits ".
		"FROM ".$this->config['table_prefix']."page ".
		"ORDER BY hits DESC ".
		"LIMIT {$max}");
}
else
{
	$for = $this->unwrap_link($for);

	if(!$dontrecurse || strtolower($dontrecurse) == 'false')
	{
		// We want to recurse and include all the sub pages of sub pages (and so on) in the listing
		$pages = $this->load_all(
			"SELECT DISTINCT a.page_id, a.tag, a.title, a.hits ".
			"FROM ".$this->config['table_prefix']."page a, ".$this->config['table_prefix']."link l ".
			"INNER JOIN ".$this->config['table_prefix']."page b ON (l.from_page_id = b.page_id) ".
			"INNER JOIN ".$this->config['table_prefix']."page c ON (l.to_page_id = c.page_id) ".
			"WHERE a.tag <> '".$for."' ".
				"AND a.tag = c.tag ".
				"AND INSTR(b.tag, '".$for."') = 1 ".
				"AND INSTR(c.tag, '".$for."') = 1 ".
			"ORDER BY a.hits DESC ".
			"LIMIT {$max}");
	}
	else
	{
		// The only pages we want to display are those directly under the selected page, not their kids and grandkids
		$pages = $this->load_all(
			"SELECT DISTINCT a.page_id, a.tag, a.title, a.hits ".
			"FROM ".$this->config['table_prefix']."page a, ".$this->config['table_prefix']."link l ".
				"INNER JOIN ".$this->config['table_prefix']."page b ON (l.from_page_id = b.page_id) ".
				"INNER JOIN ".$this->config['table_prefix']."page c ON (l.to_page_id = c.page_id) ".
			"WHERE a.tag <> '".$for."' ".
				"AND a.tag = c.tag ".
				"AND b.tag = '".$for."' ".
				"AND INSTR(c.tag, '".$for."') = 1 ".
			"ORDER BY a.hits DESC ".
			"LIMIT {$max}");
	}
}

$num = 0;

echo "<table>";

foreach ($pages as $page)
{
	if ($num < $max)
	{
		if ($this->config['hide_locked'])
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
				$this->get_translation('Shown')."</td><td>".
				$page['hits']."</td></tr>\n";
		}
	}
}

echo "</table>\n";

if(!$nomark)
{
	echo "</div>\n";
}

?>