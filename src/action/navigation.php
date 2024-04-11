<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/* navigation action:
 *
 *
TODO:
	- add option to choose custom menu as data source
*/

$info = <<<EOD
Description:
	Generates navigation bars to navigate between chapters of a book.

Usage:
	{{navigation}}

Options:
	[main="Overview"]
		tag of overview
	[prev="PreviousPage"]
		tag of previous chapter
	[next="NextPage"]
		tag of next chapter
	[title=0|1]
		uses page title for links
EOD;

// set defaults
$help		??= 0;
$main		??= '';
$next		??= '';
$prev		??= '';
$table		??= 1;
$title		??= 0;
$track		??= true; // seems to have no effect


if ($help)
{
	$tpl->help	= $this->help($info, 'navigation');
	return;
}

// resolve relative tag
$_main	= $this->unwrap_link($main);
$_next	= $this->unwrap_link($next);
$_prev	= $this->unwrap_link($prev);

// preload link data
$pages	= [$_prev, $_main, $_next];

foreach ($pages as $page)
{
	if ($page != '')
	{
		$q_spages[]		= $this->db->q($page);
	}
}

$pages = $this->db->load_all(
	'SELECT ' . $this->page_meta . ' ' .
	'FROM ' . $this->prefix . 'page ' .
	'WHERE tag IN ( ' . implode(', ', $q_spages) . ' ) '
	, true);

$__main	= null;
$__next	= null;
$__prev	= null;

foreach ($pages as $page)
{
	$this->cache_page($page, true);
	$page_ids[]	= $page['page_id'];
	$this->page_id_cache[$page['tag']] = $page['page_id'];

	if ($page['tag'] == $_prev)
	{
		$__prev = $page;
	}
	else if ($page['tag'] == $_main)
	{
		$__main = $page;
	}
	else if ($page['tag'] == $_next)
	{
		$__next = $page;
	}
}

// cache acls
$this->preload_acl($page_ids, ['read']);

// fall back to tag
if (!$__prev)
{
	$__prev['tag']		= $_prev;
	$__prev['title']	= '';
}
if (!$__main)
{
	$__main['tag']		= $_main;
	$__main['title']	= '';
}
if (!$__next)
{
	$__next['tag']		= $_next;
	$__next['title']	= '';
}

// link text
$__main['text'] = '↑ ' .	($title ? $__main['title'] : $this->_t('Overview'));
$__prev['text'] = '« ' .	($title ? $__prev['title'] : $this->_t('Back'));
$__next['text'] =			($title ? $__next['title'] : $this->_t('Next'))		. ' »';

$__main['title'] =			($title ? '' : $__main['title']);
$__prev['title'] =			($title ? '' : $__prev['title']);
$__next['title'] =			($title ? '' : $__next['title']);

// define navigation links
$tpl->enter($table ? 'tbl_' : 'div_');
$tpl->main_link			= $this->link('/' . $__main['tag'], '', $__main['text'], $__main['title'], $track, true, false);

if ($prev)
{
	$tpl->prev_link		= $this->link('/' . $__prev['tag'], '', $__prev['text'], $__prev['title'], $track, true, false);
}

if ($next)
{
	$tpl->next_link		= $this->link('/' . $__next['tag'], '', $__next['text'], $__next['title'], $track, true, false);
}

if ($prev & $next & !$table)
{
	$tpl->separator	= true;
}

$tpl->leave();

