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
	$user = $this->GetUser();

	// process 'mark read' - reset session time
	if (isset($_GET['markread']) && $user == true)
	{
		$this->UpdateSessionTime($user);
		$this->SetUserSetting('session_time', date('Y-m-d H:i:s', time()));
		$user = $this->GetUser();
		$user_id = $this->GetUserId(); //xxx
	}

	// parse subforums list if any
	if (!empty($pages)) $pages = trim(explode(',', $pages), '/ ');

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
			$sql .= "AND p.tag = '".quote($this->dblink, $page)."' ";
	}
	$sql .= "ORDER BY p.modified ASC";

	// load subforums data
	$forums	= $this->LoadAll($sql, 1);

	// display list
	echo '<table cellspacing="1" cellpadding="4" class="forum">'.
			'<tr>'.
				'<th>'.$this->GetTranslation('ForumSubforums').'</th>'.
				'<th colspan="2">'.$this->GetTranslation('ForumLastComment').'</th>'.
			'</tr>'."\n";

	foreach ($forums as $forum)
	{
		// show only those forums where user has read access
		if ($this->HasAccess('read', $forum['page_id']))
		{
			// load latest comment
			$comment = $this->LoadSingle(
				"SELECT a.tag, a.title, a.comment_on_id, a.user_id, a.owner_id, a.created, b.tag as comment_on, u.user_name AS user ".
				"FROM {$this->config['table_prefix']}page a ".
				"LEFT JOIN ".$this->config["table_prefix"]."user u ON (a.user_id = u.user_id) ".
				"LEFT JOIN ".$this->config["table_prefix"]."page b ON (a.comment_on_id = b.page_id) ".
				"WHERE b.tag LIKE '".quote($this->dblink, $forum['tag'])."/%' ".
					"OR a.tag LIKE '".quote($this->dblink, $forum['tag'])."/%' ".
				"ORDER BY a.created DESC ".
				"LIMIT 1", 1);

			// print
			echo '<tr class="lined">'.
					'<td style="width:70%" valign="top">'.
						( $this->HasAccess('write', $forum['page_id'], GUEST) === false ? str_replace('{theme}', $this->config['theme_url'], $this->GetTranslation('lockicon')) : '' ).
						( $user['sessiontime'] == true && $comment['user'] != $user['user_name'] && $comment['created'] > $user['sessiontime'] ? '<strong class="cite" title="'.$this->GetTranslation('ForumNewPosts').'">[updated]</strong> ' : '' ).
						'<strong>'.$this->Link($forum['tag'], '', $forum['title'], 0).'</strong><br />'.
						'<small><small>'.$forum['description'].'</small></small>'.
					'</td>'.
					'<td>&nbsp;&nbsp;&nbsp;</td>';
			if ($comment == true)
			{
				echo '<td style="text-align:left" valign="top">';

				if ($comment['comment_on_id'] == true)
					echo '<small><a href="'.$this->href('', $comment['comment_on'], 'p=last').'#'.$comment['tag'].'">'.$this->GetPageTitle($comment['comment_on']).'</a><br />'.
						( $comment['user'] == GUEST ? '<em>'.$this->GetTranslation('Guest').'</em>' : $comment['user'] ).' ('.$this->GetTimeStringFormatted($comment['created']).')</small>';
				else
					echo '<small><a href="'.$this->href('', $comment['tag']).'">'.$comment['title'].'</a><br />'.
						( $comment['user'] == GUEST ? '<em>'.$this->GetTranslation('Guest').'</em>' : $comment['user'] ).' ('.$this->GetTimeStringFormatted($comment['created']).')</small>';
			}
			else
			{
				echo '<td>';
				echo '<small><em>'.$this->GetTranslation('ForumNoComments').'</em></small>';
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
					( $user == true ? '<small><small><a href="?markread=yes">'.$this->GetTranslation('ForumMarkRead').'</a></small></small>' : '' ).
				'</td>'.
				'<td align="right">'.
					// XML button
					'<a href="'.$this->config['base_url'].'xml/comments_'.
					preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name'])).
					'.xml"><img src="'.$this->config['theme_url'].
					'icons/xml.gif" alt="XML" /></a><a href="/Проект/ОСайте/RSS" '.
					'title="Что это такое?">?</a>'.
				'</td>'.
			'</tr>'.
		'</table>'."\n";
}

?>
