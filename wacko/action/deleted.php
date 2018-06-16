<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// show deleted pages and comments
if ($this->is_admin())
{
	if (!isset($max) || $max > 1000) $max = 1000;

	list($pages, $pagination) = $this->load_deleted_pages((int) $max, false);

	if ($pages)
	{
		$page_ids	= [];

		foreach ($pages as $page)
		{
			$page_ids[]	= $page['page_id'];
			$this->cache_page($page, true);
			$this->page_id_cache[$page['tag']] = $page['page_id'];
		}

		$this->preload_acl($page_ids);

		$tpl->pagination_text = $pagination['text'];

		$curday = '';

		$tpl->enter('page_');

		foreach ($pages as $page)
		{
			if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
			{
				$this->sql2datetime($page['modified'], $day, $time);

				// day header
				if ($day != $curday)
				{
					$tpl->day = $curday = $day;
				}

				// do unicode entities
				if (($edit_note = $page['edit_note']) !== '')
				{
					$edit_note = $this->get_unicode_entities($edit_note, $page['page_lang']);
					$tpl->l_n_text = $edit_note;
				}

				// print entry
				$tpl->l_icon = true;
				$tpl->l_time = $this->compose_link_to_page($page['tag'], 'revisions', $time);
				$tpl->l_page = $this->compose_link_to_page($page['tag'], '', '');
				$tpl->l_user = $this->user_link($page['user_name'], '', true, false);
			}
		}

		$tpl->leave();
	}
	else
	{
		$tpl->nopages = true;
	}
}

