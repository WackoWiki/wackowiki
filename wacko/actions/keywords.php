<?php

// settings:
//	root		- where to start counting from (defaults to current tag)
//	list		- make keywords a clickable links which display pages of a given category (1 (default) or 0)
//	ids		- display pages which belong to these comma-separated keyword ids (default none)
//	lang		- keywords language if necessary (defaults to current page lang)
//	inline		- display all keywords on one line and not emphisize main categories (1 or 0 (default))
//	sort		- order pages alphabetically ('abc', default) or creation date ('date')
//	nomark	- display header and fieldset (1, 2 (no header even in 'keywords' mode) or 0 (default))

if (!$root)			$root	= '/';

if (!$lang)			$lang	= $this->page['lang'];

if (!isset($list))	$list	= 1;

if (!$sort || !in_array($sort, array('abc', 'date')))
	$sort = 'abc';

$root = $this->UnwrapLink($root);

//echo '<br />';

if ($list && ($ids || $_GET['category']))
{
	if ($ids) $category = preg_replace('/[^\d, ]/', '', $ids);
	else $category = (int)$_GET['category'];
	
	if ($_words = $this->LoadAll(
	"SELECT keyword FROM {$this->config['table_prefix']}keywords ".
	"WHERE keyword_id IN ( ".quote($this->dblink, $category)." )", 1));
	
	if ($nomark != 2)
	{
		if ($_words)
		{
			foreach ($_words as $word) $words[] = $word['keyword'];
			$words = strtolower(implode(', ', $words));
		}
		echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>Pages Categories".( $words ? ' &laquo;<b>'.$words.'</b>&raquo;' : '' ).":</span></p>\n";
	}
	
	if		($sort == 'abc')	$order = 'title ASC';
	else if ($sort == 'date')	$order = 'created DESC';
	
	if ($pages = $this->LoadAll(
	"SELECT p.page_id, p.tag, p.title, p.created ".
	"FROM {$this->config['table_prefix']}keywords_pages AS k ".
		"INNER JOIN {$this->config['table_prefix']}pages AS p ON (k.page_id = p.page_id) ".
	"WHERE k.keyword_id IN ( ".quote($this->dblink, $category)." ) AND k.page_id = p.page_id ".
		( $root ? "AND ( p.tag = '".quote($this->dblink, $root)."' OR p.tag LIKE '".quote($this->dblink, $root)."/%' ) " : '' ).
	"ORDER BY p.$order ", 1))
	{
		if ($_words = $this->LoadAll(
		"SELECT keyword FROM {$this->config['table_prefix']}keywords ".
		"WHERE keyword_id IN ( ".quote($this->dblink, $category)." )", 1))
		{
			echo '<ul>';
			
			foreach ($pages as $page)
			{
				if ($this->HasAccess('read', $page['page_id']) !== true)
					continue;
				else
					echo '<li>'.( $sort == 'date' ? '<small>('.date('d/m/Y', strtotime($page['created'])).')</small> ' : '' ).$this->Link('/'.$page['tag'], '', $page['title'], 0, 1)."</li>\n";
			}
			
			echo '</ul>';
		}
		else
		{
			echo '<em>Category does not exist.</em><br />';
		}
	}
	else
	{
		echo '<em>Category empty.</em><br />';
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
		echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>Keywords".( $root ? " a cluster ".$this->Link('/'.$root, '', '', 0) : '' ).":</span></p>\n";
	}
	
	// keywords list
	if ($keywords = $this->GetKeywordsList($lang, 1, $root))
	{
		foreach ($keywords as $id => $word)
		{
			$spacer = '&nbsp;&nbsp;&nbsp;';
			
			if (!$inline && $i++ > 0) echo '<br />';
			
			echo '<span class="nobr">'.( !$inline ? '<strong>' : '' ).'&bull; '.( $list ? '<a href="'.$this->href('', '', 'category='.$id).'">' : '' ).htmlspecialchars($word['keyword']).' ('.(int)$word['n'].')'.( $list ? '</a>' : '' ).( !$inline ? '</strong>' : $spacer )."</span>\n";
			
			if ($word['childs'] == true) foreach ($word['childs'] as $id => $word)
			{
				echo '<span class="nobr">'.( !$inline ? $spacer : '' ).'&bull; '.( $list ? '<a href="'.$this->href('', '', 'category='.$id).'">' : '' ).htmlspecialchars($word['keyword']).' ('.(int)$word['n'].')'.( $list ? '</a>' : '' ).( !$inline ? '' : $spacer )."</span>\n";
			}
		}
	}
	else
	{
		echo '<em>Keywords for this language are not specified.</em>';
	}
	
	if (!$nomark)
	{
		echo "</div>\n";
	}
}

?>