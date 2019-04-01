<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$load_recent_comments = function ($tag, $limit, $deleted = 0)
{
	$pagination	= [];

	$selector =
		"WHERE " .
			($tag
				? "b.supertag LIKE " . $this->db->q($this->translit($tag) . '/%') . " "
				: "a.comment_on_id <> 0 ") .
			($deleted != 1
				? "AND a.deleted <> 1 "
				: "");

	// count pages
	$count = $this->db->load_single(
		"SELECT COUNT(a.page_id) AS n " .
		"FROM " . $this->db->table_prefix . "page a " .
			"INNER JOIN " . $this->db->table_prefix . "page b ON (a.comment_on_id = b.page_id) " .
		$selector
		, true);

	if ((int) $count['n'])
	{
		$pagination = $this->pagination($count['n'], $limit);

		$comments = $this->db->load_all(
			"SELECT a.page_id, a.tag, a.supertag, b.tag as comment_on_tag, b.title as page_title, b.page_lang,
				a.title AS comment_title, u.user_name AS comment_user, a.modified AS comment_time, a.comment_on_id " .
			"FROM " . $this->db->table_prefix . "page a " .
				"INNER JOIN " . $this->db->table_prefix . "page b ON (a.comment_on_id = b.page_id) " .
				"LEFT JOIN " . $this->db->table_prefix . "user u ON (a.user_id = u.user_id) " .
			$selector .
			"ORDER BY a.modified DESC " .
			$pagination['limit']);

		return [$comments, $pagination];
	}
};

if (!isset($page))		$page	= '';
if (!isset($root) && isset($page)) $root = $this->unwrap_link($page);
if (!isset($root))		$root	= '';
if (!isset($title))		$title	= 0;
if (!isset($noxml))		$noxml	= 0;
if (!isset($max))		$max	= null;

$user	= $this->get_user();

if ($this->user_allowed_comments())
{
	if (list ($comments, $pagination) = $load_recent_comments($root, $max))
	{
		$page_ids	= [];

		foreach ($comments as $page)
		{
			$page_ids[]	= $page['page_id'];
			$page_ids[]	= $page['comment_on_id'];
			$this->cache_page($page, true);
			$this->page_id_cache[$page['tag']] = $page['page_id'];
		}

		$this->preload_acl($page_ids);

		// process 'mark read' - reset session time
		if (isset($_GET['markread']) && $user)
		{
			$this->update_last_mark($user);
			$this->set_user_setting('last_mark', date('Y-m-d H:i:s', time()));
			$user = $this->get_user();
		}

		if ($user)
		{
			$tpl->mark_href =  $this->href('', '', ['markread' => 1]);
		}

		if ($root == '' && !(int) $noxml)
		{
			$tpl->xml_href = $this->db->base_url . XML_DIR . '/comments_' . preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->db->site_name)) . '.xml';
		}

		$tpl->pagination_text = $pagination['text'];

		$curday = '';

		$tpl->enter('page_');

		foreach ($comments as $page)
		{
			if ((!$this->db->hide_locked || $this->has_access('read', $page['comment_on_id'])) && $this->user_allowed_comments())
			{
				$this->sql2datetime($page['comment_time'], $day, $time);

				if ($day != $curday)
				{
					$tpl->day = $curday = $day;
				}

				$tpl->l_viewed	= ($user['last_mark'] == true
									&& $page['comment_user'] != $user['user_name']
									&& $page['comment_time'] > $user['last_mark'] ? ' class="viewed"' : '');

				// do unicode entities
				// page lang
				$page_lang = ($this->page['page_lang'] != $page['page_lang'])? $page['page_lang'] : '';

				// print entry
				$tpl->l_time = $time;
				$tpl->l_page = ($title == 1
					? $this->link('/' . $page['tag'], '', $page['comment_title'], $page['page_title'], 0, 1, $page_lang, 0)
					: $this->link('/' . $page['tag'], '', $page['comment_title'], $page['page_title'], 0, 1, $page_lang, 0)
				);

				$tpl->l_user = $this->user_link($page['comment_user'], '', true, false);
			}
		}

		$tpl->leave();
	}
	else
	{
		$tpl->nopages = true;
	}
}
else
{
	$tpl->message =  $this->_t('CommentsDisabled');
}
