<?php

// shows subforums list
// {{forums [pages="subtag1, subtag2, ..."]}}
//		pages	= to create multilevel forums this optional parameter passes
//				  a comma-delimeted list of tag names of pages that must be
//				  considered subforums, and not topics. tags must not be relative

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
		#$user = $this->get_user();
		$user_id = $this->get_user_id(); //xxx
	}

	// parse subforums list if any
	if (!empty($pages))
	{
		$pages = trim(explode(',', $pages), '/ ');
	}

	// make query
	$sql = "SELECT p.page_id, p.tag, p.title, p.description ".
		"FROM {$this->config['table_prefix']}page AS p, ".
			"{$this->config['table_prefix']}acl AS a ".
		"WHERE p.page_id = a.page_id ".
		"AND a.privilege = 'comment' AND a.list = '*' ";

	if (!isset($pages))
	{
		$sql .= "AND p.tag LIKE '".quote($this->dblink, $this->config['forum_cluster'])."/%' ";
	}
	else
	{
		foreach ($pages as $page)
		{
			$sql .= "AND p.tag = '".quote($this->dblink, $page)."' ";
		}
	}

	$sql .= "ORDER BY p.modified ASC";

	// load subforums data
	$forums	= $this->load_all($sql, 1);

	// display list
	echo '<table cellspacing="1" cellpadding="4" class="forum">'.
			'<tr>'.
				'<th>'.$this->get_translation('ForumSubforums').'</th>'.
				'<th colspan="2">'.$this->get_translation('ForumLastComment').'</th>'.
			'</tr>'."\n";

	foreach ($forums as $forum)
	{
		// show only those forums where user has read access
		if ($this->has_access('read', $forum['page_id']))
		{
			// load latest comment
			$comment = $this->load_single(
				"SELECT a.tag, a.title, a.comment_on_id, a.user_id, a.owner_id, a.created, b.tag as comment_on, u.user_name AS user ".
				"FROM {$this->config['table_prefix']}page a ".
				"LEFT JOIN ".$this->config['table_prefix']."user u ON (a.user_id = u.user_id) ".
				"LEFT JOIN ".$this->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) ".
				"WHERE b.tag LIKE '".quote($this->dblink, $forum['tag'])."/%' ".
					"OR a.tag LIKE '".quote($this->dblink, $forum['tag'])."/%' ".
				"ORDER BY a.created DESC ".
				"LIMIT 1", 1);

			// print
			echo '<tr class="lined">'.
					'<td style="width:70%" valign="top">'.
						( $this->has_access('write', $forum['page_id'], '*') === false ? str_replace('{theme}', $this->config['theme_url'], $this->get_translation('lockicon')) : '' ).
						( $user['last_mark'] == true && $comment['user'] != $user['user_name'] && $comment['created'] > $user['last_mark'] ? '<strong class="cite" title="'.$this->get_translation('ForumNewPosts').'">[updated]</strong> ' : '' ).
						'<strong>'.$this->link($forum['tag'], '', $forum['title'], '', 0).'</strong><br />'.
						'<small>'.$forum['description'].'</small>'.
					'</td>'.
					'<td>&nbsp;&nbsp;&nbsp;</td>';
			if ($comment == true)
			{
				echo '<td style="text-align:left" valign="top">';

				if ($comment['comment_on_id'] == true)
				{
					echo '<small><a href="'.$this->href('', $comment['comment_on'], 'p=last').'#'.$comment['tag'].'">'.$this->get_page_title($comment['comment_on']).'</a><br />'.
						( $comment['user'] == GUEST ? '<em>'.$this->get_translation('Guest').'</em>' : $comment['user'] ).' ('.$this->get_time_string_formatted($comment['created']).')</small>';
				}
				else
				{
					echo '<small><a href="'.$this->href('', $comment['tag']).'">'.$comment['title'].'</a><br />'.
						( $comment['user'] == GUEST ? '<em>'.$this->get_translation('Guest').'</em>' : $comment['user'] ).' ('.$this->get_time_string_formatted($comment['created']).')</small>';
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
	echo '<table>'.
			'<tr>'.
				'<td>'.
					// mark all forums read
					( $user == true ? '<small><a href="'.$this->href('', '', 'markread=yes').'">'.$this->get_translation('MarkRead').'</a></small>' : '' ).
				'</td>'.
				'<td align="right">'.
					// XML button
					'<a href="'.$this->config['base_url'].'xml/comments_'.
					preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name'])).
					'.xml"><img src="'.$this->config['theme_url'].
					'icons/xml.gif" alt="XML" /></a>'.
				'</td>'.
			'</tr>'.
		'</table>'."\n";
}

?>
