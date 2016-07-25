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
	$_usergroup = isset($_GET['profile']) ? $_GET['profile'] : (isset($_POST['profile']) ? $_POST['profile'] : '');

	// does requested usergroup exists?
	if (false == $usergroup = $this->load_usergroup($_usergroup))
	{
		$this->show_message(Ut::perc_replace($this->_t('GroupsNotFound'),
			$this->supertag,
			htmlspecialchars($_usergroup, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)));
	}
	else
	{
		// header and profile data
		echo '<h1>'.$usergroup['group_name'].'</h1>';
		echo '<small><a href="'.$this->href('', $this->tag).'">&laquo; '.$this->_t('GroupsList')."</a></small>\n";
		echo '<h2>'.$this->_t('GroupsProfile').'</h2>'."\n";

		// basic info
?>
		<table>
			<tr class="lined">
				<td class="userprofil"><?php echo $this->_t('GroupsDescription'); ?></td>
				<td><?php echo $usergroup['description']; ?></td>
			</tr>
			<tr class="lined">
				<td class="userprofil"><?php echo $this->_t('GroupsCreated'); ?></td>
				<td><?php echo $this->get_time_formatted($usergroup['created']); ?></td>
			</tr>
			<tr class="lined"><?php // Have all usergroup pages as sub pages of the current Groups page. ?>
				<td class="userprofil"><?php echo $this->_t('GroupSpace'); // TODO: this might be placed somewhere else, just put it here for testing ?></td>
				<td><a href="<?php echo $this->href('', ($this->config['groups_page'].'/'.$usergroup['group_name'])); ?>"><?php echo $this->config['groups_page'].'/'.$usergroup['group_name']; ?></a></td>
			</tr>
		</table>

<?php

		// usergroup members
		$limit = 20;
		$count = $this->db->load_single(
			"SELECT COUNT(m.user_id) AS total_members ".
			"FROM {$this->config['table_prefix']}usergroup g ".
				"LEFT JOIN ".$this->config['table_prefix']."usergroup_member m ON (m.group_id = g.group_id) ".
			"WHERE ".
				"g.active = '1' ".
				"AND g.group_id = '".$usergroup['group_id']."' ".
			"LIMIT 1", true);

		echo '<h2 id="pages">'.$count['total_members'].' '.$this->_t('GroupsMembers').'</h2>'."\n";


		// print list

		$pagination = $this->pagination($count['total_members'], $limit, 'd', 'profile='.$usergroup['group_name'].'&amp;sort='.( isset($_GET['sort']) && $_GET['sort'] != 'name' ? 'date' : 'name' ).'#members');

		if ($count['total_members'])
		{
			echo "<table style=\"width:100%; white-space:nowrap; padding-right:20px;\">\n";

			if (isset($_GET['sort']) && $_GET['sort'] == 'name')
			{
				$order = "ORDER BY user_name ";
				$param = "sort=".$_GET['sort'];
			}
			else if (isset($_GET['sort']) && $_GET['sort'] == 'pages')
			{
				$order = "ORDER BY total_pages ";
				$param = "sort=".$_GET['sort'];
			}
			else if (isset($_GET['sort']) && $_GET['sort'] == 'comments')
			{
				$order = "ORDER BY total_comments ";
				$param = "sort=".$_GET['sort'];
			}
			else if (isset($_GET['sort']) && $_GET['sort'] == 'revisions')
			{
				$order = "ORDER BY total_revisions ";
				$param = "sort=".$_GET['sort'];
			}
			else if (isset($_GET['sort']) && $_GET['sort'] == 'signup')
			{
				$order = "ORDER BY signup_time ";
				$param = "sort=".$_GET['sort'];
			}
			else if (isset($_GET['sort']) && $_GET['sort'] == 'last_visit')
			{
				$order = "ORDER BY last_visit ";
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

			$members = $this->db->load_all(
				"SELECT u.user_id, u.user_name, u.signup_time, u.total_pages, u.total_revisions, u.total_comments, u.last_visit, s.hide_lastsession ".
				"FROM {$this->config['table_prefix']}user u ".
					"LEFT JOIN {$this->config['table_prefix']}usergroup_member m ON (u.user_id = m.user_id) ".
					"LEFT JOIN {$this->config['table_prefix']}user_setting s ON (u.user_id = s.user_id) ".
				"WHERE m.group_id = '".$usergroup['group_id']."' ".
				( $order == true ? $order : "ORDER BY user_name DESC " ).
				"LIMIT {$pagination['offset']}, $limit");

			// sorting and pagination

			$this->print_pagination($pagination);

			// members list itself
			#echo '<div>'."\n";

			// list header
			echo '<tr>'.
				'<th><a href="'.$this->href('', '', 'profile='.$_GET['profile'].'&amp;sort=name'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->_t('UsersName').( (isset($_GET['sort']) && $_GET['sort'] == 'name') || (isset($_REQUEST['user']) && $_REQUEST['user'] == true) ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
				'<th><a href="'.$this->href('', '', 'profile='.$_GET['profile'].'&amp;sort=pages'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->_t('UsersPages').( (isset($_GET['sort']) && $_GET['sort'] == 'pages') || (isset($_GET['sort']) && $_GET['sort'] == false) ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
				'<th><a href="'.$this->href('', '', 'profile='.$_GET['profile'].'&amp;sort=comments'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->_t('UsersComments').( isset($_GET['sort']) && $_GET['sort'] == 'comments' ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
				'<th><a href="'.$this->href('', '', 'profile='.$_GET['profile'].'&amp;sort=revisions'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->_t('UsersRevisions').( isset($_GET['sort']) && $_GET['sort'] == 'revisions' ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
			($this->get_user()
				?
				'<th><a href="'.$this->href('', '', 'profile='.$_GET['profile'].'&amp;sort=signup'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->_t('UsersSignup').( isset($_GET['sort']) && $_GET['sort'] == 'signup' ? (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
				'<th><a href="'.$this->href('', '', 'profile='.$_GET['profile'].'&amp;sort=last_visit'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->_t('UsersLastSession').( isset($_GET['sort']) && $_GET['sort'] == 'last_visit' ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'
				: '').
			"</tr>\n";


			foreach ($members as $member)
			{
				echo '<tr class="lined">';

				echo	'<td style="padding-left:5px;">'.$this->user_link($member['user_name'], '', true, false).'</td>'.
									'<td style="text-align:center;">'.$member['total_pages'].'</td>'.
									'<td style="text-align:center;">'.$member['total_comments'].'</td>'.
									'<td style="text-align:center;">'.$member['total_revisions'].'</td>'.
				($this->get_user()
				?
									'<td style="text-align:center;">'.$this->get_time_formatted($member['signup_time']).'</td>'.
									'<td style="text-align:center;">'.( $member['hide_lastsession']
					? '<em>'.$this->_t('UsersSessionHidden').'</em>'
					: ( $member['last_visit'] === SQL_DATE_NULL
						? '<em>'.$this->_t('UsersSessionNA').'</em>'
						: $this->get_time_formatted($member['last_visit']) )
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
			echo '<em>'.$this->_t('UsersNA2').'</em>';
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
			$this->http->redirect($this->href('', '', 'profile='.htmlspecialchars($_GET['group'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)));
		}
		else
		{
			$where = "WHERE group_name LIKE " . $this->db->q('%' . $_GET['group'] . '%') . " ";
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

	$count = $this->db->load_single(
		"SELECT COUNT(group_name) AS n ".
		"FROM {$this->config['table_prefix']}usergroup ".
		( $where == true ? $where : '' ));

	$pagination = $this->pagination($count['n'], $limit, 'p', $param);

	// collect data
	$groups = $this->db->load_all(
		"SELECT g.group_name, g.description, g.created, u.user_name AS moderator, COUNT(m.user_id) AS members ".
		"FROM {$this->config['table_prefix']}usergroup g ".
			"LEFT JOIN ".$this->config['table_prefix']."user u ON (g.moderator_id = u.user_id) ".
			"LEFT JOIN ".$this->config['table_prefix']."usergroup_member m ON (m.group_id = g.group_id) ".
		( $where == true ? $where : '' ).
		( $where ? 'AND ' : "WHERE ").
			"g.active = '1' ".
		"GROUP BY g.group_id ".
		( $order == true ? $order : "ORDER BY members DESC " ).
		"LIMIT {$pagination['offset']}, $limit");

	// usergroup filter form
	echo '<table class="formation"><tr><td class="label">';
	echo $this->form_open('search_group', ['form_method' => 'get']);
	echo $this->_t('GroupsSearch').': </td><td>';
	echo '<input type="search" name="group" maxchars="40" size="40" value="'.(isset($_GET['group']) ? htmlspecialchars($_GET['group'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : '').'" /> ';
	echo '<input type="submit" id="submit" value="'.$this->_t('GroupsFilter').'" /> ';
	echo '<input type="submit" id="button" value="'.$this->_t('GroupsOpenProfile').'" name="gotoprofile" />';
	echo $this->form_close();
	echo '</td></tr></table><br />'."\n";

	// print list
	echo "<table style=\"width:100%; white-space:nowrap; padding-right:20px;\">\n";

	$this->print_pagination($pagination);

	// list header
	echo '<tr>'.
			'<th><a href="'.$this->href('', '', 'sort=name'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->_t('GroupsName').( (isset($_GET['sort']) && $_GET['sort'] == 'name') || (isset($_REQUEST['group']) && $_REQUEST['group'] == true) ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
			'<th><a href="'.$this->href('', '', 'sort=members'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->_t('GroupsMembers').( (isset($_GET['sort']) && $_GET['sort'] == 'members') || (isset($_GET['sort']) && $_GET['sort'] == false) ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
		($this->get_user()
			?
			'<th><a href="'.$this->href('', '', 'sort=created'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->_t('GroupsCreated').( isset($_GET['sort']) && $_GET['sort'] == 'created' ? (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
			/* '<th><a href="'.$this->href('', '', 'sort=session'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->_t('GroupsLastSession').( isset($_GET['sort']) && $_GET['sort'] == 'session' ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>' */''
			: '').
		"</tr>\n";

	// list entries
	if ($groups == false)
	{
		echo '<tr class="lined"><td colspan="5" style="padding:10px; text-align:center;"><small><em>'.$this->_t('UsersNoMatching')."</em></small></td></tr>\n";
	}
	else
	{
		foreach ($groups as $usergroup)
		{
			echo '<tr class="lined">';

			echo	'<td style="padding-left:5px;"><a href="'.$this->href('', '', 'profile='.htmlspecialchars($usergroup['group_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'').'">'.$usergroup['group_name'].'</a></td>'.
					'<td style="text-align:center;">'.$usergroup['members'].'</td>'.
					/* '<td style="text-align:center;">'.$usergroup['total_comments'].'</td>'.
					'<td style="text-align:center;">'.$usergroup['total_revisions'].'</td>'. */
				($this->get_user()
					?
					'<td style="text-align:center;">'.$this->get_time_formatted($usergroup['created']).'</td>'
					: '').
			"</tr>\n";
		}
	}

	$this->print_pagination($pagination);

	echo "</table>\n";
}
