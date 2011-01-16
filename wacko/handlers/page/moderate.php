<?php

// TODO: Fix acl checks in sql WHERE clauses, just commented them out
//

?>

<div class="page">
<h3><?php echo $this->get_translation('Moderation').' '.( $this->forum === true ? $this->get_translation('Topics') : $this->get_translation('ModerateSection') ).' '.$this->compose_link_to_page($this->tag, '', $this->page['title'], 0);
	echo ( $this->forum === true ? '<br />['.$this->compose_link_to_page(substr($this->tag, 0, strrpos($this->tag, '/')), 'moderate', $this->get_translation('ModerateSection2'), 0).']' : '' ) ?></h3>

<?php

// local functions
function moderate_page_exists(&$engine, $tag)
{
	if ($page = $engine->load_single(
	"SELECT page_id ".
	"FROM {$engine->config['table_prefix']}page ".
	"WHERE tag = '".quote($engine->dblink, $tag)."' ".
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
	$engine->remove_comments($tag);
	$engine->remove_files($tag);
	$engine->remove_page($tag);
	return true;
}

function moderate_rename_topic(&$engine, $old_tag, $new_tag, $title = '')
{
	// set forum context
	$forum_context	= $engine->forum;
	$engine->forum	= true;

	$supertag = $engine->npj_translit($new_tag);

	$engine->rename_page($old_tag, $new_tag, $supertag);
	$engine->remove_referrers($old_tag);
	$engine->remove_links($old_tag);
	$engine->clear_cache_wanted_page($new_tag);
	$engine->clear_cache_wanted_page($supertag);

	// rerender page and update link table in new context
	$page = $engine->load_page($new_tag);
	$engine->current_context++;
	$engine->context[$engine->current_context] = $new_tag;
	$engine->clear_link_table();
	$engine->start_link_tracking();
	$dummy = $engine->format($page['body_r'], 'post_wacko');
	$engine->stop_link_tracking();
	$engine->write_link_table($new_tag);
	$engine->clear_link_table();
	$engine->current_context--;

	// update title in meta and body if needed
	if ($title != '')
	{
		// resave modified body
		$page['body'] = preg_replace('/^==.*?==/', '=='.$title.'==', $page['body']);
		$engine->save_page($new_tag, false, $page['body'], '', '', '', '', '', true, false);

		$engine->query(
			"UPDATE {$engine->config['table_prefix']}page ".
			"SET title = '".quote($engine->dblink, $title)."' ".
			"WHERE tag = '".quote($engine->dblink, $new_tag)."' ".
			"LIMIT 1");
	}

	// restore forum context
	$engine->forum = $forum_context;

	return true;
}

function moderate_merge_topics(&$engine, $base, $topics, $movetopics = true)
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
			$engine->query(
				"UPDATE {$engine->config['table_prefix']}page SET ".
					"comment_on_id = '".quote($engine->dblink, $base_id)."' ".
				"WHERE comment_on_id = '".quote($engine->dblink, $topic_id)."'");

			// for the forum moderation only
			if ($movetopics === true)
			{
				// find latest number
				$status	= $engine->load_all("SHOW TABLE STATUS");
				foreach ($status as $row)
				{
					if ($row['Name'] == $engine->config['table_prefix'].'page')
					{
						$num = $row['Auto_increment'];
					}
				}

				// resave topic body as comment
				$page = $engine->load_page($topic);

				$page['body'] = preg_replace('/^==.*?==(\\n)*/', '', str_replace("\r", '', $page['body']));
				$engine->save_page('Comment'.$num, false, $page['body'], '', '', '', $base_id, '', true);

				// restore creation date
				$engine->query(
					"UPDATE {$engine->config['table_prefix']}page SET ".
						"modified		= '".quote($engine->dblink, $page['modified'])."', ".
						"created		= '".quote($engine->dblink, $page['created'])."', ".
						"commented		= '".quote($engine->dblink, $page['commented'])."', ".
						"owner_id		= '".quote($engine->dblink, $page['owner_id'])."', ".
						"user_id		= '".quote($engine->dblink, $page['user_id'])."', ".
						"ip				= '".quote($engine->dblink, $page['ip'])."' ".
					"WHERE tag = '".quote($engine->dblink, 'Comment'.$num)."'");

				// remove old page remnants
				moderate_delete_page($engine, $topic);
			}
		}
	}

	// update link table
	$comments = $engine->load_all(
		"SELECT tag, body_r ".
		"FROM {$engine->config['table_prefix']}page ".
		"WHERE comment_on_id = '".quote($engine->dblink, $base_id)."'");

	foreach ($comments as $comment)
	{
		$engine->context[++$engine->current_context] = $comment['tag'];
		$engine->clear_link_table();
		$engine->start_link_tracking();
		$dummy = $engine->format($comment['body_r'], 'post_wacko');
		$engine->stop_link_tracking();
		$engine->write_link_table($comment['tag']);
		$engine->clear_link_table();
		$engine->current_context--;
	}

	// recount comments for the base topic
	$engine->query(
		"UPDATE {$engine->config['table_prefix']}page SET ".
			"comments	= '".(int)$engine->count_comments($base_id)."', ".
			"commented	= NOW() ".
		"WHERE tag = '".quote($engine->dblink, $base)."' ".
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

	$old_tag_id = $engine->get_page_id($old_tag);
	$new_tag_id = $engine->get_page_id($new_tag);
	$title_id = $engine->get_page_id($title);

	// set forum context
	$forum_context	= $engine->forum;
	$engine->forum	= true;

	// resave first comment as new topic page
	$first_tag		= $engine->get_page_tag_by_id(array_shift($comment_ids));
	$page			= $engine->load_page($first_tag);

	// resave modified body
	$page['body']	= '=='.$title."==\n\n".$page['body'];
	$engine->save_page($new_tag, false, $page['body'], '', '', '', $title_id, '', true);

	// bug-resistent check: has page been really resaved?
	if ($engine->load_single(
	"SELECT page_id FROM {$engine->config['table_prefix']}page ".
	"WHERE tag = '".quote($engine->dblink, $new_tag)."'") != true)
	{
		$engine->forum = $forum_context;
		return false;
	}

	// restore original metadata
	$engine->query(
		"UPDATE {$engine->config['table_prefix']}page SET ".
			"modified		= '".quote($engine->dblink, $page['modified'])."', ".
			"created		= '".quote($engine->dblink, $page['created'])."', ".
			"owner_id		= '".quote($engine->dblink, $page['owner_id'])."', ".
			"user_id		= '".quote($engine->dblink, $page['user_id'])."', ".
			"ip				= '".quote($engine->dblink, $page['ip'])."' ".
		"WHERE tag = '".quote($engine->dblink, $new_tag)."'");

	// move remaining comments to the new topic
	foreach ($comment_ids as $id)
	{
		$engine->query(
			"UPDATE {$engine->config['table_prefix']}page SET ".
				"comment_on_id = '".quote($engine->dblink, $new_tag_id)."' ".
			"WHERE page_id = '".quote($engine->dblink, $id)."'");
	}

	// remove old first comment
	moderate_delete_page($engine, $first_tag);

	// update link table
	$page = $engine->load_page($new_tag);
	$engine->current_context++;
	$engine->context[$engine->current_context] = $new_tag;
	$engine->clear_link_table();
	$engine->start_link_tracking();
	$dummy = $engine->format($page['body_r'], 'post_wacko');
	$engine->stop_link_tracking();
	$engine->write_link_table($new_tag);
	$engine->clear_link_table();
	$engine->current_context--;

	// recount comments for old and new topics
	$engine->query(
		"UPDATE {$engine->config['table_prefix']}page SET ".
			"comments	= '".(int)$engine->count_comments($new_tag_id)."', ".
			"commented	= NOW() ".
		"WHERE tag = '".quote($engine->dblink, $new_tag)."' ".
		"LIMIT 1");
	$engine->query(
		"UPDATE {$engine->config['table_prefix']}page ".
		"SET comments = '".(int)$engine->count_comments($old_tag_id)."' ".
		"WHERE tag = '".quote($engine->dblink, $old_tag)."' ".
		"LIMIT 1");

	// restore forum context
	$engine->forum = $forum_context;

	return true;
}

