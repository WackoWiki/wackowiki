<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// redirect to show method if page doesn't exists
if (!$this->page || $this->page['comment_on_id'])
{
	$this->http->redirect($this->href());
}

// TODO: purge old SQL query cache

$tpl->title = ($this->forum
		? $this->_t('ForumTopic')
		: $this->_t('ModerateSection')) . ' ' .
	$this->compose_link_to_page($this->tag, '', $this->page['title']);

$tpl->moderate =  ($this->forum
	? $this->compose_link_to_page(mb_substr($this->tag, 0, mb_strrpos($this->tag, '/')), 'moderate', '« ' . $this->_t('ModerateSection2')) . '<br><br>'
	: '');

// local functions
$moderate_page_exists = function($tag)
{
	if ($this->db->load_single(
		"SELECT page_id " .
		"FROM " . $this->prefix . "page " .
		"WHERE tag = " . $this->db->q($tag) . " " .
		"LIMIT 1"))
	{
		return true;
	}
	else
	{
		return false;
	}
};

// applicable for both topics and comments
$moderate_delete_page = function($tag)
{
	if (!$tag)
	{
		return false;
	}

	$this->remove_referrers($tag);
	$this->remove_links($tag);
	$this->remove_acls($tag);
	$this->remove_watches($tag);
	$this->remove_page_categories($tag);
	$this->remove_comments($tag);
	$this->remove_files_perpage($tag);
	$this->remove_page($this->get_page_id($tag));

	return true;
};

$moderate_rename_topic = function($old_tag, $new_tag, $title = '')
{
	// set forum context
	$forum_context	= $this->forum;
	$this->forum	= true;

	$tag = $new_tag;

	$this->rename_page($old_tag, $new_tag, $tag);
	$this->remove_referrers($old_tag);
	$this->remove_links($old_tag);
	$this->clear_cache_wanted_page($new_tag);
	$this->clear_cache_wanted_page($tag);

	// rerender page and update page_link table in new context
	$page = $this->load_page($new_tag);
	$this->current_context++;
	$this->context[$this->current_context] = $new_tag;
	$this->update_link_table($page['page_id'], $page['body_r']);
	$this->current_context--;

	// update title in meta and body if needed
	if ($title != '')
	{
		// resave modified page
		$this->save_page($new_tag, $page['body'], $title, '', null, null, 0, null, '', true, false);
	}

	// restore forum context
	$this->forum = $forum_context;

	return true;
};

$moderate_merge_topics = function($base, $topics, $move_topics = true) use ($moderate_delete_page)
{
	// set forum context
	$forum_context	= $this->forum;
	$this->forum	= true;

	if (!$topics || !$base)
	{
		return false;
	}

	$base_id = $this->get_page_id($base);

	foreach ($topics as $topic)
	{
		// we don't really want to touch the base topic
		if ($topic != $base)
		{
			$topic_id = $this->get_page_id($topic);

			// move comments to the base topic
			$this->db->sql_query(
				"UPDATE " . $this->prefix . "page SET " .
					"comment_on_id = " . (int) $base_id . " " .
				"WHERE comment_on_id = " . (int) $topic_id);

			// for the forum moderation only
			if ($move_topics)
			{
				// find latest number
				$status	= $this->db->load_all("SHOW TABLE STATUS");

				foreach ($status as $row)
				{
					if ($row['Name'] == $this->prefix . 'page')
					{
						$num = (int) $row['Auto_increment'];
					}
				}

				// resave topic body as comment
				$page = $this->load_page($topic);

				$this->save_page('Comment' . $num, $page['body'], $page['title'], '', null, null, $base_id, null, '', true);

				// restore creation date
				$this->db->sql_query(
					"UPDATE " . $this->prefix . "page SET " .
						"modified		= " . $this->db->q($page['modified']) . ", " .
						"created		= " . $this->db->q($page['created']) . ", " .
						"commented		= " . $this->db->q($page['commented']) . ", " .
						"owner_id		= " . (int) $page['owner_id'] . ", " .
						"user_id		= " . (int) $page['user_id'] . ", " .
						"ip				= " . $this->db->q($page['ip']) . " " .
					"WHERE tag = " . $this->db->q('Comment' . $num));

				// remove old page remnants
				$moderate_delete_page($topic);
			}
		}
	}

	// update acl
	// Give comments the same read rights as their parent page
	$read_acl		= $this->load_acl($base_id, 'read');
	$read_acl		= $read_acl['list'];
	$write_acl		= '';
	$comment_acl	= '';
	$create_acl		= '';
	$upload_acl		= '';

	// update page_link table
	$comments = $this->db->load_all(
		"SELECT page_id, tag, body_r " .
		"FROM " . $this->prefix . "page " .
		"WHERE comment_on_id = " . (int) $base_id);

	foreach ($comments as $comment)
	{
		$this->context[++$this->current_context] = $comment['tag'];
		$this->update_link_table($comment['page_id'], $comment['body_r']);
		$this->current_context--;

		// saving acls
		$this->save_acl($comment['page_id'], 'write',	$write_acl);
		$this->save_acl($comment['page_id'], 'read',	$read_acl);
		$this->save_acl($comment['page_id'], 'comment',	$comment_acl);
		$this->save_acl($comment['page_id'], 'create',	$create_acl);
		$this->save_acl($comment['page_id'], 'upload',	$upload_acl);
	}

	// recount comments for the base topic
	$this->db->sql_query(
		"UPDATE " . $this->prefix . "page SET " .
			"comments	= " . (int) $this->count_comments($base_id) . ", " .
			"commented	= UTC_TIMESTAMP() " .
		"WHERE page_id = " . (int) $base_id . " " .
		"LIMIT 1");

	// restore forum context
	$this->forum = $forum_context;

	return true;
};

