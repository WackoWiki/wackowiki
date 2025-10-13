<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	User Groups											##
##########################################################

$module['user_groups'] = [
		'order'	=> 402,
		'cat'	=> 'users',
		'status'=> !RECOVERY_MODE,
	];

##########################################################

function admin_user_groups($engine, $module)
{
	$where		= '';
	$order		= '';
	$usergroup	= [];
	$orderuser	= '';
	$prefix		= $engine->prefix;

/*
 * Pre-defined groups
 * Pre-defined groups are special groups, they cannot be deleted or directly modified. However, you can still add users and alter basic settings.
 *
 * User defined groups
 * These are groups created by you or another admin on this wiki. You can manage memberships as well as edit group properties or even delete the group.
*/
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
	<p>
		<?php echo $engine->_t('GroupsInfo');?>
	</p>
	<br>
<?php

	/////////////////////////////////////////////
	//   list change/update
	/////////////////////////////////////////////

	$_order		= $_GET['order'] ?? '';
	$action		= $_POST['_action'] ?? null;

	$group_id	= (int) ($_GET['group_id'] ?? $_POST['group_id'] ?? null);
	$change_id	= (int) ($_POST['group_id'] ?? null);
	$open		= (int) ($_POST['open']		?? 0);
	$active		= (int) ($_POST['active']	?? 0);

	// update groups list
	if (isset($_POST['save']))
	{
		$engine->log(4, $engine->_t('LogMembersUpdated', SYSTEM_LANG));
		$engine->set_message($engine->_t('GroupsUpdated'));
	}
	else
	{
		$p_group_id	= (int) ($_POST['group_id'] ?? null);

		$usergroup = $engine->db->load_single(
			'SELECT group_name ' .
			'FROM ' . $prefix . 'usergroup ' .
			'WHERE group_id = ' . (int) $group_id . ' ' .
			'LIMIT 1');

		/////////////////////////////////////////////
		//   MEMBERS
		/////////////////////////////////////////////

		// get group
		if (isset($_GET['group_id']) || isset($_POST['add_member'])|| isset($_POST['remove_member']))
		{
			$p_user_id	= (int) ($_POST['member_id'] ?? null);

			$member = $engine->db->load_single(
				'SELECT user_id, user_name ' .
				'FROM ' . $prefix . 'user ' .
				'WHERE user_id = ' . (int) $p_user_id . ' ' .
				'LIMIT 1');

			// add member into group
			if ($action == 'add_group_member' && $member['user_id'] && $p_group_id)
			{
				$engine->db->sql_query(
					'INSERT INTO ' . $prefix . 'usergroup_member (' .
						'group_id, ' .
						'user_id)' .
					'VALUES (' .
						(int) $p_group_id . ', ' .
						(int) $member['user_id'] . ')'
					);

					$engine->config->invalidate_config_cache();
					$engine->show_message($engine->_t('MembersAdded'), 'success');
					$engine->log(4, Ut::perc_replace($engine->_t('LogMemberAdded', SYSTEM_LANG), $member['user_name'], $usergroup['group_name']));
					unset($_POST['add_member']);
			}
			// remove member from group
			else if ($action == 'remove_group_member' && $member['user_id'] && $p_group_id)
			{
				$engine->db->sql_query(
					'DELETE FROM ' . $prefix . 'usergroup_member ' .
					'WHERE group_id = ' . (int) $p_group_id . ' ' .
						'AND user_id = ' . (int) $member['user_id']);

				$engine->config->invalidate_config_cache();
				$engine->show_message($engine->_t('MembersRemoved'), 'success');
				$engine->log(4, Ut::perc_replace($engine->_t('LogMemberRemoved', SYSTEM_LANG), $member['user_name'], $usergroup['group_name']));
			}

			/////////////////////////////////////////////
			//   edit member forms
			/////////////////////////////////////////////

			// add member into group
			if (isset($_POST['add_member']))
			{
				$subqery_members = 'SELECT m.user_id ' .
					'FROM ' . $prefix . 'usergroup g ' .
						'INNER JOIN ' . $prefix . 'usergroup_member m ON (g.group_id = m.group_id) ' .
						'INNER JOIN ' . $prefix . 'user u ON (m.user_id = u.user_id) ' .
					'WHERE g.group_id = ' . (int) $group_id . ' ';

				$available_users = $engine->db->load_all(
					'SELECT user_id, user_name ' .
					'FROM ' . $prefix . 'user ' .
					'WHERE user_id NOT IN (' . $subqery_members. ') ' .
						'AND account_type = 0 ' .
						'AND enabled = 1 ' .
					'ORDER BY user_name');

				# Ut::debug_print_r($available_users);
				echo '<h2>' . $engine->_t('GroupAddMember') . '</h2>';
				echo $engine->form_open('add_group_member');

				echo '<input type="hidden" name="group_id" value="' . (int) $group_id . '">' .
				'<table class="formation">
					<tr>
						<td>
							<label for="member_id">' . $engine->_t('MembersAddNew') . '</label>
						</td>
						<td>
							<select id="member_id" name="member_id">
								<option value=""></option>';

						if ($available_users)
						{
							foreach ($available_users as $user)
							{
								echo '<option value="' . $user['user_id'] . '">' . Ut::html($user['user_name']) . "</option>\n";
							}
						}

						echo '</select>
						</td>
					</tr>
					<tr>
						<td>
							<br>
							<button type="submit" id="submit" name="add_member">' . $engine->_t('AddButton') . '</button>
							<a href="' . $engine->href() . '" class="btn-link"><button type="button" class="btn-cancel">' . $engine->_t('CancelButton') . '</button></a>
						</td>
					</tr>
				</table>
				<br>';

				echo $engine->form_close();
			}

			// remove member from group
			if (isset($_POST['remove_member']) && isset($_POST['change_member_id']))
			{
				if ($member = $engine->db->load_single(
					'SELECT user_id, user_name ' .
					'FROM ' . $prefix . 'user ' .
					'WHERE user_id = ' . (int) $_POST['change_member_id'] . ' ' .
					'LIMIT 1'))
				{
					echo '<h2>' . $engine->_t('GroupRemoveMember') . '</h2>';
					echo $engine->form_open('remove_group_member');

					echo
						'<input type="hidden" name="group_id" value="' . (int) $group_id . '">' .
						'<input type="hidden" name="member_id" value="' . (int) $member['user_id'] . '">' . "\n" .
					'<table class="formation">' .
						'<tr>
							<td>' .
								Ut::perc_replace($engine->_t('MembersRemove'), '<code>' . Ut::html($member['user_name']) . '</code>') . ' ' .
								'<button type="submit" id="submit" name="remove_member">' . $engine->_t('Remove') . '</button> ' .
								'<a href="' . $engine->href() . '" class="btn-link"><button type="button" id="button">' . $engine->_t('Cancel') . '</button></a>' .
							'</td>
						</tr>' .
					'</table><br>';

					echo $engine->form_close();
				}
			}
		}

		/////////////////////////////////////////////
		//   GROUPS
		/////////////////////////////////////////////

		// add group
		if ($action == 'add_group'
			&& isset($_POST['new_group_name']))
		{
			$group_name		= $engine->sanitize_username(($_POST['new_group_name'] ?? ''));
			$description	= $engine->sanitize_text_field(($_POST['description'] ?? ''));

			// checking for identical name (case-insensitive, not BINARY)
			if ($engine->db->load_single(
				'SELECT group_id ' .
				'FROM ' . $prefix . 'usergroup ' .
				'WHERE group_name = ' . $engine->db->q($group_name) . ' ' .
				'LIMIT 1'))
			{
				$engine->show_message($engine->_t('GroupsAlreadyExists'));
				$_POST['change'] = $p_group_id;
				$_POST['create'] = 1;
			}
			else
			{
				$engine->db->sql_query(
					'INSERT INTO ' . $prefix . 'usergroup (' .
						'group_name, ' .
						'description, ' .
						'moderator_id, ' .
						'created, ' .
						'open, ' .
						'active)' .
					'VALUES (' .
						$engine->db->q($group_name) . ', ' .
						$engine->db->q($description) . ', ' .
						(int) $_POST['moderator_id'] . ', ' .
						$engine->db->utc_dt() . ', ' .
						(int) $open . ', ' .
						(int) $active . ')'
					);

				$engine->config->invalidate_config_cache();
				$engine->show_message($engine->_t('GroupsAdded'), 'success');
				$engine->log(4, Ut::perc_replace($engine->_t('LogGroupCreated', SYSTEM_LANG), $_POST['new_group_name']));
				unset($_POST['create']);
			}
		}
		// edit group
		else if ($action == 'edit_group'
			&&  $p_group_id
			&& (isset($_POST['new_group_name']) || isset($_POST['moderator_id'])))
		{
			$group_name		= $engine->sanitize_username(($_POST['new_group_name'] ?? ''));
			$description	= $engine->sanitize_text_field(($_POST['description'] ?? ''));

			// do we have identical names?
			if ($engine->db->load_single(
				'SELECT group_id FROM ' . $prefix . 'usergroup ' .
				'WHERE group_name = ' . $engine->db->q($group_name) . ' ' .
					'AND group_id <> ' . (int) $p_group_id . ' ' .
				'LIMIT 1'))
			{
				$engine->set_message($engine->_t('GroupsAlreadyExists'));
				$_POST['change_id']	= $p_group_id;
				$_POST['edit']		= 1;
			}
			else
			{
				$engine->db->sql_query(
					'UPDATE ' . $prefix . 'usergroup SET ' .
						'group_name		= ' . $engine->db->q($group_name) . ', ' .
						'description	= ' . $engine->db->q($description) . ', ' .
						'moderator_id	= ' . (int) $_POST['moderator_id'] . ', ' .
						'open			= ' . (int) $open . ', ' .
						'active			= ' . (int) $active . ' ' .
					'WHERE group_id = ' . (int) $p_group_id . ' ' .
					'LIMIT 1');

				$engine->show_message($engine->_t('GroupsRenamed'));
				$engine->log(4, Ut::perc_replace($engine->_t('LogGroupRenamed', SYSTEM_LANG), $usergroup['group_name'], $_POST['new_group_name']));
			}
		}
		// delete group
		else if ($action == 'delete_group'
			&& $p_group_id)
		{
			$usergroup = $engine->db->load_single(
				'SELECT group_name, group_id
				FROM ' . $prefix . 'usergroup
				WHERE group_id = ' . (int) $p_group_id . '
					AND is_system <> 1
				LIMIT 1');

			$engine->db->sql_query(
				'DELETE FROM ' . $prefix . 'usergroup ' .
				'WHERE group_id = ' . (int) $usergroup['group_id']) . ' ' .
					'AND is_system <> 1';
			$engine->db->sql_query(
				'DELETE FROM ' . $prefix . 'usergroup_member ' .
				'WHERE group_id = ' . (int) $usergroup['group_id']) . ' ' .
					'AND is_system <> 1';

			$engine->config->invalidate_config_cache();
			$engine->show_message(Ut::perc_replace($engine->_t('GroupsDeleted'), '<code>' . $usergroup['group_name'] . '</code>'), 'success');
			$engine->log(4, Ut::perc_replace($engine->_t('LogGroupRemoved', SYSTEM_LANG), $usergroup['group_name']));

			unset($_GET['group_id'], $_POST['group_id']);
		}
	}

	/////////////////////////////////////////////
	//   edit group forms
	/////////////////////////////////////////////

	// add new group
	if (isset($_POST['create_group']))
	{
		echo '<h2>' . $engine->_t('GroupAddNew') . '</h2>';
		echo $engine->form_open('add_group');

		echo '<table class="formation lined">
				<tr>
					<th>
						<label for="new_group_name">' . $engine->_t('GroupsAdd') . '</label>
					</th>
					<td>
						<input type="text" id="new_group_name" name="new_group_name" value="' . Ut::html(($_POST['new_group_name'] ?? '')) . '" pattern="' . $engine::PATTERN['USER_NAME'] . '" size="20" maxlength="100" required autofocus>
					</td>
				</tr>
				<tr>
					<th>
						<label for="description">' . $engine->_t('GroupsDescription') . '</label>
					</th>
					<td>
						<input type="text" id="description" name="description" value="' . Ut::html(($_POST['description'] ?? '')) . '" size="50" maxlength="100">
					</td>
				</tr>
				<tr>
					<th>
						<label for="moderator_id">' . $engine->_t('GroupsModerator') . '</label>
					</th>
					<td>
						<select id="moderator_id" name="moderator_id">
							<option value=""></option>';

				if ($users = $engine->load_users())
				{
					foreach ($users as $user)
					{
						echo '<option value="' . $user['user_id'] . '">' . Ut::html($user['user_name']) . "</option>\n";
					}
				}

					echo '</select>
					</td>
				</tr>
				<tr>
					<th>
						<label for="open">' . $engine->_t('GroupsOpen') . '</label>
					</th>
					<td>
						<input type="checkbox" id="open" name="open" value="1" ' . (!$open ? ' checked' : '') . '>
					</td>
				</tr>
				<tr>
					<th>
						<label for="active">' . $engine->_t('GroupsActive') . '</label>
	 				</th>
					<td>
	 					<input type="checkbox" id="active" name="active" value="1" ' . (!$active ? ' checked' : '') . '>
	 				</td>
				</tr>
				<tr>
					<td colspan="2">
	 					<br>
	 					<button type="submit" id="submit" name="create">' . $engine->_t('SubmitButton') . '</button>
						<a href="' . $engine->href() . '" class="btn-link"><button type="button" class="btn-cancel">' . $engine->_t('CancelButton') . '</button></a>
					</td>
				</tr>
			</table>
			<br>';

		echo $engine->form_close();
	}
	// edit group
	else if (isset($_POST['edit_group']) && $change_id)
	{
		if ($usergroup = $engine->db->load_single(
			'SELECT group_name, description, moderator_id, open, active
			FROM ' . $prefix . 'usergroup
			WHERE group_id = ' . (int) $change_id . '
			LIMIT 1'))
		{
			echo '<h2>' . $engine->_t('GroupEdit') . '</h2>';
			echo $engine->form_open('edit_group');

			echo '<input type="hidden" name="group_id" value="' . $change_id . '">' . "\n" .
				'<table class="formation lined">
				<tr>
					<th>
						<label for="new_group_name">' . Ut::perc_replace($engine->_t('GroupsRename'), ' <code>' . Ut::html($usergroup['group_name']) . '</code>') . '</label>
					</th>
					<td>
						<input type="text" id="new_group_name" name="new_group_name" value="' . Ut::html(($_POST['new_group_name'] ?? $usergroup['group_name'])) . '" pattern="' . $engine::PATTERN['USER_NAME'] . '" size="20" maxlength="100">
					</td>
				</tr>
				<tr>
					<th>
						<label for="new_description">' . $engine->_t('GroupsDescription') . '</label>
					</th>
					<td>
						<input type="text" id="new_description" name="new_description" value="' . Ut::html(($_POST['new_description'] ?? $usergroup['description'])) . '" size="50" maxlength="100">
					</td>
				</tr>
				<tr>
					<th>
						<label for="moderator_id">' . $engine->_t('GroupsModerator') . '</label>
					</th>
				<td>
					<select id="moderator_id" name="moderator_id">
						<option value=""></option>';

				if ($users = $engine->load_users())
				{
					foreach ($users as $user)
					{
						echo '<option value="' . $user['user_id'] . '" ' . ($usergroup['moderator_id'] == $user['user_id'] ? ' selected' : '') . '>' . $user['user_name'] . "</option>\n";
					}
				}

			echo '</select>
					</td>
				</tr>
				<tr>
					<th>
						<label for="open">' . $engine->_t('GroupsOpen') . '</label>
					</th>
					<td>
						<input type="checkbox" id="open" name="open" value="1" ' . ($open || $usergroup['open'] == 1 ? ' checked' : '') . '>
					</td>
				</tr>
				<tr>
					<th>
						<label for="active">' . $engine->_t('GroupsActive') . '</label>
					</th>
					<td>
						<input type="checkbox" id="active" name="active" value="1" ' . ($active || $usergroup['active'] == 1 ? ' checked' : '') . '>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<br><small>' . $engine->_t('GroupsRenameInfo') . '</small>
						<br><br>
						<button type="submit" id="submit" name="edit">' . $engine->_t('SubmitButton') . '</button>
						<a href="' . $engine->href() . '" class="btn-link"><button type="button" class="btn-cancel">' . $engine->_t('CancelButton') . '</button></a>
					</td>
				</tr>
				</table><br>';

			echo $engine->form_close();
		}
	}
	// delete group
	else if (isset($_POST['delete_group']) && $change_id)
	{
		if ($usergroup = $engine->db->load_single(
			'SELECT group_name, is_system
			FROM ' . $prefix . 'usergroup
			WHERE group_id = ' . (int) $change_id . '
			LIMIT 1'))
		{
			if ($usergroup['is_system'])
			{
				$engine->show_message(Ut::perc_replace($engine->_t('GroupsIsSystem'), ' <code>' . Ut::html($usergroup['group_name']) . '</code>'));
			}
			else
			{
				echo '<h2>' . $engine->_t('GroupDelete') . '</h2>';
				echo $engine->form_open('delete_group');

				echo '<input type="hidden" name="group_id" value="' . $change_id . '">' . "\n" .
					'<table class="formation lined">
						<tr>
							<td>' .
								Ut::perc_replace($engine->_t('GroupsDelete'), ' <code>' . Ut::html($usergroup['group_name']) . '</code>') . ' ' .
								'<button type="submit" id="submit" name="delete">' . $engine->_t('Remove') . '</button> ' .
								'<a href="' . $engine->href() . '" class="btn-link"><button type="button" id="button">' . $engine->_t('Cancel') . '</button></a>' .
								'<br><small>' . $engine->_t('GroupsDeleteInfo') . '</small>
							</td>
						</tr>
					</table>
					<br>';

				echo $engine->form_close();
			}
		}
	}

	/////////////////////////////////////////////
	//   building lists
	/////////////////////////////////////////////

	// get group
	else if ($group_id)
	{
		$usergroup = $engine->db->load_single(
			'SELECT group_id, moderator_id, group_name ' .
			'FROM ' . $prefix . 'usergroup ' .
			'WHERE group_id = ' . (int) $group_id . ' ' .
			'LIMIT 1');

		echo '<h2>' . $engine->_t('GroupsMembersFor') . ': ' . $usergroup['group_name'] . '</h2>';

		$members = $engine->db->load_all(
			'SELECT m.user_id, u.user_name ' .
			'FROM ' . $prefix . 'usergroup g ' .
				'INNER JOIN ' . $prefix . 'usergroup_member m ON (g.group_id = m.group_id) ' .
				'INNER JOIN ' . $prefix . 'user u ON (m.user_id = u.user_id) ' .
			'WHERE g.group_id = ' . (int) $group_id . ' ');

		echo $engine->form_open('get_group');
?>
		<input type="hidden" name="group_id" value="<?php echo (int) $group_id; ?>">

		<table class="members formation listcenter lined">
			<colgroup>
				<col span="1">
				<col span="1">
				<col span="1">
			</colgroup>
			<thead>
				<tr>
					<th></th>
					<th>ID</th>
					<th><a href="<?php echo $engine->href() . $orderuser; ?>"><?php echo $engine->_t('UserName');?></a></th>
				</tr>
			</thead>
			<tbody>
<?php
		foreach ($members as $member)
		{
			echo
				'<tr>' . "\n" .
					'<td>
						<input type="radio" name="change_member_id" value="' . $member['user_id'] . '"></td>' .
					'<td>' . $member['user_id'] . '</td>' .
					'<td><strong><a href="' . $engine->href('', '', ['mode' => 'user_users', 'user_id' => $member['user_id']]) . '">' . $member['user_name'] . '</a></strong></td>' .
				'</tr>';
		}
			?>
			</tbody>
		</table>
		<?php

		/////////////////////////////////////////////
		//   control buttons
		/////////////////////////////////////////////

		echo '<br>' .
			 '<button type="submit" id="button_add" name="add_member">' . $engine->_t('AddButton') . '</button> ' .
			 '<button type="submit" id="button_remove" name="remove_member" class="btn-danger">' . $engine->_t('RemoveButton') . '</button> ' .
			 '<a href="' . $engine->href() . '" class="btn-link"><button type="button" class="btn-cancel">' . $engine->_t('CancelButton') . '</button></a>';

		echo $engine->form_close();
	}
	else
	{
		$order = match($_order) {
			'created_asc'		=> 'g.created ASC ',
			'created_desc'		=> 'g.created DESC ',
			'group_asc'			=> 'g.group_name DESC ',
			'members_asc'		=> 'members DESC ',
			'members_desc'		=> 'members ASC ',
			default				=> 'g.group_name ASC ',
		};

		// set created ordering
		$created = match($_order) {
			'created_asc'		=> 'created_desc',
			default				=> 'created_asc',
		};

		// set usergroup ordering
		$order_group = match($_order) {
			'group_desc'		=> 'group_asc',
			default				=> 'group_desc',
		};

		// set members ordering
		$order_members = match($_order) {
			'members_asc'		=> 'members_desc',
			default				=> 'members_asc',
		};

		// filter
		if (isset($_GET['moderator_id']))
		{
			$where = 'WHERE g.moderator_id = ' . (int) $_GET['moderator_id'] . ' ';
		}

		// entries to display
		$limit = 100;

		// collecting data
		$count = $engine->db->load_single(
			'SELECT COUNT(group_name) AS n ' .
			'FROM ' . $prefix . 'usergroup ' .
			($where ?: ''));

		$order_pagination	= !empty($_order) ? ['order' => Ut::html($_order)] : [];
		$pagination			= $engine->pagination($count['n'], $limit, 'p', ['mode' => $module] + $order_pagination, '', 'admin.php');

		$groups = $engine->db->load_all(
			'SELECT g.group_id, g.group_name, g.description, g.moderator_id, g.open, g.active, g.created, u.user_name, COUNT(m.user_id) AS members ' .
			'FROM ' . $prefix . 'usergroup g ' .
				'LEFT JOIN ' . $prefix . 'user u ON (g.moderator_id = u.user_id) ' .
				'LEFT JOIN ' . $prefix . 'usergroup_member m ON (m.group_id = g.group_id) ' .
			($where ?: '') .
			'GROUP BY g.group_id,g.group_name, g.description, g.moderator_id, g.open, g.active, g.created, u.user_name ' .
			'ORDER BY ' . $order .
			$pagination['limit']);

		/////////////////////////////////////////////
		//   print list
		/////////////////////////////////////////////

		echo $engine->form_open('groups');

		/////////////////////////////////////////////
		//   control buttons
		/////////////////////////////////////////////

		$control_buttons =
			'<br>' .
			'<button type="submit" id="create-button" name="create_group">' . $engine->_t('AddButton') . '</button> ' .
			'<button type="submit" id="edit-button" name="edit_group">' . $engine->_t('EditButton') . '</button> ' .
			'<button type="submit" id="delete-button" name="delete_group" class="btn-danger">' . $engine->_t('RemoveButton') . '</button> ';

		echo $control_buttons;

		$engine->print_pagination($pagination);
?>
		<table class="groups formation listcenter lined">
			<colgroup>
				<col span="1">
				<col span="1">
				<col span="1">
				<col span="1">
				<col span="1">
				<col span="1">
				<col span="1">
				<col span="1">
				<col span="1">
			</colgroup>
			<thead>
				<tr>
					<th></th>
					<th>ID</th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $order_group]); ?>"><?php echo $engine->_t('GroupsName');?></a></th>
					<th><?php echo $engine->_t('GroupsDescription');?></th>
					<th><?php echo $engine->_t('GroupsModerator');?></th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $order_members]); ?>"><?php echo $engine->_t('GroupsMembers');?></a></th>
					<th><?php echo $engine->_t('GroupsOpen');?></th>
					<th><?php echo $engine->_t('GroupsActive');?></th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $created]); ?>"><?php echo $engine->_t('GroupsCreated');?></a></th>
				</tr>
			</thead>
			<tbody>
<?php
		if ($groups)
		{
			foreach ($groups as $row)
			{
				echo
					'<tr>' . "\n" .
						'<td><input type="radio" name="change_id" value="' . $row['group_id'] . '"></td>' .
						'<td>' . $row['group_id'] . '</td>' .
						'<td><a href="' . $engine->href('', '', ['group_id' => $row['group_id']]) . '">' . $row['group_name'] . '</a></td>' .
						'<td>' . $row['description'] . '</td>' .
						'<td><small><a href="' . $engine->href('', '', ['moderator' => $row['moderator_id']]) . '">' . $row['user_name'] . '</a></small></td>' .
						'<td>' . $row['members'] . '</td>' .
						'<td>' . $row['open'] . '</td>' .
						'<td>' . $row['active'] . '</td>' .
						'<td><small>' . $engine->sql_time_format($row['created']) . '</small></td>' .
					'</tr>';
			}
		}
		else
		{
			echo '<tr><td colspan="5"><br><em>' . $engine->_t('GroupsNoMatching') . '</em></td></tr>';
		}
?>
			</tbody>
		</table>
<?php
		$engine->print_pagination($pagination);

		/////////////////////////////////////////////
		//   control buttons
		/////////////////////////////////////////////

		echo $control_buttons;
		echo $engine->form_close();
	}
}
