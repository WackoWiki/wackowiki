<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// shows subforums list
// {{forums [pages="subtag1, subtag2, ..."]}}
//		pages	= to create multilevel forums this optional parameter passes
//				  a comma-delimeted list of tag names of pages that must be
//				  considered subforums, and not topics. tags must not be relative

// define variables
$_pages = '';

// make sure that we're executing inside the forum cluster
if (substr($this->tag, 0, strlen($this->config['forum_cluster'])) == $this->config['forum_cluster'])
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
		#$pages = trim($pages, '/ ');
		$pages = explode(',', $pages);
	}

	// make query
	$sql = "SELECT p.page_id, p.tag, p.title, p.description, p.lang ".
		"FROM {$this->config['table_prefix']}page AS p, ".
			"{$this->config['table_prefix']}acl AS a ".
		"WHERE p.page_id = a.page_id ".
		"AND a.privilege = 'comment' AND a.list = '' ";

	if (!isset($pages))
	{
		$sql .= "AND p.tag LIKE '".quote($this->dblink, $this->config['forum_cluster'])."/%' ";
	}
	else
	{
		foreach ($pages as $num => $page)
		{
			if ($num <> 0)
			{
				$_pages .= "','";
			}

			$_pages .= quote($this->dblink, $page);
		}

		$sql .= "AND p.tag IN ('".$_pages."') ";
	}

	$sql .= "ORDER BY p.created ASC";

	// load subforums data
	$forums	= $this->load_all($sql, 1);

	// display list
	echo '<table class="forum">'.
			'<tr>'.
				'<th>'.$this->get_translation('ForumSubforums').'</th>'.
				'<th>'.$this->get_translation('ForumTopics').'</th>'.
				'<th>'.$this->get_translation('ForumPosts').'</th>'.
				'<th>'.$this->get_translation('ForumLastComment').'</th>'.
			'</tr>'."\n";

	foreach ($forums as $forum)
	{
		// show only those forums where user has read access
		if ($this->has_access('read', $forum['page_id']))
		{
			// count total topics
			$topics = $this->load_single(
				"SELECT count(a.page_id) as total ".
				"FROM {$this->config['table_prefix']}page a ".
				"WHERE a.tag LIKE '".quote($this->dblink, $forum['tag'])."/%' ".
					"AND a.deleted <> '1' ", 1);

			// count total posts
			$posts = $this->load_single(
				"SELECT sum(a.comments) as total ".
				"FROM {$this->config['table_prefix']}page a ".
				"WHERE a.tag LIKE '".quote($this->dblink, $forum['tag'])."/%' ".
					"AND a.deleted <> '1' ", 1);

			// load latest comment
			$comment = $this->load_single(
				"SELECT a.tag, a.title, a.comment_on_id, a.user_id, a.owner_id, a.created, a.lang, b.tag as comment_on, b.title as topic_title, b.lang as topic_lang, u.user_name ".
				"FROM {$this->config['table_prefix']}page a ".
					"LEFT JOIN ".$this->config['table_prefix']."user u ON (a.user_id = u.user_id) ".
					"LEFT JOIN ".$this->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) ".
				"WHERE b.tag LIKE '".quote($this->dblink, $forum['tag'])."/%' ".
					"OR a.tag LIKE '".quote($this->dblink, $forum['tag'])."/%' ".
					"AND a.deleted <> '1' ".
				"ORDER BY a.created DESC ".
				"LIMIT 1", 1);

			if ($this->page['lang'] != $forum['lang'])
			{
				$_lang = $forum['lang'];
			}
			else
			{
				$_lang ='';
			}

			// print
			echo '<tr class="lined">'.
					'<td style="width:60%" valign="top">'.
						( $this->has_access('write', $forum['page_id'], '*') === false ? str_replace('{theme}', $this->config['theme_url'], $this->get_translation('lockicon')) : '' ).
						( $user['last_mark'] == true && $comment['user_name'] != $user['user_name'] && $comment['created'] > $user['last_mark'] ? '<strong class="cite" title="'.$this->get_translation('ForumNewPosts').'">[updated]</strong> ' : '' ).
						'<strong>'.$this->link('/'.$forum['tag'], '', $forum['title'], '', 0, '', $_lang).'</strong><br />'.
						'<small>'.htmlspecialchars($forum['description'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'</small>'.
					'</td>'.
					'<td style="text-align:center" >&nbsp;'.$topics['total'].'&nbsp;&nbsp;</td>'.
					'<td style="text-align:center" >&nbsp;'.$posts['total'].'&nbsp;&nbsp;</td>';

			if ($comment == true)
			{
				echo '<td style="text-align:left" valign="top">';

				if ($comment['comment_on_id'] == true)
				{
					if ($this->page['lang'] != $comment['topic_lang'])
					{
						$comment['topic_title'] = $this->do_unicode_entities($comment['topic_title'], $comment['topic_lang']);
					}

					echo '<small><a href="'.$this->href('', $comment['comment_on'], 'p=last').'#'.$comment['tag'].'">'.$comment['topic_title'].'</a><br />'.
						( $comment['user_name'] == GUEST ? '<em>'.$this->get_translation('Guest').'</em>' : $comment['user_name'] ).' ('.$this->get_time_string_formatted($comment['created']).')</small>';
				}
				else
				{
					if ($this->page['lang'] != $comment['lang'])
					{
						$comment['title']= $this->do_unicode_entities($comment['title'], $comment['lang']);
					}

					echo '<small><a href="'.$this->href('', $comment['tag']).'">'.$comment['title'].'</a><br />'.
						( $comment['user_name'] == GUEST ? '<em>'.$this->get_translation('Guest').'</em>' : $comment['user_name'] ).' ('.$this->get_time_string_formatted($comment['created']).')</small>';
				}
			}
			else
			{
				echo '<td>';
				echo '<small><em>'.$this->get_translation('ForumNoComments').'</em></small>';
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
		echo '<small><a href="'.$this->href('', '', 'markread=yes').'">'.$this->get_translation('MarkRead').'</a></small>';
	}

	echo "<span class=\"desc_rss_feed\"><a href=\"".$this->config['base_url']."xml/comments_".preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['site_name'])).".xml\"><img src=\"".$this->config['theme_url']."icons/xml.png"."\" title=\"".$this->get_translation('RecentCommentsXMLTip')."\" alt=\"XML\" /></a></span><br />\n";
}

?>