// redirect to show method if page doesn't exists
if (!$this->page || $this->page['comment_on_id'] == true)
{
	$this->redirect($this->href('show'));
}

$forum_cluster = '';

if (($this->is_moderator() && $this->has_access('read')) || $this->is_admin())
{
	$accept_action = '';
	$error = '';

	if (substr($this->tag, 0, strlen($this->config['forum_cluster'])) == $this->config['forum_cluster'])
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
		$_POST[$key] = htmlspecialchars($val);
	}

	// IDs PROCESSING (COMMON PROCEDURES)
	$set = array();

	// pass previously selected items
	if (isset($_REQUEST['ids']))
	{
		$ids = explode('-', $_REQUEST['ids']);

		foreach ($ids as $id)
		{
			if (!in_array($id, $set))
			{
				$set[] = $id;
			}
		}

		unset($ids, $id);
	}

	// keep currently selected list items
	foreach ($_POST as $val => $key)
	{
		if ($key == 'id' && !in_array($val, $set))
		{
			$set[] = $val;
		}
	}
	unset($key, $val);

	// save page ids for later operations (correct if needed)
	if (isset($_POST['set']))
	{
		$set = array();

		foreach ($_POST as $val => $key)
		{
			if ($key == 'id')
			{
				$set[] = $val;
			}
		}

		unset($key, $val);
	}
	// reset page ids
	else if (isset($_POST['reset']))
	{
		$set = array();
	}

	// check moderator read access on passed ids
	foreach ($set as $n => $id)
	{
		if ($this->has_access('read', $id) !== true)
		{
			unset($set[$n]);
		}
	}
	reset($set);
	unset($n, $id);

	// creting rss object
	$this->use_class('rss');
	$xml = new rss($this);

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
				foreach ($set as $id)
				{
					$page = $this->load_page('', $id, '', LOAD_NOCACHE, LOAD_META);
					moderate_delete_page($this, $page['tag']);
					$this->log(1, str_replace('%2', $page['user_id'], str_replace('%1', $page['tag'], $this->get_translation('LogRemovedPage', $this->config['language']))));
				}
				unset($accept_action);
				$xml->comments();
				$set = array();
				$this->set_message($this->get_translation('ModerateTopicsDeleted'));
				$this->redirect($this->href('moderate'));
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
				foreach ($set as $id)
				{
					$old_tags[] = $this->get_page_tag_by_id($id);
					$new_tags[] = $_POST['section'].substr($old_tags[$i], strrpos($old_tags[$i], '/'));

					if (moderate_page_exists($this, $new_tags[$i++]) === true)
					{
						$error[] = '<u>&laquo;'.$this->get_page_title('', $id).'&raquo;</u>';
					}
				}

				// in case no errors, move...
				if ($error == true)
				{
					$error = str_replace('%1', implode(', ', $error), $this->get_translation('ModerateMoveExists'));
				}
				else
				{
					$i = 0;
					foreach ($set as $id)
					{
						moderate_rename_topic($this, $old_tags[$i], $new_tags[$i]);
						$this->log(3, str_replace('%2', $new_tags[$i], str_replace('%1', $old_tags[$i], $this->get_translation('LogRenamedPage', $this->config['language']))));
						$i++;
					}
					unset($accept_action, $i, $old_tags, $new_tags);
					$xml->comments();
					$set = array();
					$this->set_message($this->get_translation('ModerateTopicsRelocated'));
					$this->redirect($this->href('moderate'));
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
				$old_tag	= $this->get_page_tag_by_id($set[0]);
				$tag		= trim($_POST['title'], " \t");
				$title		= $tag;
				$tag 		= ucwords($tag);
				$tag		= preg_replace('/[^- \\w]/', '', $tag);
				$tag		= str_replace(array(' ', "\t"), '', $tag);

				// check new tag existance
				if ($old_tag != $this->tag.'/'.$tag && moderate_page_exists($this, $this->tag.'/'.$tag) === true)
				{
					$error = $this->get_translation('ModerateRenameExists');
				}

				// okey, then rename page
				if ($tag != '' && $error != true)
				{
					moderate_rename_topic($this, $old_tag, $this->tag.'/'.$tag, $title);
					$this->log(3, str_replace('%2', $this->tag.'/'.$tag.' '.$title, str_replace('%1', $old_tag, $this->get_translation('LogRenamedPage', $this->config['language']))));
					unset($accept_action, $old_tag, $tag, $title);
					$xml->comments();
					$set = array();
					$this->set_message($this->get_translation('ModerateTopicsRenamed'));
					$this->redirect($this->href('moderate'));
				}
			}
		}
		// merge several topics into a single topic
		else if (isset($_POST['merge']) && $set == true)
		{
			$accept_action	= 'merge';

			if (count($set) < 2)
			{
				$error = $this->get_translation('ModerateMerge2Min');
			}

			// perform accepted action
			if (isset($_POST['accept']) && isset($_POST['base']) && !$error)
			{
				foreach ($set as $id)
				{
					$topics[] = $this->get_page_tag_by_id($id);
				}
				moderate_merge_topics($this, $_POST['base'], $topics);
				$this->log(3, str_replace('%2', $_POST['base'], str_replace('%1', '##'.implode('##, ##', $topics).'##', $this->get_translation('LogMergedPages', $this->config['language']))));
				unset($accept_action, $topics);
				$xml->comments();
				$set = array();
				$this->set_message($this->get_translation('ModerateTopicsMerged'));
				$this->redirect($this->href('moderate'));
			}
		}
		// lock topics
		else if (isset($_POST['lock']) && $set == true)
		{
			foreach ($set as $id)
			{
				$page = $this->load_page('', $id, '', LOAD_NOCACHE, LOAD_META);
				$this->log(2, str_replace('%1', $page['tag'].' '.$page['title'], $this->get_translation('LogTopicLocked', $this->config['language'])));
				// DON'T USE BLANK PRIVILEGE LIST!!! Only "negative all" - '!*'
				$this->save_acl($id, 'comment', '!*');
			}
			$set = array();
			$this->set_message($this->get_translation('ModerateTopicsBlocked'));
			$this->redirect($this->href('moderate'));
		}
		// unlock topics
		else if (isset($_POST['unlock']) && $set == true)
		{
			foreach ($set as $id)
			{
				$page = $this->load_page('', $id, '', LOAD_NOCACHE, LOAD_META);
				$this->log(2, str_replace('%1', $page['tag'].' '.$page['title'], $this->get_translation('LogTopicUnlocked', $this->config['language'])));
				$this->save_acl($id, 'comment', '*');
			}
			$set = array();
			$this->set_message($this->get_translation('ModerateTopicsUnlocked'));
			$this->redirect($this->href('moderate'));
		}

		// make counter query
		$sql = "SELECT COUNT(p.tag) AS n ".
			"FROM {$this->config['table_prefix']}page AS p ".
				#"{$this->config['table_prefix']}acl AS a ".
			"WHERE". # p.page_id = a.page_id ".
				#"AND a.`create` = '' ".
				#"AND
				"p.tag LIKE '{$this->tag}/%'";

		// count topics and make pagination
		$count		= $this->load_single($sql);
		$pagination	= $this->pagination($count['n'], $limit, 'p', 'ids='.implode('-', $set), 'moderate');

		// make collector query
		$sql = "SELECT p.page_id, p.tag, title, p.owner_id, p.user_id, ip, comments, created, u.user_name AS user, o.user_name as owner ".
			"FROM {$this->config['table_prefix']}page AS p ".
					"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
					"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.owner_id = o.user_id) ".
				#"{$this->config['table_prefix']}acl AS a ".
			"WHERE ".// p.page_id = a.page_id ".
				#"AND a.`create` = '' ".
				#"AND
				"p.tag LIKE '{$this->tag}/%' ".
			"ORDER BY commented DESC ".
			"LIMIT {$pagination['offset']}, $limit";

		// load topics data
		$topics	= $this->load_all($sql);

		// display list
		echo $this->form_open('moderate');

		// pagination
		if (isset($pagination['text']))
		{
			echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
		}

		// confirm deletion
		if ($accept_action == 'delete')
		{
			foreach ($set as $id)
			{
				$accept_text[] = '&laquo;'.$this->get_page_title('', $id).'&raquo;';
			}

			echo '<input name="'.$accept_action.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.$this->get_translation('ModerateDeleteConfirm').'</th></td>'.
					'<tr><td>'.
						'<em>'.implode('<br />', $accept_text).'</em><br />'.
						'<input name="accept" id="submit" type="submit" value="'.$this->get_translation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->get_translation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
					'</td></tr>'.
				'</table><br />'."\n";
		}
		// select target forum section
		else if ($accept_action == 'move')
		{
			foreach ($set as $id)
			{
				$accept_text[] = '&laquo;'.$this->get_page_title('', $id).'&raquo;';
			}

			$sections = $this->load_all(
				"SELECT p.tag, p.title ".
				"FROM {$this->config['table_prefix']}page AS p ".
					#"{$this->config['table_prefix']}acl AS a ".
				"WHERE ". #p.page_id = a.page_id ".
					#"AND a.`comment` = '' ".
					#"AND
					"p.tag LIKE '".quote($this->dblink, $this->config['forum_cluster'])."/%' ".
				"ORDER BY time ASC", 1);

			foreach ($sections as $section)
			{
				$list .= "<option value=\"{$section['tag']}\">{$section['title']}</option>\n";
			}

			echo '<input name="'.$accept_action.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.$this->get_translation('ModerateMovesConfirm').'</th></td>'.
					'<tr><td>'.
						( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
						'<em>'.implode('<br />', $accept_text).'</em><br />'.
						'<select name="section">'.
							'<option selected="selected"></option>'.
							$list.
						'</select> '.
						'<input name="accept" id="submit" type="submit" value="'.$this->get_translation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->get_translation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
					'</td></tr>'.
				'</table><br />'."\n";
		}
		// enter a new name for the renamed topic
		else if ($accept_action == 'rename')
		{
			echo '<input name="'.$accept_action.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.$this->get_translation('ModerateRenameConfirm').'</th></td>'.
					'<tr><td>'.
						( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
						'<input name="title" size="50" maxlength="100" value="'.$this->get_page_title('', $set[0]).'" /> '.
						'<input name="accept" id="submit" type="submit" value="'.$this->get_translation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->get_translation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
						( count($set) > 1 ? '<br /><small>'.$this->get_translation('ModerateRename1Only').'</small>' : '' ).
					'</td></tr>'.
				'</table><br />'."\n";
		}
		// select base for merging topics
		else if ($accept_action == 'merge')
		{
			foreach ($set as $id)
			{
				$accept_text[] = '&laquo;'.$this->get_page_title('', $id).'&raquo;';
				$topics_list[] = $this->get_page_tag_by_id($id);
			}

			$list = '';
			for ($i = 0; $i < count($topics_list); $i++)
			{
				$list .= "<option value=\"{$topics_list[$i]}\">{$accept_text[$i]}</option>\n";
			}

			echo '<input name="'.$accept_action.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.$this->get_translation('ModerateMergeConfirm').'</th></td>'.
					'<tr><td>'.
						( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
						'<em>'.implode('<br />', $accept_text).'</em><br />'."\n".
						'<select name="base">'.
							'<option selected="selected"></option>'.
							$list.
						'</select> '.
						'<input name="accept" id="submit" type="submit" value="'.$this->get_translation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->get_translation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
					'</td></tr>'.
				'</table><br />'."\n";
		}

		// print moderation controls...
		echo '<input name="ids" type="hidden" value="'.implode('-', $set).'" />'.
			'<input name="p" type="hidden" value="'.(isset($_GET['p']) ? $_GET['p'] : '').'" />'."\n";
		echo '<table cellspacing="1" cellpadding="4">'.
				'<tr class="lined">'.
					'<td colspan="5">'.
						'<input name="delete" id="submit" type="submit" value="'.$this->get_translation('ModerateDelete').'" /> '.
						'<input name="move" id="submit" type="submit" value="'.$this->get_translation('ModerateMove').'" /> '.
						'<input name="rename" id="submit" type="submit" value="'.$this->get_translation('ModerateRename').'" /> '.
						'<input name="merge" id="submit" type="submit" value="'.$this->get_translation('ModerateMerge').'" /> '.
						'<input name="lock" id="submit" type="submit" value="'.$this->get_translation('ModerateLock').'" /> '.
						'<input name="unlock" id="submit" type="submit" value="'.$this->get_translation('ModerateUnlock').'" /> '.
						'&nbsp;&nbsp;&nbsp;<a href="'.$this->href('', $this->config['moders_docs']).'">'.$this->get_translation('Help').'...</a> '.
						'<br />'."\n".
						'<input name="set" id="submit" type="submit" value="'.$this->get_translation('ModerateSet').'" /> '.
						( $set
							? '<input name="reset" id="submit" type="submit" value="'.$this->get_translation('ModerateReset').'" /> '.
							  '&nbsp;&nbsp;&nbsp;<small>ids: '.implode(', ', $set).'</small>'
							: ''
						).
					'</td>'.
				'</tr>'."\n".
				'<tr class="formation">'.
					'<th colspan="2">'.$this->get_translation('ForumTopics').'</th>'.
					'<th>'.$this->get_translation('ForumAuthor').'</th>'.
					'<th>'.$this->get_translation('ForumReplies').'</th>'.
					'<th>'.$this->get_translation('ForumCreated').'</th>'.
				'</tr>'."\n";

		// ...and topics list itself
		foreach ($topics as $topic)

		if ($this->has_access('read', $topic['page_id']))
		{
			echo '<tr>'.
					'<td valign="middle" style="width:10px;" class="label"><input name="'.$topic['page_id'].'" type="checkbox" value="id" '.( in_array($topic['page_id'], $set) ? 'checked="checked "' : '' ).'/></td>'.
					'<td align="left" style="padding-left:5px;">'.( $this->has_access('comment', $topic['page_id'], GUEST) === false ? str_replace('{theme}', $this->config['theme_url'], $this->get_translation('lockicon')) : '' ).$this->compose_link_to_page($topic['tag'], 'moderate', $topic['title']).' <strong>'.$this->compose_link_to_page($topic['tag'], '', '&lt;#&gt;', 0).'</strong></td>'.
					'<td align="center"'.( $this->is_admin() ? ' title="'.$topic['ip'].'"' : '' ).'><small>&nbsp;&nbsp;'.( $topic['owner'] == GUEST ? '<em>'.$this->get_translation('Guest').'</em>' : ( $topic['owner'] ? '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$topic['owner']).'">'.$topic['owner'].'</a>' : $topic['user'] ) ).'&nbsp;&nbsp;</small></td>'.
					'<td align="center"><small>'.$topic['comments'].'</small></td>'.
					'<td align="center" style="white-space:nowrap"><small>&nbsp;&nbsp;'.$this->get_time_string_formatted($topic['created']).'</small></td>'.
				'</tr>'."\n".
				'<tr class="lined">'.
					'<td colspan="5"></td>'.
				'</tr>'."\n";
		}

		echo '</table>'."\n";

		// pagination
		if (isset($pagination['text']))
		{
			echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
		}

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
				$this->log(1, str_replace('%2', $this->page['user_id'], str_replace('%1', $this->page['tag'], $this->get_translation('LogRemovedPage', $this->config['language']))));
				moderate_delete_page($this, $this->tag);
				unset($accept_action);
				$xml->comments();
				$this->set_message($this->get_translation('ModerateTopicDeleted'));
				$this->redirect($this->href('moderate', substr($this->tag, 0, strrpos($this->tag, '/'))));
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
				$sub_tag	= substr($this->tag, ( $pos ? $pos+1 : 0 ));
				$old_tag	= $this->tag;
				$new_tag	= ( $_POST['cluster'] ? ( $_POST['cluster'] == '/' ? '' : trim($_POST['cluster'], '/').'/' ) : $_POST['section'].'/' ).$sub_tag;

				if ($forum_cluster === true)
				{
					if (isset($_POST['cluster']) && $_POST['cluster'] != '/')
					{
						if (moderate_page_exists($this, $_POST['cluster']) === false)
						{
							$error = $this->get_translation('ModerateMoveNotExists');
						}
					}
					else if (isset($_POST['section']))
					{
						if (moderate_page_exists($this, $new_tag) === true)
						{
							$error = '<u>&laquo;'.$this->page['title'].'&raquo;</u>';
						}
					}
				}
				else if ($_POST['cluster'] != '/')
				{
					if (moderate_page_exists($this, $_POST['cluster']) === false)
					{
						$error = $this->get_translation('ModerateMoveNotExists');
					}
				}

				// in case no errors, move...
				if ($error == true)
				{
					if ($forum_cluster === true && $_POST['section'])
					{
						$error = str_replace('%1', $error, $this->get_translation('ModerateMoveExists'));
					}
				}
				else
				{
					moderate_rename_topic($this, $old_tag, $new_tag);
					$this->log(3, str_replace('%2', $new_tag, str_replace('%1', $old_tag, $this->get_translation('LogRenamedPage', $this->config['language']))));
					unset($accept_action);
					$xml->comments();
					$this->set_message($this->get_translation('ModeratePageMoved'));
					$this->redirect($this->href('moderate', $new_tag));
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
				$section	= substr($this->tag, 0, ( $pos ? $pos : null ));
				$tag		= trim($_POST['title'], " \t");
				$title		= $tag;
				$tag 		= ucwords($tag);
				$tag		= preg_replace('/[^- \\w]/', '', $tag);
				$tag		= str_replace(array(' ', "\t"), '', $tag);
				$old_tag	= $this->tag;
				$new_tag	= ( $section ? $section.'/' : '' ).$tag;

				// check new tag existance
				if ($old_tag == $new_tag || moderate_page_exists($this, $new_tag) === true)
				{
					$error = $this->get_translation('ModerateRenameExists');
				}

				// okey, then rename page
				if ($tag != '' && $error != true)
				{
					moderate_rename_topic($this, $old_tag, $new_tag, $title);
					$this->log(3, str_replace('%2', $new_tag.' '.$title, str_replace('%1', $old_tag, $this->get_translation('LogRenamedPage', $this->config['language']))));
					unset($accept_action);
					$xml->comments();
					$this->set_message($this->get_translation('ModerateTopicRenamed'));
					$this->redirect($this->href('moderate', $new_tag));
				}
			}
		}
		// lock topic
		else if (isset($_POST['topic_lock']) && $forum_cluster === true)
		{
			// DON'T USE BLANK PRIVILEGE LIST!!! Only "negative all" - '!*'
			$this->save_acl($this->page['page_id'], 'comment', '!*');
			$this->log(2, str_replace('%1', $this->page['tag'].' '.$this->page['title'], $this->get_translation('LogTopicLocked', $this->config['language'])));
			$this->set_message($this->get_translation('ModerateTopicBlocked'));
			$this->redirect($this->href('moderate'));
		}
		// unlock topic
		else if (isset($_POST['topic_unlock']) && $forum_cluster === true)
		{
			$this->save_acl($this->page['page_id'], 'comment', '*');
			$this->log(2, str_replace('%1', $this->page['tag'].' '.$this->page['title'], $this->get_translation('LogTopicUnlocked', $this->config['language'])));
			$this->set_message($this->get_translation('ModerateTopicUnlocked'));
			$this->redirect($this->href('moderate'));
		}
		// delete selected comments
		else if (isset($_POST['posts_delete']) && $set == true)
		{
			$accept_action	= 'posts_delete';

			// actually remove topics
			if (isset($_POST['accept']))
			{
				foreach ($set as $id)
				{
					$page = $this->load_page('', $id, '', LOAD_NOCACHE, LOAD_META);
					moderate_delete_page($this, $page['tag']);
					$this->log(1, str_replace('%3', $this->get_time_string_formatted($page['created']), str_replace('%2', $page['user'], str_replace('%1', $page['comment_on'].' '.$this->get_page_title($page['comment_on']), $this->get_translation('LogRemovedComment', $this->config['language'])))));
				}

				// recount comments for current topic
				$this->query(
					"UPDATE {$this->config['table_prefix']}page SET ".
						"comments	= '".(int)$this->count_comments($this->tag)."', ".
						"commented	= NOW() ".
					"WHERE tag = '".quote($this->dblink, $this->tag)."' ".
					"LIMIT 1");

				unset($accept_action);
				$xml->comments();
				$set = array();
				$this->set_message($this->get_translation('ModerateCommentsDeleted'));
				$this->redirect($this->href('moderate'));
			}
		}
		// split topic
		else if (isset($_POST['posts_split']) && $set == true)
		{
			$accept_action	= 'posts_split';

			// perform accepted splitting
			if (isset($_POST['accept']) && isset($_POST['title']))
			{
				$section	= substr($this->tag, 0, strrpos($this->tag, '/'));
				$old_tag	= $this->tag;
				$tag		= trim($_POST['title'], "/ \t");
				$title		= $tag;
				$page_id	= $this->get_page_id($tag);
				$tag 		= ucwords($tag);
				$tag		= preg_replace('/[^- \\w]/', '', $tag);
				$tag		= str_replace(array(' ', "\t"), '', $tag);

				if ($forum_cluster === true)
				{
					// check new tag existance
					if ($old_tag != $section.'/'.$tag && moderate_page_exists($this, $section.'/'.$tag) === true)
					{
						$error = $this->get_translation('ModerateRenameExists');
					}
				}
				else
				{
					// check desired target tag existance
					if (moderate_page_exists($this, $title) === false)
					{
						$error = $this->get_translation('ModerateMoveNotExists');
					}
				}

				// split topic or move comments
				if ($tag != '' && $error != true)
				{
					// get comments ids according to the splitting scheme
					if ($_POST['scheme'] == 'selected')
					{
						$comment_ids = $set;
					}
					else if ($_POST['scheme'] == 'after')
					{
						$_set = $set;
						sort($_set);

						$first_comment	= $this->load_page('', $_set[0]);
						$_comments		= $this->load_all(
							"SELECT page_id ".
							"FROM {$this->config['table_prefix']}page ".
							"WHERE comment_on_id = '".quote($this->dblink, $first_comment['comment_on_id'])."' ".
								"AND created >= '".quote($this->dblink, $first_comment['created'])."' ".
							"ORDER BY created ASC");

						foreach ($_comments as $_comment)
						{
							$comment_ids[] = $_comment['page_id'];
						}

						unset($first_comment, $_set, $_comments, $_comment);
					}

					if ($forum_cluster === true)
					{
						if (moderate_split_topic($this, $comment_ids, $old_tag, $section.'/'.$tag, $title) === true)
						{
							$this->log(3, str_replace('%2', $section.'/'.$tag.' '.$title, str_replace('%1', $this->tag.' '.$this->page['title'], $this->get_translation('LogSplittedPage', $this->config['language']))));
							unset($accept_action);
							$xml->comments();
							$this->set_message($this->get_translation('ModerateCommentsSplited'));
							$this->redirect($this->href('moderate', $section.'/'.$tag));
						}
						else
						{
							$this->set_message($this->get_translation('ModerateCommentsSplitFailed'));
							$this->log(2, 'Error when separating comments from the topic ((/'.$this->tag.')) a new topic '.$section.'/'.$tag.': page was not created');  // ru: Ошибка при отделении комментариев из темы     в новую тему        документ не был создан
						}
					}
					else
					{
						foreach ($comment_ids as $id)
						{
							$ids_str .= "'".quote($this->dblink, $id)."', ";
						}
						$ids_str = substr($ids_str, 0, strlen($ids_str)-2);

						// move
						$this->query(
							"UPDATE {$this->config['table_prefix']}page SET ".
								"comment_on_id = '".quote($this->dblink, $page_id)."' ".
							"WHERE page_id IN ( $ids_str )");

						// update link table
						$comments = $this->load_all(
							"SELECT tag, body_r ".
							"FROM {$this->config['table_prefix']}page ".
							"WHERE page_id IN ( $ids_str )");

						foreach ($comments as $comment)
						{
							$this->context[++$this->current_context] = $comment['tag'];
							$this->clear_link_table();
							$this->start_link_tracking();
							$dummy = $this->format($comment['body_r'], 'post_wacko');
							$this->stop_link_tracking();
							$this->write_link_table($comment['tag']);
							$this->clear_link_table();
							$this->current_context--;
						}

						// recount comments for the old and new page
						$this->query(
							"UPDATE {$this->config['table_prefix']}page ".
							"SET comments = '".(int)$this->count_comments($this->page['page_id'])."' ".
							"WHERE page_id = '".quote($this->dblink, $this->page['page_id'])."' ".
							"LIMIT 1");
						$this->query(
							"UPDATE {$this->config['table_prefix']}page SET ".
								"comments	= '".(int)$this->count_comments($page_id)."', ".
								"commented	= NOW() ".
							"WHERE page_id = '".quote($this->dblink, $page_id)."' ".
							"LIMIT 1");

						$this->log(3, str_replace('%2', $title.' '.$this->get_page_title($title), str_replace('%1', $this->tag.' '.$this->page['title'], $this->get_translation('LogSplittedPage', $this->config['language']))));
						unset($accept_action);
						$xml->comments();
						$this->set_message($this->get_translation('ModerateCommentsMoved'));
						$this->redirect($this->href('moderate'));
					}
				}
			}
		}

		// make counter query
		$sql = "SELECT COUNT(tag) AS n ".
			"FROM {$this->config['table_prefix']}page ".
			"WHERE comment_on_id = '{$this->page['page_id']}'";

		// count posts and make pagination
		$count		= $this->load_single($sql);
		$pagination	= $this->pagination($count['n'], $limit, 'p', 'ids='.implode('-', $set), 'moderate');

		// make collector query
		$sql = "SELECT p.page_id, p.tag, p.user_id, p.owner_id, ip, LEFT(body, 500) AS body, created, u.user_name AS user, o.user_name as owner ".
			"FROM {$this->config['table_prefix']}page p ".
				"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
				"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.owner_id = o.user_id) ".
			"WHERE comment_on_id = '{$this->page['page_id']}' ".
			"ORDER BY created ASC ".
			"LIMIT {$pagination['offset']}, $limit";

		// load comments data
		$comments = $this->load_all($sql);

		$this->page['body'] = $this->format($this->page['body'], 'bbcode');

		$body = $this->format($this->page['body'], 'cleanwacko');
		$body = ( strlen($body) > 300 ? substr($body, 0, 300).'...' : $body.' (-)' );

		// display list
		echo $this->form_open('moderate');

		// pagination
		if (isset($pagination['text']))
		{
			echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
		}

		// confirm topic deletion
		if ($accept_action == 'topic_delete')
		{
			$accept_text = '&laquo;'.$this->page['title'].'&raquo;';

			echo '<input name="'.$accept_action.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.$this->get_translation('ModerateDeleteConfirm').'</th></td>'.
					'<tr><td>'.
						'<em>'.$accept_text.'</em><br />'.
						'<input name="accept" id="submit" type="submit" value="'.$this->get_translation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->get_translation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
					'</td></tr>'.
				'</table><br />'."\n";
		}
		// select target forum section / cluster for topic/page moving
		else if ($accept_action == 'topic_move')
		{
			$accept_text = '&laquo;'.$this->page['title'].'&raquo;';

			if ($forum_cluster === true)
			{
				$sections = $this->load_all(
					"SELECT p.tag, p.title ".
					"FROM {$this->config['table_prefix']}page AS p ".
						#"{$this->config['table_prefix']}acl AS a ".
					"WHERE ". #p.page_id = a.page_id ".
						#"AND a.`comment` = '' ".
						#"AND
						"p.tag LIKE '".quote($this->dblink, $this->config['forum_cluster'])."/%' ".
					"ORDER BY time ASC", 1);

				foreach ($sections as $section)
				{
					$list .= "<option value=\"{$section['tag']}\">{$section['title']}</option>\n";
				}

				echo '<input name="'.$accept_action.'" type="hidden" value="1" />'.
					'<table cellspacing="1" cellpadding="4" class="formation">'.
						'<tr><th>'.$this->get_translation('ModerateMoveConfirm').'</th></td>'.
						'<tr><td>'.
							( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
							'<em>'.$accept_text.'</em><br />'.
							'<select name="section">'.
								'<option selected="selected"></option>'.
								$list.
							'</select> or <input name="cluster" size="50" maxlength="250" /><br />'.
							'<input name="accept" id="submit" type="submit" value="'.$this->get_translation('ModerateAccept').'" /> '.
							'<input name="cancel" id="button" type="button" value="'.$this->get_translation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
						'</td></tr>'.
					'</table><br />'."\n";
			}
			else
			{
				echo '<input name="'.$accept_action.'" type="hidden" value="1" />'.
					'<table cellspacing="1" cellpadding="4" class="formation">'.
						'<tr><th>'.$this->get_translation('ModeratePgMoveConfirm').'</th></td>'.
						'<tr><td>'.
							( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
							'<em>'.$accept_text.'</em><br />'.
							'<input name="cluster" size="50" maxlength="250" /> '.
							'<input name="accept" id="submit" type="submit" value="'.$this->get_translation('ModerateAccept').'" /> '.
							'<input name="cancel" id="button" type="button" value="'.$this->get_translation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
						'</td></tr>'.
					'</table><br />'."\n";
			}
		}
		// enter a new name for topic renaming
		else if ($accept_action == 'topic_rename')
		{
			echo '<input name="'.$accept_action.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.$this->get_translation('ModerateRenameConfirm').'</th></td>'.
					'<tr><td>'.
						( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
						'<input name="title" size="50" maxlength="100" value="'.$this->page['title'].'" /> '.
						'<input name="accept" id="submit" type="submit" value="'.$this->get_translation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->get_translation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
					'</td></tr>'.
				'</table><br />'."\n";
		}
		// confirm comments deletion
		else if ($accept_action == 'posts_delete')
		{
			echo '<input name="'.$accept_action.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.str_replace('%2', ( count($set) > 1 ? $this->get_translation('ModerateComments') : $this->get_translation('ModerateComment') ), str_replace('%1', count($set), $this->get_translation('ModerateComDelConfirm'))).'</th></td>'.
					'<tr><td>'.
						'<input name="accept" id="submit" type="submit" value="'.$this->get_translation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->get_translation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
					'</td></tr>'.
				'</table><br />'."\n";
		}
		// enter a new name for the detached topic
		else if ($accept_action == 'posts_split')
		{
			echo '<input name="'.$accept_action.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.( $forum_cluster === true ? $this->get_translation('ModerateSplitNewName') : $this->get_translation('ModerateSplitPageName') ).'</th></td>'.
					'<tr><td>'.
						( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
						'<input name="title" size="50" maxlength="250" value="" /> '.
						'<input name="accept" id="submit" type="submit" value="'.$this->get_translation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->get_translation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
						'<br />'.
						'<small>'.
						'<input type="radio" name="scheme" value="after" id="after" '.( isset($_POST['scheme']) && $_POST['scheme'] != 'selected' ? 'checked="checked" ' : '' ).'/> <label for="after">'.$this->get_translation('ModerateSplitAllAfter').'</label><br />'.
						'<input type="radio" name="scheme" value="selected" id="selected" '.( isset($_POST['scheme']) && $_POST['scheme'] == 'selected' ? 'checked="checked" ' : '' ).'/> <label for="selected">'.str_replace('%1', count($set), $this->get_translation('ModerateSplitSelected')).'</label>'.
						'</small>'.
					'</td></tr>'.
				'</table><br />'."\n";
		}

		// print moderation controls...
		echo '<input name="ids" type="hidden" value="'.implode('-', $set).'" />'.
			'<input name="p" type="hidden" value="'.(isset($_GET['p']) ? $_GET['p'] : '').'" />'."\n";
		echo '<table cellspacing="1" cellpadding="4">'.
				'<tr class="lined">'.
					'<td colspan="2">'.
						'<input name="topic_delete" id="submit" type="submit" value="'.$this->get_translation('ModerateDeleteTopic').'" /> '.
						'<input name="topic_move" id="submit" type="submit" value="'.$this->get_translation('ModerateMove').'" /> '.
						( $forum_cluster === true
							? '<input name="topic_rename" id="submit" type="submit" value="'.$this->get_translation('ModerateRename').'" /> '
							: ''
						).
						( $forum_cluster === true
							? ( $this->has_access('comment', $this->page['page_id'], GUEST) === true
								? '<input name="topic_lock" id="submit" type="submit" value="'.$this->get_translation('ModerateLock').'" /> '
								: '<input name="topic_unlock" id="submit" type="submit" value="'.$this->get_translation('ModerateUnlock').'" /> '
							  )
							: ''
						).
						'&nbsp;&nbsp;&nbsp;<a href="'.$this->href('', $this->config['moders_docs']).'">'.$this->get_translation('Help').'...</a> '.
					'</td>'.
				'</tr>'."\n".
				'<tr class="formation">'.
					'<th colspan="2">'.( $this->has_access('comment', $this->page['page_id'], GUEST) === false ? str_replace('{theme}', $this->config['theme_url'], $this->get_translation('lockicon')) : '' ).$this->get_translation('ForumTopics').'</th>'.
				'</tr>'."\n".
				'<tr class="lined">'.
					'<td colspan="2" style="padding-bottom:30px;">'.
						'<strong><small><span'.( $this->is_admin() ? ' title="'.$this->page['ip'].'"' : '' ).'>'.( $forum_cluster === false ? $this->page['owner_name'] : ( $this->page['user_name'] == GUEST ? '<em>'.$this->get_translation('Guest').'</em>' : $this->page['user_name'] ) ).'</span> ('.$this->get_time_string_formatted($this->page['created']).')</small></strong>'.
						'<br />'.$body.
					'</td>'.
				'</tr>'."\n";

		if ($comments)
		{
			echo '<tr class="lined">'.
					'<td colspan="2">'.
						'<input name="posts_delete" id="submit" type="submit" value="'.$this->get_translation('ModerateDeletePosts').'" /> '.
						'<input name="posts_split" id="submit" type="submit" value="'.$this->get_translation('ModerateSplit').'" /> '.
						'&nbsp;&nbsp;&nbsp;<a href="'.$this->href('', $this->config['moders_docs']).'">'.$this->get_translation('Help').'...</a> '.
						'<br />'."\n".
						'<input name="set" id="submit" type="submit" value="'.$this->get_translation('ModerateSet').'" /> '.
						( $set
							? '<input name="reset" id="submit" type="submit" value="'.$this->get_translation('ModerateReset').'" /> '.
							  '&nbsp;&nbsp;&nbsp;<small>ids: '.implode(', ', $set).'</small>'
							: ''
						).
					'</td>'.
				'</tr>'."\n".
				'<tr class="formation">'.
					'<th colspan="2">'.$this->get_translation('ForumComments').'</th>'.
				'</tr>'."\n";

			// ...and comments list
			foreach ($comments as $comment)
			{
				$comment['body'] = $this->format($comment['body'], 'bbcode');

				$desc = $this->format($comment['body'], 'cleanwacko');
				$desc = ( strlen($desc) > 300 ? substr($desc, 0, 300).'...' : $desc.' (-)' );

				echo '<tr>'.
						'<td valign="middle" style="width:10px;" class="label"><input name="'.$comment['page_id'].'" type="checkbox" value="id" '.( in_array($comment['page_id'], $set) ? 'checked="checked "' : '' ).'/></td>'.
						'<td align="left" style="padding-left:5px;"><strong><small><span'.( $this->is_admin() ? ' title="'.$comment['ip'].'"' : '' ).'>'.( $comment['user'] == GUEST ? '<em>'.$this->get_translation('Guest').'</em>' : $comment['user'] ).'</span> ('.$this->get_time_string_formatted($comment['created']).') &nbsp;&nbsp; '.$this->compose_link_to_page($comment['tag'], '', '&lt;#&gt;', 0).( $comment['owner'] != GUEST ? ' &nbsp;&nbsp; <a href="'.$this->href('', $this->config['users_page'], 'profile='.$comment['owner']).'">'.$this->get_translation('ModerateUserProfile').'</a>' : '' ).'</small></strong>'.
							'<br />'.$desc.'</td>'.
					'</tr>'."\n".
					'<tr class="lined">'.
						'<td colspan="2"></td>'.
					'</tr>'."\n";
			}
		}

		echo '</table>'."\n";

		// pagination
		if (isset($pagination['text']))
		{
			echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
		}

		echo $this->form_close();
	}
}
else
{
	echo $this->get_translation('NotModerator');
}

// set forum context
if ($forum_cluster === true)
{
	$this->forum = true;
}

?>
</div>