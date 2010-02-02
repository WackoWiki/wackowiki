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

	// filter by lang or user ip
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
		<input type="hidden" name="mode" value="users" />
		<div>
			<h4>Filter users by criteria:</h4><br />
			Level
			<select name="level_mod">
				<option value="not_lower"<?php echo ( !$_POST['level_mod'] || $_POST['level_mod'] == 'not_lower' ? ' selected="selected"' : '' ); ?>>not less than</option>
				<option value="not_higher"<?php echo ( $_POST['level_mod'] == 'not_higher' ? ' selected="selected"' : '' ); ?>>not higher than</option>
				<option value="equal"<?php echo ( $_POST['level_mod'] == 'equal' ? ' selected="selected"' : '' ); ?>>corresponds</option>
			</select>
			<select name="level">
<?php
	for ($i = 1; $i <= 7; $i++)
	{
		echo '<option value="'.$i.'"'.( (!$_POST['level'] && $level == $i) || $_POST['level'] == $i ? ' selected="selected"' : '' ).'>'.strtolower($engine->GetTranslation('LogLevel'.$i)).'</option>'."\n";
	}
?>
			</select>

			<input name="update" id="submit" type="submit" value="update" />
			<input name="reset" id="submit" type="submit" value="reset" />
		</div>
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

?>