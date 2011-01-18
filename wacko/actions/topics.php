<?php

// shows forum topics list
// {{topics [pages="subtag1, subtag2, ..."]}}
//		pages	= when creating multilevel forums this optional parameter passes
//				  a comma-delimeted list of tag names of pages that must be
//				  considered subforums, so topics under these cluster subpages
//				  will not be displayed. tags must be absolute
//					  ^^^ UNTESTED FUNCTIONALITY!!! ^^^

$access = '';

// make sure that we're executing inside the forum cluster
if (substr($this->tag, 0, strlen($this->config['forum_cluster'])) == $this->config['forum_cluster'])
{
	// count slashes in the tag
	$i		= 0;
	$tag	= $this->tag;

	while (strpos($tag, '/') !== false)
	{
		$tag = substr($tag, strpos($tag, '/') + 1);
		$i++;
	}

	$this->forum = $i - 1;

	// load user data
	$user = $this->get_user();

	// process 'mark read' - reset session time
	if (isset($_GET['markread']) && $user == true)
	{
		$this->update_last_mark($user);
		$this->set_user_setting('last_mark', date('Y-m-d H:i:s', time()));
		$user = $this->get_user();
	}

	// check privilege
	if ($this->has_access('write') === true) $access = true;

	// checking new topic input if any
	if (isset($_POST['action']) && $_POST['action'] == 'topicadd' && $access === true)
	{
		if (isset($_POST['title']) && $_POST['title'] == true)
		{
			$name		= trim($_POST['title'], ". \t");
			$title		= $name;
			$name		= ucwords($name);
			$name		= preg_replace('/[^- \\w]/', '', $name);
			$name		= str_replace(array(' ', "\t"), '', $name);

			if ($name == '')
			{
				$error = $this->get_translation('ForumNoTopicName');
			}
		}
		else
		{
			$error = $this->get_translation('ForumNoTopicName');
		}

		// display error or continue
		if ($error)
		{
			$this->set_message('<div class="error">'.$error.'</div>');
			$this->redirect($this->href());
		}
		else
		{
			// redirecting to the edit form
			$_SESSION['title']	= $title;
			$_SESSION['body']	= "==".$title."==\n\n";
			$this->redirect($this->href('edit', $this->tag.'/'.$name, '', 1));
		}
	}

	// check admin privilege
	$admin = $this->is_admin();

	// parse subforums list if any
	if (!empty($pages))
	{
		$pages = trim(explode(',', $pages), '/ ');
	}

	// make counter query
	$sql = "SELECT COUNT(p.tag) AS n ".
		"FROM {$this->config['table_prefix']}page AS p, ".
			"{$this->config['table_prefix']}acl AS a ".
		"WHERE p.page_id = a.page_id ".
			"AND a.privilege = 'write' AND a.list = '$' ".
			"AND p.tag LIKE '{$this->tag}/%' ";

	if (isset($pages))
	{
		foreach ($pages as $page)
		{
			$sql .= "AND tag NOT LIKE '".quote($this->dblink, $page)."/%' ";
		}
	}

	// count topics and make pagination
	$count		= $this->load_single($sql);
	$pagination	= $this->pagination($count['n'], $this->config['forum_topics']);

	// make collector query
	$sql = "SELECT p.page_id, p.tag, p.title, p.user_id, p.ip, p.comments, p.hits, p.created, p.commented, p.description, u.user_name AS user, o.user_name as owner ".
		"FROM {$this->config['table_prefix']}page AS p ".
			"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
			"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.owner_id = o.user_id), ".
			"{$this->config['table_prefix']}acl AS a ".
		"WHERE p.page_id = a.page_id ".
			"AND a.privilege = 'write' AND a.list = '$' ".
			"AND p.tag LIKE '{$this->tag}/%' ";

	if (isset($pages))
	{
		foreach ($pages as $page)
		{
			$sql .= "AND p.tag NOT LIKE '".quote($this->dblink, $page)."/%' ";
		}
	}

	$sql .= "ORDER BY p.commented DESC ".
		"LIMIT {$pagination['offset']}, {$this->config['forum_topics']}";

	// load topics data
	$topics	= $this->load_all($sql);

	// display list
	echo '<table><tr><td>'.( $access === true ? '<strong><small class="cite"><a href="#newtopic">'.$this->get_translation('ForumNewTopic').'</a></small></strong>' : '' ).'</td>'.
			'<td align="right">'.( isset($pagination['text']) && $pagination['text'] == true ? '<small>'.$pagination['text'].'</small>' : '' ).'</td></tr></table>'."\n";

	echo '<table cellspacing="1" cellpadding="4" class="forum">'.
			'<tr>'.
				'<th>'.$this->get_translation('ForumTopics').'</th>'.
				'<th>'.$this->get_translation('ForumAuthor').'</th>'.
				'<th>'.$this->get_translation('ForumReplies').'</th>'.
				'<th>'.$this->get_translation('ForumViews').'</th>'.
				'<th colspan="2">'.$this->get_translation('ForumLastComment').'</th>'.
			'</tr>'."\n";

	foreach ($topics as $topic)
	{
		$comment = false;
		$updated = false;

		// load latest comment
		if ($topic['comments'] > 0)
		{
			$comment = $this->load_single(
				"SELECT p.tag, p.ip, p.created, u.user_name AS user, o.user_name AS owner ".
				"FROM {$this->config['table_prefix']}page p ".
				"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
				"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.owner_id = o.user_id) ".
				"WHERE p.comment_on_id = '".quote($this->dblink, $topic['page_id'])."' ".
				"ORDER BY p.created DESC ".
				"LIMIT 1");
		}

		// check new comments
		if ($user['last_mark'] == true && ( ($comment['user'] != $user['user_name'] && $comment['created'] > $user['last_mark']) || ($topic['owner'] != $user['user_name'] && $topic['created'] > $user['last_mark']) ))
		{
			$updated = true;
		}

		// print
		echo '<tr>'.
				'<td align="left">'.
				( $this->has_access('comment', $topic['page_id'], GUEST) === false ? str_replace('{theme}', $this->config['theme_url'], $this->get_translation('lockicon')) : '' ).
				( $updated === true
					? '<strong><span class="cite" title="'.$this->get_translation('ForumNewPosts').'">[updated]</span> '.$this->compose_link_to_page($topic['tag'], '', $topic['title']).'</strong>'
					: $this->compose_link_to_page($topic['tag'], '', $topic['title'])
				).
				'</td>'.
				'<td align="center" style="white-space: nowrap;"><small title="'.( $admin ? $topic['ip'] : '' ).'">'.
					'&nbsp;&nbsp;'.( $topic['user'] == GUEST ? '<em>'.$this->get_translation('Guest').'</em>' : ( $topic['owner'] == GUEST ? $topic['user'] : '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$topic['user']).'">'.$topic['user'].'</a>' ) ).'&nbsp;&nbsp;<br />'.
					'&nbsp;&nbsp;'.$this->get_time_string_formatted($topic['created']).'&nbsp;&nbsp;'.
				'</small></td>'.
				'<td align="center"><small>'.$topic['comments'].'</small></td>'.
				'<td align="center"><small>'.$topic['hits'].'</small></td>'.
				'<td>&nbsp;&nbsp;&nbsp;</td>'.
				'<td align="center">';

		if ($comment == true)
		{
			echo '<small'.( $updated === true ? ' style="font-weight:600;"' : '' ).' title="'.( $admin ? $comment['ip'] : '' ).'">'.
				( $comment['user'] == GUEST ? '<em>'.$this->get_translation('Guest').'</em>' : ( $comment['owner'] == GUEST ? $comment['user'] : '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$comment['user']).'">'.$comment['user'].'</a>' ) ).'<br />'.
				'<a href="'.$this->href('', $topic['tag'], 'p=last').'#'.$comment['tag'].'">'.$this->get_time_string_formatted($comment['created']).'</a></small>';
		}
		else
		{
			echo '<small><em>('.$this->get_time_string_formatted($topic['created']).')</em></small>';
		}
		echo	'</td>'.
			'</tr>'.
			'<tr>'.
				'<td colspan="6" class="description"><small>'.htmlspecialchars($topic['description']).'</small></td>'.
			'</tr>'."\n".
			'<tr class="lined">'.
				'<td colspan="6"></td>'.
			'</tr>'."\n";
	}

	echo '</table>'."\n";

	echo '<table><tr><td>'.( $user == true ? '<small><a href="'.$this->href('', '', 'markread=yes').'">'.$this->get_translation('MarkRead').'</a></small>' : '' ).'</td>'.
			'<td align="right">'.( isset($pagination['text']) && $pagination['text'] == true ? '<small>'.$pagination['text'].'</small>' : '' ).'</td></tr></table>'."\n";

	// display new topic form when applicable
	if ($access === true)
	{
		echo $this->form_open();
		?>
		<a name="newtopic"></a><br />
		<input type="hidden" name="action" value="topicadd" />
		<table cellspacing="3" class="formation">
			<tr>
				<td class="label"><?php echo $this->get_translation('ForumTopicName'); ?>:</td>
				<td>
					<input name="title" size="50" maxlength="100" value="" />
					<input id="submit" type="submit" value="<?php echo $this->get_translation('ForumTopicSubmit'); ?>" />
				</td>
			</tr>
		</table>
		<?php
		echo $this->form_close();
	}
}

?>