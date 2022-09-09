<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// shows subforums list
// {{forums [pages="subtag1, subtag2, ..."]}}
//		pages	= to create multilevel forums this optional parameter passes
//				  a comma-delimeted list of tag names of pages that must be
//				  considered subforums, and not topics. tags must be absolute (not relative)
//		if you define pages, it must be done for all subforums and topic pages

// define variables
$pages		??= '';
$noxml		??= 0;

$comment	= null;
$prefix		= $this->prefix;

// ensure that we're executing inside the forum cluster
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
	$sql =	"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.description, p.page_lang " .
			"FROM " . $prefix . "page AS p, " .
					  $prefix . "acl AS a " .
			"WHERE p.page_id = a.page_id " .
				"AND a.privilege = 'comment' " .
				"AND a.list = '' ";

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
	$forums		= $this->db->load_all($sql, true);

	$page_ids	= [];

	foreach ($forums as $forum)
	{
		$page_ids[]	= $forum['page_id'];

		$this->page_id_cache[$forum['tag']] = $forum['page_id'];
		$this->cache_page($forum, true);
	}

	$this->preload_acl($page_ids);

	$tpl->enter('forum_');

	// display search
	$tpl->search = $this->action('search', ['page' => '/' . $this->tag, 'nomark' => 0, 'options' => 0]);


	if (isset($_GET['phrase']))
	{
		$tpl->salign = '';
	}
	else
	{
		$tpl->salign = 'search-box-right';

		$tpl->enter('t_');
		$tpl->enter('f_');

		// display list
		foreach ($forums as $forum)
		{
			// show only those forums where user has read access
			if ($this->has_access('read', $forum['page_id']))
			{
				// count total topics and posts
				$counter = $this->db->load_single(
					"SELECT COUNT(a.page_id) as topics_total, sum(a.comments) as posts_total " .
					"FROM " . $prefix . "page a " .
					"WHERE a.tag LIKE " . $this->db->q($forum['tag'] . '/%') . " " .
						"AND a.deleted <> 1 ", true);

				// load latest comment
				$comments = $this->db->load_all(
					"SELECT a.page_id, a.owner_id, a.user_id, a.tag, a.title, a.comment_on_id, a.created, a.page_lang, b.tag as comment_on, b.title as topic_title, b.page_lang as topic_lang, u.user_name " .
					"FROM " . $prefix . "page a " .
						"LEFT JOIN " . $prefix . "user u ON (a.user_id = u.user_id) " .
						"LEFT JOIN " . $prefix . "page b ON (a.comment_on_id = b.page_id) " .
					"WHERE b.tag LIKE " . $this->db->q($forum['tag'] . '/%') . " " .
						"OR a.tag LIKE " . $this->db->q($forum['tag'] . '/%') . " " .
						"AND a.deleted <> 1 " .
					"ORDER BY a.created DESC ", true);

				$comment = null;

				foreach ($comments as $_comment)
				{
					$this->cache_page($_comment, true);
					$this->page_id_cache[$_comment['tag']] = $_comment['page_id'];
					$this->owner_id_cache[$_comment['page_id']] = $_comment['owner_id'];

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

				$tpl->link			= $this->link('/' . $forum['tag'], '', $forum['title'], '', 0, '');
				$tpl->description	= $forum['description'];

				if ($comment)
				{
					if (isset($user['last_mark'])
						&& $comment['user_name'] != $user['user_name']
						&& $comment['created'] > $user['last_mark'])
					{
						$tpl->updated	= true;
					}

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

					$tpl->leave(); // c_
				}
				else
				{
					$tpl->none = true;
				}
			}
		}

		$tpl->leave(); // f_

		// mark all forums read
		if ($user)
		{
			$tpl->mark_href = $this->href('', '', ['markread' => 1]);
		}

		$tpl->leave(); // t_
	}

	if (!(int) $noxml)
	{
		$tpl->xml_href = $this->get_xml_file('comments');
	}

	$tpl->leave(); // forum_
}
else
{
	// wrong placed show hint
	$message	= (!$this->db->forum_cluster
		? $this->_t('ForumNoClusterDefined')
		: Ut::perc_replace($this->_t('ForumOutsideCluster'), '<code>forums</code>')
	);

	$tpl->message	= $this->show_message($message,'note', false);
}

