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
				  '<span class="item-multiplier-x"> &times; </span>' .
				  '<span class="item-multiplier-count">' . (int) $word['n'] . '</span>'
				: '');
};

// settings:
//	root		- where to start counting from (defaults to current tag)
//	list		- make categories clickable links which display pages of a given category (1 (default) or 0)
//	ids			- display pages which belong to these comma-separated categories ids (default none)
//	lang		- categories language if necessary (defaults to current page lang)
//	sort		- order pages alphabetically ('abc', default) or creation date ('date')
//	nomark		- display header and fieldset (1, 2 (no header even in 'categories' mode) or 0 (default))

if (!isset($root))			$root		= '/';
if (!isset($list))			$list		= 1;
if (!isset($type_id))		$type_id	= OBJECT_PAGE;
if (!isset($ids))			$ids		= '';
if (!isset($lang))			$lang		= $this->page['page_lang'];
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
if (!isset($nomark))		$nomark = 0;
$type_id	= (int) ($_GET['type_id'] ?? OBJECT_PAGE);
$filter		= [];

$root = $this->unwrap_link($root);

if ($list && ($ids || isset($_GET['category_id'])))
{
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

	if ($_words = $this->db->load_all(
		"SELECT category, category_lang " .
		"FROM " . $this->db->table_prefix . "category " .
		"WHERE category_id IN (" . $this->ids_string($category_ids) . ")", true));

	if ($nomark != 2)
	{
		if ($_words)
		{
			foreach ($_words as $word)
			{
				// do unicode entities
				$word['category'] = $this->get_unicode_entities($word['category'], $word['category_lang']);

				$words[] = $word['category'];
			}

			$words = strtolower(implode(', ', $words));
		}

		echo '<div class="layout-box"><p><span>' . $this->_t('PagesCategory') . ($words ? ' &laquo;<strong>' . $words . '</strong>&raquo;' : '' ) . ":</span></p>\n";
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
			"SELECT category, category_lang " .
			"FROM " . $this->db->table_prefix . "category " .
			"WHERE category_id IN (" . $this->ids_string($category_ids) . ")", true))
		{
			echo '<ol>';

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
					// do unicode entities
					$page['title'] = $this->get_unicode_entities($page['title'], $page['page_lang']);

					echo '<li>' .
							($sort == 'date'
								? '<small>(' . date('d/m/Y', strtotime($page['created'])) . ')</small> '
								: '') .
							$this->link('/' . $page['tag'], '', $page['title'], '', 0, 1) .
						"</li>\n";
				}

				// take recent lang
				$lang = $page['page_lang'];
			}

			echo '</ol>';
		}
		else
		{
			echo '<em>' . $this->_t('CategoryNotExists') . '</em><br>';
		}
	}
	else
	{
		echo '<em>' . $this->_t('CategoryEmpty') . '</em><br>';
	}

	if ($nomark != 2)
	{
		echo '</div><br>';
	}
}

if (!$ids)
{
	// select category language
	if ($this->db->multilanguage)
	{
		echo $this->form_open('category_lang');
		echo '<p class="t_right">';
		echo $this->show_select_lang('category_lang', $lang, false);
		echo '<input type="submit" name="update" id="submit" value="update">';
		echo '</p>';
		echo $this->form_close();
	}

	// header
	if (!$nomark)
	{
		echo '<div class="layout-box"><p><span>' . $this->_t('Categories') . ($root ? " of cluster " . $this->link('/' . $root, '', '', '', 0) : '') . ":</span></p>\n";
	}

	// categories list
	if ($categories = $this->get_categories_list($lang, true, $root))
	{
		$total	= ceil(count($categories) / 4);
		$n		= 1;

		echo '<table class="category_browser">' . "\n\t<tr>\n" . "\t\t<td>\n";
		echo '<ul class="ul_list lined">' . "\n";

		foreach ($categories as $category_id => $word)
		{
			$spacer = '&nbsp;&nbsp;&nbsp;';

			// do unicode entities
			$word['category'] = $this->get_unicode_entities($word['category'], $lang);

			echo '<li> ' . $category_link($word, $category_id, $type_id, $filter, $list);

			if (isset($word['child']) && $word['child'] == true)
			{
				echo "\n<ul>\n";

				foreach ($word['child'] as $category_id => $word)
				{
					echo '<li> ' . $category_link($word, $category_id, $type_id, $filter, $list) . "</li>\n";
				}

				echo "</ul>\n</li>\n";
			}
			else
			{
				echo "</li>\n";
			}

			// modulus operator: every n loop add a break
			if ($n % $total == 0)
			{
				echo "</ul>\n";
				echo "\t\t</td>\n" .
					 "\t\t<td>\n";
				echo '<ul class="ul_list lined">' . "\n";
			}

			$n++;
		}

		echo "</ul>\n";
		echo "\t\t</td>\n\t</tr>\n</table>\n";
	}
	else
	{
		echo '<em>' . $this->_t('NoCategoriesForThisLang') . '</em>';
	}

	if (!$nomark)
	{
		echo "</div>\n";
	}
}

?>