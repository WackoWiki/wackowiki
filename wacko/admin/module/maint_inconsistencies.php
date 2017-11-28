<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Data Inconsistencies                             ##
########################################################
$_mode = 'maint_inconsistencies';

$module[$_mode] = [
		'order'	=> 600,
		'cat'	=> 'maintenance',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Inconsistencies
		'title'	=> $engine->_t($_mode)['title'],	// Fixing Data Inconsistencies
	];

########################################################

function admin_maint_inconsistencies(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
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
				<th class="t_left"></th>
				<th class="t_left">Records</th>
			</tr>
			<?php
			// 1.1 usergroup_member without user
			$usergroup_member = $engine->db->load_all(
				"SELECT
					gm.*
				FROM
					" . $engine->db->table_prefix . "usergroup_member gm
					LEFT JOIN " . $engine->db->table_prefix . "user u ON (gm.user_id = u.user_id)
				WHERE
					u.user_id IS NULL");

			$inconsistencies['1.1'] = ['usergroup_member without user', count($usergroup_member)];
			// -> DELETE

			// 1.2. menu without user
			$menu = $engine->db->load_all(
				"SELECT
					m.menu_id
				FROM
					" . $engine->db->table_prefix . "menu m
					LEFT JOIN " . $engine->db->table_prefix . "user u ON (m.user_id = u.user_id)
				WHERE
					u.user_id IS NULL");

			$inconsistencies['1.2'] = ['menu without user', count($menu)];
				// -> DELETE

			// 1.3. upload without user
			$upload = $engine->db->load_all(
				"SELECT
					u.user_id
				FROM
					" . $engine->db->table_prefix . "file ul
					LEFT JOIN " . $engine->db->table_prefix . "user u ON (ul.user_id = u.user_id)
				WHERE
					u.user_id IS NULL");

			$inconsistencies['1.3'] = ['upload without user', count($upload)];
				// -> DELETE / assign to new user

			// 1.4. user_settings without user
			$user_settings = $engine->db->load_all(
				"SELECT
					us.setting_id
				FROM
					" . $engine->db->table_prefix . "user_setting us
					LEFT JOIN " . $engine->db->table_prefix . "user u ON (us.user_id = u.user_id)
				WHERE
					u.user_id IS NULL");

			$inconsistencies['1.4'] = ['user_settings without user', count($user_settings)];
				// -> DELETE


			// 1.5. watches without user
			$watches = $engine->db->load_all(
				"SELECT
					w.watch_id
				FROM
					" . $engine->db->table_prefix . "watch w
					LEFT JOIN " . $engine->db->table_prefix . "user u ON (w.user_id = u.user_id)
				WHERE
					u.user_id is NULL");

			$inconsistencies['1.5'] = ['watches without user', count($watches)];
				// -> DELETE

			// 2. without page
			// 2.1. acl without page
			$acl = $engine->db->load_all(
				"SELECT
					a.*
				FROM
					" . $engine->db->table_prefix . "acl a
					LEFT JOIN " . $engine->db->table_prefix . "page p ON (a.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$inconsistencies['2.1'] = ['acl without page', count($acl)];
				// -> DELETE

			// 2.2. category_assignment without page
			$category_assignment = $engine->db->load_all(
				"SELECT
					ca.*
				FROM
					" . $engine->db->table_prefix . "category_assignment ca
					LEFT JOIN " . $engine->db->table_prefix . "page p ON (ca.object_id = p.page_id)
				WHERE
					ca.object_type_id = 1 AND
					p.page_id IS NULL");

			$inconsistencies['2.2'] = ['category_assignment without page', count($category_assignment)];
				// -> DELETE

			// 2.3. link without page
			$link = $engine->db->load_all(
				"SELECT
					l.link_id
				FROM
					" . $engine->db->table_prefix . "page_link l
					LEFT JOIN " . $engine->db->table_prefix . "page p ON (l.from_page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$inconsistencies['2.3'] = ['link without page', count($link)];
				// -> DELETE

			// 2.4. menu without page
			$menu2 = $engine->db->load_all(
				"SELECT
					m.menu_id
				FROM
					" . $engine->db->table_prefix . "menu m
					LEFT JOIN " . $engine->db->table_prefix . "page p ON (m.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$inconsistencies['2.4'] = ['menu without page', count($menu2)];
				// -> DELETE

			// 2.5. rating without page
			$rating = $engine->db->load_all(
				"SELECT
					r.*
				FROM
					" . $engine->db->table_prefix . "rating r
					LEFT JOIN " . $engine->db->table_prefix . "page p ON (r.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$inconsistencies['2.5'] = ['rating without page', count($rating)];
				// -> DELETE

			// 2.6. referrer without page
			$referrer = $engine->db->load_all(
				"SELECT
					r.*
				FROM
					" . $engine->db->table_prefix . "referrer r
					LEFT JOIN " . $engine->db->table_prefix . "page p ON (r.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$inconsistencies['2.6'] = ['referrer without page', count($referrer)];
				// -> DELETE

			// 2.7. upload without page and not global
			$upload2 = $engine->db->load_all(
				"SELECT
					u.file_id
				FROM
					" . $engine->db->table_prefix . "file u
					LEFT JOIN " . $engine->db->table_prefix . "page p ON (u.page_id = p.page_id)
				WHERE
					p.page_id IS NULL AND
					u.page_id NOT LIKE 0");

			$inconsistencies['2.7'] = ['upload without page and not global', count($upload2)];
				// -> DELETE

			// 2.8. watch without page
			$watch2 = $engine->db->load_all(
				"SELECT
					w.watch_id
				FROM
					" . $engine->db->table_prefix . "watch w
					LEFT JOIN " . $engine->db->table_prefix . "page p ON (w.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$inconsistencies['2.8'] = ['watch without page', count($watch2)];
				// -> DELETE

			// 2.9. revision without page
			$revision = $engine->db->load_all(
				"SELECT
					r.revision_id
				FROM
					" . $engine->db->table_prefix . "revision r
					LEFT JOIN " . $engine->db->table_prefix . "page p ON (r.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$inconsistencies['2.9'] = ['revision without page', count($revision)];
			// -> DELETE

			// 3.1. usergroup_member without group
			$usergroup_member2 = $engine->db->load_all(
				"SELECT
					gm.*
				FROM
					" . $engine->db->table_prefix . "usergroup_member gm
					LEFT JOIN " . $engine->db->table_prefix . "usergroup g ON (gm.group_id = g.group_id)
				WHERE
					g.group_id IS NULL");

			$inconsistencies['3.1'] = ['usergroup_member without usergroup', count($usergroup_member2)];
			// -> DELETE

			// 3.2. page without valid user_id (e.g. deleted user)
			$page_user = $engine->db->load_all(
				"SELECT
					p.page_id
				FROM
					" . $engine->db->table_prefix . "page p
					LEFT JOIN " . $engine->db->table_prefix . "user u ON (p.user_id = u.user_id)
				WHERE
					p.user_id <> 0 AND
					u.user_id IS NULL");

			$inconsistencies['3.2'] = ['page without valid user_id', count($page_user)];

			// -> DELETE

			// TODO: check for abandoned files, files with no reference left in the upload table

			foreach ($inconsistencies as $param => $value)
			{
				if ($value[1] >= 1)
				{
					echo '<tr class="hl_setting">' .
						'<td class="label">' .
							($value[1] >= 1
								? '<strong>' . $value[0] . '</strong>'
								: '<em class="grey">' . $value[0] . '</em>') .
							'</td>' .
						'<td> </td>' .
						'<td>' .
							($value[1] >= 1
								? '<strong>' . $value[1] . '</strong>'
								: '<em class="grey">' . $value[1] . '</em>') .
						'</td>' .
						'<tr class="lined"><td colspan="5"></td></tr>' . "\n";
				}
			}

			echo '</table>';


?>
			<p>

			</p>
			<br>
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
				<th class="t_left"></th>
				<th class="t_left">Records</th>
			</tr>
			<?php
			// 1.1 usergroup_member without user
			$usergroup_member = $engine->db->sql_query(
					"DELETE
						gm.*
					FROM
			" . $engine->db->table_prefix . "usergroup_member gm
						LEFT JOIN " . $engine->db->table_prefix . "user u ON (gm.user_id = u.user_id)
					WHERE
						u.user_id IS NULL");

			// STS: pattern like it was
			// $count			= $engine->db->sql_query("SELECT ROW_COUNT();");
			// $_count			= fetch_assoc($count);
			// $_solved['1.1'] = ['usergroup_member without user', $_count['ROW_COUNT()']);

			$_solved['1.1'] = ['usergroup_member without user', $engine->config->affected_rows];

			// 1.2. menu without user
			$menu = $engine->db->sql_query(
					"DELETE
						m.*
					FROM
						" . $engine->db->table_prefix . "menu m
						LEFT JOIN " . $engine->db->table_prefix . "user u ON (m.user_id = u.user_id)
					WHERE
						u.user_id IS NULL");

			$_solved['1.2'] = ['menu without user', $engine->config->affected_rows];

			// 1.3. upload without user
			$admin_id = $engine->db->load_single(
				"SELECT user_id
				FROM " . $engine->db->table_prefix . "user
				WHERE user_name = " . $engine->db->q($engine->db->admin_name) . "
				LIMIT 1");

			$upload = $engine->db->sql_query(
				"UPDATE " . $engine->db->table_prefix . "file ul " .
					"LEFT JOIN " . $engine->db->table_prefix . "user u ON (ul.user_id = u.user_id) " .
				"SET ul.user_id		= " . (int) $admin_id['user_id'] . " " .
				"WHERE
					u.user_id IS NULL");

			$_solved['1.3'] = ['upload without user', $engine->config->affected_rows];

			// 1.4. user_settings without user
			$user_settings = $engine->db->sql_query(
					"DELETE
						us.*
					FROM
						" . $engine->db->table_prefix . "user_setting us
						LEFT JOIN " . $engine->db->table_prefix . "user u ON (us.user_id = u.user_id)
					WHERE
						u.user_id IS NULL");

			$_solved['1.4'] = ['user_settings without user', $engine->config->affected_rows];

			// 1.5. watches without user
			$watches = $engine->db->sql_query(
					"DELETE
						w.*
					FROM
						" . $engine->db->table_prefix . "watch w
						LEFT JOIN " . $engine->db->table_prefix . "user u ON (w.user_id = u.user_id)
					WHERE
						u.user_id is NULL");

			$_solved['1.5'] = ['watches without user', $engine->config->affected_rows];

			// 2. without page
			// 2.1. acl without page
			$acl = $engine->db->sql_query(
					"DELETE
						a.*
					FROM
						" . $engine->db->table_prefix . "acl a
						LEFT JOIN " . $engine->db->table_prefix . "page p ON (a.page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			$_solved['2.1'] = ['acl without page', $engine->config->affected_rows];

			// 2.2. category_assignment without page
			$category_assignment = $engine->db->sql_query(
					"DELETE
						ca.*
					FROM
						" . $engine->db->table_prefix . "category_assignment ca
						LEFT JOIN " . $engine->db->table_prefix . "page p ON (ca.object_id = p.page_id)
					WHERE
						ca.object_type_id = 1 AND
						p.page_id IS NULL");

			$_solved['2.2'] = ['category_assignment without page', $engine->config->affected_rows];

			// 2.3. link without page
			$link = $engine->db->sql_query(
					"DELETE
						l.*
					FROM
						" . $engine->db->table_prefix . "page_link l
						LEFT JOIN " . $engine->db->table_prefix . "page p ON (l.from_page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			$_solved['2.3'] = ['link without page', $engine->config->affected_rows];

			// 2.4. menu without page
			$menu2 = $engine->db->sql_query(
					"DELETE
						m.*
					FROM
						" . $engine->db->table_prefix . "menu m
						LEFT JOIN " . $engine->db->table_prefix . "page p ON (m.page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			$_solved['2.4'] = ['menu without page', $engine->config->affected_rows];

			// 2.5. rating without page
			$rating = $engine->db->sql_query(
					"DELETE
						r.*
					FROM
						" . $engine->db->table_prefix . "rating r
						LEFT JOIN " . $engine->db->table_prefix . "page p ON (r.page_id = p.page_id)
					WHERE
					p.page_id IS NULL");

			$_solved['2.5'] = ['rating without page', $engine->config->affected_rows];

			// 2.6. referrer without page
			$referrer = $engine->db->sql_query(
					"DELETE
						r.*
					FROM
						" . $engine->db->table_prefix . "referrer r
						LEFT JOIN " . $engine->db->table_prefix . "page p ON (r.page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			$_solved['2.6'] = ['referrer without page', $engine->config->affected_rows];

			// 2.7. upload without page and not global
			$upload2 = $engine->db->sql_query(
					"DELETE
						u.*
					FROM
						" . $engine->db->table_prefix . "file u
						LEFT JOIN " . $engine->db->table_prefix . "page p ON (u.page_id = p.page_id)
					WHERE
						p.page_id IS NULL AND
						u.page_id NOT LIKE 0");

			$_solved['2.7']	= ['upload without page and not global', $engine->config->affected_rows];

			// 2.8. watch without page
			$watch2 = $engine->db->sql_query(
					"DELETE
						w.*
					FROM
						" . $engine->db->table_prefix . "watch w
						LEFT JOIN " . $engine->db->table_prefix . "page p ON (w.page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			$_solved['2.8'] = ['watch without page', $engine->config->affected_rows];

			// 2.9. revision without page
			$revision = $engine->db->sql_query(
				"DELETE
					r.*
				FROM
					" . $engine->db->table_prefix . "revision r
					LEFT JOIN " . $engine->db->table_prefix . "page p ON (r.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			$_solved['2.9'] = ['revision without page', $engine->config->affected_rows];

			// 3.1. usergroup_member without group
			$usergroup_member2 = $engine->db->sql_query(
				"DELETE
					gm.*
				FROM
					" . $engine->db->table_prefix . "usergroup_member gm
					LEFT JOIN " . $engine->db->table_prefix . "usergroup g ON (gm.group_id = g.group_id)
				WHERE
					g.group_id IS NULL");

			$_solved['3.1'] = ['usergroup_member without usergroup', $engine->config->affected_rows];

			// TODO: // 3.2. page without valid user_id (e.g. deleted user)

			foreach ($_solved as $param => $value)
			{
				if ($value[1] >= 1)
				{
					echo '<tr class="hl_setting">' .
							'<td class="label">' .
								($value[1] >= 1
									? '<strong>' . $value[0] . '</strong>'
									: '<em class="grey">' . $value[0] . '</em>') .
							'</td>' .
							'<td> </td>' .
							'<td>' .
								($value[1] >= 1
									? '<strong>' . $value[1] . '</strong>'
									: '<em class="grey">' . $value[1] . '</em>') .
							'</td>' .
						'<tr class="lined"><td colspan="5"></td></tr>' . "\n";
				}
			}

			echo '</table>';

			$engine->log(1, 'Removed inconsistencies');

			$message = 'Data Inconsistencies solved.';
			$engine->show_message($message, 'success');
		}

	}
?>

	<p>
	show / count mismatches / inconsistencies<br>
	delete records<br>
	assign records to new user / value<br>
	</p>
	<br>
<?php
	echo $engine->form_open('usersupdate');
?>
		<input type="hidden" name="action" value="check_inconsistencies">
		<input type="submit" name="check" id="submit" value="check">
		<input type="submit" name="solve" id="submit" value="solve">
<?php
	echo $engine->form_close();
}

?>
