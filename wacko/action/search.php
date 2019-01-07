<?php

// TODO:
// - too much loose ends, read thoroughly and refactor
// - seach also for attachments

if (!defined('IN_WACKO'))
{
	exit;
}

$full_text_search = function ($phrase, $tag, $limit, $scope, $filter = [], $deleted = 0)
{
	$category_id	= null;
	$lang			= null;
	extract($filter, EXTR_IF_EXISTS);

	$selector =
		($category_id
			? "LEFT JOIN " . $this->db->table_prefix . "category_assignment ca ON (a.page_id = ca.object_id) "
			: "") .
		($tag
			? "LEFT JOIN " . $this->db->table_prefix . "page b ON (a.comment_on_id = b.page_id) "
			: "") .
		"WHERE ((MATCH
					(a.body) AGAINST(" . $this->db->q($phrase) . " IN BOOLEAN MODE) " .
					"OR lower(a.title) LIKE lower(" . $this->db->q('%' . $phrase . '%') . ") " .
					"OR lower(a.tag) LIKE lower(" . $this->db->q('%' . $phrase . '%') . ") " .
				") " .
			($tag
				? "AND (a.supertag LIKE " . $this->db->q($this->translit($tag) . '/%') . " " .
				  "OR b.supertag LIKE " . $this->db->q($this->translit($tag) . '/%') . ") "
				: "") .
			($scope
				? "AND a.comment_on_id = 0 "
				: "") .
			($lang
				? "AND a.page_lang = " . $this->db->q($lang) . " "
				: "") .
			($category_id
				? "AND ca.category_id = " . (int) $category_id . " "
				: "") .
			(!$deleted
				? ($tag
					? "AND (a.deleted <> 1 OR b.deleted <> 1) "
					: "AND a.deleted <> 1 ")
				: "") .
			" )";

	$count = $this->db->load_single(
		"SELECT COUNT(a.page_id) AS n " .
		"FROM " . $this->db->table_prefix . "page a " .
		$selector, true);

	$pagination = $this->pagination($count['n'], $limit, 'p', ['phrase' => $phrase]);

	// load search results
	$results = $this->db->load_all(
		"SELECT a.page_id, a.title, a.tag, a.supertag, a.created, a.modified, a.body, a.comment_on_id, a.page_lang, a.page_size, a.comments,
			MATCH(a.body) AGAINST(" . $this->db->q($phrase) . " IN BOOLEAN MODE) AS score,
			u.user_name, o.user_name as owner_name " .
		"FROM " . $this->db->table_prefix . "page a " .
			"LEFT JOIN " . $this->db->user_table . " u ON (a.user_id = u.user_id) " .
			"LEFT JOIN " . $this->db->user_table . " o ON (a.owner_id = o.user_id) " .
		$selector .
		"ORDER BY score DESC " .
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

$tag_search = function ($phrase, $tag, $limit, $scope, $filter = [], $deleted = 0)
{
	$category_id	= null;
	$lang			= null;
	extract($filter, EXTR_IF_EXISTS);

	$selector =
		($category_id
			? "LEFT JOIN " . $this->db->table_prefix . "category_assignment ca ON (a.page_id = ca.object_id) "
			: "") .
		($tag
			? "LEFT JOIN " . $this->db->table_prefix . "page b ON (a.comment_on_id = b.page_id) "
			: "") .
		"WHERE ( lower(a.tag) LIKE binary lower(" . $this->db->q('%' . $phrase . '%') . ") " .
			"OR lower(a.title) LIKE lower(" . $this->db->q('%' . $phrase . '%') . ")) " .
		($tag
			? "AND (a.supertag LIKE " . $this->db->q($this->translit($tag) . '/%') . " " .
			  "OR b.supertag LIKE " . $this->db->q($this->translit($tag) . '/%') . ") "
			: "") .
		($scope
			? "AND a.comment_on_id = 0 "
			: "") .
		($lang
			? "AND a.page_lang = " . $this->db->q($lang) . " "
			: "") .
		($category_id
			? "AND ca.category_id = " . (int) $category_id . " "
			: "") .
		(!$deleted
			? ($tag
				? "AND (a.deleted <> 1 OR b.deleted <> 1) "
				: "AND a.deleted <> 1 ")
			: "");

	$count = $this->db->load_single(
		"SELECT COUNT(a.page_id) AS n " .
		"FROM " . $this->db->table_prefix . "page a " .
		$selector, true);

	$pagination = $this->pagination($count['n'], $limit, 'p', ['phrase' => $phrase]);

	// load search results
	$results = $this->db->load_all(
		"SELECT a.page_id, a.title, a.tag, a.supertag, a.created, a.modified, a.comment_on_id, a.page_lang, a.page_size, comments,
			u.user_name, o.user_name as owner_name " .
		"FROM " . $this->db->table_prefix . "page a " .
			"LEFT JOIN " . $this->db->user_table . " u ON (a.user_id = u.user_id) " .
			"LEFT JOIN " . $this->db->user_table . " o ON (a.owner_id = o.user_id) " .
		$selector .
		"ORDER BY a.supertag " .
		$pagination['limit']);

	return [$results, $pagination, $count['n']];
};

$get_line_with_phrase = function ($phrase, $string, $insensitive = true, $cleanup = '')
{
	$lines	= explode("\n", $string);
	$result	= '';

	foreach ($lines as $line)
	{
		if ($insensitive == true)
		{
			if (stripos($line, $phrase))
			{
				if ($result)
				{
					$result .= "<br>\n";
				}
			}
		}
		else
		{
			if (strpos($line, $phrase))
			{
				if ($result)
				{
					$result .= "<br>\n";
				}
			}

			$result .= $cleanup ? str_replace('$phrase', '', $line) : $line;
		}
	}

	return $result;
};

$preview_text = function ($text, $limit, $tags = 0)
{
	// trim text
	$text = trim($text);

	// strip tags if preview is without HTML
	if ($tags == 0)
	{
		$text = preg_replace('/\s\s+/', ' ', strip_tags($text));
	}

	// if strlen is smaller than limit return
	if (strlen($text) < $limit)
	{
		return $text;
	}

	if ($tags == 0)
	{
		return substr($text, 0, $limit) . ' [..]';
	}
	else
	{
		$counter = 0;
		$return	= '';

		for ($i = 0; $i <= strlen($text); $i++)
		{
			if ($text[$i] == '<')
			{
				$stop = 1;
			}

			if ($stop != 1)
			{
				$counter++;
			}

			if ($text[$i] == '>')
			{
				$stop = 0;
			}

			$return .= $text[$i];

			if ($counter >= $limit && $text[$i] == ' ')
			{
				break;
			}
		}

		return $return . '[..]';
	}
};

$highlight_this = function ($text, $words, $the_place)
{
	$words			= trim($words);
	$the_count		= 0;
	$words_array	= explode(' ', $words);

	foreach ($words_array as $word)
	{
		if (strlen(trim($word)) != 0)
		{
			//exclude these words from being replaced
			$exclude_list = ['word1', 'word2', 'word3'];
		}

		// Check if it's excluded
		if (in_array(strtolower($word), $exclude_list))
		{
			// skip
		}
		else
		{
			// escape bad regex characters
			$word		= preg_quote($word);

			// highlight uppercase and lowercase correctly
			$text		= preg_replace('/(' . $word . ')/i','<mark class="highlight">$1</mark>' , $text, -1 , $count);
			$the_count	= $count + $the_count;
		}
	}

	return [$text, $the_count];
};

// --------------------------------------------------------------------------------

$output = '';

if (!isset($for))		$for		= ''; // depreciated
if ($for)				$page		= $for;

if (!isset($page))		$page		= '';
if (!isset($topic))		$topic		= '';
if (!isset($title))		$title		= 0;
if (!isset($filter))	$filter		= '';
if ($filter)			$scope		= $filter; // depreciated
if (!isset($style))		$style		= '';
if (!isset($scope))		$scope		= '';
if (!isset($nomark))	$nomark		= 0;
if (!isset($term))		$term		= '';
if (!isset($options))	$options	= 1;
if (!isset($lang))		$lang		= '';
if (!isset($max))		$max		= null;
if (!isset($clean))		$clean		= false;

if ($lang && !$this->known_language($lang))
{
	$lang = '';
	$this->set_message('The selected language is not available!');
}

$user			= $this->get_user();
$category_id	= $_GET['category_id'] ?? 0;
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

if (isset($$term)) // TODO: some historical junk, $vars currently not available
{
	$phrase = $$term;
	$form	= 0;
}
else
{
	$phrase	= '';
	$form	= 1;
}

$phrase or $phrase = @$_GET['phrase'];

if ($form)
{
	$tpl->form_href		= $this->href();
	$tpl->form_phrase	= $phrase;

	if ($options)
	{
		$tpl->form_options			= true;
		$tpl->form_options_topic	= ($mode == 'topic');
	}
}

$n = 0;

if (strlen($phrase) >= 3)
{
	if ($mode == 'topic')
	{
		$results = $tag_search($phrase, $page, $max, ($scope != 'all'), $filter);
	}
	else
	{
		$results = $full_text_search($phrase, $page, $max, ($scope != 'all'), $filter);
	}

	list ($pages, $pagination, $tcount) = $results;

	if ($pages)
	{
		$tpl->s_pagination_text	= $pagination['text'];
		$tpl->s_ol_offset		= $pagination['offset'] + 1;

		$tpl->enter('s_' . $style . '_l_');

		foreach ($pages as $page)
		{
			if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
			{
				// Don't show it if it's a comment and we're hiding comments from this user
				if (!$page['comment_on_id'] || $this->user_allowed_comments())
				{
					$tpl->delim = $n++;

					$_lang		= '';
					$preview	= '';
					$ccount		= false;

					// generate preview
					if ($mode !== 'topic' && $this->has_access('read', $page['page_id']))
					{
						$body		= $this->format($page['body'], 'cleanwacko');
						$context	= $get_line_with_phrase($phrase, $body, $clean);
						$context	= $preview_text($context, 500, 0);
						$context	= $highlight_this($context, $phrase, 0);
						list($context, $ccount) = $context;
						$preview	= $context;
					}

					// check current page lang for different charset to do_unicode_entities() against
					if ($this->page['page_lang'] != $page['page_lang'])
					{
						#$page['title'] = $this->do_unicode_entities($page['title'], $page['page_lang']);
						$_lang		= $page['page_lang'];
						$preview	= $this->do_unicode_entities($preview, $_lang);
					}

					$tpl->l_link		= $this->link('/' . $page['tag'], '', (isset($title) ? $page['title'] : $page['tag']), '', '', '', $_lang);
					$tpl->l_userlink	= $this->user_link($page['user_name'], '', false, false);
					$tpl->l_mtime		= $page['modified'];
					$tpl->l_psize		= $this->binary_multiples($page['page_size'], false, true, true);
					if ($page['comments'])
					{
						$tpl->l_comments_n	= $page['comments'];
					}
					$tpl->l_category	= $this->get_categories($page['page_id'], OBJECT_PAGE, '', '', ['phrase' => $phrase]);

					if ($mode != 'topic')
					{
						$tpl->l_count	= $ccount;
						$tpl->l_preview	= $preview;
					}
				}
			}
		}

		$tpl->leave();

		if (!$nomark)
		{
			$tpl->s_mark_diag	= $this->_t(($mode == 'topic' ? 'Topic' : '') . 'SearchResults');
			$tpl->s_mark_phrase	= $phrase;
			$tpl->s_mark_count	= $tcount;
			$tpl->s_emark		= true;
		}
	}
}

$nomark or $n or $tpl->none_phrase = $phrase;
