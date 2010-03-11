<?php

// ToDo:
//

?>

<div class="page">
<h3><?php echo $this->GetTranslation('Moderation').' '.( $this->forum === true ? $this->GetTranslation('Topics') : $this->GetTranslation('ModerateSection') ).' '.$this->ComposeLinkToPage($this->tag, '', $this->page['title'], 0);
	echo ( $this->forum === true ? '<br />['.$this->ComposeLinkToPage(substr($this->tag, 0, strrpos($this->tag, '/')), 'moderate', 'moderate section...', 0).']' : '' ) // ru: модерировать раздел ?></h3>

<?php

// local functions
function ModeratePageExists(&$engine, $tag)
{
	if ($page = $engine->LoadSingle(
	"SELECT page_id ".
	"FROM {$engine->config['table_prefix']}pages ".
	"WHERE tag = '".quote($this->dblink, $tag)."' ".
	"LIMIT 1"))
		return true;
	else
		return false;
}

// applicable for both topics and comments
function ModerateDeletePage(&$engine, $tag)
{
	if (!$tag) return false;
	$engine->RemoveReferrers($tag);
	$engine->RemoveLinks($tag);
	$engine->RemoveAcls($tag);
	$engine->RemoveWatches($tag);
	$engine->RemoveRatings($tag);
	$engine->RemoveComments($tag);
	$engine->RemoveFiles($tag);
	$engine->RemovePage($tag);
	return true;
}

function ModerateRenameTopic(&$engine, $oldtag, $newtag, $title = '')
{
	// set forum context
	$forum_context	= $engine->forum;
	$engine->forum	= true;

	$supertag = $engine->NpjTranslit($newtag);

	$engine->RenamePage($oldtag, $newtag, $supertag);
	$engine->RemoveReferrers($oldtag);
	$engine->RemoveLinks($oldtag);
	$engine->ClearCacheWantedPage($newtag);
	$engine->ClearCacheWantedPage($supertag);

	// rerender page and update links table in new context
	$page = $engine->LoadPage($newtag);
	$engine->current_context++;
	$engine->context[$engine->current_context] = $newtag;
	$engine->ClearLinkTable();
	$engine->StartLinkTracking();
	$dummy = $engine->Format($page['body_r'], 'post_wacko');
	$engine->StopLinkTracking();
	$engine->WriteLinkTable($newtag);
	$engine->ClearLinkTable();
	$engine->current_context--;

	// update title in meta and body if needed
	if ($title != '')
	{
		// resave modified body
		$page['body'] = preg_replace('/^==.*?==/', '=='.$title.'==', $page['body']);
		$engine->SavePage($newtag, $page['body'], '', '', '', '', true, false);

		$engine->Query(
			"UPDATE {$engine->config['table_prefix']}pages ".
			"SET title = '".quote($this->dblink, $title)."' ".
			"WHERE tag = '".quote($this->dblink, $newtag)."' ".
			"LIMIT 1");
	}

	// restore forum context
	$engine->forum = $forum_context;

	return true;
}

function ModerateMergeTopics(&$engine, $base, $topics, $movetopics = true)
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
			$engine->Query(
				"UPDATE {$engine->config['table_prefix']}pages SET ".
					"comment_on_id = '".quote($this->dblink, $base)."', ".
				"WHERE comment_on_id = '".quote($this->dblink, $topic)."'");

			// for the forum moderation only
			if ($movetopics === true)
			{
				// find latest number
				$status	= $engine->LoadAll("SHOW TABLE STATUS");
				foreach ($status as $row) if ($row['Name'] == $engine->config['table_prefix'].'pages') $num = $row['Auto_increment'];

				// resave topic body as comment
				$page = $engine->LoadPage($topic);

				$page['body'] = preg_replace('/^==.*?==(\\n)*/', '', str_replace("\r", '', $page['body']));
				$engine->SavePage('Comment'.$num, $page['body'], '', '', $base, '', true, false);

				// restore creation date
				$engine->Query(
					"UPDATE {$engine->config['table_prefix']}pages SET ".
						"modified		= '".quote($this->dblink, $page['modified'])."', ".
						"created	= '".quote($this->dblink, $page['created'])."', ".
						"commented	= '".quote($this->dblink, $page['commented'])."', ".
						"owner_id		= '".quote($this->dblink, $page['owner_id'])."', ".
						"user_id		= '".quote($this->dblink, $page['user_id'])."', ".
						"ip			= '".quote($this->dblink, $page['ip'])."' ".
					"WHERE tag = '".quote($this->dblink, 'Comment'.$num)."'");

				// remove old page remnants
				ModerateDeletePage($engine, $topic);
			}
		}
	}

	// update links table
	$comments = $engine->LoadAll(
		"SELECT tag, body_r ".
		"FROM {$engine->config['table_prefix']}pages ".
		"WHERE comment_on_id = '".quote($this->dblink, $base)."'");

	foreach ($comments as $comment)
	{
		$engine->context[++$engine->current_context] = $comment['tag'];
		$engine->ClearLinkTable();
		$engine->StartLinkTracking();
		$dummy = $engine->Format($comment['body_r'], 'post_wacko');
		$engine->StopLinkTracking();
		$engine->WriteLinkTable($comment['tag']);
		$engine->ClearLinkTable();
		$engine->current_context--;
	}

	// recount comments for the base topic
	$engine->Query(
		"UPDATE {$engine->config['table_prefix']}pages SET ".
			"comments	= '".(int)$engine->CountComments($base)."', ".
			"commented	= NOW() ".
		"WHERE tag = '".quote($this->dblink, $base)."' ".
		"LIMIT 1");

	// restore forum context
	$engine->forum = $forum_context;

	return true;
}

