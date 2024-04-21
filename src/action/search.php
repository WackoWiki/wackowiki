<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// TODO:
// - too much loose ends, read thoroughly and refactor
// - search also for attachments

$info = <<<EOD
Description:
	Searches the content of the Wiki.

Usage:
	{{search}}

Options:
	[phrase="Term"]
	[page="PageName"]
	[topic=1]
	[options=1]
	[lang="en"]
	[form=1]
	[hl_simple=1]
	[nomark=1]
	[style=one of ("br","ul","ol","comma") ]
	[scope=one of ("pages", "all")]
EOD;

$full_text_search = function ($phrase, $tag, $limit, $scope, $filter = [], $deleted = false)
{
	$category_id	= null;
	$lang			= null;
	$prefix			= $this->prefix;
	extract($filter, EXTR_IF_EXISTS);

	$selector =
		($category_id
			? 'LEFT JOIN ' . $prefix . 'category_assignment ca ON (a.page_id = ca.object_id) '
			: '') .
		($tag
			? 'LEFT JOIN ' . $prefix . 'page b ON (a.comment_on_id = b.page_id) '
			: '') .
		'WHERE ((MATCH
					(a.body) AGAINST(' . $this->db->q($phrase) . ' IN BOOLEAN MODE) ' .
					'OR lower(a.title) LIKE lower(' . $this->db->q('%' . $phrase . '%') . ') ' .
					'OR lower(a.tag) LIKE lower(' . $this->db->q('%' . $phrase . '%') . ') ' .
					'OR lower(a.description) LIKE lower(' . $this->db->q('%' . $phrase . '%') . ') ' .
					'OR lower(a.keywords) LIKE lower(' . $this->db->q('%' . $phrase . '%') . ') ' .
		') ' .
			($tag
				? 'AND (a.tag LIKE ' . $this->db->q($tag . '/%') . ' ' .
				'OR b.tag LIKE ' . $this->db->q($tag . '/%') . ') '
				: '') .
			($scope
				? 'AND a.comment_on_id = 0 '
				: '') .
			($lang
				? 'AND a.page_lang = ' . $this->db->q($lang) . ' '
				: '') .
			($category_id
				? 'AND ca.category_id = ' . (int) $category_id . ' '
				: '') .
			($deleted
				? ''
				: ($tag
					? 'AND (a.deleted <> 1 OR b.deleted <> 1) '
					: 'AND a.deleted <> 1 ')) .
		' )';

	$count = $this->db->load_single(
		'SELECT COUNT(a.page_id) AS n ' .
		'FROM ' . $prefix . 'page a ' .
		$selector, true);

	$pagination = $this->pagination($count['n'], $limit, 'p', ['phrase' => $phrase]
		+ (!empty($lang)			? ['lang'			=> $lang]			: []));

	// load search results
	$results = $this->db->load_all(
		'SELECT a.page_id, a.owner_id, a.user_id, a.tag, a.title, a.created, a.modified, a.body, a.comment_on_id, a.page_lang, a.page_size, a.comments,
			MATCH(a.body) AGAINST(' . $this->db->q($phrase) . ' IN BOOLEAN MODE) AS score,
			u.user_name, o.user_name as owner_name ' .
		'FROM ' . $prefix . 'page a ' .
			'LEFT JOIN ' . $prefix . 'user u ON (a.user_id = u.user_id) ' .
			'LEFT JOIN ' . $prefix . 'user o ON (a.owner_id = o.user_id) ' .
		$selector .
		'ORDER BY score DESC ' .
		$pagination['limit']);

	foreach ($results as $result)
	{
		$this->cache_page($result, true);
		$page_ids[]	= $result['page_id'];
		$this->page_id_cache[$result['tag']] = $result['page_id'];
	}

	if (!empty($page_ids))
	{
		$this->preload_acl($page_ids);
		$this->preload_categories($page_ids);
	}

	return [$results, $pagination, $count['n']];
};

