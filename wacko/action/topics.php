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
//					  ^^^ UNTESTED FUNCTIONALITY!!! ^^^

if (!isset($pages))		$pages = '';

// make sure that we're executing inside the forum cluster
if (substr($this->tag, 0, strlen($this->config['forum_cluster'])) == $this->config['forum_cluster'])
{
	// count slashes in the tag
	$i = $off = 0;
	while (($off = strpos($this->tag, '/', $off)) !== false)
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
	if (@$_POST['action'] == 'topicadd' && $create_access)
	{
		if (@$_POST['title'])
		{
			$topic_name		= trim($_POST['title'], ". \t");
			$page_title		= $topic_name;
			$topic_name		= ucwords($topic_name);
			$topic_name		= preg_replace('/[^- \\w]/', '', $topic_name);
			$topic_name		= str_replace(array(' ', "\t"), '', $topic_name);

			if (!$topic_name)
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
			$this->set_message($error, 'error');
			$this->redirect($this->href());
		}
		else
		{
			// redirecting to the edit form
			$this->sess->title	= $page_title;
			$this->redirect($this->href('edit', $this->tag.'/'.$topic_name, '', 1));
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
			$page = trim($page, '/ ');
		}
	}

	// filter categories
	$category = (int)@$_GET['category'];

	// make counter query
	$sql = "SELECT COUNT(p.tag) AS n ".
		"FROM {$this->config['table_prefix']}page AS p, ".
		($category
			? "INNER JOIN {$this->config['table_prefix']}category_page AS k ON (k.page_id = p.page_id) "
			: "").
			"{$this->config['table_prefix']}acl AS a ".
		"WHERE p.page_id = a.page_id ".
			"AND a.privilege = 'create' AND a.list = '' ".
			"AND p.tag LIKE '{$this->tag}/%' ";

	if ($pages)
	{
		foreach ($pages as $page)
		{
			$sql .= "AND tag NOT LIKE '".quote($this->dblink, $page)."/%' ";
		}
	}

	if ($category)
	{
		$sql .= "AND k.category_id IN ( ".quote($this->dblink, $category)." ) AND k.page_id = p.page_id ";
	}

	// count topics and make pagination
	$count		= $this->load_single($sql);
	$pagination	= $this->pagination($count['n'], $this->config['forum_topics']);

	// make collector query
	$sql = "SELECT p.page_id, p.tag, p.title, p.user_id, p.owner_id, p.ip, p.comments, p.hits, p.created, p.commented, p.description, p.page_lang, u.user_name, o.user_name as owner_name ".
		"FROM {$this->config['table_prefix']}page AS p ".
		($category
			? "INNER JOIN {$this->config['table_prefix']}category_page AS k ON (k.page_id = p.page_id) "
			: "").
			"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
			"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.owner_id = o.user_id), ".
			"{$this->config['table_prefix']}acl AS a ".
		"WHERE p.page_id = a.page_id ".
			"AND a.privilege = 'create' AND a.list = '' ".
			"AND p.tag LIKE '{$this->tag}/%' ";

	if ($pages)
	{
		foreach ($pages as $page)
		{
			$sql .= "AND p.tag NOT LIKE '".quote($this->dblink, $page)."/%' ";
		}
	}

	if ($category)
	{
			$sql .= "AND k.category_id IN ( ".quote($this->dblink, $category)." ) AND k.page_id = p.page_id ";
	}

	$sql .= "ORDER BY p.commented DESC ".
		"LIMIT {$pagination['offset']}, {$this->config['forum_topics']}";

	// load topics data
	$topics	= $this->load_all($sql);

	//  display search
	echo '<div class="clearfix" style="float: right; margin-bottom: 10px;">'.$this->action('search', array('for' => $this->tag, 'nomark' => 1, 'options' => 0)).'</div>'."\n";

	if (!isset($_GET['phrase']))
	{
		// display list
		echo '<div style="clear: both;">'.
				'<p style="float: left">'.($create_access ? '<strong><small class="cite"><a href="#newtopic">'.$this->get_translation('ForumNewTopic').'</a></small></strong>' : '').'</p>';
		$this->print_pagination($pagination);
		echo "</div>\n";

		echo '<table class="forum">'.
				'<thead><tr>'.
					'<th>'.$this->get_translation('ForumTopic').'</th>'.
					'<th>'.$this->get_translation('ForumAuthor').'</th>'.
					'<th>'.$this->get_translation('ForumReplies').'</th>'.
					'<th>'.$this->get_translation('ForumViews').'</th>'.
					'<th colspan="2">'.$this->get_translation('ForumLastComment').'</th>'.
				'</tr></thead>'."\n";

		foreach ($topics as $topic)
		{
			if (!$this->config['hide_locked'] || $this->has_access('read', $topic['page_id']))
			{
				// load latest comment
				if ($topic['comments'] > 0)
				{
					$comment = $this->load_single(
						"SELECT p.tag, p.ip, p.created, p.user_id, p.owner_id, u.user_name, o.user_name AS owner_name ".
						"FROM {$this->config['table_prefix']}page p ".
						"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
						"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.owner_id = o.user_id) ".
						"WHERE p.comment_on_id = '".$topic['page_id']."' ".
						"ORDER BY p.created DESC ".
						"LIMIT 1");
				}
				else
				{
					$comment = false;
				}

				// check new comments
				$updated = ($user['last_mark'] && (
					($comment['user_name'] != $user['user_name'] && $comment['created'] > $user['last_mark']) ||
					($topic['owner_name'] != $user['user_name'] && $topic['created'] > $user['last_mark']) ));

				$topic['description'] = htmlspecialchars($topic['description'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);

				if ($this->page['page_lang'] != $topic['page_lang'])
				{
					$topic['title']			= $this->do_unicode_entities($topic['title'], $topic['page_lang']);
					$topic['description']	= $this->do_unicode_entities($topic['description'], $topic['page_lang']);
				}

				// load related categories
				$_category = $this->get_categories($topic['page_id']);
				$_category = !empty($_category) ? '<br />'./* $this->get_translation('Category').': '. */$_category : '';

				// print
				echo '<tbody class="lined"><tr style="background-color: #f9f9f9;">'.
						'<td style="text-align:left;">'.
						( !$this->has_access('comment', $topic['page_id'], GUEST)
							? '<img src="'.$this->config['theme_url'].'icon/spacer.png" title="'.$this->get_translation('DeleteCommentTip').'" alt="'.$this->get_translation('DeleteText').'" class="btn-locked"/>'
							: '' ).
						( $updated
							? '<strong><span class="cite" title="'.$this->get_translation('ForumNewPosts').'">[updated]</span> '.$this->compose_link_to_page($topic['tag'], '', $topic['title']).'</strong>'
							: '<strong>'.$this->compose_link_to_page($topic['tag'], '', $topic['title']).'</strong>'
						).
						'</td>'.
						'<td style="text-align:center; white-space: nowrap;"><small title="'.( $admin ? $topic['ip'] : '' ).'">'.
							'&nbsp;&nbsp;'.$this->user_link($topic['owner_name']).'&nbsp;&nbsp;<br />'.
							'&nbsp;&nbsp;'.$this->get_time_formatted($topic['created']).'&nbsp;&nbsp;'.
						'</small></td>'.
						'<td style="text-align:center;"><small>'.$topic['comments'].'</small></td>'.
						'<td style="text-align:center;"><small>'.$topic['hits'].'</small></td>'.
						'<td>&nbsp;&nbsp;&nbsp;</td>'.
						'<td style="text-align:center;">';

				if ($comment)
				{
					echo '<small'.( $updated ? ' style="font-weight:600;"' : '' ).' title="'.( $admin ? $comment['ip'] : '' ).'">'.
						$this->user_link($comment['user_name']).'<br />'.
						'<a href="'.$this->href('', $topic['tag'], 'p=last').'#'.$comment['tag'].'">'.$this->get_time_formatted($comment['created']).'</a></small>';
				}
				else
				{
					echo '<small><em>('.$this->get_time_formatted($topic['created']).')</em></small>';
				}

				echo	'</td>'.
					'</tr>'.
					'<tr>'.
						'<td colspan="6" class="description">'.$topic['description'].''.
						$_category.'</td>'.
					'</tr></tbody>'."\n";
			}
		}

		echo '</table>'."\n";

		echo '<div class="clearfix"><p style="float: left">'.( $user ? '<small><a href="'.$this->href('', '', 'markread=yes').'">'.$this->get_translation('MarkRead').'</a></small>' : '' ).'</p>';
		$this->print_pagination($pagination);
		echo "</div>\n";
	}

	// display new topic form when applicable
	if ($create_access)
	{
		echo $this->form_open('add_topic');
		?>
		<a id="newtopic"></a><br />
		<input type="hidden" name="action" value="topicadd" />
		<table class="formation">
			<tr>
				<td class="label"><label for="topictitle"><?php echo $this->get_translation('ForumTopicName'); ?>:</label></td>
				<td>
					<input type="text" id="topictitle" name="title" size="50" maxlength="250" value="" />
					<input type="submit" id="submit" value="<?php echo $this->get_translation('ForumTopicSubmit'); ?>" />
				</td>
			</tr>
		</table>
		<?php
		echo $this->form_close();
	}
}

?>
