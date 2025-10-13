<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
 TODO:
 - put target with regex data in session
 - improve search, possibly merge with search action
 - allow binary search only for registered users (?)
 */

$info = <<<EOD
Description:
	binary search allows users to do a string search using exact or regex search

Usage:
	{{search_binary}}

Options:
	[page="PageName"]
	[options=1]
	[lang="en"]
	[max=Number]
EOD;

// functions
$search_text = function ($target, $tag, $use_regex, $limit, $filter = [], $deleted = false)
{
	$category_ids	= null;
	$lang			= null;
	$comments		= null;
	$pages			= null;
	$titles			= null;
	$prefix			= $this->prefix;
	extract($filter, EXTR_IF_EXISTS);

	// choose match scope
	if (($pages || $comments) && $titles)
	{
		$match =
			($use_regex
				? '(CAST(a.body AS ' . $this->db->binary() . ') REGEXP '	. $this->db->q($target) . ' ' .
				  'OR CAST(a.title AS ' . $this->db->binary() . ') REGEXP '	. $this->db->q($target) . ') '
				: '(CAST(a.body AS ' . $this->db->binary() . ') LIKE '		. $this->db->q('%' . $target . '%') . ' ' .
				  'OR CAST(a.title AS ' . $this->db->binary() . ') LIKE '	. $this->db->q('%' . $target . '%') . ') '
		);
	}
	else if ($pages || $comments)
	{
		$match =
			($use_regex
				? '(CAST(a.body AS ' . $this->db->binary() . ') REGEXP '	. $this->db->q($target) . ') '
				: '(CAST(a.body AS ' . $this->db->binary() . ') LIKE '		. $this->db->q('%' . $target . '%') . ') '
			);
	}
	else if ($titles)
	{
		$match =
			($use_regex
				? '(CAST(a.title AS ' . $this->db->binary() . ') REGEXP '	. $this->db->q($target) . ') '
				: '(CAST(a.title AS ' . $this->db->binary() . ') LIKE '		. $this->db->q('%' . $target . '%') . ') '
		);
	}

	// namespace: include tag and tag/%, not tag%
	$selector =
		($category_ids
			? 'LEFT JOIN ' . $prefix . 'category_assignment ca ON (a.page_id = ca.object_id) '
			: '') .
		($tag
			? 'LEFT JOIN ' . $prefix . 'page b ON (a.comment_on_id = b.page_id) '
			: '') .
		'WHERE ' .
			$match .
			($tag
				? 'AND (a.tag = '	. $this->db->q($tag) . ' ' .
				  'OR a.tag LIKE '	. $this->db->q($tag . '/%') . ' ' .
				  'OR b.tag = '		. $this->db->q($tag) . ' ' .
				  'OR b.tag LIKE '	. $this->db->q($tag . '/%') . ') '
				: '') .
			($comments
				? ($pages
					? ''
					: 'AND a.comment_on_id <> 0 ')
				: 'AND a.comment_on_id = 0 ') .
			(!empty($this->sess->replace_unset)
				? 'AND a.page_id NOT IN (' . $this->ids_string($this->sess->replace_unset) . ') '
				: '') .
			($lang
				? 'AND a.page_lang = ' . $this->db->q($lang) . ' '
				: '') .
			($category_ids
				? 'AND ca.category_id IN (' . $this->ids_string($category_ids) . ') ' .
				  'AND ca.object_type_id = ' . (int) OBJECT_PAGE . ' '
				: '') .
			($deleted
				? ''
				: ($tag
					? 'AND (a.deleted <> 1 OR b.deleted <> 1) '
					: 'AND a.deleted <> 1 ')) .
		' ';

	$count = $this->db->load_single(
		'SELECT COUNT(a.page_id) AS n ' .
		'FROM ' . $prefix . 'page a ' .
		$selector, true);

	$pagination = $this->pagination($count['n'], $limit, 'p',
		#							  ['target'			=> $target]
		#+
		  (!empty($lang)			? ['lang'			=> $lang]			: [])
		+ (!empty($category_ids)	? ['category_id'	=> $category_ids]	: [])
		+ (!empty($comments)		? ['comments'		=> $comments]		: [])
		+ (!empty($lang)			? ['lang'			=> $lang]			: [])
		+ (!empty($titles)			? ['titles'			=> $titles]			: [])
		+ (!empty($pages)			? ['pages'			=> $pages]			: [])
		+ (!empty($use_regex)		? ['use_regex'		=> $use_regex]		: []));

	// load search results
	$results = $this->db->load_all(
		'SELECT a.page_id, a.owner_id, a.user_id, a.tag, a.title, a.created, a.modified, a.body, a.comment_on_id, a.page_lang, a.page_size, a.comments,
			u.user_name, o.user_name as owner_name ' .
		'FROM ' . $prefix . 'page a ' .
			'LEFT JOIN ' . $prefix . 'user u ON (a.user_id = u.user_id) ' .
			'LEFT JOIN ' . $prefix . 'user o ON (a.owner_id = o.user_id) ' .
		$selector .
		'ORDER BY a.tag ' .
		$pagination['limit']);

	foreach ($results as $result)
	{
		$this->cache_page($result, true);
		$page_ids[] = $result['page_id'];
		$this->page_id_cache[$result['tag']] = $result['page_id'];
	}

	if (!empty($page_ids))
	{
		$this->preload_acl($page_ids);
		$this->preload_categories($page_ids);
	}

	return [$results, $pagination, $count['n']];
};