$tag_search = function ($phrase, $tag, $limit, $scope, $filter = [], $deleted = false)
{
	$category_id	= null;
	$lang			= null;
	$prefix			= $this->prefix;
	extract($filter, EXTR_IF_EXISTS);

	$selector =
		($category_id
			? 'LEFT JOIN ' . $prefix . 'category_assignment ca ON (a.page_id = ca.object_id) '
			: '') .
		($tag
			? 'LEFT JOIN ' . $prefix . 'page b ON (a.comment_on_id = b.page_id) '
			: '') .
		'WHERE ( lower(a.tag) LIKE binary lower('	. $this->db->q('%' . $phrase . '%') . ') ' .
		'OR lower(a.title) LIKE lower('			. $this->db->q('%' . $phrase . '%') . ')) ' .
		($tag
			? 'AND (a.tag LIKE '	. $this->db->q($tag . '/%') . ' ' .
			'OR b.tag LIKE '	. $this->db->q($tag . '/%') . ') '
			: '') .
		($scope
			? 'AND a.comment_on_id = 0 '
			: '') .
		($lang
			? 'AND a.page_lang = ' . $this->db->q($lang) . ' '
			: '') .
		($category_id
			? 'AND ca.category_id = ' . (int) $category_id . ' '
			: '') .
		($deleted
			? ''
			: ($tag
				? 'AND (a.deleted <> 1 OR b.deleted <> 1) '
				: 'AND a.deleted <> 1 '));

	$count = $this->db->load_single(
		'SELECT COUNT(a.page_id) AS n ' .
		'FROM ' . $prefix . 'page a ' .
		$selector, true);

	$pagination = $this->pagination($count['n'], $limit, 'p', ['phrase' => $phrase, 'topic' => 'on', 'lang' => $lang]);

	// load search results
	$results = $this->db->load_all(
		'SELECT a.page_id, a.owner_id, a.user_id, a.tag, a.title, a.created, a.modified, a.comment_on_id, a.page_lang, a.page_size, comments,
			u.user_name, o.user_name as owner_name ' .
		'FROM ' . $prefix . 'page a ' .
			'LEFT JOIN ' . $prefix . 'user u ON (a.user_id = u.user_id) ' .
			'LEFT JOIN ' . $prefix . 'user o ON (a.owner_id = o.user_id) ' .
		$selector .
		'ORDER BY a.tag COLLATE utf8mb4_unicode_520_ci ' .
		$pagination['limit']);

	return [$results, $pagination, $count['n']];
};

// return context around first keyword match
$get_context = function($phrase, $string, $position, $padding, $hellip = true)
{
	$clength	= mb_strlen($string);

	// get start point
	$_start		= $position - $padding;
	$start		= $_start < 0
					? 0
					: mb_strpos($string, ' ', $_start);

	$_length	= (mb_strlen($phrase) + $padding * 2);

	// get endpoint
	$_end		= $start + $_length;
	$end		= $_end > $clength
					? $clength
					: mb_strpos($string, ' ', $_end);

	$length		= $end - $start;
	$context	= mb_substr($string, $start, $length);
	$_hellip	= $hellip ? ($_end < $clength ? ' ... ' : '') : '';

	return $context . $_hellip;
};

// returns only the first $position match as intended
$strpos_array = function($content, $keywords, $offset = 0)
{
	if(!is_array($keywords)) $keywords = [$keywords];

	foreach ($keywords as $keyword)
	{
		if (($position = mb_stripos($content, $keyword, $offset)) !== false)
		{
			return $position; // stop on first true result
		}
	}

	return false;
};

// return the part of the content where the keyword was matched
$get_line_with_phrase = function ($content, $phrase, $padding = 75, $insensitive = true) use ($get_context, $strpos_array)
{
	$keywords	= explode(' ', $phrase);
	$lines		= explode("\n", $content);
	$result		= '';
	$matches	= 0;

	// get a first taste, skip the rest
	foreach ($lines as $string)
	{
		if ($matches > 3) break; // enough berries, go home!

		if (($position	= $strpos_array($string, $keywords)) !== false)
		{
			$result .= $get_context($phrase, $string, $position, $padding);

			$matches++;
		}
	}

	return $result;
};

// TODO: cut new line at the end without present keyword, e.g. ... stump text
$preview_text = function ($text, $limit, $hellip = true)
{
	$text = trim($text);

	// if mb_strlen is smaller than limit return
	if (mb_strlen($text) < $limit)
	{
		return $text;
	}
	else
	{
		$length		= mb_strpos($text, ' ', $limit);
		$_hellip	= $hellip ? ($length < $limit ? ' ... ' : '') : '';

		return mb_substr($text, 0, $length) . $_hellip;
	}
};

// highlight only full words
$highlight_terms = function ($text, $words)
{
	$boundaries		= '[\\p{Z}\\p{P}\\p{C}]';
	$text			= Ut::html($text);
	$words			= trim($words);
	$words_array	= explode(' ', $words);

	if ($words_array)
	{
		$pat_pre		= "(^|{$boundaries})";
		$pat_post		= "({$boundaries}|$)";

		foreach ($words_array as $word)
		{
			// escape bad regex characters
			$word	= preg_quote($word, '/');

			$pattern	= "/$pat_pre(" . $word . ")$pat_post/ui";
			$text		= preg_replace($pattern, "\\1<mark class='highlight'>\\2</mark>\\3", $text);
		}
	}

	return $text;
};

$highlight_simple = function ($text, $words)
{
	$hl_words		= [];
	$text			= Ut::html($text);
	$words			= trim($words);
	$words_array	= explode(' ', $words);

	if ($words_array)
	{
		foreach ($words_array as $word)
		{
			// escape bad regex characters
			$hl_words[] = preg_quote($word, '/');
		}

		$pattern	= implode('|', $hl_words);
		$text	= preg_replace('/(' . $pattern . ')/ui', '<mark class="highlight">$1</mark>', $text);
	}

	return $text;
};

