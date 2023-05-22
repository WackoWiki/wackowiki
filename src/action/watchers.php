<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// set defaults
$nomark		??= false;
$page		??= '';

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

if ($this->is_owner($page_id) || $this->is_admin())
{
	$watchers = $this->db->load_all(
		'SELECT u.user_name ' .
		'FROM ' . $this->prefix . 'watch w ' .
			'LEFT JOIN ' . $this->prefix . 'user u ON (w.user_id = u.user_id) ' .
		'WHERE w.page_id = ' . (int) $page_id . ' ' .
		'ORDER BY u.user_name ASC');

	if (!$nomark)
	{
		$tpl->mark			= true;
		$tpl->mark_title	= Ut::perc_replace($this->_t('Watchers'), $this->link('/' . $tag, '', $tag));
		$tpl->emark			= true;
	}

	if ($watchers)
	{
		foreach ($watchers as $watcher)
		{
			$tpl->l_link = $this->user_link($watcher['user_name'], true, false);
		}
	}
	else
	{
		$tpl->none = Ut::perc_replace($this->_t('NoWatchers'), $this->link('/' . $tag, '', $tag));
	}
}
else
{
	$tpl->denied =  Ut::perc_replace($this->_t('NotOwnerToViewWatchers'), $this->link('/' . $tag, '', $tag));
}
