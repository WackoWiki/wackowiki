<?php

if (!defined('IN_WACKO'))
{
	exit;
}

use PHPDiff\ {
	Diff,
	Diff\Renderer\Html\Merged,
	Diff\Renderer\Html\SideBySide,
	Diff\Renderer\Html\Unified,
	Diff\Renderer\Text\Context,
	Diff\Renderer\Text\Unified as TextUnified,
};

/*
	[A] search & replace form
	[B] target matches selection form
	[C] replace target text with replacement

	TODO:
	- send only one notification per batch replacement, and not for every single page
	- allow also $this->check_acl($user_name, $this->db->rename_global_acl)
	- improve batch processing
*/

$info = <<<EOD
Description:
	Mass edit using regular expressions

	Enter one or more regular expressions (one per line) for matching, and one or more expressions to replace each match with.
	The first match-expression, if successful, will be replaced with the first replace-expression, and so on.
	See the PHP function preg_replace() for details.

Usage:
	{{admin_massregex}}

Options:
	[page="PageName"]
	[options=1]
	[lang="en"]
	[mute=1]
	[max=NUMBER]
EOD;

if (!$this->is_admin())
{
	return;
}

// functions
$search_text = function ($target, $tag, $limit, $filter = [], $deleted = false)
{
	$category_ids	= null;
	$lang			= null;
	$comments		= null;
	$pages			= null;
	$titles			= null;
	$prefix			= $this->prefix;
	extract($filter, EXTR_IF_EXISTS);

	if ($pages)
	{
		$array_pages = explode("\n", trim($pages));

		foreach ($array_pages as $_tag)
		{
			$q_tags_string[] = $this->db->q($_tag);
		}

		$tags_string	= implode(',', $q_tags_string);
		$match			= 'BINARY a.tag IN (' . $tags_string . ') ';
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
			($pages ? $match : '1=1 ') .
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

	$pagination = $this->pagination($count['n'], $limit);

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

$replace_text = function ($target, $replacement, $text)
{
	$changes = $count = 0;

	foreach ($target as $i => $str_match)
	{
		$str_next_replace	= $replacement[$i];
		$result				= @preg_replace_callback($str_match,
			static function ($array_matches) use ($str_next_replace)
			{
				$array_find		= [];
				$array_replace	= [];

				foreach ($array_matches as $i => $str_match)
				{
					$array_find[]		= '$' . $i;
					$array_replace[]	= $str_match;
				}

				return str_replace($array_find, $array_replace, $str_next_replace);
			},
			$text, -1, $count);

		$changes += $count;

		if ($result !== null)
		{
			$text = $result;
		}
		else
		{
			// replace text failed
			$this->set_message(Ut::perc_replace(
				$this->_t('ReplaceTextEditFailed'),
				#'<code>' . Ut::html(Ut::shorten_string($target)) . '</code>',
				#'<code>' . Ut::html(Ut::shorten_string($replacement)) . '</code>'
			''), 'error');
			// 'masseditregex-badregex'
			//	. ' <b>' . Ut::html( $str_match ) . '</b>' );

			return false;
		}
	}

	return [$text, $changes];
};

$set_replacement = function ($replacement)
{
	$replace = explode("\n", $replacement);

	foreach ($replace as &$str)
	{
		// convert \n into a newline, \\n into \n, \\\n into \<newline>, etc.
		$str = preg_replace(
			[
				'/(^|[^\\\\])((\\\\)*)(\2)\\\\n/',
				'/(^|[^\\\\])((\\\\)*)(\2)n/'
			], [
			"\\1\\2\n",
			"\\1\\2n"
		], $str);
	}

	return $replace;
};

$set_target = function ($target)
{
	return explode("\n", trim($target));
};

$search_form = function (array $o) use ($tpl)
{
	$category_ids		= $o['filter']['category_ids'];

	$tpl->enter('search_');

	$tpl->target		= $o['target']			?: '';
	$tpl->replacement	= $o['replacement']		?: '';
	$tpl->pages			= $o['pages']			?: '';
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

$select_form = function ($pages, $pagination, $tcount, $max, array $o) use ($tpl, $search_text, $replace_text, $set_replacement, $set_target)
{
	$tpl->enter('select_');

	$tpl->replace		= true;
	$tpl->cancel		= true;

	if (count($pages) > 5)
	{
		$tpl->invert	= true;
	}

	$hidden = [
		'categories'		=> implode(',', $o['filter']['category_ids']),
		'edit_comments'		=> $o['edit_comments'],
		'edit_note'			=> $o['edit_note'],
		'edit_pages'		=> $o['edit_pages'],
		'edit_titles'		=> $o['edit_titles'],
		'lang'				=> $o['lang'],
		'minor_edit'		=> $o['minor_edit'],
		'pages'				=> $o['pages'],
		'replacement'		=> $o['replacement'],
		'tag'				=> $o['page'],
		'target'			=> $o['target'],
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

	$this->add_html('header', '<link rel="stylesheet" href="' . $this->db->theme_url . 'css/diff.css">');
	$tpl->offset		= $pagination['offset'] + 1;
	$n_diff				= 0;

	$tpl->enter('l_');

	foreach ($pages as $n => $p)
	{
		if (!$this->db->hide_locked || $this->has_access('read', $p['page_id']))
		{
			$preview			= '';
			$array_replacement	= $set_replacement($o['replacement']);
			$array_target		= $set_target($o['target']);

			// generate preview
			if (($o['edit_pages'] || $o['edit_comments']) && $this->has_access('read', $p['page_id']))
			{
				[$text, $changes] = $replace_text($array_target, $array_replacement, $p['body']);

				// using lib/php-diff library
				$diff = new Diff(explode("\n", $p['body']), explode("\n", $text));

				// the compared versions are identical
				if ($diff->isIdentical())
				{
					continue;
				}

				$renderer	= new SideBySide;
				$preview	= $diff->render($renderer);
			}

			$n_diff++;
			$tpl->delim = $n++;
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
			'<strong>' . $n_diff . '</strong>');
		$tpl->emark		= true;
	}

	$tpl->leave(); // select_
};

// --------------------------------------------------------------------------------

// set defaults
$help			??= 0;
$lang			??= '';
$max			??= 50;	// (10 ... 100) overwritten by user settings
$options		??= 0;
$padding		??= 40;
$page			??= '/';
$title			??= 1;
$mute			??= 1;

if ($help)
{
	$tpl->help	= $this->action('help', ['info' => $info, 'action' => 'admin_massregex']);
	return;
}

$action			= (string)	($_POST['_action']			?? null);
$categories		= (string)	($_POST['categories']		?? '');
$edit_comments	= (bool)	($_POST['edit_comments']	?? 0);
$edit_pages		= (bool)	($_POST['edit_pages']		?? 1);
$edit_titles	= (bool)	($_POST['edit_titles']		?? 0);
$lang			= (string)	($_POST['lang']				?? $lang);
$page			= (string)	($_POST['page']				?? $page);
$pages			= (string)	trim(($_POST['pages']		?? ''));
$replacement	= (string)	trim(($_POST['replacement']	?? ''));
$target			= (string)	trim(($_POST['target']		?? ''));
$edit_note		= (string)	trim(($_POST['edit_note']	?? ''));
$minor_edit		= (bool)	($_POST['minor_edit']		?? 0);

$edit_note			= $this->sanitize_text_field($edit_note, true);
$show_search_form	= false;

// remove \r (body contains only \n)
$pages				= str_replace("\r\n", "\n", $pages);
$replacement		= str_replace("\r\n", "\n", $replacement);
$target				= str_replace("\r\n", "\n", $target);

$array_replacement	= $set_replacement($replacement);
$array_target		= $set_target($target);

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
	'edit_comments'		=> $edit_comments,
	'edit_note'			=> $edit_note,
	'edit_pages'		=> $edit_pages,
	'edit_titles'		=> $edit_titles,
	'filter' => [
		'category_ids'	=> $category_ids,
		'comments'		=> $edit_comments,
		'lang'			=> $lang,
		'pages'			=> $pages,
		'titles'		=> $edit_titles,
	],
	'lang'				=> $lang,
	'minor_edit'		=> $minor_edit,
	'msg_replacement'	=> $msg_replacement,
	'msg_target'		=> $msg_target,
	'options'			=> (bool) $options,
	'padding'			=> (int) $padding,
	'page'				=> $page,
	'pages'				=> $pages,
	'replacement'		=> $replacement,
	'tag'				=> $tag,
	'target'			=> $target,
	'title'				=> $title,
];

// [C] replace target text with replacement
if ($action == 'replace_text')
{
	// return to form
	if (isset($_POST['back']))
	{
		$show_search_form = true;
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
					[$p['body'], ] = $replace_text($array_target, $array_replacement, $p['body']) ?: $p['body'];
				}

				// discards anything beyond 250 bytes (title field)
				if ($edit_titles)
				{
					[$p['title'], ] = $replace_text($array_target, $array_replacement, $p['title']) ?: $p['title'];
				}

				// mark as processed (prevents possible re-match via regex)
				$this->sess->replace_unset[] = $p['page_id'];

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
		$tpl->message		= $this->show_message($this->_t($error[0]), $error[1], false);
		$show_search_form	= true;
	}
	else if (mb_strlen($target) >= 3)
	{
		// search for target matches
		[$pages, $pagination, $tcount] = $search_text($target, $tag, $max, $o['filter']);

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

			$show_search_form = true;
		}
	}
}
else
{
	$show_search_form = true;
}

// [A] search & replace form
if ($show_search_form)
{
	unset(
		$this->sess->replace_set,
		$this->sess->replace_unset);

	$search_form($o);
}
