<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Outputs a list of pages that this page links to.

Usage:
	{{pagelinks}}

Options:
	[page="PageName"]
	[max=Number]
	[nomark=1]
	[title=0]
EOD;

// set defaults
$help		??= 0;
$max		??= null;
$nomark		??= 0;
$page		??= '';
$params		??= null;	// for $_GET parameters to be passed with the page link
$title		??= '';

if ($help)
{
	$tpl->help	= $this->action('help', ['info' => $info, 'action' => 'pagelinks']);
	return;
}

$tag = $page ? $this->unwrap_link($page) : $this->tag;

if (!$nomark)
{
	$tpl->mark		= true;
	$tpl->emark		= true;
}

if ([$pages, $pagination] = $this->load_page_links($tag, null, $max))
{
	foreach ($pages as $page)
	{
		$page_ids[] = (int) $page['page_id'];

		$this->page_id_cache[$page['tag']] = $page['page_id'];
		$this->cache_page($page, true);
	}

	// cache acls
	$this->preload_acl($page_ids);

	// display navigation
	$tpl->pagination_text	= $pagination['text'];
	$tpl->offset			= $pagination['offset'] + 1;

	foreach ($pages as $page)
	{
		if ($page['tag'])
		{
			if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
			{
				if ($title)
				{
					$link = $this->link('/' . $page['tag'], '', $page['title']);
				}
				else
				{
					$link = $this->link('/' . $page['tag'], '', $page['tag'], $page['title']);
				}

				if (mb_strpos($link, 'span class="missingpage"') === false)
				{
					$tpl->l_link = $link;
				}
			}
		}
	}
}
else
{
	$tpl->nolinks = true;
}