$space_to_nbsp = function ($message)
{
	$msg = Ut::html($message);

	$msg = preg_replace('/^ /m',	NBSP . ' ', $msg);
	$msg = preg_replace('/ $/m',	' ' . NBSP, $msg);
	$msg = preg_replace('/  /',		NBSP . ' ', $msg);

	return $msg;
};

/**
 * Remove bytes that represent an incomplete Unicode character
 * at the end of string (e.g. bytes of the char are missing)
 */
$remove_bad_char_last = function ($string)
{
	if ($string != '')
	{
		$char	= ord($string[strlen($string) - 1]);
		$match	= [];

		if ($char >= 0xc0)
		{
			// got only the first byte of a multibyte char; remove it
			$string = substr($string, 0, -1);
		}
		else if ($char >= 0x80 &&
			// use the /s modifier so (.*) also matches newlines
			preg_match('/^(.*)(?:[\xe0-\xef][\x80-\xbf]|' .
				'[\xf0-\xf7][\x80-\xbf]{1,2})$/s', $string, $match)
		)
		{
			// chopped in the middle of a character; remove it
			$string = $match[1];
		}
	}

	return $string;
};

/**
 * Remove bytes that represent an incomplete Unicode character
 * at the start of string (e.g. bytes of the char are missing)
 */
$remove_bad_char_first = function ($string)
{
	if ($string != '')
	{
		$char = ord($string[0]);

		if ($char >= 0x80 && $char < 0xc0)
		{
			// chopped in the middle of a character; remove the whole thing
			$string = preg_replace('/^[\x80-\xbf]+/', '', $string);
		}
	}

	return $string;
};

/**
 * Truncate a string to a specified length in bytes, appending an optional
 * string (e.g. for ellipsis)
 */
$truncate_string = function ($string, $length = 80, $ellipsis = '...') use ($remove_bad_char_first, $remove_bad_char_last)
{
	if (strlen($string) <= abs($length))
	{
		return $string;
	}

	if ($length == 0)
	{
		return $ellipsis;
	}

	if ($length > 0)
	{
		$string = substr($string, 0, $length); // text...
		$string = $remove_bad_char_last($string);
		$string = rtrim($string) . $ellipsis;
	}
	else
	{
		$string = substr($string, $length); // ...text
		$string = $remove_bad_char_first($string);
		$string = $ellipsis . ltrim($string);
	}

	return $string;
};

