<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$category_link = function ($word, $category_id, $type_id, $filter = [], $list)
{
	$selected = (in_array($category_id, $filter));

	return ($list
				? ($selected
					? '<span rel="tag" class="tag">'
					: '<a href="' . $this->href('', '', ['category_id' => $category_id, 'type_id' => $type_id]) . '" rel="tag" class="tag">')
				: '') .
			# Ut::html($word['category']) .
			$word['category'] .
			($list
				? ($selected
					? '</span>'
					: '</a>' ) .
				  '<span class="item-multiplier-x"> × </span>' .
				  '<span class="item-multiplier-count">' . (int) $word['n'] . '</span>'
				: '');
};

// {{category}}
//	page		- where to start counting from (defaults to current tag)
//	list		- make categories clickable links which display pages of a given category (1 (default) or 0)
//	ids			- display pages which belong to these comma-separated categories ids (default none)
//	lang		- categories language if necessary (defaults to current page lang)
//	sort		- order pages alphabetically ('abc', default) or creation date ('date')
//	nomark		- display header and fieldset (1, 2 (no header even in 'categories' mode) or 0 (default))
//	info		- display category description

if (!isset($page))			$page		= '/';
if (!isset($list))			$list		= 1;
if (!isset($type_id))		$type_id	= OBJECT_PAGE;
if (!isset($ids))			$ids		= '';
if (!isset($lang))			$lang		= $this->page['page_lang'];
if (!isset($nomark))		$nomark 	= 0;
if (!isset($info))			$info 		= 0;
if (isset($_REQUEST['category_lang']))
{
	$lang = ($this->db->multilanguage
			? ($this->known_language($_REQUEST['category_lang'])
				? $_REQUEST['category_lang']
				: '')
			: $lang);
}
if (!isset($sort) || !in_array($sort, ['abc', 'date']))
{
	$sort = 'abc';
}

$type_id	= (int) ($_GET['type_id'] ?? OBJECT_PAGE);
$filter		= [];

$root = $this->unwrap_link($page);

// show assigned objects
if ($list && ($ids || isset($_GET['category_id'])))
{
	$tpl->enter('r_');

	if ($ids)
	{
		$category_ids[]	= preg_replace('/[^\d, ]/', '', $ids);
		$filter			= implode(',', $ids);
	}
	else
	{
		$category_ids[]	= (int) $_GET['category_id'];

		if (is_array($category_ids))
		{

		}
		else
		{
			$filter[]	= (int) $_GET['category_id'];
		}
	}

	$_words = $this->db->load_all(
		"SELECT category, category_lang " .
		"FROM " . $this->db->table_prefix . "category " .
		"WHERE category_id IN (" . $this->ids_string($category_ids) . ")", true);

	if ($nomark != 2)
	{
		$word	= [];
		$words	= '';

		if ($_words)
		{
			foreach ($_words as $_word)
			{
				$word[] = $_word['category'];
			}

			$words = mb_strtolower(implode(', ', $word));
		}

		$tpl->mark			= true;
		$tpl->mark_words	= $words;
		$tpl->emark			= true;
	}

	if ($sort == 'abc')
	{
		$order = 'title ASC';
	}
	else if ($sort == 'date')
	{
		$order = 'created DESC';
	}

	// get category assignments
	if ($pages = $this->db->load_all(
		"SELECT p.page_id, p.tag, p.title, p.created, p.page_lang " .
		"FROM " . $this->db->table_prefix . "category_assignment AS k " .
			"INNER JOIN " . $this->db->table_prefix . "page AS p ON (k.object_id = p.page_id) " .
		"WHERE k.category_id IN (" . $this->ids_string($category_ids) . ") " .
			"AND k.object_type_id = 1 " .
			"AND p.deleted <> 1 " .
			(($root && $type_id = OBJECT_PAGE)
				? "AND (p.tag = " . $this->db->q($root) . " " .
					"OR p.tag LIKE " . $this->db->q($root . '/%') . ") "
				: '') .
		"ORDER BY p.{$order} ", true))
	{
		if ($_words = $this->db->load_all(
			"SELECT category, category_description, category_lang " .
			"FROM " . $this->db->table_prefix . "category " .
			"WHERE category_id IN (" . $this->ids_string($category_ids) . ")", true))
		{
			if ($info)
			{
				$tpl->d_description	= $_words[0]['category_description'];
			}

			foreach ($pages as $page)
			{
				// cache page_id for for has_access validation in link function
				$this->page_id_cache[$page['tag']] = $page['page_id'];

				if ($this->has_access('read', $page['page_id']) !== true)
				{
					continue;
				}
				else
				{
					$tpl->l_link	= $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1);

					if ($sort == 'date')
					{
						$tpl->l_d_created = date('d/m/Y', strtotime($page['created']));
					}
				}

				// take recent lang
				$lang = $page['page_lang'];
			}
		}
		else
		{
			$tpl->message = '<em>' . $this->_t('CategoryNotExists') . '</em><br>';
		}
	}
	else
	{
		$tpl->message = '<em>' . $this->_t('CategoryEmpty') . '</em><br>';
	}

	$tpl->leave(); // r_
}

// show categories
if (!$ids)
{
	$tpl->enter('c_');

	// select category language
	if ($this->db->multilanguage)
	{
		$tpl->ml_lang	= $this->show_select_lang('category_lang', $lang, false);
	}

	// header
	if (!$nomark)
	{
		$tpl->mark		= true;
		$tpl->emark		= true;

		if ($root)
		{
			$tpl->mark_link		= $this->link('/' . $root, '', '', '', 0);
			$tpl->mark_cluster	= $this->_t('CategoriesOfCluster');
		}
	}

	// categories list
	if ($categories = $this->get_categories_list($lang, true, $root))
	{
		$filter[]	= (int) ($_GET['category_id'] ?? null);
		$total		= ceil(count($categories) / 4); // TODO: without subcategories!
		$n			= 1;

		foreach ($categories as $category_id => $word)
		{
			$spacer = NBSP . NBSP . NBSP;	// No-Break Space (NBSP)

			$tpl->l_link		= $category_link($word, $category_id, $type_id, $filter, $list);

			if (isset($word['child']) && $word['child'] == true)
			{

				foreach ($word['child'] as $category_id => $word)
				{
					$tpl->l_c_l_link	= $category_link($word, $category_id, $type_id, $filter, $list);
				}
			}

			// modulus operator: every n loop add a break
			if ($n % $total == 0)
			{
				$tpl->l_next = true;
			}

			$n++;
		}
	}
	else
	{
		$tpl->message = '<em>' . $this->_t('NoCategoriesForThisLang') . '</em>';
	}

	$tpl->leave(); // c_
}