$moderate_split_topic = function($comment_ids, $old_tag, $new_tag, $title) use ($moderate_delete_page)
{
	if (is_array($comment_ids) === false)
	{
		return false;
	}

	$old_page_id	= $this->get_page_id($old_tag);

	// set forum context
	$forum_context	= $this->forum;
	$this->forum	= true;

	// resave first comment as new topic page
	$first_page_id	= array_shift($comment_ids);
	$page			= $this->load_page('', $first_page_id);

	// temporary unset page context
	$old_page = $this->page;
	unset($this->page);

	// build title
	$title = $this->add_spaces_title($title);

	// TODO: pass user, else save_page might fail due missing write privilege
	// resave modified body
	$this->save_page($new_tag, $page['body'], $title, '', null, null, 0, null, '', true);

	// set page context back
	$this->page	= $old_page;

	$new_page_id	= $this->get_page_id($new_tag);

	// bug-resistent check: has page been really resaved?
	if (!$new_page_id)
	{
		$this->forum = $forum_context;

		return false;
	}

	// update acl
	// Give comments the same read rights as their parent page
	$read_acl		= $this->load_acl($new_page_id, 'read');
	$read_acl		= $read_acl['list'];
	$write_acl		= '';
	$comment_acl	= '';
	$create_acl		= '';
	$upload_acl		= '';

	// restore original metadata
	$this->db->sql_query(
		"UPDATE " . $this->prefix . "page SET " .
			"modified		= " . $this->db->q($page['modified']) . ", " .
			"created		= " . $this->db->q($page['created']) . ", " .
			"owner_id		= " . (int) $page['owner_id'] . ", " .
			"user_id		= " . (int) $page['user_id'] . ", " .
			"ip				= " . $this->db->q($page['ip']) . " " .
		"WHERE page_id = " . (int) $new_page_id);

	// move remaining comments to the new topic
	foreach ($comment_ids as $comment_id)
	{
		$this->db->sql_query(
			"UPDATE " . $this->prefix . "page SET " .
				"comment_on_id = " . (int) $new_page_id . " " .
			"WHERE page_id = " . (int) $comment_id);

		// saving acls
		$this->save_acl($comment_id, 'write',	$write_acl);
		$this->save_acl($comment_id, 'read',	$read_acl);
		$this->save_acl($comment_id, 'comment',	$comment_acl);
		$this->save_acl($comment_id, 'create',	$create_acl);
		$this->save_acl($comment_id, 'upload',	$upload_acl);
	}

	// remove old first comment
	$moderate_delete_page($page['tag']);

	// update page_link table
	$page = $this->load_page('', $new_page_id);
	$this->current_context++;
	$this->context[$this->current_context] = $new_tag;
	$this->update_link_table($page['page_id'], $page['body_r']);
	$this->current_context--;

	// recount comments for old and new topics
	$this->db->sql_query(
		"UPDATE " . $this->prefix . "page SET " .
			"comments	= " . (int) $this->count_comments($new_page_id) . ", " .
			"commented	= UTC_TIMESTAMP() " .
		"WHERE page_id = " . (int) $new_page_id . " " .
		"LIMIT 1");

	$this->db->sql_query(
		"UPDATE " . $this->prefix . "page SET " .
			"comments = " . (int) $this->count_comments($old_page_id) . " " .
		"WHERE page_id = " . (int) $old_page_id . " " .
		"LIMIT 1");

	// restore forum context
	$this->forum = $forum_context;

	return true;
};

$write_comment_feed = function()
{
	if ($this->db->enable_feeds)
	{
		$xml = new Feed($this);
		$xml->comments();

		$this->set_language($this->user_lang, true);
	}
};

// END FUNCTIONS

$forum_cluster	= '';
$prefix			= $this->prefix;