$extract_context = function ($text, $target, $use_regex = false, $padding = 40) use ($space_to_nbsp, $truncate_string)
{
	// get all indexes
	if ($use_regex)
	{
		$target_q	= str_replace('/', "\\/", $target);
		$target_str	= "/$target_q/Uu";
	}
	else
	{
		$target_q	= preg_quote($target, '/');
		$target_str	= "/$target_q/u";
	}

	preg_match_all($target_str, $text, $matches, PREG_OFFSET_CAPTURE);

	$pos	= $matches[0] ?? [];
	$cuts	= [];

	// [0] => matched string, [1] => offset
	for ($i = 0; $i < count($pos); $i++)
	{
		$index	= $pos[$i][1];
		$len	= strlen($pos[$i][0]);

		// merge to the next if possible
		while (isset($pos[$i + 1][1]))
		{
			if ($pos[$i + 1][1] < $index + $len + $padding * 2)
			{
				$len += $pos[$i + 1][1] - $pos[$i][1];
				$i++;
			}
			else
			{
				// can't merge, exit the inner loop
				break;
			}
		}

		$cuts[] = [$index, $len];
	}

	if (!$use_regex)
	{
		$target_q	= preg_quote($space_to_nbsp($target), '/');
		$target_str	= "/$target_q/u";
	}

	$context = '';

	foreach ($cuts as $cut)
	{
		[$index, $len, ]	= $cut;
		$context_before		= substr($text, 0, $index);
		$context_after		= substr($text, $index + $len);

		$context_before		= $truncate_string($context_before, -$padding);
		$context_after		= $truncate_string($context_after, $padding);

		$context			.= $space_to_nbsp($context_before);
		$snippet			=  $space_to_nbsp(substr($text, $index, $len));

		$context			.= preg_replace($target_str, '<code>\0</code>', $snippet);
		$context			.= $space_to_nbsp($context_after);
	}

	$context = str_replace("\n", '↵', $context);

	return $context;
};

$search_form = function (array $o) use ($tpl)
{
	$category_ids		= $o['filter']['category_ids'];

	$tpl->enter('search_');

	$tpl->target		= $o['target'];
	$tpl->regex			= $o['use_regex'];
	$tpl->tag			= $o['page'];
	$tpl->pages			= $o['pages'];
	$tpl->titles		= $o['titles'];
	$tpl->comments		= $o['comments'];
	$tpl->cancel		= true;

	if ($o['options'])
	{
		$tpl->options		= true;

		$tpl->enter('options_');

		$tpl->c_categories	= $this->show_category_form($this->page_lang, null, OBJECT_PAGE, false, false, $category_ids);

		if ($this->db->multilanguage)
		{
			$languages			= $this->_t('LanguageArray');
			$langs				= $this->http->available_languages();
			$tpl->l_selected	= $o['lang'] ? null : ' selected';

			foreach ($langs as $iso)
			{
				$tpl->l_o_iso	= $iso;
				$tpl->l_o_lang	= $languages[$iso];

				if ($iso == $o['lang'])
				{
					$tpl->l_o_selected	= ' selected';
				}
			}
		}

		$tpl->leave(); // options_
	}

	$tpl->leave(); // search_
};

$show_matches = function ($pages, $pagination, $tcount, $max, array $o) use ($tpl, $search_text, $extract_context)
{
	$tpl->enter('matches_');

	if (count($pages) > 5)
	{
		$tpl->invert	= true;
	}

	$tpl->offset			= $pagination['offset'] + 1;
	$tpl->pagination_text	= $pagination['text'];
	$tpl->enter('l_');

	foreach ($pages as $n => $p)
	{
		if (!$this->db->hide_locked || $this->has_access('read', $p['page_id']))
		{
			$tpl->delim = $n++;

			$preview	= '';

			// generate preview
			if (($o['pages'] || $o['comments']) && $this->has_access('read', $p['page_id']))
			{
				$preview	= $extract_context($p['body'], $o['target'], $o['use_regex'], $o['padding']);
			}

			$this->sess->replace_set[] = $p['page_id'];

			$tpl->enter('l_');

			$tpl->link		= $this->link('/' . $p['tag'], '', ($o['title'] ? $p['title'] : $p['tag']), '', false);
			$tpl->userlink	= $this->user_link($p['user_name'], false, false);
			$tpl->mtime		= $p['modified'];
			$tpl->psize		= $this->factor_multiples($p['page_size'], 'binary', true, true);

			if ($this->db->multilanguage)
			{
				$tpl->lang	= '- ' . $p['page_lang'];
			}

			$tpl->category	= $this->get_categories($p['page_id'], OBJECT_PAGE);
			$tpl->preview	= $preview;

			if ($p['comments'])
			{
				$tpl->comments_n	= $p['comments'];
			}

			$tpl->leave(); // l_
		}
	}

	unset($p);
	$tpl->leave(); // l_

	if ($n)
	{
		$batch_count	= $tcount > $pagination['perpage']
			? $pagination['perpage'] . ' / ' . $tcount
			: $tcount;

		$tpl->mark_diag		= $this->_t('SearchResults');
		$tpl->mark_phrase	= $o['msg_target'];
		$tpl->mark_count	= $tcount;	// TODO: count only accessible results
		$tpl->emark			= true;
	}

	$tpl->leave(); // matches_
};

