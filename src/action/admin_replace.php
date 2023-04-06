<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/* USAGE:
	{{admin_replace
		[page="PageName"]
		[options=1]
		[lang="en"]
		[mute=1]
		[max=NUMBER]
	}}

	[A] search & replace form
	[B] target matches selection form
	[C] replace target text with replacement

	TODO:
	- send only one notification per batch replacement, and not for every single page
	- allow also $this->check_acl($user_name, $this->db->rename_global_acl)
	- improve batch processing
*/

if (!$this->is_admin())
{
	return;
}

// functions
$search_text = function ($target, $tag, $use_regex, $limit, $filter = [], $deleted = false)
{
	$category_id	= null;
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
				? "(BINARY a.body REGEXP "		. $this->db->q($target) . " " .
				  "OR BINARY a.title REGEXP "	. $this->db->q($target) . ") "
				: "(BINARY a.body LIKE "		. $this->db->q('%' . $target . '%') . " " .
				  "OR BINARY a.title LIKE "		. $this->db->q('%' . $target . '%') . ") "
		);
	}
	else if ($pages || $comments)
	{
		$match =
			($use_regex
				? "(BINARY a.body REGEXP "		. $this->db->q($target) . ") "
				: "(BINARY a.body LIKE "		. $this->db->q('%' . $target . '%') . ") "
			);
	}
	else if ($titles)
	{
		$match =
			($use_regex
				? "(BINARY a.title REGEXP "		. $this->db->q($target) . ") "
				: "(BINARY a.title LIKE "		. $this->db->q('%' . $target . '%') . ") "
		);
	}

	// namespace: include tag and tag/%, not tag%
	$selector =
		($category_id
			? "LEFT JOIN " . $prefix . "category_assignment ca ON (a.page_id = ca.object_id) "
			: "") .
		($tag
			? "LEFT JOIN " . $prefix . "page b ON (a.comment_on_id = b.page_id) "
			: "") .
		"WHERE " .
			$match .
			($tag
				? "AND (a.tag = "	. $this->db->q($tag) . " " .
				  "OR a.tag LIKE "	. $this->db->q($tag . '/%') . " " .
				  "OR b.tag = "		. $this->db->q($tag) . " " .
				  "OR b.tag LIKE "	. $this->db->q($tag . '/%') . ") "
				: "") .
			($comments
				? ($pages
					?	""
					:	"AND a.comment_on_id <> 0 ")
				: "AND a.comment_on_id = 0 ") .
			(!empty($this->sess->replace_unset)
				? "AND a.page_id NOT IN (" . $this->ids_string($this->sess->replace_unset) . ") "
				: "") .
			($lang
				? "AND a.page_lang = " . $this->db->q($lang) . " "
				: "") .
			($category_id
				? "AND ca.category_id IN (" . $this->ids_string($category_id) . ") " .
				  "AND ca.object_type_id = " . (int) OBJECT_PAGE . " "
				: "") .
			($deleted
				? ""
				: ($tag
					? "AND (a.deleted <> 1 OR b.deleted <> 1) "
					: "AND a.deleted <> 1 ")) .
			" ";

	$count = $this->db->load_single(
		"SELECT COUNT(a.page_id) AS n " .
		"FROM " . $prefix . "page a " .
		$selector, true);

	$pagination = $this->pagination($count['n'], $limit);

	// load search results
	$results = $this->db->load_all(
		"SELECT a.page_id, a.owner_id, a.user_id, a.tag, a.title, a.created, a.modified, a.body, a.comment_on_id, a.page_lang, a.page_size, a.comments,
			u.user_name, o.user_name as owner_name " .
		"FROM " . $prefix . "page a " .
			"LEFT JOIN " . $prefix . "user u ON (a.user_id = u.user_id) " .
			"LEFT JOIN " . $prefix . "user o ON (a.owner_id = o.user_id) " .
		$selector .
		"ORDER BY a.tag " .
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

$replace_text = function ($target, $replacement, $text, $use_regex)
{
	if ($use_regex)
	{
		$new_text =  preg_replace('/' . $target . '/Uu', "$replacement", $text, -1, $num_matches);
	}
	else
	{
		$new_text = str_replace($target, $replacement, $text, $num_matches);
	}

	if ($num_matches > 0)
	{
		return $new_text;
	}
	else
	{
		// replace text failed
		$this->set_message(Ut::perc_replace(
			$this->_t('ReplaceTextEditFailed'),
			'<code>' . Ut::html(Ut::shorten_string($target)) . '</code>',
			'<code>' . Ut::html(Ut::shorten_string($replacement)) . '</code>'), 'error');
	}

	return false;
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
		$target_str	= "/$target/Uu";
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
	$tpl->enter('search_');

	$tpl->target		= $o['target'];
	$tpl->replacement	= $o['replacement'];
	$tpl->regex			= $o['use_regex'];
	$tpl->tag			= $o['page'];
	$tpl->editpages		= $o['edit_pages'];
	$tpl->edittitles	= $o['edit_titles'];
	$tpl->editcomments	= $o['edit_comments'];
	$tpl->cancel		= true;

	// edit note
	if ($this->db->edit_summary)
	{
		$tpl->n_note		= $o['edit_note'];
	}

	// minor edit
	if ($this->page && $this->db->minor_edit)
	{
		$tpl->minor			= true;
		$tpl->minor_minor	= $o['minor_edit'];
	}

	if ($o['options'])
	{
		$tpl->options		= true;

		$tpl->enter('options_');

		$tpl->c_categories	= $this->show_category_form($this->page_lang, null, OBJECT_PAGE, false, false);

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

$select_form = function ($pages, $pagination, $tcount, $max, array $o) use ($tpl, $search_text, $extract_context)
{
	$tpl->enter('select_');

	$tpl->replace		= true;
	$tpl->cancel		= true;

	if (count($pages) > 5)
	{
		$tpl->invert	= true;
	}

	$hidden = [
		'edit_comments'		=> $o['edit_comments'],
		'edit_note'			=> $o['edit_note'],
		'edit_pages'		=> $o['edit_pages'],
		'edit_titles'		=> $o['edit_titles'],
		'lang'				=> $o['lang'],
		'minor_edit'		=> $o['minor_edit'],
		'replacement'		=> $o['replacement'],
		'tag'				=> $o['page'],
		'target'			=> $o['target'],
		'use_regex'			=> $o['use_regex'],
	];

	foreach ($hidden as $key => $value)
	{
		$tpl->hidden_name	= $key;
		$tpl->hidden_value	= $value;
	}

	if (trim($o['replacement']) === '')
	{
		$tpl->warning_msg = $this->_t('ReplaceTextBlankWarning');
	}
	else if ([ , , $rcount] = $search_text($o['replacement'], $o['tag'], $o['use_regex'], $max, $o['filter']))
	{
		if ($rcount > 0)
		{
			$tpl->warning_msg = Ut::perc_replace(
				$this->_t('ReplaceTextWarning'),
				$rcount,
				'<code>' . Ut::html($o['msg_replacement']) . '</code>');
		}
	}

	$tpl->offset		= $pagination['offset'] + 1;

	$tpl->enter('l_');

	foreach ($pages as $n => $p)
	{
		if (!$this->db->hide_locked || $this->has_access('read', $p['page_id']))
		{
			$tpl->delim = $n++;

			$preview	= '';

			// generate preview
			if (($o['edit_pages'] || $o['edit_comments']) && $this->has_access('read', $p['page_id']))
			{
				$preview	= $extract_context($p['body'], $o['target'], $o['use_regex'], $o['padding']);
			}

			$this->sess->replace_set[] = $p['page_id'];

			$tpl->enter('l_');

			$tpl->pageid	= $p['page_id'];
			$tpl->link		= $this->link('/' . $p['tag'], '', ($o['title'] ? $p['title'] : $p['tag']), '', false);
			$tpl->userlink	= $this->user_link($p['user_name'], false, false);
			$tpl->mtime		= $p['modified'];
			$tpl->psize		= $this->binary_multiples($p['page_size'], false, true, true);

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

		$tpl->mark_diag	= Ut::perc_replace(
			$this->_t(($o['edit_pages'] || $o['edit_comments'] ? 'ReplaceTextPagesEdit' : 'ReplaceTextTitlesEdit')),
			'<code>' . Ut::html($o['msg_target']) . '</code>',
			'<code>' . Ut::html($o['msg_replacement']) . '</code>',
			'<strong>' . $batch_count . '</strong>');
		$tpl->emark		= true;
	}

	$tpl->leave(); // select_
};

// --------------------------------------------------------------------------------

// set defaults
$lang			??= '';
$max			??= 50;	// (10 ... 100)
$options		??= 0;
$padding		??= 40;
$page			??= '/';
$title			??= 1;
$mute			??= 1;

$action			= (string)	($_POST['_action']			?? null);
$edit_comments	= (bool)	($_POST['edit_comments']	?? 0);
$edit_pages		= (bool)	($_POST['edit_pages']		?? 0);
$edit_titles	= (bool)	($_POST['edit_titles']		?? 0);
$lang			= (string)	($_POST['lang']				?? $lang);
$page			= (string)	($_POST['page']				?? $page);
$replacement	= (string)	trim(($_POST['replacement']	?? ''));
$target			= (string)	trim(($_POST['target']		?? ''));
$use_regex		= (bool)	($_POST['use_regex']		?? 0);
$edit_note		= (string)	trim(($_POST['edit_note']	?? ''));
$minor_edit		= (bool)	($_POST['minor_edit']		?? 0);

$edit_note		= $this->sanitize_text_field($edit_note, true);
$show_form		= false;

// remove \r (body contains only \n)
$replacement	= str_replace("\r\n", "\n", $replacement);
$target			= str_replace("\r\n", "\n", $target);

// visualize line breaks in message sets
$msg_replacement	= str_replace("\n", '↵', $replacement);
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

foreach ($_POST as $key => $val)
{
	if (preg_match('/^category(\d+)$/', $key, $ids) && $val == 'set')
	{
		$category_ids[] = $ids[1];
	}
}

$o = [
	'edit_comments'		=> $edit_comments,
	'edit_note'			=> $edit_note,
	'edit_pages'		=> $edit_pages,
	'edit_titles'		=> $edit_titles,
	'filter' => [
		'category_id'	=> $category_ids,
		'comments'		=> $edit_comments,
		'lang'			=> $lang,
		'pages'			=> $edit_pages,
		'titles'		=> $edit_titles,
	],
	'lang'				=> $lang,
	'minor_edit'		=> $minor_edit,
	'msg_replacement'	=> $msg_replacement,
	'msg_target'		=> $msg_target,
	'options'			=> (bool) $options,
	'padding'			=> (int) $padding,
	'page'				=> $page,
	'replacement'		=> $replacement,
	'tag'				=> $tag,
	'target'			=> $target,
	'title'				=> $title,
	'use_regex'			=> $use_regex,
];

// [C] replace target text with replacement
if ($action == 'replace_text')
{
	// return to form
	if (isset($_POST['back']))
	{
		$show_form = true;
	}
	else if (isset($_POST['replace']))
	{
		$mute = (bool) $mute; // TODO: add option to send only one email per batch if true

		// TODO: Is this realy useful for large strings?
		$edit_note = $edit_note ?: $this->sanitize_text_field(
			Ut::perc_replace(
				$this->_t('ReplaceTextEditSummary'),
				'' . Ut::shorten_string($msg_target) . '',
				'' . Ut::shorten_string($msg_replacement) . ''
			),
		true);

		$set = [];

		// keep currently selected list items
		if (isset($_POST['id']))
		{
			foreach ($_POST['id'] as $key => $val)
			{
				if (!in_array($val, $set) && !empty($val))
				{
					$set[] = (int) $val;
				}
			}

			unset($key, $val);
		}

		// for next batch, keep excluded ids and ignore them (does not scale)
		$this->sess->replace_unset	= array_unique(array_diff($this->sess->replace_set, $set));

		if ($count = count($set))
		{
			foreach ($set as $page_id)
			{
				$p = $this->load_page('', $page_id);

				// TODO: add error message if replace_text returns false and continue if neighter page nor title is true, default
				if ($edit_pages || $edit_comments)
				{
					$p['body'] = $replace_text($target, $replacement, $p['body'], $use_regex) ?: $p['body'];
				}

				// discards anything beyond 250 bytes (title field)
				if ($edit_titles)
				{
					$p['title'] = $replace_text($target, $replacement, $p['title'], $use_regex) ?: $p['title'];
				}

				// mark as processed (prevents possible re-match via regex)
				if ($use_regex)
				{
					$this->sess->replace_unset[] = $p['page_id'];
				}

				$this->save_page($p['tag'], $p['body'], $p['title'], $edit_note, $minor_edit, 0, $p['comment_on_id'], 0, $p['page_lang'], $mute);
			}

			sort($this->sess->replace_unset);
			unset($p, $this->sess->replace_set);

			$this->set_message(
				Ut::perc_replace(
					$this->_t('ReplaceTextSuccess'),
					'<code>' . Ut::html($msg_target) . '</code>',
					'<code>' . Ut::html($msg_replacement) . '</code>',
					$count),
				'success');
		}

		// reload selection form with remaining matches, use cancel button to reset form
		$action = 'replace_text';
	}
}

// [B] show target matches for replacement selection
if ($action == 'select_pages')
{
	$error = null;

	if (!$edit_pages && !$edit_comments && !$edit_titles)
	{
		$error = ['ReplaceTextNoOption', 'hint'];
	}
	else if ($target == $replacement)
	{
		$error = ['ReplaceTextNoDifference', 'hint'];
	}
	else if ($edit_titles && max(strlen($target), strlen($replacement)) > 200)
	{
		$error = ['ReplaceTextTitleTooBig', 'error'];
	}

	if ($error)
	{
		$tpl->message	= $this->show_message($this->_t($error[0]), $error[1], false);
		$show_form		= true;
	}
	else if (mb_strlen($target) >= 3)
	{
		// search for target matches
		[$pages, $pagination, $tcount] = $search_text($target, $tag, $use_regex, $max, $o['filter']);

		if ($pages)
		{
			$select_form($pages, $pagination, $tcount, $max, $o);
		}
		else
		{
			if (  (($edit_pages || $edit_comments)
				|| ($edit_pages || $edit_comments) && $edit_titles))
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

			$show_form = true;
		}
	}
}
else
{
	$show_form = true;
}

// [A] search & replace form
if ($show_form)
{
	unset(
		$this->sess->replace_set,
		$this->sess->replace_unset);

	$search_form($o);
}
