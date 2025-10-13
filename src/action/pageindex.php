<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
 Page Index Action
 */

$info = <<<EOD
Description:
	Outputs a complete directory of all pages on the site, ordered alphabetically.

Usage:
	{{pageindex}}

Options:
	[page="Cluster"]
		show page index only for a certain cluster
	[max=50]
		number of pages to show at one time, if there are more pages then the next/prev buttons are shown
	[letter="a"]
		only display pages whose name starts with this letter
	[title=0|1]
		takes title inplace of tag
	[system=0|1]
		includes or excludes system pages
	[lang="ru"]
		show pages only in specified language
EOD;

// set defaults
$help		??= 0;
$lang		??= '';
$letter		??= '';
$max		??= null;
$page		??= '';
$system		??= 1;
$title		??= 0;

if ($help)
{
	$tpl->help	= $this->help($info, 'pageindex');
	return;
}

$system
	? $user_id		= null
	: $user_id		= $this->db->system_user_id;

if ($lang && !$this->known_language($lang))
{
	$lang = '';
	#$this->set_message($this->_t('FilterLangNotAvailable'));
}

$tag		= $this->unwrap_link($page);
$title		= (int) $title;
$_alnum		= '/' . self::PATTERN['ALPHANUM'] . '/uS';

$get_letter	= function ($ch) use (&$_alnum) // hope "it" will cache compiled regex
{
	$ch = mb_strtoupper(mb_substr($ch, 0, 1));

	if ($ch !== '' && !preg_match($_alnum, $ch))
	{
		$ch = '#';
	}

	return $ch;
};

$letter = $get_letter($_GET['letter'] ?? $letter);

// get letters of alphabet with existing pages, and cache them in _SESSION
$letters = &$this->sess->pi_letters;

if (!isset($letters)
	|| $this->sess->pi_for		!= $page
	|| $this->sess->pi_lang		!= $lang
	|| $this->sess->pi_title	!= $title
	|| time() > $this->sess->pi_time)
{
	$this->sess->pi_for		= $page;
	$this->sess->pi_lang	= $lang;
	$this->sess->pi_title	= $title;
	$this->sess->pi_time	= time() + 600;

	$pages = $this->db->load_all(
		'SELECT tag, title ' .
		'FROM ' . $this->prefix . 'page ' .
		'WHERE comment_on_id = 0 ' .
			'AND deleted = 0 ' .
			($page
				? 'AND tag LIKE ' . $this->db->q($tag . '/%') . ' '
				: '') .
			($user_id
				? 'AND owner_id <> ' . (int) $user_id . ' '
				: '') .
			($lang
				? 'AND page_lang = ' . $this->db->q($lang) . ' '
				: '') .
		'ORDER BY ' .
			($title
				? 'title ASC '
				: 'tag ASC ')
			, true);

	$letters = [];

	foreach ($pages as $_page)
	{
		if (($ch = $get_letter($title? $_page['title'] : $_page['tag'])) !== '')
		{
			if (array_key_exists($ch, $letters))
			{
				++$letters[$ch];
			}
			else
			{
				$letters[$ch] = 1;
			}
		}
	}
}

// get index pages
$selector =
	'FROM ' . $this->prefix . 'page ' .
	'WHERE comment_on_id = 0 ' .
		'AND deleted = 0 ' .
		($page
			? 'AND tag LIKE ' . $this->db->q($tag . '/%') . ' '
			: '') .
		($user_id
			? 'AND owner_id <> ' . (int) $user_id . ' '
			: '') .
		($lang
			? 'AND page_lang = ' . $this->db->q($lang) . ' '
			: '') .
		($letter !== ''
			? 'AND ' .
				($title
					? 'title '
					: 'tag ') .
				'COLLATE ' . $this->db->collate() . ' LIKE ' . $this->db->q($letter . '%') . ' '
			: '');

$count = $this->db->load_single(
	'SELECT COUNT(page_id) AS n ' .
	$selector
	, true);

$pagination = $this->pagination($count['n'], $max, 'p', ($letter !== ''? ['letter' => $letter] : []));

// collect data for index
$pages_to_display	= [];
$page_ids			= [];

if ($pages = $this->db->load_all(
	'SELECT page_id, owner_id, user_id, tag, title, page_lang ' .
	$selector .
	'ORDER BY ' .
		($title
			? 'title '
			: 'tag ') .
		'COLLATE ' . $this->db->collate() . ' ASC ' .
	$pagination['limit'], true))
{
	foreach ($pages as $page)
	{
		$page_ids[] = (int) $page['page_id'];

		$this->page_id_cache[$page['tag']] = $page['page_id'];
		$this->cache_page($page, true);
	}

	// cache acls
	$this->preload_acl($page_ids);

	foreach ($pages as $page)
	{
		if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
		{
			if (($ch = $get_letter($title ? $page['title'] : $page['tag'])) !== '')
			{
				if (!array_key_exists($ch, $letters))
				{
					$letters[$ch] = 1;
				}

				$pages_to_display[$page['page_id']] = $page;
			}
		}
	}
}

// display navigation
$tpl->pagination_text = $pagination['text'];

// create the top links menu
if ($letters)
{
	// 'Any' menu item
	$tpl->letter_l_commit		= true;
	$tpl->letter_l_item_link	= $this->href();
	$tpl->letter_l_item_ch		= $this->_t('Any');

	foreach ($letters as $ch => $letter_count)
	{
		$tpl->letter_l_commit = true;

		if ($ch === $letter)
		{
			$tpl->letter_l_active_ch = $ch;
		}
		else
		{
			$tpl->letter_l_item_ch		= $ch;
			$tpl->letter_l_item_link	= $this->href('', '', ['letter' => $ch]);
		}
	}
}

if (!$pages_to_display)
{
	$tpl->nopages = true;
	return;
}

// display collected data
$cur_char = false;

foreach ($pages_to_display as $page)
{
	$ch			= $get_letter($title ? $page['title'] : $page['tag']);

	if ($ch !== $cur_char)
	{
		$tpl->page_ch = $cur_char = $ch;
	}

	if ($title)
	{
		$tpl->page_l_link = $this->link('/' . $page['tag'], '', $page['title'], '', false, true, false);
	}
	else
	{
		$tpl->page_l_link = $this->link('/' . $page['tag'], '', $page['tag'], $page['title'], false, true, false);
	}
}