function ModerateSplitTopic(&$engine, $comment_ids, $oldtag, $newtag, $title)
{
	if (is_array($comment_ids) === false) return false;

	// set forum context
	$forum_context	= $engine->forum;
	$engine->forum	= true;

	// resave first comment as new topic page
	$first_tag		= $engine->GetTagById(array_shift($comment_ids));
	$page			= $engine->LoadPage($first_tag);

	// resave modified body
	$page['body']	= '=='.$title."==\n\n".$page['body'];
	$engine->SavePage($newtag, $page['body'], '', '', '', $title, true, false);

	// bug-resistent check: has page been really resaved?
	if ($engine->LoadSingle(
	"SELECT page_id FROM {$engine->config['table_prefix']}pages ".
	"WHERE tag = '".quote($this->dblink, $newtag)."'") != true)
	{
		$engine->forum = $forum_context;
		return false;
	}

	// restore original metadata
	$engine->Query(
		"UPDATE {$engine->config['table_prefix']}pages SET ".
			"modified		= '".quote($this->dblink, $page['modified'])."', ".
			"created	= '".quote($this->dblink, $page['created'])."', ".
			"owner_id		= '".quote($this->dblink, $page['owner_id'])."', ".
			"user_id		= '".quote($this->dblink, $page['user_id'])."', ".
			"ip			= '".quote($this->dblink, $page['ip'])."' ".
		"WHERE tag = '".quote($this->dblink, $newtag)."'");

	// move remaining comments to the new topic
	foreach ($comment_ids as $id)
	{
		$engine->Query(
			"UPDATE {$engine->config['table_prefix']}pages SET ".
				"comment_on_id = '".quote($this->dblink, $newtag)."', ".
			"WHERE page_id = '".quote($this->dblink, $id)."'");
	}

	// remove old first comment
	ModerateDeletePage($engine, $first_tag);

	// update links table
	$page = $engine->LoadPage($newtag);
	$engine->current_context++;
	$engine->context[$engine->current_context] = $newtag;
	$engine->ClearLinkTable();
	$engine->StartLinkTracking();
	$dummy = $engine->Format($page['body_r'], 'post_wacko');
	$engine->StopLinkTracking();
	$engine->WriteLinkTable($newtag);
	$engine->ClearLinkTable();
	$engine->current_context--;

	// recount comments for old and new topics
	$engine->Query(
		"UPDATE {$engine->config['table_prefix']}pages SET ".
			"comments	= '".(int)$engine->CountComments($newtag)."', ".
			"commented	= NOW() ".
		"WHERE tag = '".quote($this->dblink, $newtag)."' ".
		"LIMIT 1");
	$engine->Query(
		"UPDATE {$engine->config['table_prefix']}pages ".
		"SET comments = '".(int)$engine->CountComments($oldtag)."' ".
		"WHERE tag = '".quote($this->dblink, $oldtag)."' ".
		"LIMIT 1");

	// restore forum context
	$engine->forum = $forum_context;

	return true;
}

// redirect to show method if page doesn't exists
if (!$this->page || $this->page['comment_on_id'] == true)
	$this->Redirect($this->href('show'));

