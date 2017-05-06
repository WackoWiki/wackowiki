<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!function_exists('print_tag_cloud'))
{
	function print_tag_cloud(&$engine, $tags)
	{
		// TODO: add name space 'category'
		$tag_path = $engine->db->base_url . $engine->db->category_page . '?category_id=';

		$max_size = 32; // max font size in pixels
		$min_size = 12; // min font size in pixels

		foreach ($tags as $value)
		{
			$qty[] = $value['number'];
		}

		// largest and smallest array values
		$max_qty = max(array_values($qty));
		$min_qty = min(array_values($qty));

		// find the range of values
		$spread = $max_qty - $min_qty;

		if ($spread == 0)
		{
			// we don't want to divide by zero
			$spread = 1;
		}

		// set the font-size increment
		$step = ($max_size - $min_size) / ($spread);

		// loop through the tag array
		foreach ($tags as $key => $value)
		{
			// calculate font-size
			// find the $value in excess of $min_qty
			// multiply by the font-size increment ($size)
			// and add the $min_size set above
			$size = round($min_size + (($value['number'] - $min_qty) * $step));

			echo '<a href="' . $tag_path . '' . $key . '" style="font-size: ' . $size . 'px;" title="' . $value['number'] . ' pages tagged with ' . $value['category'] . '">' . $value['category'] . '</a> ';
		}
	}
}

// settings:
//	root		- where to start counting from (defaults to current tag)
//	lang		- categories language if necessary (defaults to current page lang)
//	owner		- page owner
//	sort		- order pages alphabetically ('abc', default) or number ('number')
//	nomark		- display header and fieldset (1) or 0 (default))


if (!isset($root))			$root	= '/';
if (!isset($nomark))		$nomark = '';
if (!isset($lang))			$lang	= $this->page['page_lang'];
if (!isset($owner))			$owner = '';
if (!isset($sort) || !in_array($sort, ['abc', 'number']))
{
	$sort = 'abc';
}
$root = $this->unwrap_link($root);

if		($sort == 'abc')	$order = 'c.category ASC';
else if ($sort == 'number')	$order = 'number DESC';

$sql = "SELECT
			c.category_id,
			c.category_lang,
			c.category,
			COUNT(c.category_id) AS number
		FROM
			" . $this->db->table_prefix . "category c
			INNER JOIN " . $this->db->table_prefix . "category_assignment ca ON (c.category_id = ca.category_id)
			INNER JOIN " . $this->db->table_prefix . "page p ON (ca.object_id = p.page_id) " .
			($owner
				? "INNER JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) "
				: '' ) .
		"WHERE c.category_lang = '{$lang}' " .
			"AND ca.object_type_id = 1 " .
			"AND p.deleted <> '1' " .
			($root
				? "AND ( p.tag = " . $this->db->q($root) . " OR p.tag LIKE " . $this->db->q($root . '/%') . " ) "
				: '' ) .
			($owner
				? "AND u.user_name = " . $this->db->q($owner) . " "
				: '' ) .
		"GROUP BY
			c.category
		ORDER BY {$order}";

$tags = $this->db->load_all($sql, true);

if ($tags)
{
	foreach ($tags as $key => $tag)
	{
		$this->cloud[$tag['category_id']] = [
			'category'	=> $tag['category'],
			'number'	=> $tag['number']
		];
	}

	if (!$nomark)
	{
		echo '<div class="layout-box"><p><span>' . $this->_t('TagCloud') . ":</span></p>\n";
	}

	print_tag_cloud($this, $this->cloud);

	if (!$nomark)
	{
		echo "</div>\n";
	}
}
?>