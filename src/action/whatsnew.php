<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
 What's New Action
 Displays a list of all new, deleted, or changed pages, new attachments, and comments.

 {{whatsnew page="Cluster"}}

 TODO: table layout may suite visual orientation better, RSS feed
*/

if (!isset($page))		$page = '';
if (!isset($max))		$max		= null;
if (!isset($noxml))		$noxml		= 0;
if (!isset($printed))	$printed	= [];

if (!$max || $max > 100) $max = 100;

$prefix	= $this->prefix;
$tag	= $this->unwrap_link($page);
$user	= $this->get_user();

// process 'mark read' - reset session time
if (isset($_GET['markread']) && $user)
{
	$this->update_last_mark($user);
	$this->set_user_setting('last_mark', date('Y-m-d H:i:s', time()));
	$user = $this->get_user();
}

// loading new pages/comments
$pages1 = $this->db->load_all(
	"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.created, p.modified, p.title, p.comment_on_id, p.ip, p.created AS date, p.edit_note, p.page_lang, c.page_lang AS cf_lang, c.tag AS comment_on_page, c.title AS title_on_page, u.user_name, 1 AS ctype, p.deleted " .
	"FROM " . $prefix . "page p " .
		"LEFT JOIN " . $prefix . "page c ON (p.comment_on_id = c.page_id) " .
		"LEFT JOIN " . $prefix . "user u ON (p.owner_id = u.user_id) " .
	"WHERE (u.account_type = 0 OR p.user_id = 0) " .
		($tag
			? "AND p.tag LIKE " . $this->db->q($tag . '/%') . " "
			: "") .
	"ORDER BY p.created DESC " .
	"LIMIT " . ($max * 2), true);

// loading revisions
$pages2 = $this->db->load_all(
	"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.created, p.modified, p.title, p.comment_on_id, p.ip, p.modified AS date, p.edit_note, p.page_lang, c.page_lang AS cf_lang, c.tag AS comment_on_page, c.title AS title_on_page, u.user_name, 1 AS ctype, p.deleted " .
	"FROM " . $prefix . "page p " .
		"LEFT JOIN " . $prefix . "page c ON (p.comment_on_id = c.page_id) " .
		"LEFT JOIN " . $prefix . "user u ON (p.user_id = u.user_id) " .
	"WHERE p.comment_on_id = 0 " .
		($tag
			? "AND p.tag LIKE " . $this->db->q($tag . '/%') . " "
			: "") .
		"AND p.deleted = 0 " .
		"AND (u.account_type = 0 OR p.user_id = 0) " .
	"ORDER BY modified DESC " .
	"LIMIT " . ($max * 2), true);

// loading uloads
$files = $this->db->load_all(
	"SELECT f.page_id, p.owner_id, p.user_id, p.tag, f.uploaded_dt AS created, f.uploaded_dt AS modified, f.file_name AS title, f.file_id AS comment_on_id, 0 AS ip, f.uploaded_dt AS date, f.file_description AS edit_note, p.page_lang, f.file_lang AS cf_lang, p.tag AS comment_on_page, p.title AS title_on_page, u.user_name, 2 AS ctype, f.deleted " .
	"FROM " . $prefix . "file f " .
		"LEFT JOIN " . $prefix . "page p ON (f.page_id = p.page_id) " .
		"LEFT JOIN " . $prefix . "user u ON (f.user_id = u.user_id) " .
	"WHERE u.account_type = 0 " .
		($tag
			? "AND p.tag LIKE " . $this->db->q($tag . '/%') . " "
			: "") .
		"AND f.deleted = 0 " .
	"ORDER BY f.uploaded_dt DESC " .
	"LIMIT " . ($max * 2), true);