if (($this->IsModerator() && $this->HasAccess('read')) || $this->IsAdmin())
{
	if (substr($this->tag, 0, strlen($this->config['forum_cluster'])) == $this->config['forum_cluster'])
		$forumCluster = true;
	else
		$forumCluster = false;

	// simple and rude input sanitization
	foreach ($_POST as $key => $val) $_POST[$key] = htmlspecialchars($val);

	// IDs PROCESSING (COMMON PROCEDURES)
	$set = array();

	// pass previously selected items
	if ($_REQUEST['ids'])
	{
		$ids = explode('-', $_REQUEST['ids']);

		foreach ($ids as $id)
			if (!in_array($id, $set))
				$set[] = $id;

		unset($ids, $id);
	}

	// keep currently selected list items
	foreach ($_POST as $val => $key)
	{
		if ($key == 'id' && !in_array($val, $set))
			$set[] = $val;
	}
	unset($key, $val);

	// save page ids for later operations (correct if needed)
	if ($_POST['set'])
	{
		$set = array();

		foreach ($_POST as $val => $key) if ($key == 'id') $set[] = $val;

		unset($key, $val);
	}
	// reset page ids
	else if ($_POST['reset'])
	{
		$set = array();
	}

	// check moderator read access on passed ids
	foreach ($set as $n => $id)
	{
		 if ($this->HasAccess('read', $id) !== true) unset($set[$n]);
	}
	reset($set);
	unset($n, $id);

	// creting rss object
	$this->UseClass('rss', 'classes/');
	$xml = new RSS($this);

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
					$page = $this->LoadPage($this->GetTagById($id), '', LOAD_NOCACHE, LOAD_META);
					ModerateDeletePage($this, $page['tag']);
					$this->Log(1, str_replace('%2', $page['user_id'], str_replace('%1', $page['tag'], $this->GetTranslation('LogRemovedPage'))));
				}
				unset($acceptAction);
				$xml->Comments();
				$set = array();
				$this->SetMessage('Selected topics successfully deleted.'); // ru: Выбранные темы успешно удалены.
				$this->Redirect($this->href('moderate'));
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
					$oldtags[] = $this->GetTagById($id);
					$newtags[] = $_POST['section'].substr($oldtags[$i], strrpos($oldtags[$i], '/'));

					if (ModeratePageExists($this, $newtags[$i++]) === true)
						$error[] = '<u>&laquo;'.$this->GetPageTitle('', $id).'&raquo;</u>';
				}

				// in case no errors, move...
				if ($error == true)
				{
					$error = str_replace('%1', implode(', ', $error), $this->GetTranslation('ModerateMoveExists'));
				}
				else
				{
					$i = 0;
					foreach ($set as $id)
					{
						ModerateRenameTopic($this, $oldtags[$i], $newtags[$i]);
						$this->Log(3, str_replace('%2', $newtags[$i], str_replace('%1', $oldtags[$i], $this->GetTranslation('LogRenamedPage'))));
						$i++;
					}
					unset($acceptAction, $i, $oldtags, $newtags);
					$xml->Comments();
					$set = array();
					$this->SetMessage('Selected topics successfully relocated.'); // ru: Выбранные темы успешно перемещены.
					$this->Redirect($this->href('moderate'));
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
				$oldtag		= $this->GetTagById($set[0]);
				$tag		= trim($_POST['title'], " \t");
				$title		= $tag;
				$tag 		= ucwords($tag);
				$tag		= preg_replace('/[^- \\w]/', '', $tag);
				$tag		= str_replace(array(' ', "\t"), '', $tag);

				// check new tag existance
				if ($oldtag != $this->tag.'/'.$tag && ModeratePageExists($this, $this->tag.'/'.$tag) === true)
					$error = $this->GetTranslation('ModerateRenameExists');

				// okey, then rename page
				if ($tag != '' && $error != true)
				{
					ModerateRenameTopic($this, $oldtag, $this->tag.'/'.$tag, $title);
					$this->Log(3, str_replace('%2', $this->tag.'/'.$tag.' '.$title, str_replace('%1', $oldtag, $this->GetTranslation('LogRenamedPage'))));
					unset($acceptAction, $oldtag, $tag, $title);
					$xml->Comments();
					$set = array();
					$this->SetMessage('Subject successfully renamed. Note: if the subject signed electronically, its title on the same.'); // ru: Тема успешно переименована. Заметьте: если тема электронно подписана, ее заголовок оставлен неизменным.
					$this->Redirect($this->href('moderate'));
				}
			}
		}
		// merge several topics into a single topic
		else if ($_POST['merge'] && $set == true)
		{
			$acceptAction	= 'merge';

			if (count($set) < 2)
			{
				$error = $this->GetTranslation('ModerateMerge2Min');
			}

			// perform accepted action
			if ($_POST['accept'] && $_POST['base'] && !$error)
			{
				foreach ($set as $id)
				{
					$topics[] = $this->GetTagById($id);
				}
				ModerateMergeTopics($this, $_POST['base'], $topics);
				$this->Log(3, str_replace('%2', $_POST['base'], str_replace('%1', '##'.implode('##, ##', $topics).'##', $this->GetTranslation('LogMergedPages'))));
				unset($acceptAction, $topics);
				$xml->Comments();
				$set = array();
				$this->SetMessage('Selected topics successfully merged.'); // ru: Выбранные темы успешно склеены.
				$this->Redirect($this->href('moderate'));
			}
		}
		// lock topics
		else if ($_POST['lock'] && $set == true)
		{
			foreach ($set as $id)
			{
				$page = $this->LoadPage($this->GetTagById($id), '', LOAD_NOCACHE, LOAD_META);
				$this->Log(2, str_replace('%1', $page['tag'].' '.$page['title'], $this->GetTranslation('LogTopicLocked')));
				// DON'T USE BLANK PRIVILEGE LIST!!! Only "negative all" - '!*'
				$this->SaveAcl($id, 'comment', '!*');
			}
			$set = array();
			$this->SetMessage('Selected topics successfully blocked.'); // ru: Выбранные темы успешно заблокированы.
			$this->Redirect($this->href('moderate'));
		}
		// unlock topics
		else if ($_POST['unlock'] && $set == true)
		{
			foreach ($set as $id)
			{
				$page = $this->LoadPage($this->GetTagById($id), '', LOAD_NOCACHE, LOAD_META);
				$this->Log(2, str_replace('%1', $page['tag'].' '.$page['title'], $this->GetTranslation('LogTopicUnlocked')));
				$this->SaveAcl($id, 'comment', '*');
			}
			$set = array();
			$this->SetMessage('Selected topics successfully unlocked.'); // ru: Выбранные темы успешно разблокированы.
			$this->Redirect($this->href('moderate'));
		}

		// make counter query
		$sql = "SELECT COUNT(p.tag) AS n ".
			"FROM {$this->config['table_prefix']}pages AS p, ".
				"{$this->config['table_prefix']}acls AS a ".
			"WHERE p.page_id = a.page_id ".
				#"AND a.`create` = '' ".
				"AND p.tag LIKE '{$this->tag}/%'";

		// count topics and make pagination
		$count		= $this->LoadSingle($sql);
		$pagination	= $this->Pagination($count['n'], $limit, 'p', 'ids='.implode('-', $set), 'moderate');

		// make collector query
		$sql = "SELECT p.page_id, p.tag, title, p.owner_id, p.user_id, ip, comments, created, u.user_name AS user,  o.user_name as owner ".
			"FROM {$this->config['table_prefix']}pages AS p ".
					"LEFT JOIN ".$this->config["table_prefix"]."users u ON (p.user_id = u.user_id) ".
					"LEFT JOIN ".$this->config["table_prefix"]."users o ON (p.owner_id = o.user_id), ".
				"{$this->config['table_prefix']}acls AS a ".
			"WHERE p.page_id = a.page_id ".
				#"AND a.`create` = '' ".
				"AND p.tag LIKE '{$this->tag}/%' ".
			"ORDER BY commented DESC ".
			"LIMIT {$pagination['offset']}, $limit";

		// load topics data
		$topics	= $this->LoadAll($sql);

		// display list
		echo $this->FormOpen('moderate');
		echo '<table><tr>'.
				'<td align="right">'.( $pagination['text'] == true ? '<small><small>'.$pagination['text'].'</small></small>' : '&nbsp;' ).'</td>'.
			'</tr></table>'."\n";

		// confirm deletion
		if ($acceptAction == 'delete')
		{
			foreach ($set as $id) $acceptText[] = '&laquo;'.$this->GetPageTitle('', $id).'&raquo;';

			echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.$this->GetTranslation('ModerateDeleteConfirm').'</th></td>'.
					'<tr><td>'.
						'<em>'.implode('<br />', $acceptText).'</em><br />'.
						'<input name="accept" id="submit" type="submit" value="'.$this->GetTranslation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->GetTranslation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
					'</td></tr>'.
				'</table><br />'."\n";
		}
		// select target forum section
		else if ($acceptAction == 'move')
		{
			foreach ($set as $id) $acceptText[] = '&laquo;'.$this->GetPageTitle('', $id).'&raquo;';

			$sections = $this->LoadAll(
				"SELECT p.tag, p.title ".
				"FROM {$this->config['table_prefix']}pages AS p, ".
					"{$this->config['table_prefix']}acls AS a ".
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
					'<tr><th>'.$this->GetTranslation('ModerateMovesConfirm').'</th></td>'.
					'<tr><td>'.
						( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
						'<em>'.implode('<br />', $acceptText).'</em><br />'.
						'<select name="section">'.
							'<option selected="selected"></option>'.
							$list.
						'</select> '.
						'<input name="accept" id="submit" type="submit" value="'.$this->GetTranslation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->GetTranslation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
					'</td></tr>'.
				'</table><br />'."\n";
		}
		// enter a new name for the renamed topic
		else if ($acceptAction == 'rename')
		{
			echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.$this->GetTranslation('ModerateRenameConfirm').'</th></td>'.
					'<tr><td>'.
						( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
						'<input name="title" size="50" maxlength="100" value="'.$this->GetPageTitle('', $set[0]).'" /> '.
						'<input name="accept" id="submit" type="submit" value="'.$this->GetTranslation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->GetTranslation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
						( count($set) > 1 ? '<br /><small>'.$this->GetTranslation('ModerateRename1Only').'</small>' : '' ).
					'</td></tr>'.
				'</table><br />'."\n";
		}
		// select base for merging topics
		else if ($acceptAction == 'merge')
		{
			foreach ($set as $id)
			{
				$acceptText[] = '&laquo;'.$this->GetPageTitle('', $id).'&raquo;';
				$topicsList[] = $this->GetTagById($id);
			}

			for ($i = 0; $i < count($topicsList); $i++)
			{
				$list .= "<option value=\"{$topicsList[$i]}\">{$acceptText[$i]}</option>\n";
			}

			echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.$this->GetTranslation('ModerateMergeConfirm').'</th></td>'.
					'<tr><td>'.
						( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
						'<em>'.implode('<br />', $acceptText).'</em><br />'."\n".
						'<select name="base">'.
							'<option selected="selected"></option>'.
							$list.
						'</select> '.
						'<input name="accept" id="submit" type="submit" value="'.$this->GetTranslation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->GetTranslation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
					'</td></tr>'.
				'</table><br />'."\n";
		}

		// print moderation controls...
		echo '<input name="ids" type="hidden" value="'.implode('-', $set).'" />'.
			'<input name="p" type="hidden" value="'.$_GET['p'].'" />'."\n";
		echo '<table cellspacing="1" cellpadding="4">'.
				'<tr class="lined">'.
					'<td colspan="5">'.
						'<input name="delete" id="submit" type="submit" value="'.$this->GetTranslation('ModerateDelete').'" /> '.
						'<input name="move" id="submit" type="submit" value="'.$this->GetTranslation('ModerateMove').'" /> '.
						'<input name="rename" id="submit" type="submit" value="'.$this->GetTranslation('ModerateRename').'" /> '.
						'<input name="merge" id="submit" type="submit" value="'.$this->GetTranslation('ModerateMerge').'" /> '.
						'<input name="lock" id="submit" type="submit" value="'.$this->GetTranslation('ModerateLock').'" /> '.
						'<input name="unlock" id="submit" type="submit" value="'.$this->GetTranslation('ModerateUnlock').'" /> '.
						'&nbsp;&nbsp;&nbsp;<a href="'.$this->href('', $this->config['moders_docs']).'">'.$this->GetTranslation('Help').'...</a> '.
						'<br />'."\n".
						'<input name="set" id="submit" type="submit" value="'.$this->GetTranslation('ModerateSet').'" /> '.
						( $set
							? '<input name="reset" id="submit" type="submit" value="'.$this->GetTranslation('ModerateReset').'" /> '.
							  '&nbsp;&nbsp;&nbsp;<small>ids: '.implode(', ', $set).'</small>'
							: ''
						).
					'</td>'.
				'</tr>'."\n".
				'<tr class="formation">'.
					'<th colspan="2">'.$this->GetTranslation('ForumTopics').'</th>'.
					'<th>'.$this->GetTranslation('ForumAuthor').'</th>'.
					'<th>'.$this->GetTranslation('ForumReplies').'</th>'.
					'<th>'.$this->GetTranslation('ForumCreated').'</th>'.
				'</tr>'."\n";

		// ...and topics list itself
		foreach ($topics as $topic)

		if ($this->HasAccess('read', $topic['page_id']))
		{
			echo '<tr>'.
					'<td valign="middle" style="width:10px;" class="label"><input name="'.$topic['page_id'].'" type="checkbox" value="id" '.( in_array($topic['page_id'], $set) ? 'checked="checked "' : '' ).'/></td>'.
					'<td align="left" style="padding-left:5px;">'.( $this->HasAccess('comment', $topic['page_id'], GUEST) === false ? str_replace('{theme}', $this->config['theme_url'], $this->GetTranslation('lockicon')) : '' ).$this->ComposeLinkToPage($topic['tag'], 'moderate', $topic['title']).' <strong>'.$this->ComposeLinkToPage($topic['tag'], '', '&lt;#&gt;', 0).'</strong></td>'.
					'<td align="center"'.( $this->IsAdmin() ? ' title="'.$topic['ip'].'"' : '' ).'><small>&nbsp;&nbsp;'.( $topic['owner'] == GUEST ? '<em>'.$this->GetTranslation('Guest').'</em>' : ( $topic['owner'] ? '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$topic['owner']).'">'.$topic['owner'].'</a>' : $topic['user'] ) ).'&nbsp;&nbsp;</small></td>'.
					'<td align="center"><small>'.$topic['comments'].'</small></td>'.
					'<td align="center" style="white-space:nowrap"><small>&nbsp;&nbsp;'.$this->GetTimeStringFormatted($topic['created']).'</small></td>'.
				'</tr>'."\n".
				'<tr class="lined">'.
					'<td colspan="5"></td>'.
				'</tr>'."\n";
		}

		echo '</table>'."\n";
		echo '<table><tr>'.
				'<td align="right">'.( $pagination['text'] == true ? '<small><small>'.$pagination['text'].'</small></small>' : '' ).'</td>'.
			'</tr></table>'."\n";
		echo $this->FormClose();
	}
////// END SUBFORUM MODERATION //////
////// BEGIN PAGE/TOPIC MODERATION //////
	else
	{
		// number of posts to display per page
		$limit = 60;

		// PROCESS INPUT
		// delete topic
		if ($_POST['topic_delete'])
		{
			$acceptAction	= 'topic_delete';

			// actually remove topics
			if ($_POST['accept'])
			{
				$this->Log(1, str_replace('%2', $this->page['user_id'], str_replace('%1', $this->page['tag'], $this->GetTranslation('LogRemovedPage'))));
				ModerateDeletePage($this, $this->tag);
				unset($acceptAction);
				$xml->Comments();
				$this->SetMessage('Topic has been successfully removed.'); // ru: Тема успешно удалена.
				$this->Redirect($this->href('moderate', substr($this->tag, 0, strrpos($this->tag, '/'))));
			}
		}
		// move topic elsewhere
		else if ($_POST['topic_move'])
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
						if (ModeratePageExists($this, $_POST['cluster']) === false) $error = $this->GetTranslation('ModerateMoveNotExists');
					}
					else if ($_POST['section'])
					{
						if (ModeratePageExists($this, $newtag) === true) $error = '<u>&laquo;'.$this->page['title'].'&raquo;</u>';
					}
				}
				else if ($_POST['cluster'] != '/')
				{
					if (ModeratePageExists($this, $_POST['cluster']) === false) $error = $this->GetTranslation('ModerateMoveNotExists');
				}

				// in case no errors, move...
				if ($error == true)
				{
					if ($forumCluster === true && $_POST['section']) $error = str_replace('%1', $error, $this->GetTranslation('ModerateMoveExists'));
				}
				else
				{
					ModerateRenameTopic($this, $oldtag, $newtag);
					$this->Log(3, str_replace('%2', $newtag, str_replace('%1', $oldtag, $this->GetTranslation('LogRenamedPage'))));
					unset($acceptAction);
					$xml->Comments();
					$this->SetMessage('Page successfully moved.'); // ru: Документ успешно перемещен.
					$this->Redirect($this->href('moderate', $newtag));
				}
			}
		}
		// rename topic
		else if ($_POST['topic_rename'])
		{
			$acceptAction	= 'topic_rename';

			// perform accepted rename
			if ($_POST['accept'] && $forumCluster === true)
			{
				$pos		= strrpos($this->tag, '/');
				$section	= substr($this->tag, 0, ( $pos ? $pos : NULL ));
				$tag		= trim($_POST['title'], " \t");
				$title		= $tag;
				$tag 		= ucwords($tag);
				$tag		= preg_replace('/[^- \\w]/', '', $tag);
				$tag		= str_replace(array(' ', "\t"), '', $tag);
				$oldtag		= $this->tag;
				$newtag		= ( $section ? $section.'/' : '' ).$tag;

				// check new tag existance
				if ($oldtag == $newtag || ModeratePageExists($this, $newtag) === true)
					$error = $this->GetTranslation('ModerateRenameExists');

				// okey, then rename page
				if ($tag != '' && $error != true)
				{
					ModerateRenameTopic($this, $oldtag, $newtag, $title);
					$this->Log(3, str_replace('%2', $newtag.' '.$title, str_replace('%1', $oldtag, $this->GetTranslation('LogRenamedPage'))));
					unset($acceptAction);
					$xml->Comments();
					$this->SetMessage('Topic successfully renamed. Note: if the topic signed electronically, its title on the same.'); // ru: Тема успешно переименована. Заметьте: если тема электронно подписана, ее заголовок оставлен неизменным.
					$this->Redirect($this->href('moderate', $newtag));
				}
			}
		}
		// lock topic
		else if ($_POST['topic_lock'] && $forumCluster === true)
		{
			// DON'T USE BLANK PRIVILEGE LIST!!! Only "negative all" - '!*'
			$this->SaveAcl($this->page['page_id'], 'comment', '!*');
			$this->Log(2, str_replace('%1', $this->page['tag'].' '.$this->page['title'], $this->GetTranslation('LogTopicLocked')));
			$this->SetMessage('Topic successfully blocked.'); // ru: Тема успешно заблокирована.
			$this->Redirect($this->href('moderate'));
		}
		// unlock topic
		else if ($_POST['topic_unlock'] && $forumCluster === true)
		{
			$this->SaveAcl($this->page['page_id'], 'comment', '*');
			$this->Log(2, str_replace('%1', $this->page['tag'].' '.$this->page['title'], $this->GetTranslation('LogTopicUnlocked')));
			$this->SetMessage('Topic successfully unlocked.'); // ru: Тема успешно разблокирована.
			$this->Redirect($this->href('moderate'));
		}
		// delete selected comments
		else if ($_POST['posts_delete'] && $set == true)
		{
			$acceptAction	= 'posts_delete';

			// actually remove topics
			if ($_POST['accept'])
			{
				foreach ($set as $id)
				{
					$page = $this->LoadPage($this->GetTagById($id), '', LOAD_NOCACHE, LOAD_META);
					ModerateDeletePage($this, $page['tag']);
					$this->Log(1, str_replace('%3', $this->GetTimeStringFormatted($page['created']), str_replace('%2', $page['user'], str_replace('%1', $page['comment_on'].' '.$this->GetPageTitle($page['comment_on']), $this->GetTranslation('LogRemovedComment')))));
				}

				// recount comments for current topic
				$this->Query(
					"UPDATE {$this->config['table_prefix']}pages SET ".
						"comments	= '".(int)$this->CountComments($this->tag)."', ".
						"commented	= NOW() ".
					"WHERE tag = '".quote($this->dblink, $this->tag)."' ".
					"LIMIT 1");

				unset($acceptAction);
				$xml->Comments();
				$set = array();
				$this->SetMessage('Selected comments removed successfully.'); // ru: Выбранные комментарии успешно удалены.
				$this->Redirect($this->href('moderate'));
			}
		}
		// split topic
		else if ($_POST['posts_split'] && $set == true)
		{
			$acceptAction	= 'posts_split';

			// perform accepted splitting
			if ($_POST['accept'] && $_POST['title'])
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
					if ($oldtag != $section.'/'.$tag && ModeratePageExists($this, $section.'/'.$tag) === true)
						$error = $this->GetTranslation('ModerateRenameExists');
				}
				else
				{
					// check desired target tag existance
					if (ModeratePageExists($this, $title) === false)
						$error = $this->GetTranslation('ModerateMoveNotExists');
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

						$first_comment	= $this->LoadPage($this->GetTagById($_set[0]));
						$_comments		= $this->LoadAll(
							"SELECT page_id ".
							"FROM {$this->config['table_prefix']}pages ".
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
						if (ModerateSplitTopic($this, $comment_ids, $oldtag, $section.'/'.$tag, $title) === true)
						{
							$this->Log(3, str_replace('%2', $section.'/'.$tag.' '.$title, str_replace('%1', $this->tag.' '.$this->page['title'], $this->GetTranslation('LogSplittedPage'))));
							unset($acceptAction);
							$xml->Comments();
							$this->SetMessage('Selected comments successfully separated in a new topic.'); // ru: Выбранные комментарии успешно отделены в новую тему.
							$this->Redirect($this->href('moderate', $section.'/'.$tag));
						}
						else
						{
							$this->SetMessage('Note: for some reason failed to separate the selected messages to a new topic. '.
								'Usually this should not happen, so let the incident site administrator. '.
								'As a precaution, issue has been preserved in its original form.'); // ru: Внимание: по какой-то причине не удалось отделить выбранные сообщения в новую тему.     Обычно такое не должно случаться, поэтому сообщите о происшедшем администратору сайта.     В качестве меры предосторожности тема была сохранена в исходном виде.
							$this->Log(2, 'Error when separating comments from the topic ((/'.$this->tag.')) a new topic '.$section.'/'.$tag.': page was not created');  // ru: Ошибка при отделении комментариев из темы     в новую тему        документ не был создан
						}
					}
					else
					{
						foreach ($comment_ids as $id) $idsStr .= "'".quote($this->dblink, $id)."', ";
						$idsStr = substr($idsStr, 0, strlen($idsStr)-2);

						// move
						$this->Query(
							"UPDATE {$this->config['table_prefix']}pages SET ".
								"comment_on_id = '".quote($this->dblink, $title)."', ".
							"WHERE page_id IN ( $idsStr )");

						// update links table
						$comments = $this->LoadAll(
							"SELECT tag, body_r ".
							"FROM {$this->config['table_prefix']}pages ".
							"WHERE page_id IN ( $idsStr )");

						foreach ($comments as $comment)
						{
							$this->context[++$this->current_context] = $comment['tag'];
							$this->ClearLinkTable();
							$this->StartLinkTracking();
							$dummy = $this->Format($comment['body_r'], 'post_wacko');
							$this->StopLinkTracking();
							$this->WriteLinkTable($comment['tag']);
							$this->ClearLinkTable();
							$this->current_context--;
						}

						// recount comments for the old and new page
						$this->Query(
							"UPDATE {$this->config['table_prefix']}pages ".
							"SET comments = '".(int)$this->CountComments($this->tag)."' ".
							"WHERE tag = '".quote($this->dblink, $this->tag)."' ".
							"LIMIT 1");
						$this->Query(
							"UPDATE {$this->config['table_prefix']}pages SET ".
								"comments	= '".(int)$this->CountComments($title)."', ".
								"commented	= NOW() ".
							"WHERE tag = '".quote($this->dblink, $title)."' ".
							"LIMIT 1");

						$this->Log(3, str_replace('%2', $title.' '.$this->GetPageTitle($title), str_replace('%1', $this->tag.' '.$this->page['title'], $this->GetTranslation('LogSplittedPage'))));
						unset($acceptAction);
						$xml->Comments();
						$this->SetMessage('Selected comments successfully migrated to a given page.'); // ru: Выбранные комментарии успешно перенесены в заданный документ.
						$this->Redirect($this->href('moderate'));
					}
				}
			}
		}

		// make counter query
		$sql = "SELECT COUNT(tag) AS n ".
			"FROM {$this->config['table_prefix']}pages ".
			"WHERE comment_on_id = '{$this->page['page_id']}'";

		// count posts and make pagination
		$count		= $this->LoadSingle($sql);
		$pagination	= $this->Pagination($count['n'], $limit, 'p', 'ids='.implode('-', $set), 'moderate');

		// make collector query
		$sql = "SELECT p.page_id, p.tag, p.user_id, p.owner_id, ip, LEFT(body, 500) AS body, created, u.user_name AS user, o.user_name as owner ".
			"FROM {$this->config['table_prefix']}pages p ".
				"LEFT JOIN ".$this->config["table_prefix"]."users u ON (p.user_id = u.user_id) ".
				"LEFT JOIN ".$this->config["table_prefix"]."users o ON (p.owner_id = o.user_id) ".
			"WHERE comment_on_id = '{$this->page['page_id']}' ".
			"ORDER BY created ASC ".
			"LIMIT {$pagination['offset']}, $limit";

		// load comments data
		$comments = $this->LoadAll($sql);

		$this->page['body'] = $this->Format($this->page['body'], 'bbcode');

		$body = $this->Format($this->page['body'], 'cleanwacko');
		$body = ( strlen($body) > 300 ? substr($body, 0, 300).'...' : $body.' (-)' );

		// display list
		echo $this->FormOpen('moderate');
		echo '<table><tr>'.
				'<td align="right">'.( $pagination['text'] == true ? '<small><small>'.$pagination['text'].'</small></small>' : '&nbsp;' ).'</td>'.
			'</tr></table>'."\n";

		// confirm topic deletion
		if ($acceptAction == 'topic_delete')
		{
			$acceptText = '&laquo;'.$this->page['title'].'&raquo;';

			echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.$this->GetTranslation('ModerateDeleteConfirm').'</th></td>'.
					'<tr><td>'.
						'<em>'.$acceptText.'</em><br />'.
						'<input name="accept" id="submit" type="submit" value="'.$this->GetTranslation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->GetTranslation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
					'</td></tr>'.
				'</table><br />'."\n";
		}
		// select target forum section / cluster for topic/page moving
		else if ($acceptAction == 'topic_move')
		{
			$acceptText = '&laquo;'.$this->page['title'].'&raquo;';

			if ($forumCluster === true)
			{
				$sections = $this->LoadAll(
					"SELECT p.tag, p.title ".
					"FROM {$this->config['table_prefix']}pages AS p, ".
						"{$this->config['table_prefix']}acls AS a ".
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
						'<tr><th>'.$this->GetTranslation('ModerateMoveConfirm').'</th></td>'.
						'<tr><td>'.
							( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
							'<em>'.$acceptText.'</em><br />'.
							'<select name="section">'.
								'<option selected="selected"></option>'.
								$list.
							'</select> or <input name="cluster" size="50" maxlength="250" /><br />'.
							'<input name="accept" id="submit" type="submit" value="'.$this->GetTranslation('ModerateAccept').'" /> '.
							'<input name="cancel" id="button" type="button" value="'.$this->GetTranslation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
						'</td></tr>'.
					'</table><br />'."\n";
			}
			else
			{
				echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
					'<table cellspacing="1" cellpadding="4" class="formation">'.
						'<tr><th>'.$this->GetTranslation('ModeratePgMoveConfirm').'</th></td>'.
						'<tr><td>'.
							( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
							'<em>'.$acceptText.'</em><br />'.
							'<input name="cluster" size="50" maxlength="250" /> '.
							'<input name="accept" id="submit" type="submit" value="'.$this->GetTranslation('ModerateAccept').'" /> '.
							'<input name="cancel" id="button" type="button" value="'.$this->GetTranslation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
						'</td></tr>'.
					'</table><br />'."\n";
			}
		}
		// enter a new name for topic renaming
		else if ($acceptAction == 'topic_rename')
		{
			echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.$this->GetTranslation('ModerateRenameConfirm').'</th></td>'.
					'<tr><td>'.
						( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
						'<input name="title" size="50" maxlength="100" value="'.$this->page['title'].'" /> '.
						'<input name="accept" id="submit" type="submit" value="'.$this->GetTranslation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->GetTranslation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
					'</td></tr>'.
				'</table><br />'."\n";
		}
		// confirm comments deletion
		else if ($acceptAction == 'posts_delete')
		{
			echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.str_replace('%2', ( count($set) > 1 ? $this->GetTranslation('ModerateComments') : $this->GetTranslation('ModerateComment') ), str_replace('%1', count($set), $this->GetTranslation('ModerateComDelConfirm'))).'</th></td>'.
					'<tr><td>'.
						'<input name="accept" id="submit" type="submit" value="'.$this->GetTranslation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->GetTranslation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
					'</td></tr>'.
				'</table><br />'."\n";
		}
		// enter a new name for the detached topic
		else if ($acceptAction == 'posts_split')
		{
			echo '<input name="'.$acceptAction.'" type="hidden" value="1" />'.
				'<table cellspacing="1" cellpadding="4" class="formation">'.
					'<tr><th>'.( $forumCluster === true ? $this->GetTranslation('ModerateSplitNewName') : $this->GetTranslation('ModerateSplitPageName') ).'</th></td>'.
					'<tr><td>'.
						( $error == true ? '<span class="cite"><strong>'.$error.'</strong></span><br />' : '' ).
						'<input name="title" size="50" maxlength="250" value="" /> '.
						'<input name="accept" id="submit" type="submit" value="'.$this->GetTranslation('ModerateAccept').'" /> '.
						'<input name="cancel" id="button" type="button" value="'.$this->GetTranslation('ModerateDecline').'" onclick="document.location=\''.addslashes($this->href('moderate')).'\';" />'.
						'<br />'.
						'<small>'.
						'<input type="radio" name="scheme" value="after" id="after" '.( $_POST['scheme'] != 'selected' ? 'checked="checked" ' : '' ).'/> <label for="after">'.$this->GetTranslation('ModerateSplitAllAfter').'</label><br />'.
						'<input type="radio" name="scheme" value="selected" id="selected" '.( $_POST['scheme'] == 'selected' ? 'checked="checked" ' : '' ).'/> <label for="selected">'.str_replace('%1', count($set), $this->GetTranslation('ModerateSplitSelected')).'</label>'.
						'</small>'.
					'</td></tr>'.
				'</table><br />'."\n";
		}

		// print moderation controls...
		echo '<input name="ids" type="hidden" value="'.implode('-', $set).'" />'.
			'<input name="p" type="hidden" value="'.$_GET['p'].'" />'."\n";
		echo '<table cellspacing="1" cellpadding="4">'.
				'<tr class="lined">'.
					'<td colspan="2">'.
						'<input name="topic_delete" id="submit" type="submit" value="'.$this->GetTranslation('ModerateDeleteTopic').'" /> '.
						'<input name="topic_move" id="submit" type="submit" value="'.$this->GetTranslation('ModerateMove').'" /> '.
						( $forumCluster === true
							? '<input name="topic_rename" id="submit" type="submit" value="'.$this->GetTranslation('ModerateRename').'" /> '
							: ''
						).
						( $forumCluster === true
							? ( $this->HasAccess('comment', $this->page['page_id'], GUEST) === true
								? '<input name="topic_lock" id="submit" type="submit" value="'.$this->GetTranslation('ModerateLock').'" /> '
								: '<input name="topic_unlock" id="submit" type="submit" value="'.$this->GetTranslation('ModerateUnlock').'" /> '
							  )
							: ''
						).
						'&nbsp;&nbsp;&nbsp;<a href="'.$this->href('', $this->config['moders_docs']).'">'.$this->GetTranslation('Help').'...</a> '.
					'</td>'.
				'</tr>'."\n".
				'<tr class="formation">'.
					'<th colspan="2">'.( $this->HasAccess('comment', $this->page['page_id'], GUEST) === false ? str_replace('{theme}', $this->config['theme_url'], $this->GetTranslation('lockicon')) : '' ).$this->GetTranslation('ForumTopics').'</th>'.
				'</tr>'."\n".
				'<tr class="lined">'.
					'<td colspan="2" style="padding-bottom:30px;">'.
						'<strong><small><span'.( $this->IsAdmin() ? ' title="'.$this->page['ip'].'"' : '' ).'>'.( $forumCluster === false ? $this->page['owner'] : ( $this->page['user'] == GUEST ? '<em>'.$this->GetTranslation('Guest').'</em>' : $this->page['user'] ) ).'</span> ('.$this->GetTimeStringFormatted($this->page['created']).')</small></strong>'.
						'<br />'.$body.
					'</td>'.
				'</tr>'."\n";

		if ($comments)
		{
			echo '<tr class="lined">'.
					'<td colspan="2">'.
						'<input name="posts_delete" id="submit" type="submit" value="'.$this->GetTranslation('ModerateDeletePosts').'" /> '.
						'<input name="posts_split" id="submit" type="submit" value="'.$this->GetTranslation('ModerateSplit').'" /> '.
						'&nbsp;&nbsp;&nbsp;<a href="'.$this->href('', $this->config['moders_docs']).'">'.$this->GetTranslation('Help').'...</a> '.
						'<br />'."\n".
						'<input name="set" id="submit" type="submit" value="'.$this->GetTranslation('ModerateSet').'" /> '.
						( $set
							? '<input name="reset" id="submit" type="submit" value="'.$this->GetTranslation('ModerateReset').'" /> '.
							  '&nbsp;&nbsp;&nbsp;<small>ids: '.implode(', ', $set).'</small>'
							: ''
						).
					'</td>'.
				'</tr>'."\n".
				'<tr class="formation">'.
					'<th colspan="2">'.$this->GetTranslation('ForumComments').'</th>'.
				'</tr>'."\n";

			// ...and comments list
			foreach ($comments as $comment)
			{
				$comment['body'] = $this->Format($comment['body'], 'bbcode');

				$desc = $this->Format($comment['body'], 'cleanwacko');
				$desc = ( strlen($desc) > 300 ? substr($desc, 0, 300).'...' : $desc.' (-)' );

				echo '<tr>'.
						'<td valign="middle" style="width:10px;" class="label"><input name="'.$comment['page_id'].'" type="checkbox" value="id" '.( in_array($comment['page_id'], $set) ? 'checked="checked "' : '' ).'/></td>'.
						'<td align="left" style="padding-left:5px;"><strong><small><span'.( $this->IsAdmin() ? ' title="'.$comment['ip'].'"' : '' ).'>'.( $comment['user'] == GUEST ? '<em>'.$this->GetTranslation('Guest').'</em>' : $comment['user'] ).'</span> ('.$this->GetTimeStringFormatted($comment['created']).') &nbsp;&nbsp; '.$this->ComposeLinkToPage($comment['tag'], '', '&lt;#&gt;', 0).( $comment['owner'] != GUEST ? ' &nbsp;&nbsp; <a href="'.$this->href('', $this->config['users_page'], 'profile='.$comment['owner']).'">'.$this->GetTranslation('ModerateUserProfile').'</a>' : '' ).'</small></strong>'.
							'<br />'.$desc.'</td>'.
					'</tr>'."\n".
					'<tr class="lined">'.
						'<td colspan="2"></td>'.
					'</tr>'."\n";
			}
		}

		echo '</table>'."\n";
		echo '<table><tr>'.
				'<td align="right">'.( $pagination['text'] == true ? '<small><small>'.$pagination['text'].'</small></small>' : '' ).'</td>'.
			'</tr></table>'."\n";
		echo $this->FormClose();
	}
}
else
{
	echo $this->GetTranslation('NotModerator');
}

// set forum context
if ($forumCluster === true) $this->forum = true;

?>
</div>
