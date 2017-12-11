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
if (substr($this->tag, 0, strlen($this->db->forum_cluster)) == $this->db->forum_cluster)
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
	if (@$_POST['_action'] === 'add_topic' && $create_access)
	{
		if (@$_POST['title'])
		{
			$topic_name		= trim($_POST['title'], ". \t");
			$page_title		= $topic_name;
			$topic_name		= ucwords($topic_name);
			$topic_name		= preg_replace('/[^- \\w]/', '', $topic_name);
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
			$page = trim($page, '/ ');
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
			"AND k.category_id IN ( " . $this->db->q($category_id) . " ) " .
			"AND k.object_type_id = " . OBJECT_PAGE . " ";
	}

	// make counter query
	$sql =
		"SELECT COUNT(p.page_id) AS n " .
		"FROM " . $this->db->table_prefix . "page AS p, " .
		$selector;

	// count topics and make pagination
	$count		= $this->db->load_single($sql);
	$pagination	= $this->pagination($count['n'], $this->db->forum_topics);

	// make collector query
	$sql =
		"SELECT p.page_id, p.tag, p.supertag, p.title, p.user_id, p.owner_id, p.ip, p.comments, p.hits, p.created, p.commented, p.description, p.page_lang, u.user_name, o.user_name as owner_name " .
		"FROM " . $this->db->table_prefix . "page AS p " .
			"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
			"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.owner_id = o.user_id) " .
		$selector .
		"ORDER BY p.commented DESC " .
		$pagination['limit'];

	// load topics data
	$topics = $this->db->load_all($sql);

	foreach ($topics as $page)
	{
		$page_ids[]	= $page['page_id'];
		$this->cache_page($page, true);
	}

	// cache acls and categories
	$this->preload_acl($page_ids, '');
	$this->preload_categories($page_ids);

	// load latest topic comment
	$sql_comments =
		"SELECT p.tag, p.ip, p.created, p.comment_on_id, p.user_id, p.owner_id, u.user_name, o.user_name AS owner_name " .
		"FROM " . $this->db->table_prefix . "page p " .
			"LEFT JOIN " . $this->db->table_prefix . "page p2 ON (p.comment_on_id = p2.comment_on_id AND p.created < p2.created) " .
			"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
			"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.owner_id = o.user_id) " .
		"WHERE p.comment_on_id IN ( '" . implode("', '", $page_ids) . "' ) " .
			"AND p2.page_id IS NULL " .
			"AND p.comment_on_id <> 0 " .
			"AND p.deleted <> 1";

	$comments = $this->db->load_all($sql_comments);

	foreach ($comments as $comment)
	{
		$topic_comments[$comment['comment_on_id']] = $comment;
	}

	//  display search
	echo '<div class="clearfix" style="float: right; margin-bottom: 10px;">' . $this->action('search', ['for' => $this->tag, 'nomark' => 1, 'options' => 0]) . '</div>' . "\n";

	if (!isset($_GET['phrase']))
	{
		// display list
		echo '<div style="clear: both;">' .
				'<p>' . ($create_access ? '<strong><small class="cite"><a href="#newtopic">' . $this->_t('ForumNewTopic') . '</a></small></strong>' : '') . '</p>';
		$this->print_pagination($pagination);
		echo "</div>\n";

		echo '<table class="forum">' .
				'<thead><tr>' .
					'<th>' . $this->_t('ForumTopic') . '</th>' .
					'<th>' . $this->_t('ForumAuthor') . '</th>' .
					'<th>' . $this->_t('ForumReplies') . '</th>' .
					'<th>' . $this->_t('ForumViews') . '</th>' .
					'<th colspan="2">' . $this->_t('ForumLastComment') . '</th>' .
				'</tr></thead>' . "\n";

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
					$comment = false;
				}

				// check new comments
				$updated = ($user['last_mark']
							&& (($comment['user_name'] != $user['user_name']
									&& $comment['created'] > $user['last_mark'])
								|| ($topic['owner_name'] != $user['user_name']
									&& $topic['created'] > $user['last_mark']) ));

				$topic['description'] = htmlspecialchars($topic['description'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);

				if ($this->page['page_lang'] != $topic['page_lang'])
				{
					$topic['title']			= $this->do_unicode_entities($topic['title'], $topic['page_lang']);
					$topic['description']	= $this->do_unicode_entities($topic['description'], $topic['page_lang']);
				}

				// load related categories
				$_category = $this->get_categories($topic['page_id'], OBJECT_PAGE);
				$_category = !empty($_category) ? '<br>' . $_category : '';

				// print
				echo '<tbody><tr class="topic">' .
						'<td>' .
						($user && !$this->has_access('comment', $topic['page_id'])
							? '<img src="' . $this->db->theme_url . 'icon/spacer.png" title="' . $this->_t('DeleteCommentTip') . '" alt="' . $this->_t('DeleteText') . '" class="btn-locked">'
							: '' ) .
						($updated
							? '<strong><span class="cite" title="' . $this->_t('ForumNewPosts') . '">[' . $this->_t('ForumUpdated') . ']</span> ' . $this->compose_link_to_page($topic['tag'], '', $topic['title'], '', true) . '</strong>'
							: '<strong>' . $this->compose_link_to_page($topic['tag'], '', $topic['title'], '', true) . '</strong>'
						) .
						'</td>' .
						'<td class="t_center nowrap">' .
							'<small title="' . ($admin ? $topic['ip'] : '') . '">' .
								'&nbsp;&nbsp;' . $this->user_link($topic['owner_name']) . '&nbsp;&nbsp;<br>' .
								'&nbsp;&nbsp;' . $this->get_time_formatted($topic['created']) . '&nbsp;&nbsp;' .
							'</small>' .
						'</td>' .
						'<td class="t_center"><small>' . $topic['comments'] . '</small></td>' .
						'<td class="t_center"><small>' . $topic['hits'] . '</small></td>' .
						'<td>&nbsp;&nbsp;&nbsp;</td>' .
						'<td class="t_center">';

				if ($comment)
				{
					echo '<small' . ($updated ? ' style="font-weight:600;"' : '' ) . ' title="' . ($admin ? $comment['ip'] : '') . '">' .
						$this->user_link($comment['user_name']) . '<br>' .
						'<a href="' . $this->href('', $topic['tag'], ['p' => 'last', '#' => $comment['tag']]) . '">' . $this->get_time_formatted($comment['created']) . '</a></small>';
				}
				else
				{
					echo '<small><em>(' . $this->get_time_formatted($topic['created']) . ')</em></small>';
				}

				echo	'</td>' .
					'</tr>' .
					'<tr>' .
						'<td colspan="6" class="description">' . $topic['description'] . '' .
						$_category . '</td>' .
					'</tr></tbody>' . "\n";
			}
		}

		echo '</table>' . "\n";

		echo '<div class="clearfix"><p>' . ($user ? '<small><a href="' . $this->href('', '', ['markread' => 1]) . '">' . $this->_t('MarkRead') . '</a></small>' : '') . '</p>';
		$this->print_pagination($pagination);
		echo "</div>\n";
	}

	// display new topic form when applicable
	if ($create_access)
	{
		echo $this->form_open('add_topic');
		?>
		<br>
		<table id="newtopic" class="formation">
			<tr>
				<td class="label">
					<label for="topictitle"><?php echo $this->_t('ForumTopicName'); ?>:</label>
				</td>
				<td>
					<input type="text" id="topictitle" name="title" size="50" maxlength="250" value="">
					<input type="submit" id="submit" value="<?php echo $this->_t('ForumTopicSubmit'); ?>">
				</td>
			</tr>
		</table>
		<?php
		echo $this->form_close();
	}
}

?>
