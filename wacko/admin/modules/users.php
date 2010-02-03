<?php

########################################################
##   Users                                            ##
########################################################

$module['users'] = array(
		'order'	=> 5,
		'cat'	=> 'Users',
		'mode'	=> 'users',
		'name'	=> 'Users',
		'title'	=> 'User management',
	);

########################################################

function admin_users(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />


<?php

	// get user
	if ($_GET['user_id'] )
	{
		// user data
		echo '';
		echo "";
	}
	else
	{
		// set signuptime ordering
		if ($_GET['order'] == 'signup_asc')
		{
			$order		= 'ORDER BY signuptime ASC ';
			$signuptime	= 'signup_desc';
		}
		else if ($_GET['order'] == 'signup_desc')
		{
			$order		= 'ORDER BY signuptime DESC ';
			$signuptime	= 'signup_asc';
		}
		else
		{
			$signuptime	= 'signup_asc';
		}

		// set total_pages ordering
		if ($_GET['order'] == 'total_pages_asc')
		{
			$order		= 'ORDER BY total_pages ASC ';
			$orderpages	= 'total_pages_desc';
		}
		else if ($_GET['order'] == 'total_pages_desc')
		{
			$order		= 'ORDER BY total_pages DESC ';
			$orderpages	= 'total_pages_asc';
		}
		else
		{
			$orderpages	= 'total_pages_asc';
		}

		// set total_comments ordering
		if ($_GET['order'] == 'total_comments_asc')
		{
			$order		= 'ORDER BY total_comments ASC ';
			$ordercomments	= 'total_comments_desc';
		}
		else if ($_GET['order'] == 'total_comments_desc')
		{
			$order		= 'ORDER BY total_comments DESC ';
			$ordercomments	= 'total_comments_asc';
		}
		else
		{
			$ordercomments	= 'total_comments_asc';
		}

		// set total_revisions ordering
		if ($_GET['order'] == 'total_revisions_asc')
		{
			$order		= 'ORDER BY total_revisions ASC ';
			$orderrevisions	= 'total_revisions_desc';
		}
		else if ($_GET['order'] == 'total_revisions_desc')
		{
			$order		= 'ORDER BY total_revisions DESC ';
			$orderrevisions	= 'total_revisions_asc';
		}
		else
		{
			$orderrevisions	= 'total_revisions_asc';
		}

		// set user ordering
		if ($_GET['order'] == 'user_asc')
		{
			$order		= 'ORDER BY user_name DESC ';		// we make level sorting
			$orderuser	= 'user_desc';					// in reverse orber because
		}												// higher level is denoted
		else if ($_GET['order'] == 'user_desc')		// by lower value (e.g.
		{												// 1 = critical, 2 = highest,
			$order		= 'ORDER BY user_name ASC ';		// and so on)
			$orderuser	= 'user_asc';
		}
		else
		{
			$orderuser	= 'user_desc';
		}

		// filter by lang
		if ($_GET['lang'])
		{
			$where = "WHERE lang = '".quote($engine->dblink, $_GET['lang'])."' ";
		}

		// entries to display
		$limit = 100;

		// collecting data
		$count = $engine->LoadSingle(
			"SELECT COUNT(user_name) AS n ".
			"FROM {$engine->config['table_prefix']}users ".
			( $where ? $where : '' )
			);

		$pagination	= $engine->Pagination($count['n'], $limit, 'p', 'mode=users&order='.htmlspecialchars($_GET['order']), '', 'admin.php');

		$users = $engine->LoadAll(
			"SELECT * ".
			"FROM {$engine->config['table_prefix']}users ".

			( $where ? $where : '' ).
			( $order ? $order : 'ORDER BY user_id DESC ' ).
			"LIMIT {$pagination['offset']}, $limit");
	?>
		<form action="admin.php" method="post" name="users">

			<?php echo '<div class="right">'.( $pagination['text'] == true ? '<small><small>'.$pagination['text'].'</small></small>' : '&nbsp;' ).'</div>'."\n"; ?>
			<table border="0" cellspacing="5" cellpadding="3" class="formation">
				<tr>
					<th style="width:5px;">ID</th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $orderuser;  ?>">Username</a></th>
					<th style="width:150px;"><a href="?mode=users&order=<?php echo $orderuser;  ?>">Realname</a></th>

					<th>Email</th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $orderpages;  ?>">Pages</a></th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $ordercomments;  ?>">Comments</a></th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $orderrevisions;  ?>">Revisions</a></th>
					<th style="width:20px;">Language</th>
					<th style="width:20px;">Active</th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $signuptime; ?>">Signuptime</a></th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $orderlevel; ?>">Sessiontime</a></th>
				</tr>
	<?php
		if ($users)
		{
			foreach ($users as $row)
			{
				echo '<tr class="lined">'."\n".
						'<td valign="top" align="center">'.$row['user_id'].'</td>'.
						'<td valign="top" align="center" style="padding-left:5px; padding-right:5px;"><strong><a href="?mode=users&user_id='.$row['user_id'].'">'.$row['user_name'].'</a></strong></td>'.
						'<td valign="top" align="center" style="padding-left:5px; padding-right:5px;">'.$row['real_name'].'</td>'.

						'<td valign="top">'.$row['email'].'</td>'.
						'<td valign="top" align="center">'.$row['total_pages'].'</td>'.
						'<td valign="top" align="center">'.$row['total_comments'].'</td>'.
						'<td valign="top" align="center">'.$row['total_revisions'].'</td>'.
						'<td valign="top" align="center"><small><a href="?mode=users&lang='.$row['lang'].'">'.$row['lang'].'</a></small></td>'.
						'<td valign="top" align="center">'.$row['enabled'].'</td>'.
						'<td valign="top" align="center"><small>'.date($engine->config['date_precise_format'], strtotime($row['signuptime'])).'</small></td>'.
						'<td valign="top" align="center"><small>'.date($engine->config['date_precise_format'], strtotime($row['session_time'])).'</small></td>'.
					'</tr>';
			}
		}
		else
		{
			echo '<tr><td colspan="5" align="center"><br /><em>No users that meet the criteria</em></td></tr>';
		}
	?>
			</table>
			<?php echo '<div class="right">'.( $pagination['text'] == true ? '<small><small>'.$pagination['text'].'</small></small>' : '' ).'</div>'."\n"; ?>
		</form>

<?php
	}
}

?>