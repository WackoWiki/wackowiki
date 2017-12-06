<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($page))		$page = '';
if (!isset($nomark))	$nomark = '';
if (!isset($title))		$title = '';

$tag = $page?  $this->unwrap_link($page) : $this->tag;

if (($pages = $this->load_pages_linking_to($tag)))
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

	if (!$nomark)
	{
		echo '<div class="layout-box"><p><span>' . $this->_t('ReferringPages') . ":</span></p>\n";
	}

	echo "<ol>\n";

	$anchor = $this->translit($tag);

	foreach ($pages as $page)
	{
		if ($page['tag'])
		{
			if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
			{
				if ($title)
				{
					$_link = $this->link('/' . $page['tag'] . "#a-" . $anchor, '', $page['title']);
				}
				else
				{
					$_link = $this->link('/' . $page['tag'] . "#a-" . $anchor, '', $page['tag'], $page['title']);
				}

				if (strpos($_link, 'span class="missingpage"') === false)
				{
					echo '<li>' . $_link . "</li>\n";
				}
			}
		}
	}

	echo "</ol>\n";

	if (!$nomark)
	{
		echo "</div>\n";
	}
}
else
{
	echo $this->_t('NoReferringPages');
}
