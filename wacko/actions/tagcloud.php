<?php
if (!function_exists('print_tag_cloud'))
{
	function print_tag_cloud(&$wacko, $tags)
	{
		// TODO: add name space 'category'
		$tag_path = $wacko->config['base_url'].'Category?category=';

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

			echo '<a href="'.$tag_path.''.$key.'" style="font-size: ' . $size . 'px" title="' . $value['number'] . ' pages tagged with ' . $value['category'] . '">' . $value['category'] . '</a> ';
		}
	}
}

// settings:
//	root		- where to start counting from (defaults to current tag)
//	lang		- categories language if necessary (defaults to current page lang)
//	sort		- order pages alphabetically ('abc', default) or number ('number')
//	nomark		- display header and fieldset (1) or 0 (default))


if (!isset($root))			$root	= '/';
if (!isset($nomark))		$nomark = '';
if (!isset($lang))			$lang	= $this->page['lang'];
if (!isset($sort) || !in_array($sort, array('abc', 'number')))
{
	$sort = 'abc';
}
$root = $this->unwrap_link($root);

if		($sort == 'abc')	$order = 'c.category ASC';
else if ($sort == 'number')	$order = 'number DESC';

$sql = "SELECT
			c.category_id,
			c.lang,
			c.category,
			COUNT(category) AS number
		FROM
			{$this->config['table_prefix']}category c
			INNER JOIN {$this->config['table_prefix']}category_page cp ON (c.category_id = cp.category_id)
			INNER JOIN {$this->config['table_prefix']}page p ON (cp.page_id = p.page_id)
		WHERE c.lang = '{$lang}' ".
			( $root ? "AND ( p.tag = '".quote($this->dblink, $root)."' OR p.tag LIKE '".quote($this->dblink, $root)."/%' ) " : '' ).
		"GROUP BY
			c.category
		ORDER BY {$order}";

$tags = $this->load_all($sql, 1);

if ($tags)
{
	foreach ($tags as $key => $tag)
	{
		$this->cloud[$tag['category_id']] = array(
						'category'	=> $tag['category'],
						'number'	=> $tag['number']
		);
	}

	if(!$nomark)
	{
		echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->get_translation('TagCloud').":</span></p>\n";
	}

	print_tag_cloud($this, $this->cloud);

	if(!$nomark)
	{
		echo "</div>\n";
	}
}
?>