<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Shows all categories assigned to a particular object (page, file).

Usage:
	{{categories}}

Options:
	[page="Cluster"]
	[list=1]
	[nomark=1]
	[label=0|1]
EOD;

// set defaults
$help		??= 0;
$label		??= true;
$list		??= 0;
$nomark		??= 0;
$type_id	??= OBJECT_PAGE;

if ($help)
{
	$tpl->help	= $this->action('help', ['info' => $info, 'action' => 'categories']);
	return;
}

if (empty($page))		$page		= $this->db->category_page;

$i			= 0;

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
		$title	= Ut::perc_replace($this->_t('TaggedWithTip'), $category);

		if ($list)
		{
			$tpl->o_l_category	= $category;
			$tpl->o_l_href		= $href;
			$tpl->o_l_title		= $title;
		}
		else
		{
			$tpl->d_l_category	= $category;
			$tpl->d_l_href		= $href;
			$tpl->d_l_title		= $title;

			if ($i++ > 0)
			{
				$tpl->d_l_delim	= ', ';
			}
		}
	}
}

