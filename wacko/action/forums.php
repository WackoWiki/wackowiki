<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// shows subforums list
// {{forums [pages="subtag1, subtag2, ..."]}}
//		pages	= to create multilevel forums this optional parameter passes
//				  a comma-delimeted list of tag names of pages that must be
//				  considered subforums, and not topics. tags must be absolut (not relative)
//		if you define pages, it must be done for all subforums and topic pages

// define variables
$_pages = '';

// make sure that we're executing inside the forum cluster
if (substr($this->tag, 0, strlen($this->db->forum_cluster)) == $this->db->forum_cluster)
{
	$this->forum = false;

	// load user data
	$user = $this->get_user();

	// process 'mark read' - reset session time
	if (isset($_GET['markread']) && $user == true)
	{
		$this->update_last_mark($user);
		$this->set_user_setting('last_mark', date('Y-m-d H:i:s', time()));
		$user = $this->get_user();
	}

	// parse subforums list if any
	if (!empty($pages))
	{
		$pages = explode(',', $pages);
		$pages = array_map('trim', $pages);
	}

	// make query
	$sql =	"SELECT p.page_id, p.tag, p.title, p.description, p.page_lang ".
			"FROM {$this->db->table_prefix}page AS p, ".
				"{$this->db->table_prefix}acl AS a ".
			"WHERE p.page_id = a.page_id ".
				"AND a.privilege = 'comment' AND a.list = '' ";

	if (!isset($pages))
	{
		$sql .= "AND p.tag LIKE " . $this->db->q($this->db->forum_cluster . '/%') . " ";
	}
	else
	{
		foreach ($pages as $num => $page)
		{
			if ($num <> 0)
			{
				$_pages .= "','";
			}

			$_pages .= $page;
		}

		$sql .= "AND p.tag IN (".$this->db->q($_pages).") ";
	}

	$sql .= "ORDER BY p.created ASC";

	// load subforums data
	$forums	= $this->db->load_all($sql, true);

	// display list
	echo '<table class="forum">'.
			'<tr>'.
				'<th>'.$this->_t('ForumSubforums').'</th>'.
				'<th>'.$this->_t('ForumTopics').'</th>'.
				'<th>'.$this->_t('ForumPosts').'</th>'.
				'<th>'.$this->_t('ForumLastComment').'</th>'.
			'</tr>'."\n";

	foreach ($forums as $forum)
	{
		// show only those forums where user has read access
		if ($this->has_access('read', $forum['page_id']))
		{
			// count total topics
			$topics = $this->db->load_single(
				"SELECT count(a.page_id) as total ".
				"FROM {$this->db->table_prefix}page a ".
				"WHERE a.tag LIKE " . $this->db->q($forum['tag'] . '/%') . " ".
					"AND a.deleted <> '1' ", true);

			// count total posts
			$posts = $this->db->load_single(
				"SELECT sum(a.comments) as total ".
				"FROM {$this->db->table_prefix}page a ".
				"WHERE a.tag LIKE " . $this->db->q($forum['tag'] . '/%') . " ".
					"AND a.deleted <> '1' ", true);

			// load latest comment
			$comments = $this->db->load_all(
				"SELECT a.page_id, a.tag, a.title, a.comment_on_id, a.user_id, a.owner_id, a.created, a.page_lang, b.tag as comment_on, b.title as topic_title, b.page_lang as topic_lang, u.user_name ".
				"FROM {$this->db->table_prefix}page a ".
					"LEFT JOIN ".$this->db->table_prefix."user u ON (a.user_id = u.user_id) ".
					"LEFT JOIN ".$this->db->table_prefix."page b ON (a.comment_on_id = b.page_id) ".
				"WHERE b.tag LIKE ".$this->db->q($forum['tag'] . '/%')." ".
					"OR a.tag LIKE ".$this->db->q($forum['tag'] . '/%')." ".
					"AND a.deleted <> '1' ".
				"ORDER BY a.created DESC ", true);

			foreach ($comments as $_comment)
			{
				if ($this->db->hide_locked)
				{
					if ($this->has_access('read', $_comment['page_id']))
					{
						$comment = $_comment;
						break;
					}
				}
				else
				{
					$comment = $_comment;
					break;
				}
			}

			$forum['description'] = htmlspecialchars($forum['description'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);

			if ($this->page['page_lang'] != $forum['page_lang'])
			{
				$_lang = $forum['page_lang'];
				$forum['description'] = $this->do_unicode_entities($forum['description'], $forum['page_lang']);
			}
			else
			{
				$_lang = '';
			}

			// print <span class="icon"></span>
			echo '<tr class="lined">'.
					'<td style="width:60%; vertical-align:top;">'.
						( $this->has_access('read', $forum['page_id'], GUEST) === false
							? '<img src="'.$this->db->theme_url.'icon/spacer.png" title="'.$this->_t('DeleteCommentTip').'" alt="'.$this->_t('DeleteText').'" class="btn-locked"/>'
							: '' ).
						( $user['last_mark'] == true && $comment['user_name'] != $user['user_name'] && $comment['created'] > $user['last_mark']
							? '<strong class="cite" title="'.$this->_t('ForumNewPosts').'">[updated]</strong> '
							: '' ).
						'<strong>'.$this->link('/'.$forum['tag'], '', $forum['title'], '', 0, '', $_lang).'</strong><br />'.
						'<small>'.$forum['description'].'</small>'.
					'</td>'.
					'<td style="text-align:center" >&nbsp;'.$topics['total'].'&nbsp;&nbsp;</td>'.
					'<td style="text-align:center" >&nbsp;'.$posts['total'].'&nbsp;&nbsp;</td>';

			if ($comment == true)
			{
				echo '<td style="text-align:left; vertical-align:top;">';

				if ($comment['comment_on_id'] == true)
				{
					if ($this->page['page_lang'] != $comment['topic_lang'])
					{
						$comment['topic_title'] = $this->do_unicode_entities($comment['topic_title'], $comment['topic_lang']);
					}

					echo '<small><a href="'.$this->href('', $comment['comment_on'], 'p=last').'#'.$comment['tag'].'">'.$comment['topic_title'].'</a><br />'.
						$this->user_link($comment['user_name']).
						' ('.$this->get_time_formatted($comment['created']).')</small>';
				}
				else
				{
					if ($this->page['page_lang'] != $comment['page_lang'])
					{
						$comment['title']= $this->do_unicode_entities($comment['title'], $comment['page_lang']);
					}

					echo '<small><a href="'.$this->href('', $comment['tag']).'">'.$comment['title'].'</a><br />'.
						$this->user_link($comment['user_name']).
						' ('.$this->get_time_formatted($comment['created']).')</small>';
				}
			}
			else
			{
				echo '<td>';
				echo '<small><em>'.$this->_t('ForumNoComments').'</em></small>';
			}

			echo	'</td>'.
				'</tr>'."\n";
		}
	}

	echo '</table>'."\n";
	echo '<br />'."\n";

	// mark all forums read
	if ($user == true)
	{
		echo '<small><a href="'.$this->href('', '', 'markread=yes').'">'.$this->_t('MarkRead').'</a></small>';
	}

	echo '<span class="desc_rss_feed"><a href="'.$this->db->base_url.'xml/comments_'.preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->db->site_name)).'.xml"><img src="'.$this->db->theme_url.'icon/spacer.png'.'" title="'.$this->_t('RecentCommentsXMLTip').'" alt="XML" class="btn-feed"/></a></span><br />'."\n";
}

?>
