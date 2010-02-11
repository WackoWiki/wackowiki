<?php

########################################################
##   User Groups                                      ##
########################################################

$module['groups'] = array(
		'order'	=> 5,
		'cat'	=> 'Users',
		'mode'	=> 'groups',
		'name'	=> 'Groups',
		'title'	=> 'Group management',
	);

########################################################

function admin_groups(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />

<?php

	// get group
	if ($_GET['group_id'] )
	{
		// group data
		echo '';
		echo "";
	}
	else
	{
		// set created ordering
		if ($_GET['order'] == 'created_asc')
		{
			$order		= 'ORDER BY g.created ASC ';
			$created	= 'created_desc';
		}
		else if ($_GET['order'] == 'created_desc')
		{
			$order		= 'ORDER BY g.created DESC ';
			$created	= 'created_asc';
		}
		else
		{
			$created	= 'created_asc';
		}


		// set group ordering
		if ($_GET['order'] == 'group_asc')
		{
			$order		= 'ORDER BY g.group_name DESC ';
			$ordergroup	= 'user_desc';
		}
		else if ($_GET['order'] == 'group_desc')
		{
			$order		= 'ORDER BY g.group_name ASC ';
			$ordergroup	= 'group_asc';
		}
		else
		{
			$ordergroup	= 'group_desc';
		}

		// filter by lang
		if ($_GET['moderator'])
		{
			$where = "WHERE u.user_name = '".quote($engine->dblink, $_GET['moderator'])."' ";
		}

		// entries to display
		$limit = 100;

		// collecting data
		$count = $engine->LoadSingle(
			"SELECT COUNT(group_name) AS n ".
			"FROM {$engine->config['table_prefix']}groups ".
			( $where ? $where : '' )
			);

		$pagination	= $engine->Pagination($count['n'], $limit, 'p', 'mode=groups&order='.htmlspecialchars($_GET['order']), '', 'admin.php');

		$users = $engine->LoadAll(
			"SELECT g.*, u.user_name ".
			"FROM {$engine->config['table_prefix']}groups g ".
				"LEFT OUTER JOIN {$engine->config['table_prefix']}users u ON (g.moderator = u.user_id) ".

			( $where ? $where : '' ).
			( $order ? $order : 'ORDER BY group_id DESC ' ).
			"LIMIT {$pagination['offset']}, $limit");
	?>
		<form action="admin.php" method="post" name="users">

			<?php echo '<div class="right">'.( $pagination['text'] == true ? '<small><small>'.$pagination['text'].'</small></small>' : '&nbsp;' ).'</div>'."\n"; ?>
			<table border="0" cellspacing="5" cellpadding="3" class="formation">
				<tr>
					<th style="width:5px;">ID</th>
					<th style="width:20px;"><a href="?mode=groups&order=<?php echo $ordergroup; ?>">Group</a></th>
					<th>Description</th>
					<th style="width:20px;">Moderator</th>
					<th style="width:20px;">Open</th>
					<th style="width:20px;">Active</th>
					<th style="width:20px;"><a href="?mode=groups&order=<?php echo $created; ?>">Created</a></th>
				</tr>
	<?php
		if ($users)
		{
			foreach ($users as $row)
			{
				echo '<tr class="lined">'."\n".
						'<td valign="top" align="center">'.$row['group_id'].'</td>'.
						'<td valign="top" align="center" style="padding-left:5px; padding-right:5px;"><strong><a href="?mode=groups&group_id='.$row['group_id'].'">'.$row['group_name'].'</a></strong></td>'.
						'<td valign="top">'.$row['description'].'</td>'.
						'<td valign="top" align="center"><small><a href="?mode=groups&moderator='.$row['moderator'].'">'.$row['user_name'].'</a></small></td>'.
						'<td valign="top" align="center">'.$row['open'].'</td>'.
						'<td valign="top" align="center">'.$row['active'].'</td>'.
						'<td valign="top" align="center"><small>'.date($engine->config['date_precise_format'], strtotime($row['created'])).'</small></td>'.
					'</tr>';
			}
		}
		else
		{
			echo '<tr><td colspan="5" align="center"><br /><em>No groups that meet the criteria</em></td></tr>';
		}
	?>
			</table>
			<?php echo '<div class="right">'.( $pagination['text'] == true ? '<small><small>'.$pagination['text'].'</small></small>' : '' ).'</div>'."\n"; ?>
		</form>

<?php
	}
}

?>