<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// TODO: purge old SQL query cache

$tpl->title = ($this->forum
	? $this->_t('ForumTopic')
	: $this->_t('ModerateSection') ) . ' ' . $this->compose_link_to_page($this->tag, '', $this->page['title']);

$tpl->moderate =  ($this->forum
	? $this->compose_link_to_page(mb_substr($this->tag, 0, mb_strrpos($this->tag, '/')), 'moderate', '« ' . $this->_t('ModerateSection2')) . '<br><br>'
	: '');

// local functions
function moderate_page_exists(&$engine, $tag)
{
	if ($engine->db->load_single(
		"SELECT page_id " .
		"FROM " . $engine->db->table_prefix . "page " .
		"WHERE tag = " . $engine->db->q($tag) . " " .
		"LIMIT 1"))
	{
		return true;
	}
	else
	{
		return false;
	}
}

// applicable for both topics and comments
function moderate_delete_page(&$engine, $tag)
{
	if (!$tag)
	{
		return false;
	}

	$engine->remove_referrers($tag);
	$engine->remove_links($tag);
	$engine->remove_acls($tag);
	$engine->remove_watches($tag);
	$engine->remove_page_categories($tag);
	$engine->remove_comments($tag);
	$engine->remove_files_perpage($tag);
	$engine->remove_page($engine->get_page_id($tag));

	return true;
}

function moderate_rename_topic(&$engine, $old_tag, $new_tag, $title = '')
{
	// set forum context
	$forum_context	= $engine->forum;
	$engine->forum	= true;

	$tag = $new_tag;

	$engine->rename_page($old_tag, $new_tag, $tag);
	$engine->remove_referrers($old_tag);
	$engine->remove_links($old_tag);
	$engine->clear_cache_wanted_page($new_tag);
	$engine->clear_cache_wanted_page($tag);

	// rerender page and update page_link table in new context
	$page = $engine->load_page($new_tag);
	$engine->current_context++;
	$engine->context[$engine->current_context] = $new_tag;
	$engine->update_link_table($page['page_id'], $page['body_r']);
	$engine->current_context--;

	// update title in meta and body if needed
	if ($title != '')
	{
		// resave modified page
		$engine->save_page($new_tag, $page['body'], $title, '', '', '', '', '', '', true, false);
	}

	// restore forum context
	$engine->forum = $forum_context;

	return true;
}

