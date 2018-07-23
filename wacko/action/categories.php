<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// shows all categories assigned to an particular object (page, file)
//	{{categories}} [one], [two], [tree]
// list -
// nomark -
// page -
// label -

if (!isset($list))		$list		= 0;
if (!isset($type_id))	$type_id	= OBJECT_PAGE;
if (!isset($label))		$label		= true;
if (empty($page))		$page		= $this->db->category_page;
if (!isset($nomark))	$nomark		= 0;

#$category_id = (int) ($_GET['category_id'] ?? 0);

$i			= '';

if (isset($this->categories))
{
	if ($list)
	{
		if (!$nomark)
		{
			$tpl->o_mark	= true;
			$tpl->emark		= true;
		}
	}
	else
	{
		if ($label)
		{
			$tpl->d_label	= true;
		}
		else
		{
			$tpl->d_icon	= true;
		}

		if (!$nomark)
		{
			$tpl->d_mark	= true;
			$tpl->emark		= true;
		}
	}

	foreach ($this->categories[$type_id] as $category_id => $category)
	{
		$href	= $this->href('', $page, ['category_id' => $category_id, 'type_id' => $type_id]);

		if ($list)
		{
			$tpl->o_l_category	= $category;
			$tpl->o_l_href		= $href;
		}
		else
		{
			$tpl->d_l_category	= $category;
			$tpl->d_l_href		= $href;

			if ($i++ > 0)
			{
				$tpl->d_l_delim	= ', ';
			}
		}
	}
}