// --------------------------------------------------------------------------------

// set defaults
$help			??= 0;
$lang			??= '';
$max			??= 50;	// (10 ... 100)
$options		??= 0;
$padding		??= 40;
$page			??= '/';
$title			??= 1;

if ($help)
{
	$tpl->help	= $this->help($info, 'search_binary');
	return;
}

// allow binary search only for registered users
if (!$this->get_user())
{
	return;
}

$categories		= (string)	($_POST['categories']		?? ($_GET['categories']		?? ''));
$comments		= (bool)	($_POST['comments']			?? ($_GET['comments']		?? 0));
$pages			= (bool)	($_POST['pages']			?? ($_GET['pages']			?? 0));
$titles			= (bool)	($_POST['titles']			?? ($_GET['titles']			?? 0));
$lang			= (string)	($_POST['lang']				?? ($_GET['lang']			?? $lang));
$page			= (string)	($_POST['page']				?? ($_GET['page']			?? $page));

#$target			= (string)	trim(($_POST['target']		?? ($_GET['target']			?? '')));

$target			= (string)	trim(($_POST['target']		?? ($this->sess->bin_target		?? '')));

if ($_POST['target'])
{
	$this->sess->bin_target = (string) trim(($_POST['target']		?? ''));
}
#$phrase || $phrase = trim(($_GET['phrase'] ?? ''));

$use_regex		= (bool)	($_POST['use_regex']		?? ($_GET['use_regex']		?? 0));

$show_search_form	= true;

// remove \r (body contains only \n)
$target				= str_replace("\r\n", "\n", $target);

// visualize line breaks in message sets
$msg_target			= str_replace("\n", '↵', $target);

if ($lang && !$this->known_language($lang))
{
	$lang = '';
	$this->set_message($this->_t('FilterLangNotAvailable'));
}

// empty page parameter, use root not page context
$page			= $page ?: '/';
$tag			= $this->unwrap_link($page);

// category filter
$category_ids	= [];

if ($categories)
{
	$category_ids = explode(',', $categories);
}

foreach ($_POST as $key => $val)
{
	if (preg_match('/^category(\d+)$/', $key, $ids) && $val == 'set')
	{
		$category_ids[] = $ids[1];
	}
}

$o = [
	'comments'			=> $comments,
	'pages'				=> $pages,
	'titles'			=> $titles,
	'filter' => [
		'category_ids'	=> $category_ids,
		'comments'		=> $comments,
		'lang'			=> $lang,
		'pages'			=> $pages,
		'titles'		=> $titles,
	],
	'lang'				=> $lang,
	'msg_target'		=> $msg_target,
	'options'			=> (bool) $options,
	'padding'			=> (int) $padding,
	'page'				=> $page,
	'tag'				=> $tag,
	'target'			=> $target,
	'title'				=> $title,
	'use_regex'			=> $use_regex,
];

// [B] show search matches
if ($target)
{
	$error = null;

	if (!$pages && !$comments && !$titles)
	{
		unset($this->sess->bin_target);
		$error = ['SearchInNoOption', 'hint'];
	}

	if ($error)
	{
		$tpl->message		= $this->show_message($this->_t($error[0]), $error[1], false);
		$show_search_form	= true;
	}
	else if (mb_strlen($target) >= 3)
	{
		// search for target matches
		[$pages, $pagination, $tcount] = $search_text($target, $tag, $use_regex, $max, $o['filter']);

		if ($pages)
		{
			$show_matches($pages, $pagination, $tcount, $max, $o);
		}
		else
		{
			if (  (($pages || $comments)
				|| ($pages || $comments) && $titles))
			{
				$msg = 'ReplaceTextNoMatch';
			}
			else
			{
				$msg = 'ReplaceTextNoTitleMatch';
			}

			$tpl->message = $this->show_message(
				Ut::perc_replace(
					$this->_t($msg),
					'<code>' . Ut::html($msg_target) . '</code>'),
				'note', false);

			$show_search_form = true;
		}
	}
}
else
{
	$show_search_form = true;
}

// [A] search form
if ($show_search_form)
{
	$search_form($o);
}
