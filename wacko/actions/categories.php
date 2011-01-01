<?php

// settings:
//	root		- where to start counting from (defaults to current tag)
//	list		- make categories a clickable links which display pages of a given category (1 (default) or 0)
//	ids			- display pages which belong to these comma-separated categories ids (default none)
//	lang		- categories language if necessary (defaults to current page lang)
//	inline		- display all categories on one line and not emphisize main categories (1 or 0 (default))
//	sort		- order pages alphabetically ('abc', default) or creation date ('date')
//	nomark		- display header and fieldset (1, 2 (no header even in 'categories' mode) or 0 (default))

if (!isset($root))			$root	= '/';
if (!isset($list))			$list	= 1;
if (!isset($ids)) 			$ids	= '';
if (!isset($lang))			$lang	= $this->page['lang'];
if (!isset($inline)) 		$inline	= '';
if (!isset($sort) || !in_array($sort, array('abc', 'date')))
{
	$sort = 'abc';
}
if (!isset($nomark)) $nomark = '';

$root = $this->unwrap_link($root);

//echo '<br />';

if ($list && ($ids || isset($_GET['category'])))
{
	if ($ids)
	{
		$category = preg_replace('/[^\d, ]/', '', $ids);
	}
	else
	{
		$category = (int)$_GET['category'];
	}

	if ($_words = $this->load_all(
	"SELECT category FROM {$this->config['table_prefix']}category ".
	"WHERE category_id IN ( ".quote($this->dblink, $category)." )", 1));

	if ($nomark != 2)
	{
		if ($_words)
		{
			foreach ($_words as $word)
			{
				$words[] = $word['category'];
			}

			$words = strtolower(implode(', ', $words));
		}

		echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->get_translation('PagesCategory').( $words ? ' &laquo;<b>'.$words.'</b>&raquo;' : '' ).":</span></p>\n";
	}

	if ($sort == 'abc')
	{
		$order = 'title ASC';
	}
	else if ($sort == 'date')
	{
		$order = 'created DESC';
	}

	if ($pages = $this->load_all(
	"SELECT p.page_id, p.tag, p.title, p.created ".
	"FROM {$this->config['table_prefix']}category_page AS k ".
		"INNER JOIN {$this->config['table_prefix']}page AS p ON (k.page_id = p.page_id) ".
	"WHERE k.category_id IN ( ".quote($this->dblink, $category)." ) AND k.page_id = p.page_id ".
		( $root ? "AND ( p.tag = '".quote($this->dblink, $root)."' OR p.tag LIKE '".quote($this->dblink, $root)."/%' ) " : '' ).
	"ORDER BY p.$order ", 1))
	{
		if ($_words = $this->load_all(
		"SELECT category FROM {$this->config['table_prefix']}category ".
		"WHERE category_id IN ( ".quote($this->dblink, $category)." )", 1))
		{
			echo '<ol>';

			foreach ($pages as $page)
			{
				if ($this->has_access('read', $page['page_id']) !== true)
				{
					continue;
				}
				else
				{
					echo '<li>'.( $sort == 'date' ? '<small>('.date('d/m/Y', strtotime($page['created'])).')</small> ' : '' ).$this->link('/'.$page['tag'], '', $page['title'], '', 0, 1)."</li>\n";
				}
			}

			echo '</ol>';
		}
		else
		{
			echo '<em>'.$this->get_translation('CategoryNotExists').'</em><br />';
		}
	}
	else
	{
		echo '<em>'.$this->get_translation('CategoryEmpty').'</em><br />';
	}

	if ($nomark != 2)
	{
		echo '</div><br />';
	}
}

if (!$ids)
{
	// header
	if (!$nomark)
	{
		echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->get_translation('Categories').( $root ? " of cluster ".$this->link('/'.$root, '', '', '', 0) : '' ).":</span></p>\n";
	}

	// categories list
	if ($categories = $this->get_categories_list($lang, 1, $root))
	{
		echo "<ul>\n";

		foreach ($categories as $id => $word)
		{
			$spacer = '&nbsp;&nbsp;&nbsp;';

			# if (!$inline && $i++ > 0) echo '<br />';

			echo '<li class="'.( !$inline ? 'inline' : '' ).'"> '.( $list ? '<a href="'.$this->href('', '', 'category='.$id).'">' : '' ).htmlspecialchars($word['category']).( $list ? '</a>'.' ('.(int)$word['n'].')' : '' )."";

			if (isset($word['childs']) && $word['childs'] == true)
			{
				echo "<ul>\n";

				foreach ($word['childs'] as $id => $word)
				{
					echo '<li class="'.( !$inline ? 'inline' : '' ).'"> '.( $list ? '<a href="'.$this->href('', '', 'category='.$id).'">' : '' ).htmlspecialchars($word['category']).( $list ? '</a>'.' ('.(int)$word['n'].')' : '' )."</li>\n";
				}

				echo "</ul>\n</li>\n";
			}
			else
			{
				echo "</li>\n";
			}
		}

		echo "</ul>\n";
	}
	else
	{
		echo '<em>'.$this->get_translation('NoCategoriesForThisLanguage').'</em>';
	}

	if (!$nomark)
	{
		echo "</div>\n";
	}
}

?>