if ($pages = array_merge($pages1, $pages2, $files))
{
	// sort by dates
	$sort_dates = function($a, $b)
	{
		if ($a['date'] == $b['date'])
		{
			return 0;
		}

		return ($a['date'] < $b['date'] ? 1 : -1);
	};

	usort($pages, $sort_dates);

	$count	= 0;

	if ($user)
	{
		$tpl->mark_href = $this->href('', '', ['markread' => 1]);
	}

	if (!(int) $noxml)
	{
		$tpl->xml_href = $this->get_xml_file('changes');
	}

	$pagination	= $this->pagination(count($pages), @$max, 'n', '', '');
	$pages		= array_slice($pages, $pagination['offset'], $pagination['perpage']);

	$curday		= '';
	$file_ids	= [];
	$page_ids	= [];

	foreach ($pages as $page)
	{
		// file it is
		if ($page['ctype'] == 2)
		{
			$file_ids[] = $page['comment_on_id'];
		}
		else
		{
			$page_ids[] = $page['page_id'];

			$this->page_id_cache[$page['tag']] = $page['page_id'];
			$this->cache_page($page, true);
		}
	}

	// cache acls
	$this->preload_acl($page_ids);

	if (!empty($file_ids))
	{
		if ($files = $this->db->load_all(
			"SELECT f.file_id, f.page_id, f.user_id, f.file_size, f.picture_w, f.picture_h, f.file_ext, f.file_lang, f.file_name, f.file_description, f.uploaded_dt, 0 AS hits, p.tag, u.user_name " .
			"FROM " . $prefix . "file f " .
				"LEFT JOIN  " . $prefix . "page p ON (f.page_id = p.page_id) " .
				"INNER JOIN " . $prefix . "user u ON (f.user_id = u.user_id) " .
			"WHERE f.file_id IN (" . $this->ids_string($file_ids) . ") "
			))
		{
			foreach ($files as $file)
			{
				$this->file_cache[$file['page_id']][$file['file_name']] = $file;
			}
		}
	}

	// get cluster the tag resides in
	$get_cluster = function ($page_tag) use ($tag)
	{
		// adapt base to cluster context
		if ($tag && mb_substr($page_tag, 0, mb_strlen($tag)) == $tag)
		{
			$page_tag = utf8_trim(mb_substr($page_tag, mb_strlen($tag)), '/');
		}

		preg_match('/^[^\/]+/u', $page_tag, $sub_tag);

		if ($sub_tag[0] != $page_tag)
		{
			return $sub_tag[0];
		}
	};

	$tpl->pagination_text = $pagination['text'];

	$tpl->enter('page_');

	foreach ($pages as $page)
	{
		if ($this->db->hide_locked)
		{
			$access = ($page['comment_on_id'] && $page['ctype'] != 2
				? $this->has_access('read', $page['comment_on_id'])
				: $this->has_access('read', $page['page_id']));
		}
		else
		{
			$access = true;
		}

		if (!isset($printed[$page['tag']]))
		{
			$printed[$page['tag']] = '';
		}

		if ($access && $printed[$page['tag']] != $page['date'] && ($count++ < $max))
		{
			$printed[$page['tag']] = $page['date'];	// ignore duplicates

			$this->sql2datetime($page['date'], $day, $time);

			// day header
			if ($day != $curday)
			{
				$tpl->day = $curday = $day;
			}

			// print entry
			$tpl->enter('l_');

			$tpl->user			= $this->user_link($page['user_name'], true, false);
			$tpl->viewed		= (isset($user['last_mark']) && $user['last_mark']
									&& $page['user_name'] != $user['user_name']
									&& $page['date'] > $user['last_mark']
										? ' class="viewed"'
										: '' );
			$tpl->revisions		= ($page['ctype'] != 2)
									? ($this->hide_revisions || $page['comment_on_id']
										? $time
										: $this->compose_link_to_page($page['tag'], 'revisions', $time, $this->_t('RevisionTip')))
									: $this->compose_link_to_page($page['tag'], 'filemeta', $time, $this->_t('FileViewPropertiesTip'), false, ['m' => 'show', 'file_id' => $page['comment_on_id']]);

			if ($page['edit_note'])
			{
				$tpl->edit_note = $page['edit_note'];
			}

			// new file
			if ($page['ctype'] == 2)
			{
				if ($page['page_id']) // !$global
				{
					$path2				= '_file:/' . $page['tag'] . '/';
					$tpl->to_link		= $this->link('/' . $page['comment_on_page'], '', $page['title_on_page'], '', 0, 1);
					$tpl->cluster_link	= $get_cluster($page['comment_on_page']);
				}
				else
				{
					$path2				= '_file:/';
					$tpl->cluster_link	= $this->_t('UploadGlobal');
				}

				$tpl->i_title		= $page['deleted'] ? $this->_t('FileDeleted') : $this->_t('NewFileAdded');
				$tpl->i_alt			= 'file';
				$tpl->i_class		= $page['deleted'] ? 'btn-delete' : 'btn-attachment';
				$tpl->link			= $this->link($path2 . $page['title'], '', $this->shorten_string($page['title']), '', 0, 1);
			}
			// deleted
			else if ($page['deleted'])
			{
				if ($page['comment_on_page'])
				{
					$tpl->to_link	= $this->link('/' . $page['comment_on_page'], '', $page['title_on_page'], '', 0, 1);
				}

				$tpl->i_title		= $page['comment_on_page'] ? $this->_t('CommentDeleted') : $this->_t('PageDeleted');
				$tpl->i_alt			= 'deleted';
				$tpl->i_class		= 'btn-delete';
				$tpl->link			= $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1);
				$tpl->cluster_link	= $get_cluster($page['comment_on_page'] ?? $page['tag']);
			}
			// new comment
			else if ($page['comment_on_id'])
			{
				$tpl->i_title		= $this->_t('NewCommentAdded');
				$tpl->i_alt			= 'comment';
				$tpl->i_class		= 'btn-comment';
				$tpl->link			= $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1);
				$tpl->to_link		= $this->link('/' . $page['comment_on_page'], '', $page['title_on_page'], '', 0, 1);
				$tpl->cluster_link	= $get_cluster($page['comment_on_page']);
			}
			// new page
			else if ($page['created'] == $page['date'])
			{
				$tpl->i_title		= $this->_t('NewPageCreated');
				$tpl->i_alt			= 'new';
				$tpl->i_class		= 'btn-add-page';
				$tpl->link			= $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1);
				$tpl->cluster_link	= $get_cluster($page['tag']);
			}
			// new revision
			else
			{
				$tpl->i_title		= $this->_t('NewRevisionAdded');
				$tpl->i_alt			= 'changed';
				$tpl->i_class		= 'btn-edit';
				$tpl->link			= $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1);
				$tpl->cluster_link	= $get_cluster($page['tag']);
			}

			$tpl->leave();	// l_
		}
	}

	$tpl->leave();	// page_
}
