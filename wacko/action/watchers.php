<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($for))		$for = ''; // depreciated
if ($for)				$page = $for;

if (!isset($page))		$page = '';
if (!isset($nomark))	$nomark = false;

if ($page)
{
	$tag		= $this->unwrap_link($page);
	$page_id	= $this->get_page_id($tag);
}
else
{
	$tag		= $this->tag;
	$page_id	= $this->page['page_id'];
}

if ($this->is_owner($page_id))
{
	$watchers = $this->db->load_all(
		"SELECT u.user_name " .
		"FROM " . $this->db->table_prefix . "watch w " .
			"LEFT JOIN " . $this->db->table_prefix . "user u ON (w.user_id = u.user_id) " .
		"WHERE w.page_id = " . (int) $page_id . " " .
		"ORDER BY u.user_name ASC");

	if ($watchers)
	{
		$title = Ut::perc_replace($this->_t('Watchers'), $this->link('/' . $tag, '', $tag));

		if (!$nomark)
		{
			echo '<div class="layout-box"><p><span>' . $title . ":</span></p>\n";
		}

		echo '<ol class="">' . "\n";

		foreach ($watchers as $watcher)
		{
			echo '<li>' . $this->user_link($watcher['user_name'], '', true, false) . "</li>\n";
		}

		echo "</ol>\n";

		if (!$nomark)
		{
			echo "</div>\n";
		}
	}
	else
	{
		if (!$nomark)
		{
			echo Ut::perc_replace($this->_t('NoWatchers'), $this->link('/' . $tag, '', $tag));
		}
	}
}
else
{
	if (!$nomark)
	{
		echo Ut::perc_replace($this->_t('NotOwnerAndViewWatchers'), $this->link('/' . $tag, '', $tag));
	}
}

?>