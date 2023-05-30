<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Shows a list of used categories and pages assigned to a selected category.

Usage:
	{{category}}

Options:
	[page="Cluster"]
		where to start counting from (defaults to current tag)
	[list=0]
		make categories clickable links which display pages of a given category (1 (default) or 0)
	[ids="1,2,3"]
		display pages which belong to these comma-separated categories ids (default none)
	[lang="fr"]
		categories language if necessary (defaults to current page lang)
	[sort="abc|date"]
		order pages alphabetically ('abc', default) or creation date ('date')
	[nomark=1]
		display header and fieldset (1, 2 (no header even in 'categories' mode) or 0 (default))
	[info=0|1]
		display category description
EOD;

$category_link = function ($word, $category_id, $type_id, $list, $cluster = '', $filter = [])
{
	$selected = (in_array($category_id, $filter));
	// context
	$c_tag = $cluster ? ['tag' => $cluster] : [];

	return ($list
				? ($selected
					? '<span rel="tag" class="tag">'
					: '<a href="' . $this->href('', '', ['category_id' => $category_id, 'type_id' => $type_id] + $c_tag) . '" rel="tag" class="tag">')
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

// set defaults
$ids		??= null;
$info		??= 0;
$lang		??= $this->page['page_lang'];
$list		??= 1;
$nomark		??= 0;
$page		??= '/';
$sort		??= 'abc';
$type_id	??= OBJECT_PAGE;

if ($help)
{
	$tpl->help	= $this->action('help', ['info' => $info, 'action' => 'category']);
	return;
}

if (isset($_REQUEST['category_lang']))
{
	$lang = ($this->db->multilanguage
			? ($this->known_language($_REQUEST['category_lang'])
				? $_REQUEST['category_lang']
				: '')
			: $lang);
}

$type_id	= (int) ($_GET['type_id'] ?? OBJECT_PAGE);
$filter		= [];

$page		= (string) ($_GET['tag'] ?? $page);
$tag		= $this->unwrap_link($page);
$this->sanitize_page_tag($tag);

// show assigned objects
if ($list && ($ids || isset($_GET['category_id'])))
{
	$tpl->enter('r_');

	if ($ids)
	{
		$category_ids[]	= preg_replace('/[^\d, ]/', '', $ids);
		$filter			= explode(',', $ids);
	}
	else
	{
		$category_ids[]	= (int) $_GET['category_id'];

		if (!is_array($category_ids))
		{
			$filter[]	= (int) $_GET['category_id'];
		}
	}

	$_words = $this->db->load_all(
		'SELECT category, category_lang ' .
		'FROM ' . $this->prefix . 'category ' .
		'WHERE category_id IN (' . $this->ids_string($category_ids) . ')', true);

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

		if ($tag)
		{
			$tpl->mark_link		= $this->link('/' . $tag, '', '', '', false);
			$tpl->mark_cluster	= $this->_t('CategoriesOfCluster');
		}
	}

	$order = match($sort) {
		'date'		=> 'created DESC',
		default		=> 'title ASC',
	};

	// get category assignments
	if ($pages = $this->db->load_all(
		'SELECT p.page_id, p.tag, p.title, p.created, p.page_lang ' .
		'FROM ' . $this->prefix . 'category_assignment AS k ' .
			'INNER JOIN ' . $this->prefix . 'page AS p ON (k.object_id = p.page_id) ' .
		'WHERE k.category_id IN (' . $this->ids_string($category_ids) . ') ' .
			'AND k.object_type_id = 1 ' .
			'AND p.deleted <> 1 ' .
			(($tag && $type_id = OBJECT_PAGE)
				? 'AND (p.tag = ' . $this->db->q($tag) . ' ' .
					'OR p.tag LIKE ' . $this->db->q($tag . '/%') . ') '
				: '') .
		"ORDER BY p.{$order} ", true))
	{
		if ($_words = $this->db->load_all(
			'SELECT category, category_description, category_lang ' .
			'FROM ' . $this->prefix . 'category ' .
			'WHERE category_id IN (' . $this->ids_string($category_ids) . ')', true))
		{
			if ($info)
			{
				$tpl->d_description	= $_words[0]['category_description'];
			}

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
				if ($this->has_access('read', $page['page_id']) !== true)
				{
					continue;
				}
				else
				{
					$tpl->l_link	= $this->link('/' . $page['tag'], '', $page['title'], '', false, true);

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

		if ($tag)
		{
			$tpl->mark_link		= $this->link('/' . $tag, '', '', '', false);
			$tpl->mark_cluster	= $this->_t('CategoriesOfCluster');
		}
	}

	// categories list
	if ($categories = $this->get_categories_list($lang, true, $tag, false))
	{
		$filter[]	= (int) ($_GET['category_id'] ?? null);
		$total		= ceil(count($categories) / 4); // TODO: without subcategories!
		$n			= 1;

		foreach ($categories as $category_id => $word)
		{
			$tpl->l_link		= $category_link($word, $category_id, $type_id, $list, $tag, $filter);

			if (isset($word['child']) && $word['child'])
			{
				foreach ($word['child'] as $category_id => $word)
				{
					$tpl->l_c_l_link	= $category_link($word, $category_id, $type_id, $list, $tag, $filter);
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
