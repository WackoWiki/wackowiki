<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// shows subforums list
// {{forums [pages="subtag1, subtag2, ..."]}}
//		pages	= to create multilevel forums this optional parameter passes
//				  a comma-delimeted list of tag names of pages that must be
//				  considered subforums, and not topics. tags must be absolut (not relative)
//		if you define pages, it must be done for all subforums and topic pages

// define variables
$_pages		= '';
$comment	= null;

if (!isset($noxml))		$noxml = 0;

// make sure that we're executing inside the forum cluster
if (mb_substr($this->tag, 0, mb_strlen($this->db->forum_cluster)) == $this->db->forum_cluster)
{
	$this->forum = false;

	// load user data
	$user = $this->get_user();

	// process 'mark read' - reset session time
	if (isset($_GET['markread']) && $user)
	{
		$this->update_last_mark($user);
		$this->set_user_setting('last_mark', date('Y-m-d H:i:s', time()));
		$user = $this->get_user();
	}

	// parse subforums list if any
	if (!empty($pages))
	{
		$_subforum	= explode(',', $pages);
		$subforum	= array_map('trim', $_subforum);
	}

	// make query
	$sql =	"SELECT p.page_id, p.tag, p.title, p.description, p.page_lang " .
			"FROM " . $this->db->table_prefix . "page AS p, " .
					  $this->db->table_prefix . "acl AS a " .
			"WHERE p.page_id = a.page_id " .
				"AND a.privilege = 'comment' AND a.list = '' ";

	if (!isset($subforum))
	{
		$sql .= "AND p.tag LIKE " . $this->db->q($this->db->forum_cluster . '/%') . " ";
	}
	else
	{
		$q_pages = '';

		foreach ($subforum as $num => $page)
		{
			if ($num <> 0)
			{
				$q_pages .= ', ';
			}

			$q_pages	.= $this->db->q($page);
		}

		$sql .= "AND p.tag IN (" . $q_pages . ") ";
	}

	$sql .= "ORDER BY p.created ASC";

	// load subforums data
	$forums	= $this->db->load_all($sql, true);

	$page_ids	= [];

	foreach ($forums as $forum)
	{
		$page_ids[]	= $forum['page_id'];
		// cache page_id for for has_access validation in link function
		$this->page_id_cache[$forum['tag']] = $forum['page_id'];
		$this->cache_page($forum, true);
	}

	$this->preload_acl($page_ids);

	$tpl->enter('forum_');

	$tpl->enter('f_');

	// display list
	foreach ($forums as $forum)
	{
		// show only those forums where user has read access
		if ($this->has_access('read', $forum['page_id']))
		{
			// count total topics and posts
			$counter = $this->db->load_single(
				"SELECT count(a.page_id) as topics_total, sum(a.comments) as posts_total " .
				"FROM " . $this->db->table_prefix . "page a " .
				"WHERE a.tag LIKE " . $this->db->q($forum['tag'] . '/%') . " " .
					"AND a.deleted <> 1 ", true);

			// load latest comment
			$comments = $this->db->load_all(
				"SELECT a.page_id, a.tag, a.title, a.comment_on_id, a.user_id, a.owner_id, a.created, a.page_lang, b.tag as comment_on, b.title as topic_title, b.page_lang as topic_lang, u.user_name " .
				"FROM " . $this->db->table_prefix . "page a " .
					"LEFT JOIN " . $this->db->table_prefix . "user u ON (a.user_id = u.user_id) " .
					"LEFT JOIN " . $this->db->table_prefix . "page b ON (a.comment_on_id = b.page_id) " .
				"WHERE b.tag LIKE " . $this->db->q($forum['tag'] . '/%') . " " .
					"OR a.tag LIKE " . $this->db->q($forum['tag'] . '/%') . " " .
					"AND a.deleted <> 1 " .
				"ORDER BY a.created DESC ", true);

			foreach ($comments as $_comment)
			{
				if ($this->db->hide_locked)
				{
					if ($this->has_access('read', $_comment['page_id']))
					{
						$comment = $_comment;
						break;
					}
				}
				else
				{
					$comment = $_comment;
					break;
				}
			}

			$this->cache_page($comment, true);

			$forum['description'] = Ut::html($forum['description']); // don't use [ ' description | e ' ]

			$tpl->counter = $counter; // array

			if ($this->has_access('read', $forum['page_id'], GUEST) === false)
			{
				$tpl->closed	= true;
			}

			if ($user['last_mark'] == true
				&& $comment['user_name'] != $user['user_name']
				&& $comment['created'] > $user['last_mark'])
			{
				$tpl->updated	= true;
			}

			$tpl->link			= $this->link('/' . $forum['tag'], '', $forum['title'], '', 0, '');
			$tpl->description	= $forum['description'];

			if ($comment)
			{
				$tpl->enter('c_');

				$tpl->comment	= $comment;
				$tpl->user		= $this->user_link($comment['user_name']);

				if ($comment['comment_on_id'])
				{
					$tpl->href	= $this->href('', $comment['comment_on'], ['p' => 'last']) . '#' . $comment['tag'];
					$tpl->title	= $comment['topic_title'];
				}
				else
				{
					$tpl->href	= $this->href('', $comment['tag']);
					$tpl->title	= $comment['title'];
				}

				$tpl->leave();
			}
			else
			{
				$tpl->none = true;
			}
		}
	}

	$tpl->leave();

	// mark all forums read
	if ($user)
	{
		$tpl->mark_href = $this->href('', '', ['markread' => 1]);
	}

	if (!(int) $noxml)
	{
		$tpl->xml_href = $this->db->base_url . XML_DIR . '/comments_' . preg_replace('/[^a-zA-Z0-9]/', '', mb_strtolower($this->db->site_name)) . '.xml';
	}

	$tpl->leave(); // forum_
}
else
{
	// wrong placed show hint
	$message	= (!$this->db->forum_cluster
		? $this->_t('ForumNoClusterDefined')
		: Ut::perc_replace($this->_t('ForumOutsideCluster'), 'forums')
	);

	$tpl->message	= $this->show_message($message,'info', false);
}

