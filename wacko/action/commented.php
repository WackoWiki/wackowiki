<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$load_commented = function ($tag, $limit, $deleted = 0)
{
	$comments	= [];
	$pagination	= [];

	// going around the limitations of GROUP BY when used along with ORDER BY
	// http://dev.mysql.com/doc/refman/5.5/en/example-maximum-column-group-row.html
	$page_ids = $this->db->load_all(
		"SELECT a.page_id " .
		"FROM " . $this->db->table_prefix . "page a " .
			"LEFT JOIN " . $this->db->table_prefix . "page a2 ON (a.comment_on_id = a2.comment_on_id AND a.created < a2.created) " .
		($tag
			?	"INNER JOIN " . $this->db->table_prefix . "page b ON (a.comment_on_id = b.page_id) "
			:	"") .
		"WHERE " .
		($tag
			?	"a2.page_id IS NULL AND b.supertag LIKE " . $this->db->q($this->translit($tag) . '/%') . " "
			:	"a2.page_id IS NULL AND a.comment_on_id <> 0 ") .
		($deleted != 1
			? "AND a.deleted <> 1 "
			: "") .
		"ORDER BY a.created DESC"
		, true);

	if ($page_ids)
	{
		foreach ($page_ids as &$id)
		{
			$id = (int) $id['page_id'];
		}

		$pagination = $this->pagination(count($page_ids), $limit);

		// load complete comments
		$comments = $this->db->load_all(
			"SELECT a.page_id, a.tag, a.supertag, b.tag as comment_on_tag, b.title as page_title, b.page_lang, a.comment_on_id,
				a.tag AS comment_tag, a.title AS comment_title, a.page_lang AS comment_lang, a.user_id,
				u.user_name AS comment_user_name, o.user_name as comment_owner_name, a.created AS comment_time " .
			"FROM " . $this->db->table_prefix . "page a " .
				"INNER JOIN " . $this->db->table_prefix . "page b ON (a.comment_on_id = b.page_id) " .
				"LEFT JOIN " . $this->db->table_prefix . "user u ON (a.user_id = u.user_id) " .
				"LEFT JOIN " . $this->db->table_prefix . "user o ON (a.owner_id = o.user_id) " .
			"WHERE a.page_id IN (" . $this->ids_string($page_ids) . ") " .
			"ORDER BY comment_time DESC " .
			$pagination['limit']);
	}

	return [$comments, $pagination];
};

if (!isset($page))		$page = '';
if (!isset($root))		$root	= $this->unwrap_link($page ?? '');
if (!isset($title))		$title	= 0;
if (!isset($noxml))		$noxml	= 0;
if (!isset($max))		$max = null;

$user	= $this->get_user();

if ($this->user_allowed_comments())
{
	// process 'mark read' - reset session time
	if (isset($_GET['markread']) && $user)
	{
		$this->update_last_mark($user);
		$this->set_user_setting('last_mark', date('Y-m-d H:i:s', time()));
		$user = $this->get_user();
	}

	if (list ($pages, $pagination) = $load_commented($root, $max))
	{
		if ($pages)
		{
			$page_ids	= [];

			foreach ($pages as $page)
			{
				$page_ids[]	= $page['page_id'];
				$page_ids[]	= $page['comment_on_id'];
				$this->cache_page($page, true);
				$this->page_id_cache[$page['tag']] = $page['page_id'];
			}

			$this->preload_acl($page_ids);

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

			foreach ($pages as $page)
			{
				if ($this->db->hide_locked)
				{
					$access = $this->has_access('read', $page['comment_on_id']);
				}
				else
				{
					$access = true;
				}

				if ($access)
				{
					$this->sql2datetime($page['comment_time'], $day, $time);

					if ($day != $curday)
					{
						$tpl->day = $curday = $day;
					}

					// do unicode entities
					// page lang
					$page_lang		= ($this->page['page_lang'] != $page['page_lang'])? $page['page_lang'] : '';

					// comment lang
					$comment_lang	= ($this->page['page_lang'] != $page['comment_lang'])? $page['comment_lang'] : '';
					$tpl->l_viewed	= ($user['last_mark']
										&& $page['comment_user_name'] != $user['user_name']
										&& $page['comment_time'] > $user['last_mark'] ? ' class="viewed"' : '');

					// print entry
					$tpl->l_time = $time;
					$tpl->l_page = ($title
						? $this->link('/' . $page['comment_tag'], '', $page['page_title'], '', 0, 1, $page_lang, 0)
						: $this->link('/' . $page['comment_tag'], '', $page['comment_title'], $page['comment_on_tag'], 0, 0, $comment_lang)
					);

					$tpl->l_user = $this->user_link($page['comment_owner_name'], '', true, false);
				}
			}

			$tpl->leave();
		}
		else
		{
			$tpl->nopages = true;
		}
	}
}
else
{
	$tpl->message =  $this->_t('CommentsDisabled');
}
