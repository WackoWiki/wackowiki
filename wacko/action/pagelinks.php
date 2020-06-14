<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{pagelinks [page="PageName"] [max=Number] [nomark=1] [title=0]}}

if (!isset($page))		$page		= '';
if (!isset($nomark))	$nomark		= 0;
if (!isset($title))		$title		= '';
if (!isset($params))	$params		= null;	// for $_GET parameters to be passed with the page link
if (!isset($max))		$max		= null;

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
		$this->cache_page($page, true);
		$page_ids[] = (int) $page['page_id'];
		// cache page_id for for has_access validation in link function
		$this->page_id_cache[$page['tag']] = $page['page_id'];
	}

	// cache acls
	$this->preload_acl($page_ids);

	// display navigation
	$tpl->pagination_text = $pagination['text'];

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