// --------------------------------------------------------------------------------

// set defaults
$help		??= 0;
$hl_simple	??= 0;
$lang		??= '';
$max		??= 10;	// (null) 50 -> 10 overwrites system default value!
$nomark		??= 0;
$options	??= 1;
$padding	??= 75;
$page		??= '';
$phrase		??= '';
$scope		??= '';
$style		??= '';
$title		??= 1;
$topic		??= 0;

if ($help)
{
	$tpl->help	= $this->help($info, 'search');
	return;
}

$lang		= (string) ($_GET['lang'] ?? $lang);

if ($lang && !$this->known_language($lang))
{
	$lang = '';
	$this->set_message($this->_t('FilterLangNotAvailable'));
}

$tag			= $this->unwrap_link($page);
$category_id	= (int) ($_GET['category_id'] ?? 0);
$mode			= ($topic || isset($_GET['topic']))? 'topic' : 'full';

$filter = [
	'category_id'	=> $category_id,
	'lang'			=> $lang,
];

if (!in_array($style, ['br', 'ul', 'ol', 'comma']))
{
	$style = 'ol';
}

if ($scope != 'pages')
{
	$scope = 'all';
}

if (!empty($phrase))
{
	$form	= 0;
}
else
{
	$form	= 1;
}

$phrase || $phrase = trim(($_GET['phrase'] ?? ''));

if ($form)
{
	$tpl->enter('form_');
	$tpl->href		= $this->href();
	$tpl->phrase	= $phrase;

	if ($options)
	{
		$tpl->options		= true;
		$tpl->options_topic	= ($mode == 'topic');

		if ($this->db->multilanguage)
		{
			$languages	= $this->_t('LanguageArray');
			$langs		= $this->http->available_languages();
			$tpl->options_l_selected = $lang ? null : ' selected';

			foreach ($langs as $iso)
			{
				$tpl->options_l_o_iso	= $iso;
				$tpl->options_l_o_lang	= $languages[$iso];

				if ($iso == $lang)
				{
					$tpl->options_l_o_selected	= ' selected';
				}
			}
		}
	}

	$tpl->leave(); // form_
}

$n = 0;

if (mb_strlen($phrase) >= 3)
{
	if ($mode == 'topic')
	{
		$results = $tag_search($phrase, $tag, $max, ($scope != 'all'), $filter);
	}
	else
	{
		$results = $full_text_search($phrase, $tag, $max, ($scope != 'all'), $filter);
	}

	[$pages, $pagination, $tcount] = $results;

	if ($pages)
	{
		$tpl->s_pagination_text	= $pagination['text'];
		$tpl->s_ol_offset		= $pagination['offset'] + 1;

		$tpl->enter('s_' . $style . '_l_');

		foreach ($pages as $page)
		{
			if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
			{
				// Don't show it if it's a comment, and we're hiding comments from this user
				if (!$page['comment_on_id'] || $this->user_allowed_comments())
				{
					$tpl->delim = $n++;

					$context	= '';

					// generate preview
					if ($mode !== 'topic' && $this->has_access('read', $page['page_id']))
					{
						$body		= $this->format($page['body'], 'cleanwacko');

						$context	= $get_line_with_phrase($body, $phrase, $padding);
						$context	= $preview_text($context, 500, 0);
						$context	= $hl_simple ? $highlight_simple($context, $phrase) : $highlight_terms($context, $phrase);
					}

					$tpl->l_link		= $this->link('/' . $page['tag'], '', ($title ? $page['title'] : $page['tag']), '', false);
					$tpl->l_userlink	= $this->user_link($page['user_name'], false, false);
					$tpl->l_mtime		= $page['modified'];
					$tpl->l_psize		= $this->factor_multiples($page['page_size'], 'binary', true, true);

					if ($this->db->multilanguage)
					{
						$tpl->l_lang	= '- ' . $page['page_lang'];
					}

					if ($page['comments'])
					{
						$tpl->l_comments_n	= $page['comments'];
					}
					$tpl->l_category	= $this->get_categories($page['page_id'], OBJECT_PAGE, '', '', ['phrase' => $phrase]);

					if ($mode != 'topic')
					{
						$tpl->l_preview	= $context;
					}
				}
			}
		}

		$tpl->leave();

		if (!$nomark && $n)
		{
			$tpl->s_mark_diag	= $this->_t(($mode == 'topic' ? 'Topic' : '') . 'SearchResults');
			$tpl->s_mark_phrase	= $phrase;
			$tpl->s_mark_count	= $tcount;	// TODO: count only accessible results
			$tpl->s_emark		= true;
		}
	}

	$nomark || $n || $tpl->none_phrase = $phrase;
}
