<?php

if (!defined('IN_WACKO'))
{
	exit;
}

echo '<h3>';
echo $this->_t('Moderation') . ' ' . ($this->forum === true ? $this->_t('Topics') : $this->_t('ModerateSection') ) . ' ' . $this->compose_link_to_page($this->tag, '', $this->page['title']);
echo ($this->forum === true ? '<br>[' . $this->compose_link_to_page(substr($this->tag, 0, strrpos($this->tag, '/')), 'moderate', $this->_t('ModerateSection2')) . ']' : '');
echo "</h3>\n";

// local functions
function moderate_page_exists(&$engine, $tag)
{
	if ($page = $engine->db->load_single(
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
	$engine->remove_ratings($tag);
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

	$supertag = $engine->translit($new_tag);

	$engine->rename_page($old_tag, $new_tag, $supertag);
	$engine->remove_referrers($old_tag);
	$engine->remove_links($old_tag);
	$engine->clear_cache_wanted_page($new_tag);
	$engine->clear_cache_wanted_page($supertag);

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
		$engine->save_page($new_tag, $title, $page['body'], '', '', '', '', '', '', true, false);
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

	if ($topics == false || $base == false)
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

				$engine->save_page('Comment' . $num, $page['title'], $page['body'], '', '', '', $base_id, '', '', true);

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
	$engine->save_page($new_tag, $title, $page['body'], '', '', '', 0, '', '', true);

	// set page context back
	$engine->page	= $old_page;

	$new_page_id	= $engine->get_page_id($new_tag);

	// bug-resistent check: has page been really resaved?
	if ($new_page_id != true)
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
if (!$this->page || $this->page['comment_on_id'] == true)
{
	$this->http->redirect($this->href());
}

$forum_cluster = '';

if (($this->is_moderator() && $this->has_access('read')) || $this->is_admin())
{
	$accept_action	= '';
	$error			= '';

	if (substr($this->tag, 0, strlen($this->db->forum_cluster)) == $this->db->forum_cluster)
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
		$_POST[$key] = htmlspecialchars($val, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);
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
	if ($this->forum !== true && $forum_cluster === true)
	{
		// number of topics to display
		$limit = 40;

		// PROCESS INPUT
		// delete selected topic(s)
		if (isset($_POST['delete']) && $set == true)
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
		else if (isset($_POST['move']) && $set == true)
		{
			$accept_action	= 'move';

			// processing...
			if (isset($_POST['accept']) && isset($_POST['section']))
			{
				$i = 0;

				foreach ($set as $page_id)
				{
					$old_tags[] = $this->get_page_tag($page_id);
					$new_tags[] = $_POST['section'] . substr($old_tags[$i], strrpos($old_tags[$i], '/'));

					if (moderate_page_exists($this, $new_tags[$i++]) === true)
					{
						$error[] = '<span class="underline">&laquo;' . $this->get_page_title('', $page_id) . '&raquo;</span>';
					}
				}

				// in case no errors, move...
				if ($error == true)
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
		else if (isset($_POST['rename']) && $set == true)
		{
			$accept_action	= 'rename';

			// perform accepted rename
			if (isset($_POST['accept']))
			{
				$old_tag	= $this->get_page_tag($set[0]);
				$tag		= trim($_POST['new_tag'], " \t");
				$title		= $tag;
				$tag 		= ucwords($tag);
				$tag		= preg_replace('/[^- \\w]/', '', $tag);
				$tag		= str_replace([' ', "\t"], '', $tag);

				// check new tag existance
				if ($old_tag != $this->tag . '/' . $tag
					&& moderate_page_exists($this, $this->tag . '/' . $tag) === true)
				{
					$error = $this->_t('ModerateRenameExists');
				}

				// ok, then rename page
				if ($tag != '' && $error != true)
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
		else if (isset($_POST['merge']) && $set == true)
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
		else if (isset($_POST['lock']) && $set == true)
		{
			foreach ($set as $page_id)
			{
				$page = $this->load_page('', $page_id, '', LOAD_NOCACHE, LOAD_META);
				$this->log(2, Ut::perc_replace($this->_t('LogTopicLocked', SYSTEM_LANG), $page['tag'] . ' ' . $page['title']));
				// DON'T USE BLANK PRIVILEGE LIST!!! Only "negative all" - '!*'
				$this->save_acl($page_id, 'comment', '!*');
			}

			$set = [];
			$this->set_message($this->_t('ModerateTopicsBlocked'), 'success');
			$this->http->redirect($this->href('moderate'));
		}
		// unlock topics
		else if (isset($_POST['unlock']) && $set == true)
		{
			foreach ($set as $page_id)
			{
				$page = $this->load_page('', $page_id, '', LOAD_NOCACHE, LOAD_META);
				$this->log(2, Ut::perc_replace($this->_t('LogTopicUnlocked', SYSTEM_LANG), $page['tag'] . ' ' . $page['title']));
				$this->save_acl($page_id, 'comment', $this->db->default_comment_acl);
			}

			$set = [];
			$this->set_message($this->_t('ModerateTopicsUnlocked'), 'success');
			$this->http->redirect($this->href('moderate'));
		}

		// make counter query
		$sql =
			"SELECT COUNT(p.page_id) AS n " .
			"FROM " . $this->db->table_prefix . "page AS p, " .
					  $this->db->table_prefix . "acl AS a " .
			"WHERE p.page_id = a.page_id " .
				"AND a.privilege = 'create' AND a.list = '' " .
				"AND p.tag LIKE " . $this->db->q($this->tag . '/%') . " " .
			"LIMIT 1";

		// count topics and make pagination
		$count		= $this->db->load_single($sql);
		$pagination	= $this->pagination($count['n'], $limit, 'p', ['ids' => implode('-', $set)], 'moderate');

		// make collector query
		$sql =
			"SELECT p.page_id, p.tag, p.title, p.owner_id, p.user_id, p.ip, p.comments, p.created, u.user_name, o.user_name as owner_name " .
			"FROM " . $this->db->table_prefix . "page AS p " .
				"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
				"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.owner_id = o.user_id), " .
				"" . $this->db->table_prefix . "acl AS a " .
			"WHERE p.page_id = a.page_id " .
				"AND a.privilege = 'create' AND a.list = '' " .
				"AND p.tag LIKE " . $this->db->q($this->tag . '/%') . " " .
			"ORDER BY commented DESC " .
			$pagination['limit'];

		// FORMS

		// load topics data
		$topics	= $this->db->load_all($sql);

		// display list
		echo $this->form_open('moderate_subforum', ['page_method' => 'moderate']);

		$this->print_pagination($pagination);

		// confirm deletion
		if ($accept_action == 'delete')
		{
			foreach ($set as $page_id)
			{
				$accept_text[] = '<code>' . $this->get_page_title('', $page_id) . '</code>';
			}

			echo '<input type="hidden" name="' . $accept_action . '" value="1">' .
				'<table class="formation">' .
					'<tr><th>' . $this->_t('ModerateDeleteConfirm') . '</th></tr>' .
					'<tr><td>' .
						'<em>' . implode('<br>', $accept_text) . '</em><br>' .
						'<input type="submit" name="accept" id="submit" value="' . $this->_t('ModerateAccept') . '"> ' .
						'<a href="' . $this->href('moderate') . '" class="btn_link"><input type="button" name="cancel" id="button" value="' . $this->_t('ModerateDecline') . '"></a>' .
					'</td></tr>' .
				'</table><br>' . "\n";
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
					"AND a.privilege = 'comment' AND a.list = '' " .
					"AND p.tag LIKE " . $this->db->q($this->db->forum_cluster . '/%') . " " .
				"ORDER BY modified ASC", true);

			foreach ($sections as $section)
			{
				$list .= '<option value="' . $section['tag'] .'">' . $section['title'] . '</option>' ."\n";
			}

			echo '<input type="hidden" name="' . $accept_action . '" value="1">' .
				'<table class="formation">' .
					'<tr><th>' . $this->_t('ModerateMovesConfirm') . '</th></tr>' .
					'<tr><td>' .
						($error == true
							? '<span class="cite"><strong>' . $error . '</strong></span><br>'
							: '') .
						'<em>' . implode('<br>', $accept_text) . '</em><br>' .
						'<select name="section">' .
							'<option selected></option>' .
							$list .
						'</select> ' .
						'<input type="submit" name="accept" id="submit" value="' . $this->_t('ModerateAccept') . '"> ' .
						'<a href="' . $this->href('moderate') . '" class="btn_link"><input type="button" name="cancel" id="button" value="' . $this->_t('ModerateDecline') . '"></a>' .
					'</td></tr>' .
				'</table><br>' . "\n";
		}
		// enter a new name for the renamed topic
		else if ($accept_action == 'rename')
		{
			echo '<input type="hidden" name="' . $accept_action . '" value="1">' .
				'<table class="formation">' .
					'<tr><th>' . $this->_t('ModerateRenameConfirm') . '</th></tr>' .
					'<tr><td>' .
						($error == true
							? '<span class="cite"><strong>' . $error . '</strong></span><br>'
							: '') .
						'<input type="text" name="new_tag" size="50" maxlength="250" value="' . $this->get_page_title('', $set[0]) . '"> ' .
						'<input type="submit" name="accept" id="submit" value="' . $this->_t('ModerateAccept') . '"> ' .
						'<a href="' . $this->href('moderate') . '" class="btn_link"><input type="button" name="cancel" id="button" value="' . $this->_t('ModerateDecline') . '"></a>' .
						(count($set) > 1
							? '<br><small>' . $this->_t('ModerateRename1Only') . '</small>'
							: '') .
					'</td></tr>' .
				'</table><br>' . "\n";
		}
		// select base for merging topics
		else if ($accept_action == 'merge')
		{
			$i = 0;

			foreach ($set as $page_id)
			{
				$options[$i]['accept_text']	= '&laquo;' . $this->get_page_title('', $page_id) . '&raquo;';
				$options[$i]['topic']		= $this->get_page_tag($page_id);
				$i++;
			}

			$list = '';

			foreach ($options as $option)
			{
				$list			.= '<option value="' . $option['topic'] . '">' . $option['accept_text'] . "</option>\n";
				$accept_text[]	= $option['accept_text'];
			}

			echo '<input type="hidden" name="' . $accept_action . '" value="1">' .
				'<table class="formation">' .
					'<tr><th>' . $this->_t('ModerateMergeConfirm') . '</th></tr>' .
					'<tr><td>' .
						($error == true
							? '<span class="cite"><strong>' . $error . '</strong></span><br>'
							: '' ) .
						'<em>' . implode('<br>', $accept_text) . '</em><br>' . "\n" .
						'<select name="base">' .
							'<option selected></option>' .
							$list.
						'</select> ' .
						'<input type="submit" name="accept" id="submit" value="' . $this->_t('ModerateAccept') . '"> ' .
						'<a href="' . $this->href('moderate') . '" class="btn_link"><input type="button" name="cancel" id="button" value="' . $this->_t('ModerateDecline') . '"></a>' .
					'</td></tr>' .
				'</table><br>' . "\n";
		}

		// print moderation controls...
		echo '<input type="hidden" name="ids" value="' . implode('-', $set) . '">' .
			'<input type="hidden" name="p" value="' . (int) ($_GET['p'] ?? '') . '">' . "\n";
		echo '<table>' .
				'<tr class="lined">' .
					'<td colspan="5">' .
						'<input type="submit" name="delete" id="submit_delete" value="' . $this->_t('ModerateDelete') . '"> ' .
						'<input type="submit" name="move" id="submit_move" value="' . $this->_t('ModerateMove') . '"> ' .
						'<input type="submit" name="rename" id="submit_rename" value="' . $this->_t('ModerateRename') . '"> ' .
						'<input type="submit" name="merge" id="submit_merge" value="' . $this->_t('ModerateMerge') . '"> ' .
						'<input type="submit" name="lock" id="submit_lock" value="' . $this->_t('ModerateLock') . '"> ' .
						'<input type="submit" name="unlock" id="submit_unlock" value="' . $this->_t('ModerateUnlock') . '"> ' .
						(isset($this->db->moders_docs)
							? '&nbsp;&nbsp;&nbsp;<a href="' . $this->href('', $this->db->moders_docs) . '">' . $this->_t('Help') . '...</a>'
							: '') .
						'<br>' . "\n" .
						'<input type="submit" name="set" id="submit" value="' . $this->_t('ModerateSet') . '"> ' .
						($set
							? '<input type="submit" name="reset" id="submit" value="' . $this->_t('ModerateReset') . '"> ' .
							  '&nbsp;&nbsp;&nbsp;<small>ids: ' . implode(', ', $set) . '</small>'
							: ''
						) .
					'</td>' .
				'</tr>' . "\n" .
				'<tr class="formation">' .
					'<th colspan="2">' . $this->_t('ForumTopic') . '</th>' .
					'<th>' . $this->_t('ForumAuthor') . '</th>' .
					'<th>' . $this->_t('ForumReplies') . '</th>' .
					'<th>' . $this->_t('ForumCreated') . '</th>' .
				'</tr>' . "\n";

		// ...and topics list itself
		foreach ($topics as $topic)
		{
			if ($this->has_access('read', $topic['page_id']))
			{
				echo '<tr class="lined">' .
						'<td class="label a_middle">
							<input type="checkbox" name="' . $topic['page_id'] . '" value="id" ' . (in_array($topic['page_id'], $set) ? ' checked' : '') . '>
						</td>' .
						'<td>' .
							($this->has_access('comment', $topic['page_id'], GUEST) === false
								? '<img src="' . $this->db->theme_url . 'icon/spacer.png" title="' . $this->_t('DeleteCommentTip') . '" alt="' . $this->_t('DeleteText') . '" class="btn-locked">'
								: '' ) .
								$this->compose_link_to_page($topic['tag'], 'moderate', $topic['title']) . ' <strong>' . $this->compose_link_to_page($topic['tag'], '', '&lt;#&gt;') . '</strong>' .
						'</td>' .
						'<td class="t_center" ' . ($this->is_admin() ? ' title="' . $topic['ip'] . '"' : '' ) . '><small>&nbsp;&nbsp;' . $this->user_link($topic['owner_name'], '', true, false) . '&nbsp;&nbsp;</small></td>' .
						'<td class="t_center"><small>' . $topic['comments'] . '</small></td>' .
						'<td class="t_center nowrap"><small>&nbsp;&nbsp;' . $this->get_time_formatted($topic['created']) . '</small></td>' .
					'</tr>' . "\n";
			}
		}

		echo '</table>' . "\n";

		$this->print_pagination($pagination);

		echo $this->form_close();
	}
////// END SUBFORUM MODERATION //////
////// BEGIN PAGE/TOPIC MODERATION //////
	else
	{
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
				$this->http->redirect($this->href('moderate', substr($this->tag, 0, strrpos($this->tag, '/'))));
			}
		}
		// move topic elsewhere
		else if (isset($_POST['topic_move']))
		{
			$accept_action	= 'topic_move';

			// processing...
			if (isset($_POST['accept']) && (isset($_POST['section']) || isset($_POST['cluster'])))
			{
				$pos		= strrpos($this->tag, '/');
				$sub_tag	= substr($this->tag, ($pos ? $pos + 1 : 0));
				$old_tag	= $this->tag;
				$new_tag	= ($_POST['cluster']
								? ($_POST['cluster'] == '/'
									? ''
									: trim($_POST['cluster'], '/') . '/'
									)
								: $_POST['section'] . '/'
								) . $sub_tag;

				if ($forum_cluster === true)
				{
					if (!empty($_POST['cluster']) && $_POST['cluster'] != '/')
					{
						if (moderate_page_exists($this, $_POST['cluster']) === false)
						{
							$error = $this->_t('ModerateMoveNotExists') . ' <code>' . htmlspecialchars($_POST['cluster'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET) . '</code>';
						}
					}
					else if (!empty($_POST['section']))
					{
						if (moderate_page_exists($this, $new_tag) === true)
						{
							$error = '<span class="underline">&laquo;' . $this->page['title'] . '&raquo;</span>';
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
				if ($error == true)
				{
					if ($forum_cluster === true && $_POST['section'])
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
			if (isset($_POST['accept']) && $forum_cluster === true)
			{
				$pos		= strrpos($this->tag, '/');
				$section	= substr($this->tag, 0, ($pos ?: null));
				$tag		= trim($_POST['new_tag'], " \t");
				$title		= $tag;
				$tag 		= ucwords($tag);
				$tag		= preg_replace('/[^- \\w]/', '', $tag);
				$tag		= str_replace([' ', "\t"], '', $tag);
				$old_tag	= $this->tag;
				$new_tag	= ($section ? $section . '/' : '') . $tag;

				// check new tag existance
				if ($old_tag == $new_tag || moderate_page_exists($this, $new_tag) === true)
				{
					$error = $this->_t('ModerateRenameExists');
				}

				// ok, then rename page
				if ($tag != '' && $error != true)
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
		else if (isset($_POST['topic_lock']) && $forum_cluster === true)
		{
			// DON'T USE BLANK PRIVILEGE LIST!!! Only "negative all" - '!*'
			$this->save_acl($this->page['page_id'], 'comment', '!*');
			$this->log(2, Ut::perc_replace($this->_t('LogTopicLocked', SYSTEM_LANG), $this->page['tag'] . ' ' . $this->page['title']));
			$this->set_message($this->_t('ModerateTopicBlocked'), 'success');
			$this->http->redirect($this->href('moderate'));
		}
		// unlock topic
		else if (isset($_POST['topic_unlock']) && $forum_cluster === true)
		{
			$this->save_acl($this->page['page_id'], 'comment', $this->db->default_comment_acl);
			$this->log(2, Ut::perc_replace($this->_t('LogTopicUnlocked', SYSTEM_LANG), $this->page['tag'] . ' ' . $this->page['title']));
			$this->set_message($this->_t('ModerateTopicUnlocked'), 'success');
			$this->http->redirect($this->href('moderate'));
		}
		// delete selected comments
		else if (isset($_POST['posts_delete']) && $set == true)
		{
			$accept_action	= 'posts_delete';

			// actually remove topics
			if (isset($_POST['accept']))
			{
				if (array_filter($set) == false)
				{
					$error = $this->_t('ModerateNoItemChosen');
				}

				if ($error != true)
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
					$this->set_message($this->_t('ModerateCommentsDeleted'), 'succcess');
					$this->http->redirect($this->href('moderate'));
				}
			}
		}
		// split topic
		else if (isset($_POST['posts_split']) && $set == true)
		{
			$accept_action	= 'posts_split';

			// perform accepted splitting
			if (isset($_POST['accept']) && isset($_POST['new_tag']))
			{
				$section	= substr($this->tag, 0, strrpos($this->tag, '/'));
				$old_tag	= $this->tag;
				$tag		= trim($_POST['new_tag'], "/ \t");
				$title		= $tag;
				$page_id	= $this->get_page_id($tag);
				$tag		= ucwords($tag);
				$tag		= preg_replace('/[^- \\w]/', '', $tag);
				$tag		= str_replace([' ', "\t"], '', $tag);

				if ($forum_cluster === true)
				{
					// check new tag existance
					if ($old_tag != $section . '/' . $tag
						&& moderate_page_exists($this, $section . '/' . $tag) === true)
					{
						$error = $this->_t('ModerateRenameExists');
					}
				}
				else
				{
					// check desired target tag existance
					if (moderate_page_exists($this, $title) === false)
					{
						$error = $this->_t('ModerateMoveNotExists');
					}
					else if (array_filter($set) == false)
					{
						$error = $this->_t('ModerateNoItemChosen');
					}
				}

				// split topic or move comments
				if ($tag != '' && $error != true)
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

					if ($forum_cluster === true)
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
							$this->log(2, 'Error when separating comments from the topic ((/' . $this->tag . ')) a new topic ##' . $section . '/' . $tag . '##: page was not created');
						}
					}
					else
					{
						$ids_str = '';

						foreach ($comment_ids as $comment_id)
						{
							$ids_str .= "'" . (int) $comment_id . "', ";
						}

						$ids_str = substr($ids_str, 0, strlen($ids_str) - 2);

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
							"WHERE page_id IN ( $ids_str )");

						// update page_link table
						$comments = $this->db->load_all(
							"SELECT page_id, tag, body_r " .
							"FROM " . $this->db->table_prefix . "page " .
							"WHERE page_id IN ( $ids_str )");

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

		// make counter query
		$sql =
			"SELECT COUNT(page_id) AS n " .
			"FROM " . $this->db->table_prefix . "page " .
			"WHERE comment_on_id = " . (int) $this->page['page_id'] . " " .
			"LIMIT 1";

		// count posts and make pagination
		$count		= $this->db->load_single($sql);
		$pagination	= $this->pagination($count['n'], $limit, 'p', ['ids' => implode('-', $set)], 'moderate');

		// make collector query
		$sql =
			"SELECT p.page_id, p.tag, p.title, p.user_id, p.owner_id, ip, LEFT(body, 500) AS body, created, u.user_name, o.user_name as owner_name " .
			"FROM " . $this->db->table_prefix . "page p " .
				"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
				"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.owner_id = o.user_id) " .
			"WHERE comment_on_id = " . (int) $this->page['page_id'] . " " .
				"AND p.deleted <> 1 " .
			"ORDER BY created ASC " .
			$pagination['limit'];

		// load comments data
		$comments = $this->db->load_all($sql);

		$body = $this->format($this->page['body'], 'cleanwacko');
		$body = (strlen($body) > 300 ? substr($body, 0, 300) . '[..]' : $body . ' [..]');
		$body = htmlspecialchars($body, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);

		// display list
		echo $this->form_open('moderate_topic', ['page_method' => 'moderate']);

		$this->print_pagination($pagination);

		// confirm topic deletion
		if ($accept_action == 'topic_delete')
		{
			$accept_text = '<code>' . $this->page['title'] . '</code>';

			echo '<input type="hidden" name="' . $accept_action . '" value="1">' .
				'<table class="formation">' .
					'<tr><th>' . $this->_t('ModerateDeleteConfirm') . '</th></tr>' .
					'<tr><td>' .
						'<em>' . $accept_text . '</em><br>' .
						'<input type="submit" name="accept" id="submit" value="' . $this->_t('ModerateAccept') . '"> ' .
						'<a href="' . $this->href('moderate') . '" class="btn_link"><input type="button" name="cancel" id="button" value="' . $this->_t('ModerateDecline') . '"></a>' .
					'</td></tr>' .
				'</table><br>' . "\n";
		}
		// select target forum section / cluster for topic/page moving
		else if ($accept_action == 'topic_move')
		{
			$accept_text = '<code>' . $this->page['title'] . '</code>';

			if ($forum_cluster === true)
			{
				$list = '';

				$sections = $this->db->load_all(
					"SELECT p.tag, p.title " .
					"FROM " . $this->db->table_prefix . "page AS p, " .
							  $this->db->table_prefix . "acl AS a " .
					"WHERE p.page_id = a.page_id " .
						"AND a.privilege = 'comment' AND a.list = '' " .
						"AND p.tag LIKE " . $this->db->q($this->db->forum_cluster . '/%') . " " .
					"ORDER BY modified ASC", true);

				foreach ($sections as $section)
				{
					$list .= '<option value="' . $section['tag'] . '">' . $section['title'] . "</option>\n";
				}

				echo '<input type="hidden" name="' . $accept_action . '" value="1">' .
					'<table class="formation">' .
						'<tr><th>' . $this->_t('ModerateMoveConfirm') . '</th></tr>' .
						'<tr><td>' .
						($error == true
							? '<span class="cite"><strong>' . $error . '</strong></span><br>'
							: '' ) .
							'<em>' . $accept_text . '</em><br>' .
							'<select name="section">' .
								'<option selected></option>' .
								$list .
							'</select> or <input type="text" name="cluster" size="50" maxlength="250"><br>' .
							'<input type="submit" name="accept" id="submit" value="' . $this->_t('ModerateAccept') . '"> ' .
							'<a href="' . $this->href('moderate') . '" class="btn_link"><input type="button" name="cancel" id="button" value="' . $this->_t('ModerateDecline') . '"></a>' .
						'</td></tr>' .
					'</table><br>' . "\n";
			}
			else
			{
				echo '<input type="hidden" name="' . $accept_action . '" value="1">' .
					'<table class="formation">' .
						'<tr><th>' . $this->_t('ModeratePgMoveConfirm') . '</th></tr>' .
						'<tr><td>' .
						($error == true
							? '<span class="cite"><strong>' . $error . '</strong></span><br>'
							: '' ) .
							'<em>' . $accept_text . '</em><br>' .
							'<input type="text" name="cluster" size="50" maxlength="250"> ' .
							'<input type="submit" name="accept" id="submit" value="' . $this->_t('ModerateAccept') . '"> ' .
							'<a href="' . $this->href('moderate') . '" class="btn_link"><input type="button" name="cancel" id="button" value="' . $this->_t('ModerateDecline') . '"></a>' .
						'</td></tr>' .
					'</table><br>' . "\n";
			}
		}
		// enter a new name for topic renaming
		else if ($accept_action == 'topic_rename')
		{
			echo '<input type="hidden" name="' . $accept_action . '" value="1">' .
				'<table class="formation">' .
					'<tr><th>' . $this->_t('ModerateRenameConfirm') . '</th></tr>' .
					'<tr><td>' .
					($error == true
						? '<span class="cite"><strong>' . $error . '</strong></span><br>'
						: '' ) .
						'<input type="text" name="new_tag" size="50" maxlength="250" value="' . $this->page['title'] . '"> ' .
						'<input type="submit" name="accept" id="submit" value="' . $this->_t('ModerateAccept') . '"> ' .
						'<a href="' . $this->href('moderate') . '" class="btn_link"><input type="button" name="cancel" id="button" value="' . $this->_t('ModerateDecline') . '"></a>' .
					'</td></tr>' .
				'</table><br>' . "\n";
		}
		// confirm comments deletion
		else if ($accept_action == 'posts_delete')
		{
			echo '<input type="hidden" name="' . $accept_action . '" value="1">' .
				'<table class="formation">' .
					'<tr><th>' . Ut::perc_replace($this->_t('ModerateComDelConfirm'), count($set), ( count($set) > 1 ? $this->_t('ModerateComments') : $this->_t('ModerateComment') )) . '</th></tr>' .
					'<tr><td>' .
						($error == true
							? '<span class="cite"><strong>' . $error . '</strong></span><br>'
							: '') .
						'<input type="submit" name="accept" id="submit" value="' . $this->_t('ModerateAccept') . '"> ' .
						'<a href="' . $this->href('moderate') . '" class="btn_link"><input type="button" name="cancel" id="button" value="' . $this->_t('ModerateDecline') . '"></a>' .
					'</td></tr>' .
				'</table><br>' . "\n";
		}
		// enter a new name for the detached topic
		else if ($accept_action == 'posts_split')
		{
			echo '<input type="hidden" name="' . $accept_action . '" value="1">' .
				'<table class="formation">' .
					'<tr><th>' .
						($forum_cluster === true
							? $this->_t('ModerateSplitNewName')
							: $this->_t('ModerateSplitPageName') ) .
					'</th></tr>' .
					'<tr><td>' .
						($error == true
							? '<span class="cite"><strong>' . $error . '</strong></span><br>'
							: '') .
						'<input type="text" name="new_tag" size="50" maxlength="250" value=""> ' .
						'<input type="submit" name="accept" id="submit" value="' . $this->_t('ModerateAccept') . '"> ' .
						'<a href="' . $this->href('moderate') . '" class="btn_link"><input type="button" name="cancel" id="button" value="' . $this->_t('ModerateDecline') . '"></a>' .
						'<br>' .
						'<small>' .
						'<input type="radio" name="scheme" value="after" id="after" ' . (isset($_POST['scheme']) && $_POST['scheme'] != 'selected' ? 'checked ' : '' ) . '> ' .
						'<label for="after">' . $this->_t('ModerateSplitAllAfter') . '</label><br>' .
						'<input type="radio" name="scheme" value="selected" id="selected" ' . (isset($_POST['scheme']) && $_POST['scheme'] == 'selected' ? 'checked ' : '' ) . '> ' .
						'<label for="selected">' . Ut::perc_replace($this->_t('ModerateSplitSelected'), count($set)) . '</label>' .
						'</small>' .
					'</td></tr>' .
				'</table><br>' . "\n";
		}

		// print moderation controls...
		echo '<input type="hidden" name="ids" value="' . implode('-', $set) . '">' .
			'<input type="hidden" name="p" value="' . (int) ($_GET['p'] ?? '') . '">' . "\n";
		echo '<table>' .
				'<tr class="lined">' .
					'<td colspan="2">' .
						'<input type="submit" name="topic_delete" id="delete-submit" value="' . $this->_t('ModerateDeleteTopic') . '"> ' .
						'<input type="submit" name="topic_move" id="move-submit" value="' . $this->_t('ModerateMove') . '"> ' .
						($forum_cluster === true
							? '<input type="submit" name="topic_rename" id="submit" value="' . $this->_t('ModerateRename') . '"> '
							: ''
						) .
						($forum_cluster === true
							? ($this->has_access('comment', $this->page['page_id'], GUEST) === true
								? '<input type="submit" name="topic_lock" id="submit" value="' . $this->_t('ModerateLock') . '"> '
								: '<input type="submit" name="topic_unlock" id="submit" value="' . $this->_t('ModerateUnlock') . '"> '
							)
							: ''
						) .
						(isset($this->db->moders_docs)
							? '&nbsp;&nbsp;&nbsp;<a href="' . $this->href('', $this->db->moders_docs) . '">' . $this->_t('Help') . '...</a>'
							: '') .
					'</td>' .
				'</tr>' . "\n" .
				'<tr class="formation">' .
					'<th colspan="2">' .
						($this->has_access('comment', $this->page['page_id'], GUEST) === false
							? '<img src="' . $this->db->theme_url . 'icon/spacer.png" title="' . $this->_t('DeleteCommentTip') . '" alt="' . $this->_t('DeleteText') . '" class="btn-locked">'
							: '' ) .
						$this->_t('ForumTopic') .
					'</th>' .
				'</tr>' . "\n" .
				'<tr class="lined">' .
					'<td colspan="2" style="padding-bottom:30px;">' .
						'<strong><small>' .
							($forum_cluster === false
								? $this->user_link($this->page['owner_name'], '', true, false)
								: $this->user_link($this->page['user_name'], '', true, false)) .
							' (' . $this->get_time_formatted($this->page['created']) . ')</small></strong>' .
						'<br>' . $body.
					'</td>' .
				'</tr>' . "\n";

		if ($comments)
		{
			echo '<tr class="lined">' .
					'<td colspan="2">' .
						'<input type="submit" name="posts_delete" id="submit_delete" value="' . $this->_t('ModerateDeletePosts') . '"> ' .
						'<input type="submit" name="posts_split" id="submit_split" value="' . $this->_t('ModerateSplit') . '"> ' .
						(isset($this->db->moders_docs)
							? '&nbsp;&nbsp;&nbsp;<a href="' . $this->href('', $this->db->moders_docs) . '">' . $this->_t('Help') . '...</a>'
							: '') .
						'<br>' . "\n" .
						'<input type="submit" name="set" id="submit_set" value="' . $this->_t('ModerateSet') . '"> ' .
						($set
							? '<input type="submit" name="reset" id="submit_reset" value="' . $this->_t('ModerateReset') . '"> ' .
							  '&nbsp;&nbsp;&nbsp;<small>ids: ' . implode(', ', $set) . '</small>'
							: ''
						) .
					'</td>' .
				'</tr>' . "\n" .
				'<tr class="formation">' .
					'<th colspan="2">' . $this->_t('ForumComments') . '</th>' .
				'</tr>' . "\n";

			// ...and comments list
			foreach ($comments as $comment)
			{
				$desc = $this->format($comment['body'], 'cleanwacko');
				$desc = (strlen($desc) > 300 ? substr($desc, 0, 300) . '[..]' : $desc . ' [..]');
				$desc = htmlspecialchars($desc, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);

				echo '<tr class="lined">' .
						'<td class="label a_middle">
							<input type="checkbox" name="' . $comment['page_id'] . '" value="id"' . ( in_array($comment['page_id'], $set) ? ' checked' : '' ) . '>
						</td>' .
						'<td>
							<strong><small>' . $this->user_link($comment['user_name'], '', true, false) . ' (' . $this->get_time_formatted($comment['created']) . ') &nbsp;&nbsp; ' . $this->compose_link_to_page($comment['tag'], '', '&lt;#&gt;').( $comment['owner_id'] != 0 ? ' &nbsp;&nbsp; <a href="' . $this->href('', $this->db->users_page, ['profile' => $comment['owner_name']]) . '">' . $this->_t('ModerateUserProfile') . '</a>' : '' ) . '</small></strong>' .
							'<br>' . $desc .
						'</td>' .
					'</tr>' . "\n";
			}
		}

		echo '</table>' . "\n";

		$this->print_pagination($pagination);

		echo $this->form_close();
	}
}
else
{
	$this->show_message($this->_t('NotModerator'), 'info');
}

// set forum context
if ($forum_cluster === true)
{
	$this->forum = true;
}
