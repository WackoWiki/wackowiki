<?php

// ToDo:
//

?>

<div class="page">
<h3><?php echo $this->get_translation('Moderation').' '.( $this->forum === true ? $this->get_translation('Topics') : $this->get_translation('ModerateSection') ).' '.$this->compose_link_to_page($this->tag, '', $this->page['title'], 0);
	echo ( $this->forum === true ? '<br />['.$this->compose_link_to_page(substr($this->tag, 0, strrpos($this->tag, '/')), 'moderate', 'moderate section...', 0).']' : '' ) // ru: модерировать раздел ?></h3>

<?php

// local functions
function moderate_page_exists(&$engine, $tag)
{
	if ($page = $engine->load_single(
	"SELECT page_id ".
	"FROM {$engine->config['table_prefix']}page ".
	"WHERE tag = '".quote($this->dblink, $tag)."' ".
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

function moderate_rename_topic(&$engine, $oldtag, $newtag, $title = '')
{
	// set forum context
	$forum_context	= $engine->forum;
	$engine->forum	= true;

	$supertag = $engine->npj_translit($newtag);

	$engine->rename_page($oldtag, $newtag, $supertag);
	$engine->remove_referrers($oldtag);
	$engine->remove_links($oldtag);
	$engine->clear_cache_wanted_page($newtag);
	$engine->clear_cache_wanted_page($supertag);

	// rerender page and update link table in new context
	$page = $engine->load_page($newtag);
	$engine->current_context++;
	$engine->context[$engine->current_context] = $newtag;
	$engine->clear_link_table();
	$engine->start_link_tracking();
	$dummy = $engine->format($page['body_r'], 'post_wacko');
	$engine->stop_link_tracking();
	$engine->write_link_table($newtag);
	$engine->clear_link_table();
	$engine->current_context--;

	// update title in meta and body if needed
	if ($title != '')
	{
		// resave modified body
		$page['body'] = preg_replace('/^==.*?==/', '=='.$title.'==', $page['body']);
		$engine->save_page($newtag, false, $page['body'], '', '', '', '', true);

		$engine->query(
			"UPDATE {$engine->config['table_prefix']}page ".
			"SET title = '".quote($this->dblink, $title)."' ".
			"WHERE tag = '".quote($this->dblink, $newtag)."' ".
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

	if ($topics == false || $base == false) return false;

	foreach ($topics as $topic)
	{
		// we don't really want to touch the base topic
		if ($topic != $base)
		{
			// move comments to the base topic
			$engine->query(
				"UPDATE {$engine->config['table_prefix']}page SET ".
					"comment_on_id = '".quote($this->dblink, $base)."', ".
				"WHERE comment_on_id = '".quote($this->dblink, $topic)."'");

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
				$engine->save_page('Comment'.$num, false, $page['body'], '', '', $base, '', true);

				// restore creation date
				$engine->query(
					"UPDATE {$engine->config['table_prefix']}page SET ".
						"modified		= '".quote($this->dblink, $page['modified'])."', ".
						"created		= '".quote($this->dblink, $page['created'])."', ".
						"commented		= '".quote($this->dblink, $page['commented'])."', ".
						"owner_id		= '".quote($this->dblink, $page['owner_id'])."', ".
						"user_id		= '".quote($this->dblink, $page['user_id'])."', ".
						"ip			= '".quote($this->dblink, $page['ip'])."' ".
					"WHERE tag = '".quote($this->dblink, 'Comment'.$num)."'");

				// remove old page remnants
				moderate_delete_page($engine, $topic);
			}
		}
	}

	// update link table
	$comments = $engine->load_all(
		"SELECT tag, body_r ".
		"FROM {$engine->config['table_prefix']}page ".
		"WHERE comment_on_id = '".quote($this->dblink, $base)."'");

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
			"comments	= '".(int)$engine->count_comments($base)."', ".
			"commented	= NOW() ".
		"WHERE tag = '".quote($this->dblink, $base)."' ".
		"LIMIT 1");

	// restore forum context
	$engine->forum = $forum_context;

	return true;
}

function moderate_split_topic(&$engine, $comment_ids, $oldtag, $newtag, $title)
{
	if (is_array($comment_ids) === false)
	{
		return false;
	}

	// set forum context
	$forum_context	= $engine->forum;
	$engine->forum	= true;

	// resave first comment as new topic page
	$first_tag		= $engine->get_tag_by_id(array_shift($comment_ids));
	$page			= $engine->load_page($first_tag);

	// resave modified body
	$page['body']	= '=='.$title."==\n\n".$page['body'];
	$engine->save_page($newtag, false, $page['body'], '', '', '', $title, true);

	// bug-resistent check: has page been really resaved?
	if ($engine->load_single(
	"SELECT page_id FROM {$engine->config['table_prefix']}page ".
	"WHERE tag = '".quote($this->dblink, $newtag)."'") != true)
	{
		$engine->forum = $forum_context;
		return false;
	}

	// restore original metadata
	$engine->query(
		"UPDATE {$engine->config['table_prefix']}page SET ".
			"modified		= '".quote($this->dblink, $page['modified'])."', ".
			"created	= '".quote($this->dblink, $page['created'])."', ".
			"owner_id		= '".quote($this->dblink, $page['owner_id'])."', ".
			"user_id		= '".quote($this->dblink, $page['user_id'])."', ".
			"ip			= '".quote($this->dblink, $page['ip'])."' ".
		"WHERE tag = '".quote($this->dblink, $newtag)."'");

	// move remaining comments to the new topic
	foreach ($comment_ids as $id)
	{
		$engine->query(
			"UPDATE {$engine->config['table_prefix']}page SET ".
				"comment_on_id = '".quote($this->dblink, $newtag)."', ".
			"WHERE page_id = '".quote($this->dblink, $id)."'");
	}

	// remove old first comment
	moderate_delete_page($engine, $first_tag);

	// update link table
	$page = $engine->load_page($newtag);
	$engine->current_context++;
	$engine->context[$engine->current_context] = $newtag;
	$engine->clear_link_table();
	$engine->start_link_tracking();
	$dummy = $engine->format($page['body_r'], 'post_wacko');
	$engine->stop_link_tracking();
	$engine->write_link_table($newtag);
	$engine->clear_link_table();
	$engine->current_context--;

	// recount comments for old and new topics
	$engine->query(
		"UPDATE {$engine->config['table_prefix']}page SET ".
			"comments	= '".(int)$engine->count_comments($newtag)."', ".
			"commented	= NOW() ".
		"WHERE tag = '".quote($this->dblink, $newtag)."' ".
		"LIMIT 1");
	$engine->query(
		"UPDATE {$engine->config['table_prefix']}page ".
		"SET comments = '".(int)$engine->count_comments($oldtag)."' ".
		"WHERE tag = '".quote($this->dblink, $oldtag)."' ".
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

if (($this->is_moderator() && $this->has_access('read')) || $this->is_admin())
{
	$acceptAction = '';
	$error = '';

	if (substr($this->tag, 0, strlen($this->config['forum_cluster'])) == $this->config['forum_cluster'])
	{
		$forumCluster = true;
	}
	else
	{
		$forumCluster = false;
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
	if ($this->forum !== true && $forumCluster === true)
	{
		// number of topics to display
		$limit = 40;

		// PROCESS INPUT
		// delete selected topic(s)
		if ($_POST['delete'] && $set == true)
		{
			$acceptAction	= 'delete';

			// actually remove topics
			if ($_POST['accept'])
			{
				foreach ($set as $id)
				{
					$page = $this->load_page($this->get_tag_by_id($id), '', LOAD_NOCACHE, LOAD_META);
					moderate_delete_page($this, $page['tag']);
					$this->log(1, str_replace('%2', $page['user_id'], str_replace('%1', $page['tag'], $this->get_translation('LogRemovedPage', $this->config['language']))));
				}
				unset($acceptAction);
				$xml->comments();
				$set = array();
				$this->set_message('Selected topics successfully deleted.'); // ru: Выбранные темы успешно удалены.
				$this->redirect($this->href('moderate'));
			}
		}
		// move selected topics elsewhere
		else if ($_POST['move'] && $set == true)
		{
			$acceptAction	= 'move';

			// processing...
			if ($_POST['accept'] && $_POST['section'])
			{
				$i = 0;
				foreach ($set as $id)
				{
					$oldtags[] = $this->get_tag_by_id($id);
					$newtags[] = $_POST['section'].substr($oldtags[$i], strrpos($oldtags[$i], '/'));

					if (moderate_page_exists($this, $newtags[$i++]) === true)
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
						moderate_rename_topic($this, $oldtags[$i], $newtags[$i]);
						$this->log(3, str_replace('%2', $newtags[$i], str_replace('%1', $oldtags[$i], $this->get_translation('LogRenamedPage', $this->config['language']))));
						$i++;
					}
					unset($acceptAction, $i, $oldtags, $newtags);
					$xml->comments();
					$set = array();
					$this->set_message('Selected topics successfully relocated.'); // ru: Выбранные темы успешно перемещены.
					$this->redirect($this->href('moderate'));
				}
			}
		}
		// rename topics
		else if ($_POST['rename'] && $set == true)
		{
			$acceptAction	= 'rename';

			// perform accepted rename
			if ($_POST['accept'])
			{
				$oldtag		= $this->get_tag_by_id($set[0]);
				$tag		= trim($_POST['title'], " \t");
				$title		= $tag;
				$tag 		= ucwords($tag);
				$tag		= preg_replace('/[^- \\w]/', '', $tag);
				$tag		= str_replace(array(' ', "\t"), '', $tag);

				// check new tag existance
				if ($oldtag != $this->tag.'/'.$tag && moderate_page_exists($this, $this->tag.'/'.$tag) === true)
				{
					$error = $this->get_translation('ModerateRenameExists');
				}

				// okey, then rename page
				if ($tag != '' && $error != true)
				{
					moderate_rename_topic($this, $oldtag, $this->tag.'/'.$tag, $title);
					$this->log(3, str_replace('%2', $this->tag.'/'.$tag.' '.$title, str_replace('%1', $oldtag, $this->get_translation('LogRenamedPage', $this->config['language']))));
					unset($acceptAction, $oldtag, $tag, $title);
					$xml->comments();
					$set = array();
					$this->set_message('Subject successfully renamed. Note: if the subject signed electronically, its title on the same.'); // ru: Тема успешно переименована. Заметьте: если тема электронно подписана, ее заголовок оставлен неизменным.
					$this->redirect($this->href('moderate'));
				}
			}
		}
		// merge several topics into a single topic
		else if ($_POST['merge'] && $set == true)
		{
			$acceptAction	= 'merge';

			if (count($set) < 2)
			{
				$error = $this->get_translation('ModerateMerge2Min');
			}

			// perform accepted action
			if ($_POST['accept'] && $_POST['base'] && !$error)
			{
				foreach ($set as $id)
				{
					$topics[] = $this->get_tag_by_id($id);
				}
				moderate_merge_topics($this, $_POST['base'], $topics);
				$this->log(3, str_replace('%2', $_POST['base'], str_replace('%1', '##'.implode('##, ##', $topics).'##', $this->get_translation('LogMergedPages', $this->config['language']))));
				unset($acceptAction, $topics);
				$xml->comments();
				$set = array();
				$this->set_message('Selected topics successfully merged.'); // ru: Выбранные темы успешно склеены.
				$this->redirect($this->href('moderate'));
			}
		}
		// lock topics
		else if ($_POST['lock'] && $set == true)
		{
			foreach ($set as $id)
			{
				$page = $this->load_page($this->get_tag_by_id($id), '', LOAD_NOCACHE, LOAD_META);
				$this->log(2, str_replace('%1', $page['tag'].' '.$page['title'], $this->get_translation('LogTopicLocked', $this->config['language'])));
				// DON'T USE BLANK PRIVILEGE LIST!!! Only "negative all" - '!*'
				$this->save_acl($id, 'comment', '!*');
			}
			$set = array();
			$this->set_message('Selected topics successfully blocked.'); // ru: Выбранные темы успешно заблокированы.
			$this->redirect($this->href('moderate'));
		}
		// unlock topics
		else if ($_POST['unlock'] && $set == true)
		{
			foreach ($set as $id)
			{
				$page = $this->load_page($this->get_tag_by_id($id), '', LOAD_NOCACHE, LOAD_META);
				$this->log(2, str_replace('%1', $page['tag'].' '.$page['title'], $this->get_translation('LogTopicUnlocked', $this->config['language'])));
				$this->save_acl($id, 'comment', '*');
			}
			$set = array();
			$this->set_message('Selected topics successfully unlocked.'); // ru: Выбранные темы успешно разблокированы.
			$this->redirect($this->href('moderate'));
		}

		// make counter query
		$sql = "SELECT COUNT(p.tag) AS n ".
			"FROM {$this->config['table_prefix']}page AS p, ".
				"{$this->config['table_prefix']}acl AS a ".
			"WHERE p.page_id = a.page_id ".
				#"AND a.`create` = '' ".
				"AND p.tag LIKE '{$this->tag}/%'";

		// count topics and make pagination
		$count		= $this->load_single($sql);
		$pagination	= $this->pagination($count['n'], $limit, 'p', 'ids='.implode('-', $set), 'moderate');

		// make collector query
		$sql = "SELECT p.page_id, p.tag, title, p.owner_id, p.user_id, ip, comments, created, u.user_name AS user,  o.user_name as owner ".
			"FROM {$this->config['table_prefix']}page AS p ".
					"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
					"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.owner_id = o.user_id), ".
				"{$this->config['table_prefix']}acl AS a ".
			"WHERE p.page_id = a.page_id ".
				#"AND a.`create` = '' ".
				"AND p.tag LIKE '{$this->tag}/%' ".
			"ORDER BY commented DESC ".
			"LIMIT {$pagination['offset']}, $limit";

		// load topics data
		$topics	= $this->load_all($sql);

		// display list
		echo $this->form_open('moderate');
		echo '<table><tr>'.
				'<td align="right">'.( $pagination['text'] == true ? '<small>'.$pagination['text'].'</small>' : '&nbsp;' ).'</td>'.
			'</tr></table>'."\n";

		// confirm deletion
		if ($acceptAction == 'delete')
		{
			foreach ($set as $id)
			{
				$acceptText[] = '&laquo;'.$this->get_page_title('', $id).'&raquo;';
			}

			echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.$this->get_translation('ModerateDeleteConfirm').'</th></td>'.
					'<tr><td>'.
						'<em>'.implode('<br />', $acceptText).'</em><br />'.
						'<input name="accept" id="submit" type="submit" value="'.$this->get_translation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->get_translation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
					'</td></tr>'.
				'</table><br />'."\n";
		}
		// select target forum section
		else if ($acceptAction == 'move')
		{
			foreach ($set as $id)
			{
				$acceptText[] = '&laquo;'.$this->get_page_title('', $id).'&raquo;';
			}

			$sections = $this->load_all(
				"SELECT p.tag, p.title ".
				"FROM {$this->config['table_prefix']}page AS p, ".
					"{$this->config['table_prefix']}acl AS a ".
				"WHERE p.page_id = a.page_id ".
					#"AND a.`comment` = '' ".
					"AND p.tag LIKE '".quote($this->dblink, $this->config['forum_cluster'])."/%' ".
				"ORDER BY time ASC", 1);

			foreach ($sections as $section)
			{
				$list .= "<option value=\"{$section['tag']}\">{$section['title']}</option>\n";
			}

			echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.$this->get_translation('ModerateMovesConfirm').'</th></td>'.
					'<tr><td>'.
						( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
						'<em>'.implode('<br />', $acceptText).'</em><br />'.
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
		else if ($acceptAction == 'rename')
		{
			echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
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
		else if ($acceptAction == 'merge')
		{
			foreach ($set as $id)
			{
				$acceptText[] = '&laquo;'.$this->get_page_title('', $id).'&raquo;';
				$topicsList[] = $this->get_tag_by_id($id);
			}

			for ($i = 0; $i < count($topicsList); $i++)
			{
				$list .= "<option value=\"{$topicsList[$i]}\">{$acceptText[$i]}</option>\n";
			}

			echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.$this->get_translation('ModerateMergeConfirm').'</th></td>'.
					'<tr><td>'.
						( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
						'<em>'.implode('<br />', $acceptText).'</em><br />'."\n".
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
			'<input name="p" type="hidden" value="'.$_GET['p'].'" />'."\n";
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
		echo '<table><tr>'.
				'<td align="right">'.( $pagination['text'] == true ? '<small>'.$pagination['text'].'</small>' : '' ).'</td>'.
			'</tr></table>'."\n";
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
			$acceptAction	= 'topic_delete';

			// actually remove topics
			if ($_POST['accept'])
			{
				$this->log(1, str_replace('%2', $this->page['user_id'], str_replace('%1', $this->page['tag'], $this->get_translation('LogRemovedPage', $this->config['language']))));
				moderate_delete_page($this, $this->tag);
				unset($acceptAction);
				$xml->comments();
				$this->set_message('Topic has been successfully removed.'); // ru: Тема успешно удалена.
				$this->redirect($this->href('moderate', substr($this->tag, 0, strrpos($this->tag, '/'))));
			}
		}
		// move topic elsewhere
		else if (isset($_POST['topic_move']))
		{
			$acceptAction	= 'topic_move';

			// processing...
			if ($_POST['accept'] && ($_POST['section'] || $_POST['cluster']))
			{
				$pos		= strrpos($this->tag, '/');
				$subtag		= substr($this->tag, ( $pos ? $pos+1 : 0 ));
				$oldtag		= $this->tag;
				$newtag		= ( $_POST['cluster'] ? ( $_POST['cluster'] == '/' ? '' : trim($_POST['cluster'], '/').'/' ) : $_POST['section'].'/' ).$subtag;

				if ($forumCluster === true)
				{
					if ($_POST['cluster'] && $_POST['cluster'] != '/')
					{
						if (moderate_page_exists($this, $_POST['cluster']) === false)
						{
							$error = $this->get_translation('ModerateMoveNotExists');
						}
					}
					else if ($_POST['section'])
					{
						if (moderate_page_exists($this, $newtag) === true)
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
					if ($forumCluster === true && $_POST['section'])
					{
						$error = str_replace('%1', $error, $this->get_translation('ModerateMoveExists'));
					}
				}
				else
				{
					moderate_rename_topic($this, $oldtag, $newtag);
					$this->log(3, str_replace('%2', $newtag, str_replace('%1', $oldtag, $this->get_translation('LogRenamedPage', $this->config['language']))));
					unset($acceptAction);
					$xml->comments();
					$this->set_message('Page successfully moved.'); // ru: Документ успешно перемещен.
					$this->redirect($this->href('moderate', $newtag));
				}
			}
		}
		// rename topic
		else if (isset($_POST['topic_rename']))
		{
			$acceptAction	= 'topic_rename';

			// perform accepted rename
			if ($_POST['accept'] && $forumCluster === true)
			{
				$pos		= strrpos($this->tag, '/');
				$section	= substr($this->tag, 0, ( $pos ? $pos : null ));
				$tag		= trim($_POST['title'], " \t");
				$title		= $tag;
				$tag 		= ucwords($tag);
				$tag		= preg_replace('/[^- \\w]/', '', $tag);
				$tag		= str_replace(array(' ', "\t"), '', $tag);
				$oldtag		= $this->tag;
				$newtag		= ( $section ? $section.'/' : '' ).$tag;

				// check new tag existance
				if ($oldtag == $newtag || moderate_page_exists($this, $newtag) === true)
				{
					$error = $this->get_translation('ModerateRenameExists');
				}

				// okey, then rename page
				if ($tag != '' && $error != true)
				{
					moderate_rename_topic($this, $oldtag, $newtag, $title);
					$this->log(3, str_replace('%2', $newtag.' '.$title, str_replace('%1', $oldtag, $this->get_translation('LogRenamedPage', $this->config['language']))));
					unset($acceptAction);
					$xml->comments();
					$this->set_message('Topic successfully renamed. Note: if the topic signed electronically, its title on the same.'); // ru: Тема успешно переименована. Заметьте: если тема электронно подписана, ее заголовок оставлен неизменным.
					$this->redirect($this->href('moderate', $newtag));
				}
			}
		}
		// lock topic
		else if (isset($_POST['topic_lock']) && $forumCluster === true)
		{
			// DON'T USE BLANK PRIVILEGE LIST!!! Only "negative all" - '!*'
			$this->save_acl($this->page['page_id'], 'comment', '!*');
			$this->log(2, str_replace('%1', $this->page['tag'].' '.$this->page['title'], $this->get_translation('LogTopicLocked', $this->config['language'])));
			$this->set_message('Topic successfully blocked.'); // ru: Тема успешно заблокирована.
			$this->redirect($this->href('moderate'));
		}
		// unlock topic
		else if (isset($_POST['topic_unlock']) && $forumCluster === true)
		{
			$this->save_acl($this->page['page_id'], 'comment', '*');
			$this->log(2, str_replace('%1', $this->page['tag'].' '.$this->page['title'], $this->get_translation('LogTopicUnlocked', $this->config['language'])));
			$this->set_message('Topic successfully unlocked.'); // ru: Тема успешно разблокирована.
			$this->redirect($this->href('moderate'));
		}
		// delete selected comments
		else if (isset($_POST['posts_delete']) && $set == true)
		{
			$acceptAction	= 'posts_delete';

			// actually remove topics
			if ($_POST['accept'])
			{
				foreach ($set as $id)
				{
					$page = $this->load_page($this->get_tag_by_id($id), '', LOAD_NOCACHE, LOAD_META);
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

				unset($acceptAction);
				$xml->comments();
				$set = array();
				$this->set_message('Selected comments removed successfully.'); // ru: Выбранные комментарии успешно удалены.
				$this->redirect($this->href('moderate'));
			}
		}
		// split topic
		else if (isset($_POST['posts_split']) && $set == true)
		{
			$acceptAction	= 'posts_split';

			// perform accepted splitting
			if (isset($_POST['accept']) && isset($_POST['title']))
			{
				$section	= substr($this->tag, 0, strrpos($this->tag, '/'));
				$oldtag		= $this->tag;
				$tag		= trim($_POST['title'], "/ \t");
				$title		= $tag;
				$tag 		= ucwords($tag);
				$tag		= preg_replace('/[^- \\w]/', '', $tag);
				$tag		= str_replace(array(' ', "\t"), '', $tag);

				if ($forumCluster === true)
				{
					// check new tag existance
					if ($oldtag != $section.'/'.$tag && moderate_page_exists($this, $section.'/'.$tag) === true)
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

						$first_comment	= $this->load_page($this->get_tag_by_id($_set[0]));
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

					if ($forumCluster === true)
					{
						if (moderate_split_topic($this, $comment_ids, $oldtag, $section.'/'.$tag, $title) === true)
						{
							$this->log(3, str_replace('%2', $section.'/'.$tag.' '.$title, str_replace('%1', $this->tag.' '.$this->page['title'], $this->get_translation('LogSplittedPage', $this->config['language']))));
							unset($acceptAction);
							$xml->comments();
							$this->set_message('Selected comments successfully separated in a new topic.'); // ru: Выбранные комментарии успешно отделены в новую тему.
							$this->redirect($this->href('moderate', $section.'/'.$tag));
						}
						else
						{
							$this->set_message('Note: For some reason to separate the selected messages to a new topic failed. '.
								'Usually this should not happen, so let the incident site administrator. '.
								'As a precaution, issue has been preserved in its original form.'); // ru: Внимание: по какой-то причине не удалось отделить выбранные сообщения в новую тему.     Обычно такое не должно случаться, поэтому сообщите о происшедшем администратору сайта.     В качестве меры предосторожности тема была сохранена в исходном виде.
							$this->log(2, 'Error when separating comments from the topic ((/'.$this->tag.')) a new topic '.$section.'/'.$tag.': page was not created');  // ru: Ошибка при отделении комментариев из темы     в новую тему        документ не был создан
						}
					}
					else
					{
						foreach ($comment_ids as $id)
						{
							$idsStr .= "'".quote($this->dblink, $id)."', ";
						}
						$idsStr = substr($idsStr, 0, strlen($idsStr)-2);

						// move
						$this->query(
							"UPDATE {$this->config['table_prefix']}page SET ".
								"comment_on_id = '".quote($this->dblink, $title)."', ".
							"WHERE page_id IN ( $idsStr )");

						// update link table
						$comments = $this->load_all(
							"SELECT tag, body_r ".
							"FROM {$this->config['table_prefix']}page ".
							"WHERE page_id IN ( $idsStr )");

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
							"SET comments = '".(int)$this->count_comments($this->tag)."' ".
							"WHERE tag = '".quote($this->dblink, $this->tag)."' ".
							"LIMIT 1");
						$this->query(
							"UPDATE {$this->config['table_prefix']}page SET ".
								"comments	= '".(int)$this->count_comments($title)."', ".
								"commented	= NOW() ".
							"WHERE tag = '".quote($this->dblink, $title)."' ".
							"LIMIT 1");

						$this->log(3, str_replace('%2', $title.' '.$this->get_page_title($title), str_replace('%1', $this->tag.' '.$this->page['title'], $this->get_translation('LogSplittedPage', $this->config['language']))));
						unset($acceptAction);
						$xml->comments();
						$this->set_message('Selected comments successfully migrated to a given page.'); // ru: Выбранные комментарии успешно перенесены в заданный документ.
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
		echo '<table><tr>'.
				'<td align="right">'.( isset($pagination['text']) && $pagination['text'] == true ? '<small>'.$pagination['text'].'</small>' : '&nbsp;' ).'</td>'.
			'</tr></table>'."\n";

		// confirm topic deletion
		if ($acceptAction == 'topic_delete')
		{
			$acceptText = '&laquo;'.$this->page['title'].'&raquo;';

			echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.$this->get_translation('ModerateDeleteConfirm').'</th></td>'.
					'<tr><td>'.
						'<em>'.$acceptText.'</em><br />'.
						'<input name="accept" id="submit" type="submit" value="'.$this->get_translation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->get_translation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
					'</td></tr>'.
				'</table><br />'."\n";
		}
		// select target forum section / cluster for topic/page moving
		else if ($acceptAction == 'topic_move')
		{
			$acceptText = '&laquo;'.$this->page['title'].'&raquo;';

			if ($forumCluster === true)
			{
				$sections = $this->load_all(
					"SELECT p.tag, p.title ".
					"FROM {$this->config['table_prefix']}page AS p, ".
						"{$this->config['table_prefix']}acl AS a ".
					"WHERE p.page_id = a.page_id ".
						#"AND a.`comment` = '' ".
						"AND p.tag LIKE '".quote($this->dblink, $this->config['forum_cluster'])."/%' ".
					"ORDER BY time ASC", 1);

				foreach ($sections as $section)
				{
					$list .= "<option value=\"{$section['tag']}\">{$section['title']}</option>\n";
				}

				echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
					'<table cellspacing="1" cellpadding="4" class="formation">'.
						'<tr><th>'.$this->get_translation('ModerateMoveConfirm').'</th></td>'.
						'<tr><td>'.
							( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
							'<em>'.$acceptText.'</em><br />'.
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
				echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
					'<table cellspacing="1" cellpadding="4" class="formation">'.
						'<tr><th>'.$this->get_translation('ModeratePgMoveConfirm').'</th></td>'.
						'<tr><td>'.
							( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
							'<em>'.$acceptText.'</em><br />'.
							'<input name="cluster" size="50" maxlength="250" /> '.
							'<input name="accept" id="submit" type="submit" value="'.$this->get_translation('ModerateAccept').'" /> '.
							'<input name="cancel" id="button" type="button" value="'.$this->get_translation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
						'</td></tr>'.
					'</table><br />'."\n";
			}
		}
		// enter a new name for topic renaming
		else if ($acceptAction == 'topic_rename')
		{
			echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
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
		else if ($acceptAction == 'posts_delete')
		{
			echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.str_replace('%2', ( count($set) > 1 ? $this->get_translation('ModerateComments') : $this->get_translation('ModerateComment') ), str_replace('%1', count($set), $this->get_translation('ModerateComDelConfirm'))).'</th></td>'.
					'<tr><td>'.
						'<input name="accept" id="submit" type="submit" value="'.$this->get_translation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->get_translation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
					'</td></tr>'.
				'</table><br />'."\n";
		}
		// enter a new name for the detached topic
		else if ($acceptAction == 'posts_split')
		{
			echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.( $forumCluster === true ? $this->get_translation('ModerateSplitNewName') : $this->get_translation('ModerateSplitPageName') ).'</th></td>'.
					'<tr><td>'.
						( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
						'<input name="title" size="50" maxlength="250" value="" /> '.
						'<input name="accept" id="submit" type="submit" value="'.$this->get_translation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->get_translation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
						'<br />'.
						'<small>'.
						'<input type="radio" name="scheme" value="after" id="after" '.( $_POST['scheme'] != 'selected' ? 'checked="checked" ' : '' ).'/> <label for="after">'.$this->get_translation('ModerateSplitAllAfter').'</label><br />'.
						'<input type="radio" name="scheme" value="selected" id="selected" '.( $_POST['scheme'] == 'selected' ? 'checked="checked" ' : '' ).'/> <label for="selected">'.str_replace('%1', count($set), $this->get_translation('ModerateSplitSelected')).'</label>'.
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
						( $forumCluster === true
							? '<input name="topic_rename" id="submit" type="submit" value="'.$this->get_translation('ModerateRename').'" /> '
							: ''
						).
						( $forumCluster === true
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
						'<strong><small><span'.( $this->is_admin() ? ' title="'.$this->page['ip'].'"' : '' ).'>'.( $forumCluster === false ? $this->page['owner_name'] : ( $this->page['user'] == GUEST ? '<em>'.$this->get_translation('Guest').'</em>' : $this->page['user'] ) ).'</span> ('.$this->get_time_string_formatted($this->page['created']).')</small></strong>'.
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
		echo '<table><tr>'.
				'<td align="right">'.( isset($pagination['text']) && $pagination['text'] == true ? '<small>'.$pagination['text'].'</small>' : '' ).'</td>'.
			'</tr></table>'."\n";
		echo $this->form_close();
	}
}
else
{
	echo $this->get_translation('NotModerator');
}

// set forum context
if ($forumCluster === true) $this->forum = true;

?>
</div>