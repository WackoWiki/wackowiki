<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// shows all categories assigned to an particular object (page, file)

// list -
// nomark -
// path -
// label -

if (!isset($list))		$list		= 0;
if (!isset($label))		$label		= true;
if (empty($path))		$path		= 'Category';
if (!isset($nomark))	$nomark		= '';

$output		= '';
$i			= '';

if (isset($this->categories))
{
	foreach ($this->categories as $category_id => $category)
	{
		$_category = '<a href="' . $this->href('', $this->db->category_page, ['category_id' => $category_id]) . '" class="tag" rel="tag">' . htmlspecialchars($category, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '</a>';

		if ($list)
		{
			$output .= '<li>' . $_category . '</li>';
		}
		else
		{
			if ($i++ > 0)
			{
				$output .= ', ';
			}

			$output .= $_category;
		}
	}
}

if (!empty($_category))
{
	if ($list)
	{
		if (!$nomark)
		{
			echo '<div class="layout-box"><p><span>' . $this->_t('Categories') . ":</span></p>\n";
		}

		echo '<ol>';
	}
	else
	{
		if (!$nomark)
		{
			echo '<div class="layout-box">' . "\n";
		}
	}

	echo (!empty($_category) && (!$list && $label == true)
			? $this->_t('Categories') . ': '
			: '') .
		$output;

	if ($list)
	{
		echo '</ol>';
	}

	if (!$nomark)
	{
		echo "</div>\n";
	}
}
