<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Data Inconsistencies                             ##
########################################################

$module['inconsistencies'] = array(
		'order'	=> 5,
		'cat'	=> 'Database',
		'mode'	=> 'inconsistencies',
		'name'	=> 'Data Inconsistencies',
		'title'	=> 'Fixing Data Inconsistencies',
	);

########################################################

function admin_inconsistencies(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php

	/////////////////////////////////////////////
	//   check for inconsistencies
	/////////////////////////////////////////////
	if (isset($_POST['check']))
	{
		if ($_REQUEST['action'] == 'check_inconsistencies')
		{
			echo '<table class="formation" style="max-width:600px; border-spacing: 1px; border-collapse: separate; padding: 4px;">';
			?>
			<tr>
				<th style="width:250px;">Inconsistencies</th>
				<th style="text-align:left;"></th>
				<th style="text-align:left;">Records</th>
			</tr>
			<?php
			// 1.1 usergroup_member without user
			$usergroup_member = $engine->load_all(
				"SELECT
					gm.*
				FROM
					{$engine->config['table_prefix']}usergroup_member gm
					LEFT JOIN {$engine->config['table_prefix']}user u ON (gm.user_id = u.user_id)
				WHERE
					u.user_id IS NULL");

			$inconsistencies['1.1'] = array('usergroup_member without user', count($usergroup_member));
			// -> DELETE

			// 1.2. menu without user
			$menu = $engine->load_all(
				"SELECT
					m.menu_id
				FROM
					{$engine->config['table_prefix']}menu m
					LEFT JOIN {$engine->config['table_prefix']}user u ON (m.user_id = u.user_id)
				WHERE
					u.user_id IS NULL");

			$inconsistencies['1.2'] = array('menu without user', count($menu));
				// -> DELETE

			// 1.3. upload without user
			$upload = $engine->load_all(
				"SELECT
					u.user_id
				FROM
					{$engine->config['table_prefix']}upload ul
					LEFT JOIN {$engine->config['table_prefix']}user u ON (ul.user_id = u.user_id)
				WHERE
					u.user_id IS NULL");

			$inconsistencies['1.3'] = array('upload without user', count($upload));
				// -> DELETE / assign to new user

			// 1.4. user_settings without user
			$user_settings = $engine->load_all(
				"SELECT
					us.setting_id
				FROM
					{$engine->config['table_prefix']}user_setting us
					LEFT JOIN {$engine->config['table_prefix']}user u ON (us.user_id = u.user_id)
				WHERE
					u.user_id IS NULL");

			$inconsistencies['1.4'] = array('user_settings without user', count($user_settings));
				// -> DELETE


			// 1.5. watches without user
			$watches = $engine->load_all(
				"SELECT
					w.watch_id
				FROM
					{$engine->config['table_prefix']}watch w
					LEFT JOIN {$engine->config['table_prefix']}user u ON (w.user_id = u.user_id)
				WHERE
					u.user_id is NULL");

			$inconsistencies['1.5'] = array('watches without user', count($watches));
				// -> DELETE

			// 2. without page
			// 2.1. acl without page
			$acl = $engine->load_all(
				"SELECT
					a.*
				FROM
					{$engine->config['table_prefix']}acl a
					LEFT JOIN {$engine->config['table_prefix']}page p ON (a.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$inconsistencies['2.1'] = array('acl without page', count($acl));
				// -> DELETE

			// 2.2. category_page without page
			$category_page = $engine->load_all(
				"SELECT
					cp.*
				FROM
					{$engine->config['table_prefix']}category_page cp
					LEFT JOIN {$engine->config['table_prefix']}page p ON (cp.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$inconsistencies['2.2'] = array('category_page without page', count($category_page));
				// -> DELETE

			// 2.3. link without page
			$link = $engine->load_all(
				"SELECT
					l.link_id
				FROM
					{$engine->config['table_prefix']}link l
					LEFT JOIN {$engine->config['table_prefix']}page p ON (l.from_page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$inconsistencies['2.3'] = array('link without page', count($link));
				// -> DELETE

			// 2.4. menu without page
			$menu2 = $engine->load_all(
				"SELECT
					m.menu_id
				FROM
					{$engine->config['table_prefix']}menu m
					LEFT JOIN {$engine->config['table_prefix']}page p ON (m.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$inconsistencies['2.4'] = array('menu without page', count($menu2));
				// -> DELETE

			// 2.5. rating without page
			$rating = $engine->load_all(
				"SELECT
					r.*
				FROM
					{$engine->config['table_prefix']}rating r
					LEFT JOIN {$engine->config['table_prefix']}page p ON (r.page_id = p.page_id)
				WHERE
				p.page_id IS NULL");

			$inconsistencies['2.5'] = array('rating without page', count($rating));
				// -> DELETE

			// 2.6. referrer without page
			$referrer = $engine->load_all(
				"SELECT
					r.*
				FROM
					{$engine->config['table_prefix']}referrer r
					LEFT JOIN {$engine->config['table_prefix']}page p ON (r.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$inconsistencies['2.6'] = array('referrer without page', count($referrer));
				// -> DELETE

			// 2.7. upload without page and not global
			$upload2 = $engine->load_all(
				"SELECT
					u.upload_id
				FROM
					{$engine->config['table_prefix']}upload u
					LEFT JOIN {$engine->config['table_prefix']}page p ON (u.page_id = p.page_id)
				WHERE
					p.page_id IS NULL AND
					u.page_id NOT LIKE 0");

			$inconsistencies['2.7'] = array('upload without page and not global', count($upload2));
				// -> DELETE

			// 2.8. watch without page
			$watch2 = $engine->load_all(
				"SELECT
					w.watch_id
				FROM
					{$engine->config['table_prefix']}watch w
					LEFT JOIN {$engine->config['table_prefix']}page p ON (w.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$inconsistencies['2.8'] = array('watch without page', count($watch2));
				// -> DELETE

			// 2.9. revision without page
			$revision = $engine->load_all(
				"SELECT
					r.revision_id
				FROM
					{$engine->config['table_prefix']}revision r
					LEFT JOIN {$engine->config['table_prefix']}page p ON (r.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$inconsistencies['2.9'] = array('revision without page', count($revision));
			// -> DELETE

			// 3.1. usergroup_member without group
			$usergroup_member2 = $engine->load_all(
				"SELECT
					gm.*
				FROM
					{$engine->config['table_prefix']}usergroup_member gm
					LEFT JOIN {$engine->config['table_prefix']}usergroup g ON (gm.group_id = g.group_id)
				WHERE
					g.group_id IS NULL");

			$inconsistencies['3.1'] = array('usergroup_member without usergroup', count($usergroup_member2));
			// -> DELETE

			// 3.2. page without valid user_id (e.g. deleted user)
			$page_user = $engine->load_all(
				"SELECT
					p.page_id
				FROM
					{$engine->config['table_prefix']}page p
					LEFT JOIN {$engine->config['table_prefix']}user u ON (p.user_id = u.user_id)
				WHERE
					u.user_id IS NULL");

			$inconsistencies['3.2'] = array('page without valid user_id', count($page_user));

			// -> DELETE

			// TODO: check for abandoned files, files with no reference left in the upload table

			foreach ($inconsistencies as $param => $value)
			{
				if ($value[1] >= 1)
				{
					echo '<tr class="hl_setting">'.
						'<td class="label">'.
							($value[1] >= 1
								? '<strong>'.$value[0].'</strong>'
								: '<em class="grey">'.$value[0].'</em>').
							'</td>'.
						'<td> </td>'.
						'<td>'.
							($value[1] >= 1
								? '<strong>'.$value[1].'</strong>'
								: '<em class="grey">'.$value[1].'</em>').
						'</td>'.
						'<tr class="lined"><td colspan="5"></td></tr>'."\n";
				}
			}

			echo '</table>';


?>
			<p>

			</p>
			<br />
<?php
		}
	}

	/////////////////////////////////////////////
	//   solve inconsistencies
	/////////////////////////////////////////////
	if (isset($_POST['solve']))
	{
		if ($_REQUEST['action'] == 'check_inconsistencies')
		{
			echo '<table class="formation" style="max-width:600px; border-spacing: 1px; border-collapse: separate; padding: 4px;">';
			?>
			<tr>
				<th style="width:250px;">Inconsistencies</th>
				<th style="text-align:left;"></th>
				<th style="text-align:left;">Records</th>
			</tr>
			<?php
			// 1.1 usergroup_member without user
			$usergroup_member = $engine->sql_query(
					"DELETE
						gm.*
					FROM
			{$engine->config['table_prefix']}usergroup_member gm
						LEFT JOIN {$engine->config['table_prefix']}user u ON (gm.user_id = u.user_id)
					WHERE
						u.user_id IS NULL");

			$count			= $engine->sql_query("SELECT ROW_COUNT();");
			$_count			= fetch_assoc($count);

			$_solved['1.1'] = array('usergroup_member without user', $_count['ROW_COUNT()']);

			// 1.2. menu without user
			$menu = $engine->sql_query(
					"DELETE
						m.*
					FROM
			{$engine->config['table_prefix']}menu m
						LEFT JOIN {$engine->config['table_prefix']}user u ON (m.user_id = u.user_id)
					WHERE
						u.user_id IS NULL");

			$count			= $engine->sql_query("SELECT ROW_COUNT();");
			$_count			= fetch_assoc($count);

			$_solved['1.2'] = array('menu without user', $_count['ROW_COUNT()']);

			// 1.3. upload without user
			$admin_id = $engine->load_single(
				"SELECT user_id
				FROM ".$engine->config['table_prefix']."user
				WHERE user_name = '".quote($engine->dblink, $engine->config['admin_name'])."'
				LIMIT 1");

			$upload = $engine->sql_query(
				"UPDATE {$engine->config['table_prefix']}upload ul ".
					"LEFT JOIN {$engine->config['table_prefix']}user u ON (ul.user_id = u.user_id) ".
				"SET ul.user_id		= '".(int)$admin_id['user_id']."' ".
				"WHERE
					u.user_id IS NULL");

			$count			= $engine->sql_query("SELECT ROW_COUNT();");
			$_count			= fetch_assoc($count);

			$_solved['1.3'] = array('upload without user', $_count['ROW_COUNT()']);

			// 1.4. user_settings without user
			$user_settings = $engine->sql_query(
					"DELETE
						us.*
					FROM
			{$engine->config['table_prefix']}user_setting us
						LEFT JOIN {$engine->config['table_prefix']}user u ON (us.user_id = u.user_id)
					WHERE
						u.user_id IS NULL");

			$count			= $engine->sql_query("SELECT ROW_COUNT();");
			$_count			= fetch_assoc($count);

			$_solved['1.4'] = array('user_settings without user', $_count['ROW_COUNT()']);

			// 1.5. watches without user
			$watches = $engine->sql_query(
					"DELETE
						w.*
					FROM
			{$engine->config['table_prefix']}watch w
						LEFT JOIN {$engine->config['table_prefix']}user u ON (w.user_id = u.user_id)
					WHERE
						u.user_id is NULL");

			$count			= $engine->sql_query("SELECT ROW_COUNT();");
			$_count			= fetch_assoc($count);

			$_solved['1.5'] = array('watches without user', $_count['ROW_COUNT()']);

			// 2. without page
			// 2.1. acl without page
			$acl = $engine->sql_query(
					"DELETE
						a.*
					FROM
			{$engine->config['table_prefix']}acl a
						LEFT JOIN {$engine->config['table_prefix']}page p ON (a.page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			$count			= $engine->sql_query("SELECT ROW_COUNT();");
			$_count			= fetch_assoc($count);

			$_solved['2.1'] = array('acl without page', $_count['ROW_COUNT()']);

			// 2.2. category_page without page
			$category_page = $engine->sql_query(
					"DELETE
						cp.*
					FROM
			{$engine->config['table_prefix']}category_page cp
						LEFT JOIN {$engine->config['table_prefix']}page p ON (cp.page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			$count			= $engine->sql_query("SELECT ROW_COUNT();");
			$_count			= fetch_assoc($count);

			$_solved['2.2'] = array('category_page without page', $_count['ROW_COUNT()']);

			// 2.3. link without page
			$link = $engine->sql_query(
					"DELETE
						l.*
					FROM
			{$engine->config['table_prefix']}link l
						LEFT JOIN {$engine->config['table_prefix']}page p ON (l.from_page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			$count			= $engine->sql_query("SELECT ROW_COUNT();");
			$_count			= fetch_assoc($count);

			$_solved['2.3'] = array('link without page', $_count['ROW_COUNT()']);

			// 2.4. menu without page
			$menu2 = $engine->sql_query(
					"DELETE
						m.*
					FROM
			{$engine->config['table_prefix']}menu m
						LEFT JOIN {$engine->config['table_prefix']}page p ON (m.page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			$count			= $engine->sql_query("SELECT ROW_COUNT();");
			$_count			= fetch_assoc($count);

			$_solved['2.4'] = array('menu without page', $_count['ROW_COUNT()']);

			// 2.5. rating without page
			$rating = $engine->sql_query(
					"DELETE
						r.*
					FROM
			{$engine->config['table_prefix']}rating r
						LEFT JOIN {$engine->config['table_prefix']}page p ON (r.page_id = p.page_id)
					WHERE
					p.page_id IS NULL");

			$count			= $engine->sql_query("SELECT ROW_COUNT();");
			$_count			= fetch_assoc($count);

			$_solved['2.5'] = array('rating without page', $_count['ROW_COUNT()']);

			// 2.6. referrer without page
			$referrer = $engine->sql_query(
					"DELETE
						r.*
					FROM
			{$engine->config['table_prefix']}referrer r
						LEFT JOIN {$engine->config['table_prefix']}page p ON (r.page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			$count		= $engine->sql_query("SELECT ROW_COUNT();");
			$_count	= fetch_assoc($count);

			$_solved['2.6'] = array('referrer without page', $_count['ROW_COUNT()']);

			// 2.7. upload without page and not global
			$upload2 = $engine->sql_query(
					"DELETE
						u.*
					FROM
			{$engine->config['table_prefix']}upload u
						LEFT JOIN {$engine->config['table_prefix']}page p ON (u.page_id = p.page_id)
					WHERE
						p.page_id IS NULL AND
						u.page_id NOT LIKE 0");

			$count			= $engine->sql_query("SELECT ROW_COUNT();");
			$_count			= fetch_assoc($count);

			$_solved['2.7']	= array('upload without page and not global', $_count['ROW_COUNT()']);

			// 2.8. watch without page
			$watch2 = $engine->sql_query(
					"DELETE
						w.*
					FROM
			{$engine->config['table_prefix']}watch w
						LEFT JOIN {$engine->config['table_prefix']}page p ON (w.page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			$count			= $engine->sql_query("SELECT ROW_COUNT();");
			$_count			= fetch_assoc($count);

			$_solved['2.8'] = array('watch without page', $_count['ROW_COUNT()']);

			// 2.9. revision without page
			$revision = $engine->sql_query(
				"DELETE
					r.*
				FROM
					{$engine->config['table_prefix']}revision r
					LEFT JOIN {$engine->config['table_prefix']}page p ON (r.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$count			= $engine->sql_query("SELECT ROW_COUNT();");
			$_count			= fetch_assoc($count);

			$_solved['2.9'] = array('revision without page', $_count['ROW_COUNT()']);

			// 3.1. usergroup_member without group
			$usergroup_member2 = $engine->sql_query(
				"DELETE
					gm.*
				FROM
					{$engine->config['table_prefix']}usergroup_member gm
					LEFT JOIN {$engine->config['table_prefix']}usergroup g ON (gm.group_id = g.group_id)
				WHERE
					g.group_id IS NULL");

			$count			= $engine->sql_query("SELECT ROW_COUNT();");
			$_count			= fetch_assoc($count);

			$_solved['3.1'] = array('usergroup_member without usergroup', $_count['ROW_COUNT()']);

			// TODO: // 3.2. page without valid user_id (e.g. deleted user)

			foreach ($_solved as $param => $value)
			{
				if ($value[1] >= 1)
				{
					echo '<tr class="hl_setting">'.
							'<td class="label">'.
							($value[1] >= 1
									? '<strong>'.$value[0].'</strong>'
									: '<em class="grey">'.$value[0].'</em>').
									'</td>'.
									'<td> </td>'.
									'<td>'.
									($value[1] >= 1
											? '<strong>'.$value[1].'</strong>'
											: '<em class="grey">'.$value[1].'</em>').
											'</td>'.
											'<tr class="lined"><td colspan="5"></td></tr>'."\n";
				}
			}

			echo '</table>';

			$engine->log(1, 'Removed inconsistencies');

			$message = 'Data Inconsistencies solved.';
			$engine->show_message($message);
		}

	}
?>
	<h3></h3>
	<br />
	<p>
	show / count mismatches / inconsistencies<br />
	delete records<br />
	assign records to new user / value<br />
	</p>
	<br />
	<form action="admin.php" method="post" name="usersupdate">
		<input type="hidden" name="mode" value="inconsistencies" />
		<input type="hidden" name="action" value="check_inconsistencies" />
		<input name="check" id="submit" type="submit" value="check" />
		<input name="solve" id="submit" type="submit" value="solve" />
	</form>

<?php
}

?>