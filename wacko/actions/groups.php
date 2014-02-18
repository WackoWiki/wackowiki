<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$where			= '';
$order			= '';
$param			= '';
$groups			= '';
$usergroups		= '';
$error			= '';

// display usergroup profile
if (isset($_REQUEST['profile']) && $_REQUEST['profile'] == true)
{
	// does requested usergroup exists?
	if (false == $usergroup = $this->load_usergroup($_REQUEST['profile']))
	{
		echo '<div class="info">'.str_replace('%2', htmlspecialchars($_REQUEST['profile'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET), str_replace('%1', $this->supertag, $this->get_translation('GroupsNotFound'))).'</div>';
	}
	else
	{
		// header and profile data
		echo '<h1>'.$usergroup['group_name'].'</h1>';
		echo '<small><a href="'.$this->href('', $this->tag).'">&laquo; '.$this->get_translation('GroupsList')."</a></small>\n";
		echo '<h2>'.$this->get_translation('GroupsProfile').'</h2>'."\n";

		// basic info
?>
		<table cellspacing="3">
			<tr class="lined">
				<td class="userprofil"><?php echo $this->get_translation('GroupsDescription'); ?></td>
				<td><?php echo $usergroup['description']; ?></td>
			</tr>
			<tr class="lined">
				<td class="userprofil"><?php echo $this->get_translation('GroupsCreated'); ?></td>
				<td><?php echo $this->get_time_string_formatted($usergroup['created']); ?></td>
			</tr>
			<tr class="lined"><?php // Have all usergroup pages as sub pages of the current Groups page. ?>
				<td class="userprofil"><?php echo $this->get_translation('GroupSpace'); // TODO: this might be placed somewhere else, just put it here for testing ?></td>
				<td><a href="<?php echo $this->href('', ($this->config['groups_page'].'/'.$usergroup['group_name'])); ?>"><?php echo $this->config['groups_page'].'/'.$usergroup['group_name']; ?></a></td>
			</tr>
		</table>

<?php

		// usergroup members
		$limit = 20;
		$count = $this->load_single(
						"SELECT COUNT(m.user_id) AS total_members ".
						"FROM {$this->config['table_prefix']}usergroup g ".
							"LEFT JOIN ".$this->config['table_prefix']."usergroup_member m ON (m.group_id = g.group_id) ".
						"WHERE ".
							"g.active = '1' ".
							"AND g.group_id = '".quote($this->dblink, $usergroup['group_id'])."' ".
						"LIMIT 1", 1);

		echo '<h2 id="pages">'.$count['total_members'].' '.$this->get_translation('GroupsMembers').'</a></h2>'."\n";


		// print list
		echo "<table style=\"width:100%; white-space:nowrap; padding-right:20px;\">\n";


		$pagination = $this->pagination($count['total_members'], $limit, 'd', 'profile='.$usergroup['group_name'].'&amp;sort='.( isset($_GET['sort']) && $_GET['sort'] != 'name' ? 'date' : 'name' ).'#members');

		if ($count['total_members'])
		{
			$members = $this->load_all(
				"SELECT u.user_id, u.user_name, u.signup_time, u.total_pages, u.total_revisions, u.total_comments ".
				"FROM {$this->config['table_prefix']}user u ".
					"LEFT JOIN {$this->config['table_prefix']}usergroup_member m ON (u.user_id = m.user_id) ".
				"WHERE m.group_id = '".quote($this->dblink, $usergroup['group_id'])."' ".
				"ORDER BY ".( isset($_GET['sort']) && $_GET['sort'] == 'name' ? 'u.user_name ASC' : 'signup_time DESC' )." ".
				"LIMIT {$pagination['offset']}, $limit");

			// sorting and pagination

			if (isset($pagination['text']))
				echo " <span class=\"pagination\">".$pagination['text']."</span>\n";

			// members list itself
			#echo '<div>'."\n";

			// list header
			echo '<tr>'.
				'<th><a href="'.$this->href('', '', 'sort=name'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('UsersName').( (isset($_GET['sort']) && $_GET['sort'] == 'name') || (isset($_REQUEST['user']) && $_REQUEST['user'] == true) ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
				'<th><a href="'.$this->href('', '', 'sort=pages'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('UsersPages').( (isset($_GET['sort']) && $_GET['sort'] == 'pages') || (isset($_GET['sort']) && $_GET['sort'] == false) ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
				'<th><a href="'.$this->href('', '', 'sort=comments'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('UsersComments').( isset($_GET['sort']) && $_GET['sort'] == 'comments' ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
				'<th><a href="'.$this->href('', '', 'sort=revisions'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('UsersRevisions').( isset($_GET['sort']) && $_GET['sort'] == 'revisions' ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
			($this->get_user()
				?
				'<th><a href="'.$this->href('', '', 'sort=signup'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('UsersSignup').( isset($_GET['sort']) && $_GET['sort'] == 'signup' ? (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
				'<th><a href="'.$this->href('', '', 'sort=session'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('UsersLastSession').( isset($_GET['sort']) && $_GET['sort'] == 'session' ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'
				: '').
			"</tr>\n";


			foreach ($members as $member)
			{
				echo '<tr class="lined">';

				echo	'<td style="padding-left:5px;"><a href="'.$this->href('', ($this->config['users_page'].'/'.$member['user_name']), 'profile='.htmlspecialchars($member['user_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'').'">'.$member['user_name'].'</a></td>'.
									'<td align="center">'.$member['total_pages'].'</td>'.
									'<td align="center">'.$member['total_comments'].'</td>'.
									'<td align="center">'.$member['total_revisions'].'</td>'.
				($this->get_user()
				?
									'<td align="center">'.$this->get_time_string_formatted($member['signup_time']).'</td>'.
									'<td align="center">'.( $member['hide_lastsession'] == 1
				? '<em>'.$this->get_translation('UsersSessionHidden').'</em>'
				: ( !$member['session_time'] || $member['session_time'] == SQL_NULLDATE
				? '<em>'.$this->get_translation('UsersSessionNA').'</em>'
				: $this->get_time_string_formatted($member['session_time']) )
				).'</td>'
				: '').
							"</tr>\n";

				$i = 0;
				if (++$i >= $limit) break 1;
			}
			#echo "</div>\n";
			echo "</table>\n";

			unset($members, $member, $limit, $i);
		}
		else
		{
			echo '<em>'.$this->get_translation('GroupsNA2').'</em>';
		}

	}
}
// display whole usergroup list instead of the particular profile
else
{
	$limit = 50;

	// defining WHERE and ORDER clauses
	// $param is passed to the pagination links
	if (isset($_GET['group']) && $_GET['group'] == true && strlen($_GET['group']) > 2)
	{
		// goto usergroup profile directly if so desired
		if (isset($_GET['gotoprofile']) && $this->load_usergroup($_GET['group']) == true)
		{
			$this->redirect($this->href('', '', 'profile='.htmlspecialchars($_GET['group'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)));
		}
		else
		{
			$where = "WHERE group_name LIKE '%".quote($this->dblink, $_GET['group'])."%' ";
			$param = "group=".htmlspecialchars($_GET['group'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);
		}
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'name')
	{
		$order = "ORDER BY group_name ";
		$param = "sort=".$_GET['sort'];
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'members')
	{
		$order = "ORDER BY members ";
		$param = "sort=".$_GET['sort'];
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'created')
	{
		$order = "ORDER BY created ";
		$param = "sort=".$_GET['sort'];
	}

	if (isset($_GET['order']) && $_GET['order'] == 'asc')
	{
		$order .= "ASC ";
		$param .= "&amp;order=asc";
	}
	else if (isset($_GET['order']) && $_GET['order'] == 'desc')
	{
		$order .= "DESC ";
		$param .= "&amp;order=desc";
	}

	$count = $this->load_single(
		"SELECT COUNT(group_name) AS n ".
		"FROM {$this->config['table_prefix']}usergroup ".
		( $where == true ? $where : '' ));

	$pagination = $this->pagination($count['n'], $limit, 'p', $param);

	// collect data
	$groups = $this->load_all(
		"SELECT g.group_name, g.description, g.created, u.user_name AS moderator, COUNT(m.user_id) AS members ".
		"FROM {$this->config['table_prefix']}usergroup g ".
			"LEFT JOIN ".$this->config['table_prefix']."user u ON (g.moderator = u.user_id) ".
			"LEFT JOIN ".$this->config['table_prefix']."usergroup_member m ON (m.group_id = g.group_id) ".
		( $where == true ? $where : '' ).
		( $where ? 'AND ' : "WHERE ").
			"g.active = '1' ".
		"GROUP BY g.group_id ".
		( $order == true ? $order : "ORDER BY members DESC " ).
		"LIMIT {$pagination['offset']}, $limit");

	// usergroup filter form
	echo '<table class="formation"><tr><td class="label">';
	echo $this->form_open('', '', 'get');
	echo $this->get_translation('GroupsSearch').': </td><td>';
	echo '<input name="group" maxchars="40" size="40" value="'.isset($_GET['group']) ? htmlspecialchars($_GET['group'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : ''.'" /> ';
	echo '<input id="submit" type="submit" value="'.$this->get_translation('GroupsFilter').'" /> ';
	echo '<input id="button" type="submit" value="'.$this->get_translation('GroupsOpenProfile').'" name="gotoprofile" />';
	echo $this->form_close();
	echo '</td></tr></table><br />'."\n";

	// print list
	echo "<table style=\"width:100%; white-space:nowrap; padding-right:20px;\">\n";

	// pagination
	if (isset($pagination['text']))
	{
		echo '<tr><td colspan="6"><span class="pagination">'.$pagination['text'].'</span></td></tr>'."\n";
	}

	// list header
	echo '<tr>'.
			'<th><a href="'.$this->href('', '', 'sort=name'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('GroupsName').( (isset($_GET['sort']) && $_GET['sort'] == 'name') || (isset($_REQUEST['group']) && $_REQUEST['group'] == true) ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
			'<th><a href="'.$this->href('', '', 'sort=members'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('GroupsMembers').( (isset($_GET['sort']) && $_GET['sort'] == 'members') || (isset($_GET['sort']) && $_GET['sort'] == false) ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
		($this->get_user()
			?
			'<th><a href="'.$this->href('', '', 'sort=created'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('GroupsCreated').( isset($_GET['sort']) && $_GET['sort'] == 'created' ? (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
			/* '<th><a href="'.$this->href('', '', 'sort=session'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('GroupsLastSession').( isset($_GET['sort']) && $_GET['sort'] == 'session' ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>' */''
			: '').
		"</tr>\n";

	// list entries
	if ($groups == false)
	{
		echo '<tr class="lined"><td colspan="5" align="center" style="padding:10px;"><small><em>'.$this->get_translation('UsersNoMatching')."</em></small></td></tr>\n";
	}
	else
	{
		foreach ($groups as $group)
		{
			echo '<tr class="lined">';

			echo	'<td style="padding-left:5px;"><a href="'.$this->href('', '', 'profile='.htmlspecialchars($usergroup['group_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'').'">'.$usergroup['group_name'].'</a></td>'.
					'<td align="center">'.$usergroup['members'].'</td>'.
					/* '<td align="center">'.$usergroup['total_comments'].'</td>'.
					'<td align="center">'.$usergroup['total_revisions'].'</td>'. */
				($this->get_user()
					?
					'<td align="center">'.$this->get_time_string_formatted($usergroup['created']).'</td>'
					: '').
			"</tr>\n";
		}
	}

	// pagination
	if (isset($pagination['text']))
	{
		echo '<tr><td colspan="6"><span class="pagination">'.$pagination['text'].'</span></td></tr>'."\n";
	}

	echo "</table>\n";
}

?>