function moderate_merge_topics(&$engine, $base, $topics, $move_topics = true)
{
	// set forum context
	$forum_context	= $engine->forum;
	$engine->forum	= true;

	if (!$topics || !$base)
	{
		return false;
	}

	$base_id = $engine->get_page_id($base);

	foreach ($topics as $topic)
	{
		// we don't really want to touch the base topic
		if ($topic != $base)
		{
			$topic_id = $engine->get_page_id($topic);

			// move comments to the base topic
			$engine->db->sql_query(
				"UPDATE " . $engine->db->table_prefix . "page SET " .
					"comment_on_id = " . (int) $base_id . " " .
				"WHERE comment_on_id = " . (int) $topic_id);

			// for the forum moderation only
			if ($move_topics === true)
			{
				// find latest number
				$status	= $engine->db->load_all("SHOW TABLE STATUS");

				foreach ($status as $row)
				{
					if ($row['Name'] == $engine->db->table_prefix . 'page')
					{
						$num = $row['Auto_increment'];
					}
				}

				// resave topic body as comment
				$page = $engine->load_page($topic);

				$engine->save_page('Comment' . $num, $page['body'], $page['title'], '', '', '', $base_id, '', '', true);

				// restore creation date
				$engine->db->sql_query(
					"UPDATE " . $engine->db->table_prefix . "page SET " .
						"modified		= " . $engine->db->q($page['modified']) . ", " .
						"created		= " . $engine->db->q($page['created']) . ", " .
						"commented		= " . $engine->db->q($page['commented']) . ", " .
						"owner_id		= " . (int) $page['owner_id'] . ", " .
						"user_id		= " . (int) $page['user_id'] . ", " .
						"ip				= " . $engine->db->q($page['ip']) . " " .
					"WHERE tag = " . $engine->db->q('Comment' . $num));

				// remove old page remnants
				moderate_delete_page($engine, $topic);
			}
		}
	}

	// update acl
	// Give comments the same read rights as their parent page
	$read_acl		= $engine->load_acl($base_id, 'read');
	$read_acl		= $read_acl['list'];
	$write_acl		= '';
	$comment_acl	= '';
	$create_acl		= '';
	$upload_acl		= '';

	// update page_link table
	$comments = $engine->db->load_all(
		"SELECT page_id, tag, body_r " .
		"FROM " . $engine->db->table_prefix . "page " .
		"WHERE comment_on_id = " . (int) $base_id);

	foreach ($comments as $comment)
	{
		$engine->context[++$engine->current_context] = $comment['tag'];
		$engine->update_link_table($comment['page_id'], $comment['body_r']);
		$engine->current_context--;

		// saving acls
		$engine->save_acl($comment['page_id'], 'write',		$write_acl);
		$engine->save_acl($comment['page_id'], 'read',		$read_acl);
		$engine->save_acl($comment['page_id'], 'comment',	$comment_acl);
		$engine->save_acl($comment['page_id'], 'create',	$create_acl);
		$engine->save_acl($comment['page_id'], 'upload',	$upload_acl);
	}

	// recount comments for the base topic
	$engine->db->sql_query(
		"UPDATE " . $engine->db->table_prefix . "page SET " .
			"comments	= " . (int) $engine->count_comments($base_id) . ", " .
			"commented	= UTC_TIMESTAMP() " .
		"WHERE page_id = " . (int) $base_id . " " .
		"LIMIT 1");

	// restore forum context
	$engine->forum = $forum_context;

	return true;
}

function moderate_split_topic(&$engine, $comment_ids, $old_tag, $new_tag, $title)
{
	if (is_array($comment_ids) === false)
	{
		return false;
	}

	$old_page_id	= $engine->get_page_id($old_tag);

	// set forum context
	$forum_context	= $engine->forum;
	$engine->forum	= true;

	// resave first comment as new topic page
	$first_page_id	= array_shift($comment_ids);
	$page			= $engine->load_page('', $first_page_id);

	// temporary unset page context
	$old_page = $engine->page;
	unset($engine->page);

	// TODO: build title
	$title = $page['title'];

	// TODO: pass user, else save_page might fail due missing write privilege
	// resave modified body
	$engine->save_page($new_tag, $page['body'], $title, '', '', '', 0, '', '', true);

	// set page context back
	$engine->page	= $old_page;

	$new_page_id	= $engine->get_page_id($new_tag);

	// bug-resistent check: has page been really resaved?
	if (!$new_page_id)
	{
		$engine->forum = $forum_context;
		return false;
	}

	// update acl
	// Give comments the same read rights as their parent page
	$read_acl		= $engine->load_acl($new_page_id, 'read');
	$read_acl		= $read_acl['list'];
	$write_acl		= '';
	$comment_acl	= '';
	$create_acl		= '';
	$upload_acl		= '';

	// restore original metadata
	$engine->db->sql_query(
		"UPDATE " . $engine->db->table_prefix . "page SET " .
			"modified		= " . $engine->db->q($page['modified']) . ", " .
			"created		= " . $engine->db->q($page['created']) . ", " .
			"owner_id		= " . (int) $page['owner_id'] . ", " .
			"user_id		= " . (int) $page['user_id'] . ", " .
			"ip				= " . $engine->db->q($page['ip']) . " " .
		"WHERE page_id = " . (int) $new_page_id);

	// move remaining comments to the new topic
	foreach ($comment_ids as $comment_id)
	{
		$engine->db->sql_query(
			"UPDATE " . $engine->db->table_prefix . "page SET " .
				"comment_on_id = " . (int) $new_page_id . " " .
			"WHERE page_id = " . (int) $comment_id);

		// saving acls
		$engine->save_acl($comment_id, 'write',		$write_acl);
		$engine->save_acl($comment_id, 'read',		$read_acl);
		$engine->save_acl($comment_id, 'comment',	$comment_acl);
		$engine->save_acl($comment_id, 'create',	$create_acl);
		$engine->save_acl($comment_id, 'upload',	$upload_acl);
	}

	// remove old first comment
	moderate_delete_page($engine, $page['tag']);

	// update page_link table
	$page = $engine->load_page('', $new_page_id);
	$engine->current_context++;
	$engine->context[$engine->current_context] = $new_tag;
	$engine->update_link_table($page['page_id'], $page['body_r']);
	$engine->current_context--;

	// recount comments for old and new topics
	$engine->db->sql_query(
		"UPDATE " . $engine->db->table_prefix . "page SET " .
			"comments	= " . (int) $engine->count_comments($new_page_id) . ", " .
			"commented	= UTC_TIMESTAMP() " .
		"WHERE page_id = " . (int) $new_page_id . " " .
		"LIMIT 1");

	$engine->db->sql_query(
		"UPDATE " . $engine->db->table_prefix . "page SET " .
			"comments = " . (int) $engine->count_comments($old_page_id) . " " .
		"WHERE page_id = " . (int) $old_page_id . " " .
		"LIMIT 1");

	// restore forum context
	$engine->forum = $forum_context;

	return true;
}

