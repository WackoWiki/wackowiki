<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Data Inconsistencies                             ##
########################################################

$module['inconsistencies'] = array(
		'order'	=> 10,
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
	if (isset($_POST['check']))
	{
		if ($_REQUEST['action'] == 'check_inconsistencies')
		{
			echo '<table>';

			// 1.1 usergroup_member without user
			$usergroup_member = $engine->load_all(
				"SELECT
					gm.*
				FROM
					{$engine->config['table_prefix']}usergroup_member gm
					LEFT JOIN {$engine->config['table_prefix']}user u ON (gm.user_id = u.user_id)
				WHERE
					u.user_id IS NULL");

			echo '<tr class="hl_setting"><td>usergroup_member without user </td><td>'.count($usergroup_member).'</td></tr>';
			// -> DELETE

			// 1.2. menu without user
			$menu = $engine->load_all(
				"SELECT
					m.*
				FROM
					{$engine->config['table_prefix']}menu m
					LEFT JOIN {$engine->config['table_prefix']}user u ON (m.user_id = u.user_id)
				WHERE
					u.user_id IS NULL");

			echo '<tr class="hl_setting"><td>menu without user </td><td>'.count($menu).'</td></tr>';
				// -> DELETE

			// 1.3. upload without user
			$upload = $engine->load_all(
				"SELECT
					u.*
				FROM
					{$engine->config['table_prefix']}upload ul
					LEFT JOIN {$engine->config['table_prefix']}user u ON (ul.user_id = u.user_id)
				WHERE
					u.user_id IS NULL");

			echo '<tr class="hl_setting"><td>upload without user </td><td>'.count($upload).'</td></tr>';
				// -> DELETE / assign to new user

			// 1.4. user_settings without user
			$user_settings = $engine->load_all(
				"SELECT
					us.*
				FROM
					{$engine->config['table_prefix']}user_setting us
					LEFT JOIN {$engine->config['table_prefix']}user u ON (us.user_id = u.user_id)
				WHERE
					u.user_id IS NULL");

			echo '<tr class="hl_setting"><td>user_settings without user </td><td>'.count($user_settings).'</td></tr>';
				// -> DELETE


			// 1.5. watches without user
			$watches = $engine->load_all(
				"SELECT
					w.*
				FROM
					{$engine->config['table_prefix']}watch w
					LEFT JOIN {$engine->config['table_prefix']}user u ON (w.user_id = u.user_id)
				WHERE
					u.user_id is NULL");

			echo '<tr class="hl_setting"><td>watches without user </td><td>'.count($watches).'</td></tr>';
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

			echo '<tr class="hl_setting"><td>acl without page </td><td>'.count($acl).'</td></tr>';
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

			echo '<tr class="hl_setting"><td>category_page without page </td><td>'.count($category_page).'</td></tr>';
				// -> DELETE

			// 2.3. link without page
			$link = $engine->load_all(
				"SELECT
					l.*
				FROM
					{$engine->config['table_prefix']}link l
					LEFT JOIN {$engine->config['table_prefix']}page p ON (l.from_page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			echo '<tr class="hl_setting"><td>link without page </td><td>'.count($link).'</td></tr>';
				// -> DELETE

			// 2.4. menu without page
			$menu2 = $engine->load_all(
				"SELECT
					m.*
				FROM
					{$engine->config['table_prefix']}menu m
					LEFT JOIN {$engine->config['table_prefix']}page p ON (m.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			echo '<tr class="hl_setting"><td>menu without page </td><td>'.count($menu2).'</td></tr>';
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

			echo '<tr class="hl_setting"><td>rating without page </td><td>'.count($rating).'</td></tr>';
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

			echo '<tr class="hl_setting"><td>referrer without page </td><td>'.count($referrer).'</td></tr>';
				// -> DELETE

			// 2.7. upload without page and not global
			$upload2 = $engine->load_all(
				"SELECT
					u.*
				FROM
					{$engine->config['table_prefix']}upload u
					LEFT JOIN {$engine->config['table_prefix']}page p ON (u.page_id = p.page_id)
				WHERE
					p.page_id IS NULL AND
					u.page_id NOT LIKE 0");

			echo '<tr class="hl_setting"><td>upload without page and not global </td><td>'.count($upload2).'</td></tr>';
				// -> DELETE

			// 2.8. watch without page
			$watch2 = $engine->load_all(
				"SELECT
					w.*
				FROM
					{$engine->config['table_prefix']}watch w
					LEFT JOIN {$engine->config['table_prefix']}page p ON (w.page_id = p.page_id)
				WHERE
					p.page_id IS NULL");

			echo '<tr class="hl_setting"><td>watch without page </td><td>'.count($watch2).'</td></tr>';
				// -> DELETE

			// 3.1. usergroup_member without group
			$usergroup_member2 = $engine->load_all(
				"SELECT
					gm.*
				FROM
					{$engine->config['table_prefix']}usergroup_member gm
					LEFT JOIN {$engine->config['table_prefix']}usergroup g ON (gm.group_id = g.group_id)
				WHERE
					g.group_id IS NULL");;

			echo '<tr class="hl_setting"><td>usergroup_member without usergroup </td><td>'.count($usergroup_member2).'</td></tr>';
			// -> DELETE

			echo '</table>';


?>
			<p>

			</p>
			<br />
<?php
		}

	}
	if (isset($_POST['solve']))
	{
		if ($_REQUEST['action'] == 'check_inconsistencies')
		{
			echo '<table>';

			// 1.1 usergroup_member without user
			$usergroup_member = $engine->sql_query(
					"DELETE
						gm.*
					FROM
			{$engine->config['table_prefix']}usergroup_member gm
						LEFT JOIN {$engine->config['table_prefix']}user u ON (gm.user_id = u.user_id)
					WHERE
						u.user_id IS NULL");

			echo '<tr class="hl_setting"><td>usergroup_member without user </td><td>'.count($usergroup_member).'</td></tr>';


			// 1.2. menu without user
			$menu = $engine->sql_query(
					"DELETE
						m.*
					FROM
			{$engine->config['table_prefix']}menu m
						LEFT JOIN {$engine->config['table_prefix']}user u ON (m.user_id = u.user_id)
					WHERE
						u.user_id IS NULL");

			echo '<tr class="hl_setting"><td>menu without user </td><td>'.count($menu).'</td></tr>';

			// 1.3. upload without user
			$admin_id = $engine->load_single(
				"SELECT user_id
				FROM ".$engine->config['table_prefix']."user
				WHERE user_name = '".quote($engine->dblink, $engine->config['admin_name'])."'
				LIMIT 1");

			$upload = $engine->sql_query(
				"UPDATE {$engine->config['table_prefix']}upload ul ".
					"LEFT JOIN {$engine->config['table_prefix']}user u ON (ul.user_id = u.user_id) ".
				"SET ul.user_id		= '".quote($engine->dblink, $admin_id['user_id'])."' ".
				"WHERE
					u.user_id IS NULL");

			echo '<tr class="hl_setting"><td>upload without user </td><td>'.count($upload).'</td></tr>';

			// 1.4. user_settings without user
			$user_settings = $engine->sql_query(
					"DELETE
						us.*
					FROM
			{$engine->config['table_prefix']}user_setting us
						LEFT JOIN {$engine->config['table_prefix']}user u ON (us.user_id = u.user_id)
					WHERE
						u.user_id IS NULL");

			echo '<tr class="hl_setting"><td>user_settings without user </td><td>'.count($user_settings).'</td></tr>';

			// 1.5. watches without user
			$watches = $engine->sql_query(
					"DELETE
						w.*
					FROM
			{$engine->config['table_prefix']}watch w
						LEFT JOIN {$engine->config['table_prefix']}user u ON (w.user_id = u.user_id)
					WHERE
						u.user_id is NULL");

			echo '<tr class="hl_setting"><td>watches without user </td><td>'.count($watches).'</td></tr>';

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

			echo '<tr class="hl_setting"><td>acl without page </td><td>'.count($acl).'</td></tr>';

			// 2.2. category_page without page
			$category_page = $engine->sql_query(
					"DELETE
						cp.*
					FROM
			{$engine->config['table_prefix']}category_page cp
						LEFT JOIN {$engine->config['table_prefix']}page p ON (cp.page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			echo '<tr class="hl_setting"><td>category_page without page </td><td>'.count($category_page).'</td></tr>';

			// 2.3. link without page
			$link = $engine->sql_query(
					"DELETE
						l.*
					FROM
			{$engine->config['table_prefix']}link l
						LEFT JOIN {$engine->config['table_prefix']}page p ON (l.from_page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			echo '<tr class="hl_setting"><td>link without page </td><td>'.count($link).'</td></tr>';

			// 2.4. menu without page
			$menu2 = $engine->sql_query(
					"DELETE
						m.*
					FROM
			{$engine->config['table_prefix']}menu m
						LEFT JOIN {$engine->config['table_prefix']}page p ON (m.page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			echo '<tr class="hl_setting"><td>menu without page </td><td>'.count($menu2).'</td></tr>';

			// 2.5. rating without page
			$rating = $engine->sql_query(
					"DELETE
						r.*
					FROM
			{$engine->config['table_prefix']}rating r
						LEFT JOIN {$engine->config['table_prefix']}page p ON (r.page_id = p.page_id)
					WHERE
					p.page_id IS NULL");

			echo '<tr class="hl_setting"><td>rating without page </td><td>'.count($rating).'</td></tr>';

			// 2.6. referrer without page
			$referrer = $engine->sql_query(
					"DELETE
						r.*
					FROM
			{$engine->config['table_prefix']}referrer r
						LEFT JOIN {$engine->config['table_prefix']}page p ON (r.page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			echo '<tr class="hl_setting"><td>referrer without page </td><td>'.count($referrer).'</td></tr>';

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

			echo '<tr class="hl_setting"><td>upload without page and not global </td><td>'.count($upload2).'</td></tr>';

			// 2.8. watch without page
			$watch2 = $engine->sql_query(
					"DELETE
						w.*
					FROM
			{$engine->config['table_prefix']}watch w
						LEFT JOIN {$engine->config['table_prefix']}page p ON (w.page_id = p.page_id)
					WHERE
						p.page_id IS NULL");

			echo '<tr class="hl_setting"><td>watch without page </td><td>'.count($watch2).'</td></tr>';

			// 3.1. usergroup_member without group
			$usergroup_member2 = $engine->sql_query(
					"DELETE
						gm.*
					FROM
			{$engine->config['table_prefix']}usergroup_member gm
						LEFT JOIN {$engine->config['table_prefix']}usergroup g ON (gm.group_id = g.group_id)
					WHERE
						g.group_id IS NULL");;

			echo '<tr class="hl_setting"><td>usergroup_member without usergroup </td><td>'.count($usergroup_member2).'</td></tr>';


			echo '</table>';

			$engine->log(1, 'Removed inconsistencies');
			?>
				<p>
					<br />
					<em>Data Inconsistencies solved.</em>
				</p>
				<br />
	<?php
			}

		}
?>
	<h3>Data inconsistencies</h3>
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