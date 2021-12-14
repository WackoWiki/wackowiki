<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// shows forum topics list
// {{topics [pages="subtag1, subtag2, ..."]}}
//		pages	= when creating multilevel forums this optional parameter passes
//				  a comma-delimeted list of tag names of pages that must be
//				  considered subforums, so topics under these cluster subpages
//				  will not be displayed. tags must be absolute

if (!isset($pages))		$pages = '';

// ensure that we're executing inside the forum cluster
if (mb_substr($this->tag, 0, mb_strlen($this->db->forum_cluster)) == $this->db->forum_cluster)
{
	// count slashes in the tag
	$i = $off = 0;

	while (($off = mb_strpos($this->tag, '/', $off)) !== false)
	{
		++$i;
		++$off;
	}

	$this->forum = $i - 1;

	// load user data
	$user = $this->get_user();

	// process 'mark read' - reset session time
	if (isset($_GET['markread']) && $user)
	{
		$this->update_last_mark($user);
		$this->set_user_setting('last_mark', date('Y-m-d H:i:s', time()));
	}

	// check privilege
	$create_access = $this->has_access('create');

	// checking new topic input if any
	if (@$_POST['_action'] === 'add_topic' && $create_access)
	{
		$error	= '';

		if (isset($_POST['title']))
		{
			$topic_name		= utf8_trim($_POST['title'], ". \t");
			$page_title		= $topic_name;
			$topic_name		= utf8_ucwords($topic_name);
			$this->sanitize_page_tag($topic_name);
			$topic_name		= preg_replace('/[^- \\w]/u', '', $topic_name);
			$topic_name		= str_replace([' ', "\t"], '', $topic_name);

			if (!$topic_name)
			{
				$error = $this->_t('ForumNoTopicName');
			}
		}
		else
		{
			$error = $this->_t('ForumNoTopicName');
		}

		// display error or continue
		if ($error)
		{
			$this->set_message($error, 'error');
			$this->http->redirect($this->href());
		}
		else
		{
			// redirecting to the edit form
			$this->sess->title	= $page_title;
			$this->http->redirect($this->href('edit', $this->tag . '/' . $topic_name, '', true));
		}
	}

	// check admin privilege
	$admin = $this->is_admin();

	// parse subforums list if any
	if ($pages)
	{
		$pages = explode(',', $pages);

		foreach ($pages as &$page)
		{
			$page = utf8_trim($page, '/ ');
		}
	}

	// filter categories
	$category_id = (int) @$_GET['category_id'];

	$selector =
		($category_id
			? "INNER JOIN " . $this->db->table_prefix . "category_assignment AS k ON (k.object_id = p.page_id) "
			: "") . ", " .
			$this->db->table_prefix . "acl AS a " .
		"WHERE p.page_id = a.page_id " .
			"AND p.deleted <> 1 " .
			"AND a.privilege = 'create' AND a.list = '' " .
			"AND p.tag LIKE {$this->db->q($this->tag . '/%')} ";

	if ($pages)
	{
		foreach ($pages as $page)
		{
			$selector .= "AND tag NOT LIKE " . $this->db->q($page . '/%') . " ";
		}
	}

	if ($category_id)
	{
		$selector .=
			"AND k.category_id IN ( " . (int) $category_id . " ) " .
			"AND k.object_type_id = " . OBJECT_PAGE . " ";
	}

	// make counter query
	$sql =
		"SELECT COUNT(p.page_id) AS n " .
		"FROM " . $this->db->table_prefix . "page AS p " .
		$selector;

	// count topics and make pagination
	$count		= $this->db->load_single($sql);
	$pagination	= $this->pagination($count['n'], $this->db->forum_topics);

	// make collector query
	$sql =
		"SELECT p.page_id, p.user_id, p.owner_id, p.tag, p.title, p.ip, p.comments, p.hits, p.created, p.commented, p.description, p.page_lang, u.user_name, o.user_name as owner_name " .
		"FROM " . $this->db->table_prefix . "page AS p " .
			"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
			"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.owner_id = o.user_id) " .
		$selector .
		"ORDER BY p.commented DESC " .
		$pagination['limit'];

	// load topics data
	if ($topics = $this->db->load_all($sql))
	{
		$page_ids = [];

		foreach ($topics as $page)
		{
			$page_ids[]	= $page['page_id'];
			$this->cache_page($page, true);
		}

		// cache acls and categories
		$this->preload_acl($page_ids, ['read', 'comment']);
		$this->preload_categories($page_ids);

		// load latest topic comment
		$sql_comments =
			"SELECT p.tag, p.ip, p.created, p.comment_on_id, p.user_id, p.owner_id, u.user_name, o.user_name AS owner_name " .
			"FROM " . $this->db->table_prefix . "page p " .
				"LEFT JOIN " . $this->db->table_prefix . "page p2 ON (p.comment_on_id = p2.comment_on_id AND p.created < p2.created) " .
				"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
				"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.owner_id = o.user_id) " .
			"WHERE p.comment_on_id IN (" . $this->ids_string($page_ids) . ") " .
				"AND p2.page_id IS NULL " .
				"AND p.comment_on_id <> 0 " .
				"AND p.deleted <> 1";

		$comments = $this->db->load_all($sql_comments);

		foreach ($comments as $comment)
		{
			$topic_comments[$comment['comment_on_id']] = $comment;
		}
	}

	$tpl->enter('topics_');

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

		// display list
		if ($create_access)
		{
			$tpl->create = true;
		}

		$tpl->pagination_text = $pagination['text'];

		$tpl->enter('r_');

		foreach ($topics as $topic)
		{
			if (!$this->db->hide_locked || $this->has_access('read', $topic['page_id']))
			{
				// load latest comment
				if ($topic['comments'] > 0)
				{
					$comment = $topic_comments[$topic['page_id']];
				}
				else
				{
					$comment = null;
				}

				// check new comments
				$updated = (isset($user['last_mark'])
							&& ((isset($comment['user_name'])
									&& $comment['user_name'] != $user['user_name']
									&& $comment['created'] > $user['last_mark'])
								|| ($topic['owner_name'] != $user['user_name']
									&& $topic['created'] > $user['last_mark']) ));

				$topic['description'] = Ut::html($topic['description']); // replaces -> [ ' topic.description | e ' ]

				// load related categories
				$category		= $this->get_categories($topic['page_id'], OBJECT_PAGE);
				$tpl->category	= !empty($category) ? '<br>' . $category : '';

				// print
				if ($user && !$this->has_access('comment', $topic['page_id']))
				{
					$tpl->closed	= true;
				}

				if ($updated)
				{
					$tpl->updated	= true;
				}

				$tpl->topic		= $topic;
				$tpl->title		= $this->compose_link_to_page($topic['tag'], '', $topic['title'], '', true);
				$tpl->ip		= $admin ? $topic['ip'] : '';
				$tpl->owner		= $this->user_link($topic['owner_name']);

				if ($comment)
				{
					$tpl->enter('c_');

					$tpl->style		= $updated ? ' style="font-weight: 600;"' : '';
					$tpl->ip		= $admin ? $comment['ip'] : '';
					$tpl->user		= $this->user_link($comment['user_name']);
					$tpl->href		= $this->href('', $topic['tag'], ['p' => 'last', '#' => $comment['tag']]);
					$tpl->created	= $comment['created'];

					$tpl->leave(); // c_
				}
				else
				{
					$tpl->none_created = $topic['created'];
				}
			}
		}

		$tpl->leave(); // r_

		// mark all topis read
		if ($user)
		{
			$tpl->mark_href = $this->href('', '', ['markread' => 1]);
		}

		// display new topic form when applicable
		if ($create_access)
		{
			$tpl->form_href = $this->href();
		}

		$tpl->leave(); // t_
	}

	$tpl->leave(); // topics_
}
else
{
	// wrong placed show hint
	$message	= (!$this->db->forum_cluster
		? $this->_t('ForumNoClusterDefined')
		: Ut::perc_replace($this->_t('ForumOutsideCluster'), '<code>topics</code>')
	);

	$tpl->message	= $this->show_message($message,'note', false);
}