// END FUNCTIONS

// redirect to show method if page doesn't exists
if (!$this->page || $this->page['comment_on_id'])
{
	$this->http->redirect($this->href());
}

$forum_cluster = '';

if (($this->is_moderator() && $this->has_access('read')) || $this->is_admin())
{
	$accept_action	= '';
	$error			= null;

	if (mb_substr($this->tag, 0, mb_strlen($this->db->forum_cluster)) == $this->db->forum_cluster)
	{
		$forum_cluster = true;
	}
	else
	{
		$forum_cluster = false;
	}

	// simple and rude input sanitization
	foreach ($_POST as $key => $val)
	{
		$_POST[$key] = Ut::html($val);
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
	foreach ($_POST as $val => $key)
	{
		if ($key == 'id' && !in_array($val, $set) && !empty($val))
		{
			$set[] = (int) $val;
		}
	}

	unset($key, $val);

	// save page ids for later operations (correct if needed)
	if (isset($_POST['set']))
	{
		$set = [];

		foreach ($_POST as $val => $key)
		{
			if ($key == 'id'  && !empty($val))
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

	reset($set);
	unset($n, $page_id);

	// creating rss object
	$xml = new Feed($this);

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
					$page = $this->load_page('', $page_id, '', LOAD_NOCACHE, LOAD_META);
					moderate_delete_page($this, $page['tag']);
					$this->log(1, Ut::perc_replace($this->_t('LogRemovedPage', SYSTEM_LANG), $page['tag'], $page['user_id']));
				}

				unset($accept_action);

				if ($this->db->enable_feeds)
				{
					$xml->comments();
				}

				$set = [];
				$this->set_message($this->_t('ModerateTopicsDeleted'), 'success');
				$this->http->redirect($this->href('moderate'));
			}
		}
		// move selected topics elsewhere
		else if (isset($_POST['move']) && $set)
		{
			$accept_action	= 'move';

			// processing...
			if (isset($_POST['accept']) && isset($_POST['section']))
			{
				$i = 0;

				foreach ($set as $page_id)
				{
					$old_tags[] = $this->get_page_tag($page_id);
					$new_tags[] = $_POST['section'] . mb_substr($old_tags[$i], mb_strrpos($old_tags[$i], '/'));

					if (moderate_page_exists($this, $new_tags[$i++]) === true)
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
						moderate_rename_topic($this, $old_tags[$i], $new_tags[$i]);
						$this->log(3, Ut::perc_replace($this->_t('LogRenamedPage', SYSTEM_LANG), $old_tags[$i], $new_tags[$i]));
						$i++;
					}

					unset($accept_action, $i, $old_tags, $new_tags);

					if ($this->db->enable_feeds)
					{
						$xml->comments();
					}

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
				$tag 		= utf8_ucwords($tag);
				$tag		= preg_replace('/[^- \\w]/u', '', $tag);
				$tag		= str_replace([' ', "\t"], '', $tag);

				// check new tag existence
				if ($old_tag != $this->tag . '/' . $tag
					&& moderate_page_exists($this, $this->tag . '/' . $tag) === true)
				{
					$error = $this->_t('ModerateRenameExists');
				}

				// ok, then rename page
				if ($tag != '' && !$error)
				{
					moderate_rename_topic($this, $old_tag, $this->tag . '/' . $tag, $title);
					$this->log(3, Ut::perc_replace($this->_t('LogRenamedPage', SYSTEM_LANG), $old_tag, $this->tag . '/' . $tag . ' ' . $title));
					unset($accept_action, $old_tag, $tag, $title);

					if ($this->db->enable_feeds)
					{
						$xml->comments();
					}

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

			if (count($set) < 2)
			{
				$error = $this->_t('ModerateMerge2Min');
			}

			// perform accepted action
			if (isset($_POST['accept']) && isset($_POST['base']) && !$error)
			{
				foreach ($set as $page_id)
				{
					$topics[] = $this->get_page_tag($page_id);
				}

				moderate_merge_topics($this, $_POST['base'], $topics);
				$this->log(3, Ut::perc_replace($this->_t('LogMergedPages', SYSTEM_LANG),
							'##' . implode('##, ##', $topics) . '##', $_POST['base']));

				unset($accept_action, $topics);

				if ($this->db->enable_feeds)
				{
					$xml->comments();
				}

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
				$page = $this->load_page('', $page_id, '', LOAD_NOCACHE, LOAD_META);
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
				$page = $this->load_page('', $page_id, '', LOAD_NOCACHE, LOAD_META);
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
			"FROM " . $this->db->table_prefix . "page AS p, " .
					  $this->db->table_prefix . "acl AS a " .
			$selector .
			"LIMIT 1";

		// count topics and make pagination
		$count		= $this->db->load_single($sql);
		$pagination	= $this->pagination($count['n'], $limit, 'p', ['ids' => implode('-', $set)], 'moderate');

		// make collector query
		$sql =
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.owner_id, p.user_id, p.ip, p.comments, p.created, p.page_lang, u.user_name, o.user_name as owner_name " .
			"FROM " . $this->db->table_prefix . "page AS p " .
				"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
				"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.owner_id = o.user_id), " .
				$this->db->table_prefix . "acl AS a " .
			$selector .
			"ORDER BY commented DESC " .
			$pagination['limit'];

		// FORMS

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
			foreach ($set as $page_id)
			{
				$accept_text[] = '<code>' . $this->get_page_title('', $page_id) . '</code>';
			}

			$tpl->action	= $accept_action;
			$tpl->text		= implode('<br>', $accept_text);
		}
		// select target forum section
		else if ($accept_action == 'move')
		{
			foreach ($set as $page_id)
			{
				$accept_text[] = '<code>' . $this->get_page_title('', $page_id) . '</code>';
			}

			$sections = $this->db->load_all(
				"SELECT p.tag, p.title " .
				"FROM " . $this->db->table_prefix . "page AS p, " .
						  $this->db->table_prefix . "acl AS a " .
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
		}
		// enter a new name for the renamed topic
		else if ($accept_action == 'rename')
		{
			$tpl->action	= $accept_action;
			$tpl->e_text	= $error;
			$tpl->title		= $this->get_page_title('', $set[0]);
			$tpl->onlyone	= count($set) > 1;
		}
		// select base for merging topics
		else if ($accept_action == 'merge')
		{
			$i = 0;

			foreach ($set as $page_id)
			{
				$options[$i]['accept_text']	= '«' . $this->get_page_title('', $page_id) . '»';
				$options[$i]['topic']		= $this->get_page_tag($page_id);
				$i++;
			}

			foreach ($options as $option)
			{
				$tpl->o_topic	= $option['topic'];
				$tpl->o_text	= $option['accept_text'];

				$accept_text[]	= $option['accept_text'];
			}

			$tpl->action	= $accept_action;
			$tpl->e_text	= $error;
			$tpl->text		= implode('<br>', $accept_text);
		}

		$tpl->hids		= implode('-', $set);
		$tpl->p			= (int) ($_GET['p'] ?? '');
		$tpl->set		= $set;
		$tpl->set_ids	= implode(', ', $set);


		// print moderation controls...

		$tpl->enter('n_');

		// ...and topics list itself
		foreach ($topics as $topic)
		{
			if ($this->has_access('read', $topic['page_id']))
			{
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
				moderate_delete_page($this, $this->tag);
				unset($accept_action);

				if ($this->db->enable_feeds)
				{
					$xml->comments();
				}

				$this->set_message($this->_t('ModerateTopicDeleted'), 'success');
				$this->http->redirect($this->href('moderate', mb_substr($this->tag, 0, mb_strrpos($this->tag, '/'))));
			}
		}
		// move topic elsewhere
		else if (isset($_POST['topic_move']))
		{
			$accept_action	= 'topic_move';

			// processing...
			if (isset($_POST['accept']) && (isset($_POST['section']) || isset($_POST['cluster'])))
			{
				$pos		= mb_strrpos($this->tag, '/');
				$sub_tag	= mb_substr($this->tag, ($pos ? $pos + 1 : 0));
				$old_tag	= $this->tag;
				$new_tag	= ($_POST['cluster']
								? ($_POST['cluster'] == '/'
									? ''
									: utf8_trim($_POST['cluster'], '/') . '/'
									)
								: $_POST['section'] . '/'
								) . $sub_tag;

				if ($forum_cluster)
				{
					if (!empty($_POST['cluster']) && $_POST['cluster'] != '/')
					{
						if (moderate_page_exists($this, $_POST['cluster']) === false)
						{
							$error = $this->_t('ModerateMoveNotExists') . ' <code>' . Ut::html($_POST['cluster']) . '</code>';
						}
					}
					else if (!empty($_POST['section']))
					{
						if (moderate_page_exists($this, $new_tag) === true)
						{
							$error = '<span class="underline">«' . $this->page['title'] . '»</span>';
						}
					}
				}
				else if ($_POST['cluster'] != '/')
				{
					if (moderate_page_exists($this, $_POST['cluster']) === false)
					{
						$error = $this->_t('ModerateMoveNotExists');
					}
				}

				// in case no errors, move...
				if ($error)
				{
					if ($forum_cluster && $_POST['section'])
					{
						$error = Ut::perc_replace($this->_t('ModerateMoveExists'), $error);
					}
				}
				else
				{
					moderate_rename_topic($this, $old_tag, $new_tag);
					$this->log(3, Ut::perc_replace($this->_t('LogRenamedPage', SYSTEM_LANG), $old_tag, $new_tag));
					unset($accept_action);

					if ($this->db->enable_feeds)
					{
						$xml->comments();
					}

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
				if ($old_tag == $new_tag || moderate_page_exists($this, $new_tag) === true)
				{
					$error = $this->_t('ModerateRenameExists');
				}

				// ok, then rename page
				if ($tag != '' && !$error)
				{
					moderate_rename_topic($this, $old_tag, $new_tag, $title);
					$this->log(3, Ut::perc_replace($this->_t('LogRenamedPage', SYSTEM_LANG), $old_tag, $new_tag . ' ' . $title));
					unset($accept_action);

					if ($this->db->enable_feeds)
					{
						$xml->comments();
					}

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
						$page = $this->load_page('', $page_id, '', LOAD_NOCACHE, LOAD_META);
						moderate_delete_page($this, $page['tag']);
						$this->log(1, Ut::perc_replace($this->_t('LogRemovedComment', SYSTEM_LANG),
								$this->get_page_tag($page['comment_on_id']) . ' ' . $this->get_page_title('', $page['comment_on_id']),
								$page['user_name'],
								$this->get_time_formatted($page['created'])));
					}

					// recount comments for current topic
					$this->db->sql_query(
						"UPDATE " . $this->db->table_prefix . "page SET " .
							"comments	= " . (int) $this->count_comments($this->page['page_id']) . ", " .
							"commented	= UTC_TIMESTAMP() " .
						"WHERE page_id = " . (int) $this->page['page_id'] . " " .
						"LIMIT 1");

					unset($accept_action);

					if ($this->db->enable_feeds)
					{
						$xml->comments();
					}

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
						&& moderate_page_exists($this, $section . '/' . $tag) === true)
					{
						$error = $this->_t('ModerateRenameExists');
					}
				}
				else
				{
					// check desired target tag existence
					if (moderate_page_exists($this, $title) === false)
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
							"FROM " . $this->db->table_prefix . "page " .
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
						if (moderate_split_topic($this, $comment_ids, $old_tag, $section . '/' . $tag, $title) === true)
						{
							$this->log(3, Ut::perc_replace($this->_t('LogSplittedPage', SYSTEM_LANG),
									$this->tag . ' ' . $this->page['title'],
									$section . '/' . $tag . ' ' . $title));
							unset($accept_action);

							if ($this->db->enable_feeds)
							{
								$xml->comments();
							}

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
							"UPDATE " . $this->db->table_prefix . "page SET " .
								"comment_on_id = " . (int) $page_id . " " .
							"WHERE page_id IN (" . $this->ids_string($comment_ids) . ")");

						// update page_link table
						$comments = $this->db->load_all(
							"SELECT page_id, tag, body_r " .
							"FROM " . $this->db->table_prefix . "page " .
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
							"UPDATE " . $this->db->table_prefix . "page SET " .
								"comments = " . (int) $this->count_comments($this->page['page_id']) . " " .
							"WHERE page_id = " . (int) $this->page['page_id'] . " " .
							"LIMIT 1");

						$this->db->sql_query(
							"UPDATE " . $this->db->table_prefix . "page SET " .
								"comments	= " . (int) $this->count_comments($page_id) . ", " .
								"commented	= UTC_TIMESTAMP() " .
							"WHERE page_id = " . (int) $page_id . " " .
							"LIMIT 1");

						$this->log(3, Ut::perc_replace($this->_t('LogSplittedPage', SYSTEM_LANG),
								$this->tag . ' ' . $this->page['title'],
								$title . ' ' . $this->get_page_title($title)));
						unset($accept_action);

						if ($this->db->enable_feeds)
						{
							$xml->comments();
						}

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
			"FROM " . $this->db->table_prefix . "page p " .
			$selector .
			"LIMIT 1";

		// count posts and make pagination
		$count		= $this->db->load_single($sql);
		$pagination	= $this->pagination($count['n'], $limit, 'p', ['ids' => implode('-', $set)], 'moderate');

		// make collector query
		$sql =
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.user_id, p.owner_id, ip, LEFT(body, 500) AS body, p.created, p.page_lang, u.user_name, o.user_name as owner_name " .
			"FROM " . $this->db->table_prefix . "page p " .
				"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
				"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.owner_id = o.user_id) " .
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
					"FROM " . $this->db->table_prefix . "page AS p, " .
							  $this->db->table_prefix . "acl AS a " .
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
			$tpl->confirm	= Ut::perc_replace($this->_t('ModerateComDelConfirm'), count($set), (count($set) > 1 ? $this->_t('ModerateComments') : $this->_t('ModerateComment') ));

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

		if ($forum_cluster && $this->has_access('comment', $this->page['page_id'], $this->db->default_comment_acl) === true)
		{
			$tpl->forum_unlocked	= true;
		}
		else
		{
			$tpl->forum_locked		= true;
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
			foreach ($comments as $comment)
			{
				$desc = $this->format($comment['body'], 'cleanwacko');
				$desc = (mb_strlen($desc) > 300 ? mb_substr($desc, 0, 300) . '[...]' : $desc);
				$desc = Ut::html($desc);

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
	$this->show_message($this->_t('NotModerator'));
}

// set forum context
if ($forum_cluster)
{
	$this->forum = true;
}