if (($this->is_moderator() && $this->has_access('read')) || $this->is_admin())
{
	$accept_action	= '';
	$error			= null;

	if ($this->db->forum_cluster
		&& mb_substr($this->tag, 0, mb_strlen($this->db->forum_cluster)) == $this->db->forum_cluster)
	{
		$forum_cluster = true;
	}
	else
	{
		$forum_cluster = false;
	}

	// IDs PROCESSING (COMMON PROCEDURES)
	$set = [];

	// pass previously selected items
	if (isset($_REQUEST['ids']))
	{
		$ids = explode('-', $_REQUEST['ids']);

		foreach ($ids as $id)
		{
			if (!in_array($id, $set) && !empty($id))
			{
				$set[] = (int) $id;
			}
		}

		unset($ids, $id);
	}

	// keep currently selected list items
	if (isset($_POST['id']))
	{
		foreach ($_POST['id'] as $key => $val)
		{
			if (!in_array($val, $set) && !empty($val))
			{
				$set[] = (int) $val;
			}
		}

		unset($key, $val);
	}

	// save page ids for later operations (correct if needed)
	if (isset($_POST['set']))
	{
		$set = [];

		foreach ($_POST['id'] as $key => $val)
		{
			if (!empty($val))
			{
				$set[] = (int) $val;
			}
		}

		unset($key, $val);
	}
	// reset page ids
	else if (isset($_POST['reset']))
	{
		$set = [];
	}

	// check moderator read access on passed ids
	foreach ($set as $n => $page_id)
	{
		if ($this->has_access('read', $page_id) !== true)
		{
			unset($set[$n]);
		}
	}

	unset($n, $page_id);

	////// BEGIN SUBFORUM MODERATION //////
	if ($this->forum !== true && $forum_cluster)
	{
		$tpl->enter('subforum_');

		// number of topics to display
		$limit = 40;

		// PROCESS INPUT
		// delete selected topic(s)
		if (isset($_POST['delete']) && $set)
		{
			$accept_action	= 'delete';

			// actually remove topics
			if (isset($_POST['accept']))
			{
				foreach ($set as $page_id)
				{
					$page = $this->load_page('', $page_id, null, LOAD_NOCACHE, LOAD_META);
					$moderate_delete_page($page['tag']);
					$this->log(1, Ut::perc_replace($this->_t('LogRemovedPage', SYSTEM_LANG), $page['tag'], $page['user_id']));
				}

				unset($accept_action);

				$write_comment_feed();

				$set = [];
				$this->set_message($this->_t('ModerateTopicsDeleted'), 'success');
				$this->http->redirect($this->href('moderate'));
			}
		}
		// move selected topics elsewhere
		else if (isset($_POST['move']) && $set)
		{
			$accept_action	= 'move';
			$section		= $_POST['section'] ?? '';
			$this->sanitize_page_tag($section);

			// processing...
			if (isset($_POST['accept']) && $section)
			{
				$i = 0;

				foreach ($set as $page_id)
				{
					$old_tags[] = $this->get_page_tag($page_id);
					$new_tags[] = $section . mb_substr($old_tags[$i], mb_strrpos($old_tags[$i], '/'));

					if ($moderate_page_exists($new_tags[$i++]) === true)
					{
						$error[] = '<span class="underline">«' . $this->get_page_title('', $page_id) . '»</span>';
					}
				}

				// in case no errors, move...
				if ($error)
				{
					$error = Ut::perc_replace($this->_t('ModerateMoveExists'), implode(', ', $error));
				}
				else
				{
					$i = 0;

					foreach ($set as $page_id)
					{
						$moderate_rename_topic($old_tags[$i], $new_tags[$i]);
						$this->log(3, Ut::perc_replace($this->_t('LogRenamedPage', SYSTEM_LANG), $old_tags[$i], $new_tags[$i]));
						$i++;
					}

					unset($accept_action, $i, $old_tags, $new_tags);

					$write_comment_feed();

					$set = [];
					$this->set_message($this->_t('ModerateTopicsRelocated'), 'success');
					$this->http->redirect($this->href('moderate'));
				}
			}
		}
		// rename topics
		else if (isset($_POST['rename']) && $set)
		{
			$accept_action	= 'rename';

			// perform accepted rename
			if (isset($_POST['accept']))
			{
				$old_tag	= $this->get_page_tag($set[0]);
				$tag		= utf8_trim($_POST['new_tag'], " \t");
				$title		= $tag;
				$this->sanitize_page_tag($tag);
				$tag		= utf8_ucwords($tag);
				$tag		= preg_replace('/[^- \\w]/u', '', $tag);
				$tag		= str_replace([' ', "\t"], '', $tag);

				// check new tag existence
				if ($old_tag != $this->tag . '/' . $tag
					&& $moderate_page_exists($this->tag . '/' . $tag) === true)
				{
					$error = $this->_t('ModerateRenameExists');
				}

				// ok, then rename page
				if ($tag != '' && !$error)
				{
					$moderate_rename_topic($old_tag, $this->tag . '/' . $tag, $title);
					$this->log(3, Ut::perc_replace($this->_t('LogRenamedPage', SYSTEM_LANG), $old_tag, $this->tag . '/' . $tag . ' ' . $title));
					unset($accept_action, $old_tag, $tag, $title);

					$write_comment_feed();

					$set = [];
					$this->set_message($this->_t('ModerateTopicsRenamed'), 'success');
					$this->http->redirect($this->href('moderate'));
				}
			}
		}
		// merge several topics into a single topic
		else if (isset($_POST['merge']) && $set)
		{
			$accept_action	= 'merge';
			$base			= $_POST['base'] ?? '';
			$this->sanitize_page_tag($base);

			if (count($set) < 2)
			{
				$error = $this->_t('ModerateMerge2Min');
			}

			// perform accepted action
			if (isset($_POST['accept']) && $base && !$error)
			{
				foreach ($set as $page_id)
				{
					$topics[] = $this->get_page_tag($page_id);
				}

				$moderate_merge_topics($base, $topics);
				$this->log(3, Ut::perc_replace($this->_t('LogMergedPages', SYSTEM_LANG),
							'##' . implode('##, ##', $topics) . '##', $base));

				unset($accept_action, $topics);

				$write_comment_feed();

				$set = [];
				$this->set_message($this->_t('ModerateTopicsMerged'), 'success');
				$this->http->redirect($this->href('moderate'));
			}
		}
		// lock topics
		else if (isset($_POST['lock']) && $set)
		{
			foreach ($set as $page_id)
			{
				$page = $this->load_page('', $page_id, null, LOAD_NOCACHE, LOAD_META);
				$this->log(2, Ut::perc_replace($this->_t('LogTopicLocked', SYSTEM_LANG), $page['tag'] . ' ' . $page['title']));
				// DON'T USE BLANK PRIVILEGE LIST!!! Only "negative all" - '!*'
				$this->save_acl($page_id, 'comment', '!*');
			}

			// purge SQL queries cache
			$this->db->invalidate_sql_cache();

			$set = [];
			$this->set_message($this->_t('ModerateTopicsBlocked'), 'success');
			$this->http->redirect($this->href('moderate'));
		}
		// unlock topics
		else if (isset($_POST['unlock']) && $set)
		{
			foreach ($set as $page_id)
			{
				$page = $this->load_page('', $page_id, null, LOAD_NOCACHE, LOAD_META);
				$this->log(2, Ut::perc_replace($this->_t('LogTopicUnlocked', SYSTEM_LANG), $page['tag'] . ' ' . $page['title']));
				$this->save_acl($page_id, 'comment', $this->db->default_comment_acl);
			}

			// purge SQL queries cache
			$this->db->invalidate_sql_cache();

			$set = [];
			$this->set_message($this->_t('ModerateTopicsUnlocked'), 'success');
			$this->http->redirect($this->href('moderate'));
		}

		// GET TOPICS

		$selector =
			"WHERE p.page_id = a.page_id " .
				"AND a.privilege = 'create' " .
				"AND a.list = '' " .
				"AND p.tag LIKE " . $this->db->q($this->tag . '/%') . " ";

		// make counter query
		$sql =
			"SELECT COUNT(p.page_id) AS n " .
			"FROM " . $prefix . "page AS p, " .
					  $prefix . "acl AS a " .
			$selector .
			"LIMIT 1";

		// count topics and make pagination
		$count		= $this->db->load_single($sql);
		$pagination	= $this->pagination($count['n'], $limit, 'p', ['ids' => implode('-', $set)], 'moderate');

		// make collector query
		$sql =
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.owner_id, p.user_id, p.ip, p.comments, p.created, p.page_lang, u.user_name, o.user_name as owner_name " .
			"FROM " . $prefix . "page AS p " .
				"LEFT JOIN " . $prefix . "user u ON (p.user_id = u.user_id) " .
				"LEFT JOIN " . $prefix . "user o ON (p.owner_id = o.user_id), " .
				$prefix . "acl AS a " .
			$selector .
			"ORDER BY commented DESC " .
			$pagination['limit'];

		// FORMS SUBFORUM

		// load topics data
		$topics	= $this->db->load_all($sql);

		$page_ids	= [];

		foreach ($topics as $page)
		{
			$page_ids[]	= $page['page_id'];
			$this->cache_page($page, true);
			$this->page_id_cache[$page['tag']] = $page['page_id'];
		}

		$this->preload_acl($page_ids, ['read', 'comment']);

		// display list
		$tpl->pagination_text = $pagination['text'];

		// confirm deletion
		if ($accept_action == 'delete')
		{
			$tpl->enter('delete_');

			foreach ($set as $page_id)
			{
				$accept_text[] = '<code>' . $this->get_page_title('', $page_id) . '</code>';
			}

			$tpl->action	= $accept_action;
			$tpl->text		= implode('<br>', $accept_text);

			$tpl->leave();	// delete_
		}
		// select target forum section
		else if ($accept_action == 'move')
		{
			$tpl->enter('move_');

			foreach ($set as $page_id)
			{
				$accept_text[] = '<code>' . $this->get_page_title('', $page_id) . '</code>';
			}

			$sections = $this->db->load_all(
				"SELECT p.tag, p.title " .
				"FROM " . $prefix . "page AS p, " .
						  $prefix . "acl AS a " .
				"WHERE p.page_id = a.page_id " .
					"AND a.privilege = 'comment' " .
					"AND a.list = '' " .
					"AND p.tag LIKE " . $this->db->q($this->db->forum_cluster . '/%') . " " .
				"ORDER BY modified ASC", true);

			foreach ($sections as $section)
			{
				$tpl->o_tag		= $section['tag'];
				$tpl->o_title	= $section['title'];
			}

			$tpl->action	= $accept_action;
			$tpl->e_text	= $error;
			$tpl->text		= implode('<br>', $accept_text);

			$tpl->leave();	// move_
		}
		// enter a new name for the renamed topic
		else if ($accept_action == 'rename')
		{
			$tpl->enter('rename_');

			$tpl->action	= $accept_action;
			$tpl->e_text	= $error;
			$tpl->title		= $this->get_page_title('', $set[0]);
			$tpl->onlyone	= count($set) > 1;

			$tpl->leave();	// rename_
		}
		// select base for merging topics
		else if ($accept_action == 'merge')
		{
			$tpl->enter('merge_');

			$i = 0;

			foreach ($set as $page_id)
			{
				$options[$i]['accept_text']	= '«' . $this->get_page_title('', $page_id) . '»';
				$options[$i]['tag']			= $this->get_page_tag($page_id);
				$i++;
			}

			foreach ($options as $option)
			{
				$tpl->o_tag		= $option['tag'];
				$tpl->o_topic	= $option['accept_text'];

				$accept_text[]	= $option['accept_text'];
			}

			$tpl->action	= $accept_action;
			$tpl->e_text	= $error;
			$tpl->text		= implode('<br>', $accept_text);

			$tpl->leave();	// merge_
		}

		$tpl->hids		= implode('-', $set);
		$tpl->p			= (int) ($_GET['p'] ?? '');
		$tpl->set_ids	= implode(', ', $set);

		// print moderation controls...

		$tpl->enter('n_');

		// ...and topics list itself
		foreach ($topics as $n => $topic)
		{
			if ($this->has_access('read', $topic['page_id']))
			{
				$tpl->n			= $n;
				$tpl->pageid	= $topic['page_id'];
				$tpl->created	= $topic['created'];
				$tpl->comments	= $topic['comments'];
				$tpl->user		= $this->user_link($topic['owner_name'], true, false);
				$tpl->ip		= $this->is_admin() ? $topic['ip'] : '';

				if ($this->has_access('comment', $topic['page_id'], $this->db->default_comment_acl) === false)
				{
					$tpl->locked	= true;
				}

				$tpl->set		= in_array($topic['page_id'], $set);
				$tpl->moderate	= $this->compose_link_to_page($topic['tag'], 'moderate', $topic['title']);
				$tpl->topic		= $this->compose_link_to_page($topic['tag'], '', '&lt;#&gt;');
			}
		}

		$tpl->leave();	// n_
		$tpl->leave();	// subforum_
	}
	////// END SUBFORUM MODERATION //////
	////// BEGIN PAGE/TOPIC MODERATION //////
	else
	{
		$tpl->enter('forum_');

		// number of posts to display per page
		$limit = 60;

		// PROCESS INPUT
		// delete topic
		if (isset($_POST['topic_delete']))
		{
			$accept_action	= 'topic_delete';

			// actually remove topics
			if (isset($_POST['accept']))
			{
				$this->log(1, Ut::perc_replace($this->_t('LogRemovedPage', SYSTEM_LANG), $this->page['tag'], $this->page['user_id']));
				$moderate_delete_page($this->tag);
				unset($accept_action);

				$write_comment_feed();

				$this->set_message($this->_t('ModerateTopicDeleted'), 'success');
				$this->http->redirect($this->href('moderate', mb_substr($this->tag, 0, mb_strrpos($this->tag, '/'))));
			}
		}
		// move topic elsewhere
		else if (isset($_POST['topic_move']))
		{
			$accept_action	= 'topic_move';
			$cluster		= $_POST['cluster'] ?? '';
			$this->sanitize_page_tag($cluster);
			$section		= $_POST['section'] ?? '';
			$this->sanitize_page_tag($section);

			// processing...
			if (isset($_POST['accept']) && ($section || $cluster))
			{
				$pos		= mb_strrpos($this->tag, '/');
				$sub_tag	= mb_substr($this->tag, ($pos ? $pos + 1 : 0));
				$old_tag	= $this->tag;
				$new_tag	= ($cluster
								? ($cluster == '/'
									? ''
									: utf8_trim($cluster, '/') . '/'
									)
								: $section . '/'
								) . $sub_tag;

				if ($forum_cluster)
				{
					if (!empty($cluster) && $cluster != '/')
					{
						if ($moderate_page_exists($cluster) === false)
						{
							$error = $this->_t('ModerateMoveNotExists') . ' <code>' . Ut::html($cluster) . '</code>';
						}
					}
					else if (!empty($section))
					{
						if ($moderate_page_exists($new_tag) === true)
						{
							$error = '<span class="underline">«' . $this->page['title'] . '»</span>';
						}
					}
				}
				else if ($cluster != '/')
				{
					if ($moderate_page_exists($cluster) === false)
					{
						$error = $this->_t('ModerateMoveNotExists');
					}
				}

				// in case no errors, move...
				if ($error)
				{
					if ($forum_cluster && $section)
					{
						$error = Ut::perc_replace($this->_t('ModerateMoveExists'), $error);
					}
				}
				else
				{
					$moderate_rename_topic($old_tag, $new_tag);
					$this->log(3, Ut::perc_replace($this->_t('LogRenamedPage', SYSTEM_LANG), $old_tag, $new_tag));
					unset($accept_action);

					$write_comment_feed();

					$this->set_message($this->_t('ModeratePageMoved'), 'success');
					$this->http->redirect($this->href('moderate', $new_tag));
				}
			}
		}
		// rename topic
		else if (isset($_POST['topic_rename']))
		{
			$accept_action	= 'topic_rename';

			// perform accepted rename
			if (isset($_POST['accept']) && $forum_cluster)
			{
				$pos		= mb_strrpos($this->tag, '/');
				$section	= mb_substr($this->tag, 0, ($pos ?: null));
				$tag		= utf8_trim($_POST['new_tag'], " \t");
				$title		= $tag;
				$this->sanitize_page_tag($tag);
				$tag 		= utf8_ucwords($tag);
				$tag		= preg_replace('/[^- \\w]/u', '', $tag);
				$tag		= str_replace([' ', "\t"], '', $tag);
				$old_tag	= $this->tag;
				$new_tag	= ($section ? $section . '/' : '') . $tag;

				// check new tag existence
				if ($old_tag == $new_tag || $moderate_page_exists($new_tag) === true)
				{
					$error = $this->_t('ModerateRenameExists');
				}

				// ok, then rename page
				if ($tag != '' && !$error)
				{
					$moderate_rename_topic($old_tag, $new_tag, $title);
					$this->log(3, Ut::perc_replace($this->_t('LogRenamedPage', SYSTEM_LANG), $old_tag, $new_tag . ' ' . $title));
					unset($accept_action);

					$write_comment_feed();

					$this->set_message($this->_t('ModerateTopicRenamed'), 'success');
					$this->http->redirect($this->href('moderate', $new_tag));
				}
			}
		}
		// lock topic
		else if (isset($_POST['topic_lock']) && $forum_cluster)
		{
			// DON'T USE BLANK PRIVILEGE LIST!!! Only "negative all" - '!*'
			$this->save_acl($this->page['page_id'], 'comment', '!*');

			// purge SQL queries cache
			$this->db->invalidate_sql_cache();

			$this->log(2, Ut::perc_replace($this->_t('LogTopicLocked', SYSTEM_LANG), $this->page['tag'] . ' ' . $this->page['title']));
			$this->set_message($this->_t('ModerateTopicBlocked'), 'success');
			$this->http->redirect($this->href('moderate'));
		}
		// unlock topic
		else if (isset($_POST['topic_unlock']) && $forum_cluster)
		{
			$this->save_acl($this->page['page_id'], 'comment', $this->db->default_comment_acl);

			// purge SQL queries cache
			$this->db->invalidate_sql_cache();

			$this->log(2, Ut::perc_replace($this->_t('LogTopicUnlocked', SYSTEM_LANG), $this->page['tag'] . ' ' . $this->page['title']));
			$this->set_message($this->_t('ModerateTopicUnlocked'), 'success');
			$this->http->redirect($this->href('moderate'));
		}
		// delete selected comments
		else if (isset($_POST['posts_delete']) && $set)
		{
			$accept_action	= 'posts_delete';

			// actually remove topics
			if (isset($_POST['accept']))
			{
				if (!array_filter($set))
				{
					$error = $this->_t('ModerateNoItemChosen');
				}

				if (!$error)
				{
					foreach ($set as $page_id)
					{
						$page = $this->load_page('', $page_id, null, LOAD_NOCACHE, LOAD_META);
						$moderate_delete_page($page['tag']);
						$this->log(1, Ut::perc_replace($this->_t('LogRemovedComment', SYSTEM_LANG),
								$this->get_page_tag($page['comment_on_id']) . ' ' . $this->get_page_title('', $page['comment_on_id']),
								$page['user_name'],
								$this->sql_time_formatted($page['created'])));
					}

					// recount comments for current topic
					$this->db->sql_query(
						"UPDATE " . $prefix . "page SET " .
							"comments	= " . (int) $this->count_comments($this->page['page_id']) . ", " .
							"commented	= UTC_TIMESTAMP() " .
						"WHERE page_id = " . (int) $this->page['page_id'] . " " .
						"LIMIT 1");

					unset($accept_action);

					$write_comment_feed();

					$set = [];
					$this->set_message($this->_t('ModerateCommentsDeleted'), 'success');
					$this->http->redirect($this->href('moderate'));
				}
			}
		}
		// split topic
		else if (isset($_POST['posts_split']) && $set)
		{
			$accept_action	= 'posts_split';

			// perform accepted splitting
			if (isset($_POST['accept']) && isset($_POST['new_tag']))
			{
				$section	= mb_substr($this->tag, 0, mb_strrpos($this->tag, '/'));
				$old_tag	= $this->tag;
				$tag		= utf8_trim($_POST['new_tag'], "/ \t");
				$title		= $tag;
				$this->sanitize_page_tag($tag);
				$page_id	= $this->get_page_id($tag);
				$tag		= utf8_ucwords($tag);
				$tag		= preg_replace('/[^- \\w]/u', '', $tag);
				$tag		= str_replace([' ', "\t"], '', $tag);

				if ($forum_cluster)
				{
					// check new tag existence
					if ($old_tag != $section . '/' . $tag
						&& $moderate_page_exists($section . '/' . $tag) === true)
					{
						$error = $this->_t('ModerateRenameExists');
					}
				}
				else
				{
					// check desired target tag existence
					if ($moderate_page_exists($title) === false)
					{
						$error = $this->_t('ModerateMoveNotExists');
					}
					else if (!array_filter($set))
					{
						$error = $this->_t('ModerateNoItemChosen');
					}
				}

				// split topic or move comments
				if ($tag != '' && !$error)
				{
					// get comments ids according to the splitting scheme
					if (isset($_POST['scheme']) && $_POST['scheme'] == 'selected')
					{
						$comment_ids = $set;
					}
					else if (isset($_POST['scheme']) && $_POST['scheme'] == 'after')
					{
						$_set = $set;
						sort($_set);

						$first_comment	= $this->load_page('', $_set[0]);
						$_comments		= $this->db->load_all(
							"SELECT page_id " .
							"FROM " . $prefix . "page " .
							"WHERE comment_on_id = " . (int) $first_comment['comment_on_id'] . " " .
								"AND comment_on_id <> 0 " .
								"AND created >= " . $this->db->q($first_comment['created']) . " " .
							"ORDER BY created ASC");

						// debug Bug #401
						# Ut::debug_print_r($set);

						foreach ($_comments as $_comment)
						{
							$comment_ids[] = $_comment['page_id'];
						}

						unset($first_comment, $_set, $_comments, $_comment);
					}

					if ($forum_cluster)
					{
						if ($moderate_split_topic($comment_ids, $old_tag, $section . '/' . $tag, $title) === true)
						{
							$this->log(3, Ut::perc_replace($this->_t('LogSplittedPage', SYSTEM_LANG),
									$this->tag . ' ' . $this->page['title'],
									$section . '/' . $tag . ' ' . $title));
							unset($accept_action);

							$write_comment_feed();

							$this->set_message($this->_t('ModerateCommentsSplited'), 'success');
							$this->http->redirect($this->href('moderate', $section . '/' . $tag));
						}
						else
						{
							$this->set_message($this->_t('ModerateCommentsSplitFailed'), 'error');
							$this->log(2, Ut::perc_replace($this->_t('LogErrorSplitComments', SYSTEM_LANG), $this->tag, $section . '/' . $tag));
						}
					}
					else
					{
						// update acl
						// Give comments the same read rights as their parent page
						$read_acl		= $this->load_acl($page_id, 'read');
						$read_acl		= $read_acl['list'];
						$write_acl		= ''; // allow owner
						$comment_acl	= '';
						$create_acl		= '';
						$upload_acl		= '';

						// move
						$this->db->sql_query(
							"UPDATE " . $prefix . "page SET " .
								"comment_on_id = " . (int) $page_id . " " .
							"WHERE page_id IN (" . $this->ids_string($comment_ids) . ")");

						// update page_link table
						$comments = $this->db->load_all(
							"SELECT page_id, tag, body_r " .
							"FROM " . $prefix . "page " .
							"WHERE page_id IN (" . $this->ids_string($comment_ids) . ")");

						foreach ($comments as $comment)
						{
							$this->context[++$this->current_context] = $comment['tag'];
							$this->update_link_table($comment['page_id'], $comment['body_r']);
							$this->current_context--;

							// saving acls
							$this->save_acl($comment['page_id'], 'write',	$write_acl);
							$this->save_acl($comment['page_id'], 'read',	$read_acl);
							$this->save_acl($comment['page_id'], 'comment',	$comment_acl);
							$this->save_acl($comment['page_id'], 'create',	$create_acl);
							$this->save_acl($comment['page_id'], 'upload',	$upload_acl);
						}

						// recount comments for the old and new page
						$this->db->sql_query(
							"UPDATE " . $prefix . "page SET " .
								"comments = " . (int) $this->count_comments($this->page['page_id']) . " " .
							"WHERE page_id = " . (int) $this->page['page_id'] . " " .
							"LIMIT 1");

						$this->db->sql_query(
							"UPDATE " . $prefix . "page SET " .
								"comments	= " . (int) $this->count_comments($page_id) . ", " .
								"commented	= UTC_TIMESTAMP() " .
							"WHERE page_id = " . (int) $page_id . " " .
							"LIMIT 1");

						$this->log(3, Ut::perc_replace($this->_t('LogSplittedPage', SYSTEM_LANG),
								$this->tag . ' ' . $this->page['title'],
								$title . ' ' . $this->get_page_title($title)));
						unset($accept_action);

						$write_comment_feed();

						$this->set_message($this->_t('ModerateCommentsMoved'), 'success');
						$this->http->redirect($this->href('moderate'));
					}
				}
			}
		}

		// GET POSTS

		$selector =
			"WHERE p.comment_on_id = " . (int) $this->page['page_id'] . " " .
				"AND p.deleted <> 1 ";

		// make counter query
		$sql =
			"SELECT COUNT(p.page_id) AS n " .
			"FROM " . $prefix . "page p " .
			$selector .
			"LIMIT 1";

		// count posts and make pagination
		$count		= $this->db->load_single($sql);
		$pagination	= $this->pagination($count['n'], $limit, 'p', ['ids' => implode('-', $set)], 'moderate');

		// make collector query
		$sql =
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.user_id, p.owner_id, ip, LEFT(body, 500) AS body, p.created, p.page_lang, u.user_name, o.user_name as owner_name " .
			"FROM " . $prefix . "page p " .
				"LEFT JOIN " . $prefix . "user u ON (p.user_id = u.user_id) " .
				"LEFT JOIN " . $prefix . "user o ON (p.owner_id = o.user_id) " .
			$selector .
			"ORDER BY created ASC " .
			$pagination['limit'];

		// load comments data
		$comments = $this->db->load_all($sql);

		foreach ($comments as $page)
		{
			$this->cache_page($page, true);
			$this->page_id_cache[$page['tag']] = $page['page_id'];
		}

		$body = $this->format($this->page['body'], 'cleanwacko');
		$body = (mb_strlen($body) > 300 ? mb_substr($body, 0, 300) . '[...]' : $body);
		$body = Ut::html($body);

		// display list
		$tpl->pagination_text = $pagination['text'];

		// confirm topic deletion
		if ($accept_action == 'topic_delete')
		{
			$tpl->enter('delete_');

			$tpl->action	= $accept_action;
			$tpl->text		= '<code>' . $this->page['title'] . '</code>';

			$tpl->leave();
		}
		// select target forum section / cluster for topic/page moving
		else if ($accept_action == 'topic_move')
		{
			$tpl->enter('move_');

			if ($forum_cluster)
			{
				$tpl->enter('forum_');

				$tpl->action	= $accept_action;
				$tpl->e_text	= $error;
				$tpl->text		= '<code>' . $this->page['title'] . '</code>';

				$sections = $this->db->load_all(
					"SELECT p.tag, p.title " .
					"FROM " . $prefix . "page AS p, " .
							  $prefix . "acl AS a " .
					"WHERE p.page_id = a.page_id " .
						"AND a.privilege = 'comment' " .
						"AND a.list = '' " .
						"AND p.tag LIKE " . $this->db->q($this->db->forum_cluster . '/%') . " " .
					"ORDER BY modified ASC", true);

				foreach ($sections as $section)
				{
					$tpl->o_tag		= $section['tag'];
					$tpl->o_title	= $section['title'];
				}

				$tpl->leave();
			}
			else
			{
				$tpl->enter('page_');

				$tpl->action	= $accept_action;
				$tpl->e_text	= $error;
				$tpl->text		= '<code>' . $this->page['title'] . '</code>';

				$tpl->leave();
			}

			$tpl->leave();
		}
		// enter a new name for topic renaming
		else if ($accept_action == 'topic_rename')
		{
			$tpl->enter('rename_');

			$tpl->action	= $accept_action;
			$tpl->e_text	= $error;
			$tpl->title		= $this->page['title'];

			$tpl->leave();
		}
		// confirm comments deletion
		else if ($accept_action == 'posts_delete')
		{
			$tpl->enter('pdelete_');

			$tpl->action	= $accept_action;
			$tpl->e_text	= $error;
			$tpl->confirm	= Ut::perc_replace(
					$this->_t('ModerateComDelConfirm'),
					count($set),
					(count($set) > 1
						? $this->_t('ModerateComments')
						: $this->_t('ModerateComment') ));

			$tpl->leave();
		}
		// enter a new name for the detached topic
		else if ($accept_action == 'posts_split')
		{
			$tpl->enter('psplit_');

			$tpl->action	= $accept_action;
			$tpl->e_text	= $error;
			$tpl->split		= $forum_cluster
								? $this->_t('ModerateSplitNewName')
								: $this->_t('ModerateSplitPageName');
			$tpl->after		= (isset($_POST['scheme']) && $_POST['scheme'] != 'selected');
			$tpl->selected	= (isset($_POST['scheme']) && $_POST['scheme'] == 'selected');
			$tpl->count		= Ut::perc_replace($this->_t('ModerateSplitSelected'), count($set));

			$tpl->leave();
		}

		$tpl->forum		= $forum_cluster;
		$tpl->hids		= implode('-', $set);
		$tpl->p			= (int) ($_GET['p'] ?? '');
		$tpl->body		= $body;

		if ($forum_cluster)
		{
			if ($this->has_access('comment', $this->page['page_id'], $this->db->default_comment_acl) === true)
			{
				$tpl->forum_unlocked	= true;
			}
			else
			{
				$tpl->forum_locked		= true;
			}
		}

		if ($this->has_access('comment', $this->page['page_id'], $this->db->default_comment_acl) === false)
		{
			$tpl->locked		= true;
		}

		$_user			= $forum_cluster ? $this->page['user_name'] : $this->page['owner_name'];
		$tpl->user		= $this->user_link($_user, true, false);
		$tpl->created	= $this->page['created'];

		if ($comments)
		{
			$tpl->enter('comments_');

			$tpl->set_ids	= implode(', ', $set);

			$tpl->enter('n_');

			// ...and comments list
			foreach ($comments as $n => $comment)
			{
				$desc = $this->format($comment['body'], 'cleanwacko');
				$desc = (mb_strlen($desc) > 300 ? mb_substr($desc, 0, 300) . '[...]' : $desc);
				$desc = Ut::html($desc);

				$tpl->n			= $n;
				$tpl->comment	= $comment;
				$tpl->desc		= $desc;
				$tpl->ip		= $this->is_admin() ? $comment['ip'] : '';
				$tpl->clink		= $this->compose_link_to_page($comment['tag'], '', $comment['title']);
				$tpl->ulink		= $this->user_link($comment['owner_name'], true, false);
				$tpl->set		= in_array($comment['page_id'], $set);
			}

			$tpl->leave();	// n_
			$tpl->leave();	// comments_
		}

		$tpl->leave();	// forum_
	}
}
else
{
	$this->set_message($this->_t('NotModerator'));
	$this->http->redirect($this->href());
}

// set forum context
if ($forum_cluster)
{
	$this->forum = true;
}
