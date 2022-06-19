<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Approve Users										##
##########################################################
$_mode = 'user_approve';

$module[$_mode] = [
		'order'	=> 400,
		'cat'	=> 'users',
		'status'=> !RECOVERY_MODE,
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Approve
		'title'	=> $engine->_t($_mode)['title'],	// User registration approval
	];

##########################################################

function admin_user_approve(&$engine, &$module)
{
	$where			= '';
	$order			= '';
	$signup_time	= '';
	$error			= '';
	$prefix			= $engine->db->table_prefix;
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
	<p>
		<?php echo $engine->_t('UserApproveInfo'); ?>
	</p>
	<br>
<?php


	// simple and rude input sanitization
	foreach ($_POST as $key => $val)
	{
		$_POST[$key] = Ut::html($val);
	}

	// IDs PROCESSING (COMMON PROCEDURES)
	$set = [];

	// pass previously selected items
	if (isset($_REQUEST['ids']))
	{
		$ids = explode('-', $_REQUEST['ids']);

		foreach ($ids as $id)
		{
			if (!in_array($id, $set) && !empty($id))
			{
				$set[] = $id;
			}
		}

		unset($ids, $id);
	}

	// keep currently selected list items
	foreach ($_POST as $val => $key)
	{
		if ($key == 'id' && !in_array($val, $set) && !empty($val))
		{
			$set[] = $val;
		}
	}

	unset($key, $val);

	// save user ids for later operations (correct if needed)
	if (isset($_POST['set']))
	{
		$set = [];

		foreach ($_POST as $val => $key)
		{
			if ($key == 'id' && !empty($val))
			{
				$set[] = $val;
			}
		}

		unset($key, $val);
	}
	// reset user ids
	else if (isset($_POST['reset']))
	{
		$set = [];
	}

	reset($set);

	/////////////////////////////////////////////
	//   list change/update
	/////////////////////////////////////////////

	#$user_id		= (int) ($_POST['user_id'] ?? $_GET['user_id'] ?? '');
	$user_id		= (int) ($_REQUEST['user_id'] ?? '');
	$account_status	= (int) ($_GET['account_status'] ?? -1);
	$_order			= $_GET['order'] ?? '';

	// get user
	if (isset($_GET['user_id']) || isset($_POST['user_id']))
	{
		$user = $engine->db->load_single(
			"SELECT u.user_name, u.real_name, u.email, s.theme, s.user_lang, u.enabled, u.account_status " .
			"FROM " . $prefix . "user u " .
				"LEFT JOIN " . $prefix . "user_setting s ON (u.user_id = s.user_id) " .
			"WHERE u.user_id = " . (int) $user_id . " " .
				"AND u.account_type = 0 " .
			"LIMIT 1");
	}

	// approve user
	if (isset($_GET['approve']) && $user_id )
	{
		$user = $engine->db->load_single(
			"SELECT u.user_id, u.user_name, u.real_name, u.email, s.theme, s.user_lang, u.enabled, u.account_status " .
			"FROM " . $prefix . "user u " .
				"LEFT JOIN " . $prefix . "user_setting s ON (u.user_id = s.user_id) " .
			"WHERE u.user_id = " . (int) $user_id . " " .
				"AND u.account_type = 0 " .
			"LIMIT 1");

		if ($_GET['approve'] == 1)
		{
			// approved registration
			$engine->approve_user($user, false);
			$engine->add_user_page($user['user_name'], $user['user_lang']);

			$engine->show_message($engine->_t('RegistrationApproved'));
			$engine->log(4, Ut::perc_replace($engine->_t('LogUserApproved', SYSTEM_LANG), $user['user_name']));
		}
		else if ($_GET['approve'] == 2)
		{
			// deny registration
			$engine->set_account_status($user_id, 2);

			$engine->show_message($engine->_t('RegistrationDenied'));
			$engine->log(4, Ut::perc_replace($engine->_t('LogUserBlocked', SYSTEM_LANG), $user['user_name']));
		}
	}
	// approve user
	else if (isset($_POST['approve']) && ($user_id || $set))
	{
		if (!array_filter($set) && empty($user_id))
		{
			$error = $engine->_t('ApproveNotExists');
			$engine->show_message($error);
		}

		if (!$error || !empty($user_id))
		{
			if (!empty($user_id))
			{
				$set[]	= (int) $user_id;
				$set	= array_unique($set);
			}

			foreach ($set as $user_id)
			{
				if ((int) $user_id)
				{
					$user = $engine->db->load_single(
						"SELECT u.user_name " .
						"FROM " . $prefix . "user u " .
						"WHERE u.user_id = " . (int) $user_id . " " .
							"AND u.account_type = 0 " .
						"LIMIT 1");

					$engine->show_message($engine->_t('UsersDeleted'));
					$engine->log(4, Ut::perc_replace($engine->_t('LogUserDeleted', SYSTEM_LANG), $user['user_name']));
				}
			}

			$set = [];
		}
	}

	// manage, approving or denying users

	// defining WHERE and ORDER clauses
	if (!empty($_GET['user']) && mb_strlen($_GET['user']) > 2)
	{
		$where			= "WHERE user_name LIKE " . $engine->db->q('%' . $_GET['user'] . '%') . " ";
	}
	// set signuptime ordering
	else if ($_order == 'signup_asc')
	{
		$order			= 'ORDER BY signup_time ASC ';
		$signup_time	= 'signup_desc';
	}
	else if ($_order == 'signup_desc')
	{
		$order			= 'ORDER BY signup_time DESC ';
		$signup_time	= 'signup_asc';
	}
	else
	{
		$signup_time	= 'signup_asc';
	}

	// filter by account_status
	if ($account_status != -1)
	{
		$where			= "WHERE u.account_status = " . (int) $account_status . " ";
	}
	else
	{
		$where			= "WHERE u.account_status = 1 ";
	}

	// set user_name ordering
	if ($_order == 'user_asc')
	{
		$order			= 'ORDER BY user_name DESC ';
		$order_user		= 'user_desc';
	}
	else if ($_order == 'user_desc')
	{
		$order			= 'ORDER BY user_name ASC ';
		$order_user		= 'user_asc';
	}
	else
	{
		$order_user		= 'user_desc';
	}

	// filter by lang
	if (isset($_GET['user_lang']))
	{
		$where			= "WHERE s.user_lang = " . $engine->db->q($_GET['user_lang']) . " ";
	}

	// entries to display
	$limit = 100;

	$status = $engine->_t('AccountStatusArray');

	// collecting data
	$count = $engine->db->load_single(
		"SELECT COUNT(user_name) AS n " .
		"FROM " . $prefix . "user u " .
			"LEFT JOIN " . $prefix . "user_setting s ON (u.user_id = s.user_id) " .
		($where ?: '') .
		($where ? 'AND ' : "WHERE ") .
			"u.user_name <> " . $engine->db->q($engine->db->admin_name) . " "
		);

	$order_pagination	= !empty($_order) ? ['order' => Ut::html($_order)] : [];

	$pagination			= $engine->pagination($count['n'], $limit, 'p', ['mode' => $module['mode']] + $order_pagination  + ['account_status' => (int) $account_status], '', 'admin.php');

	$users = $engine->db->load_all(
		"SELECT u.user_id, u.user_name, u.email, u.user_ip, u.signup_time, u.enabled, u.account_status, s.user_lang " .
		"FROM " . $prefix . "user u " .
			"LEFT JOIN " . $prefix . "user_setting s ON (u.user_id = s.user_id) " .
		($where ?: '') .
		($where ? "AND " : "WHERE ") .
			"u.account_type = 0 " .
			"AND u.user_name <> " . $engine->db->q($engine->db->admin_name) . " " .
		($order ?: 'ORDER BY u.user_id DESC ') .
		$pagination['limit']);

	// count records by status
	$account_stati = $engine->db->load_all(
		"SELECT account_status, COUNT(account_status) AS n
		FROM " . $prefix . "user
		WHERE account_type = 0
			AND user_name <> " . $engine->db->q($engine->db->admin_name) . "
		GROUP BY account_status");

	// set default status count
	$status_count['0'] = 0; // approved
	$status_count['1'] = 0; // pending
	$status_count['2'] = 0; // denied

	foreach ($account_stati as $_status)
	{
		if ($_status['account_status'] < 3)
		{
			$status_count[$_status['account_status']] = $_status['n'];
		}
	}

	// user filter form
	$search =			$engine->form_open('search_user', ['form_method' => 'get']) .
						'<input type="hidden" name="mode" value="' . $module['mode'] . '">' .  // required to pass mode module via GET
						$engine->_t('UsersSearch') . ': </td><td>' .
						'<input type="search" name="user" maxchars="40" size="30" value="' . Ut::html(($_GET['user'] ?? '')) . '"> ' .
						'<button type="submit" id="submit">' . $engine->_t('SearchButton') . '</button> ' .
						$engine->form_close();
	$filter_status =	'<p class="right">' .
						(($account_status == 1 || $account_status == -1)
							? '<span class="active">' . $engine->_t('Pending') . '</span>'
							: '<a href="' . $engine->href('', '', ['account_status' => 1]) . '">' . $engine->_t('Pending') . '</a>' ) . ' (' . $status_count['1'] . ')' .
						($account_status === 0
							? ' | <span class="active">' . $engine->_t('Approved') . '</span>'
							: ' | <a href="' . $engine->href('', '', ['account_status' => 0]) . '">' . $engine->_t('Approved') . '</a>') . ' (' . $status_count['0'] . ')' .
						($account_status == 2
							? ' | <span class="active">' . $engine->_t('Denied') . '</span>'
							: ' | <a href="' . $engine->href('', '', ['account_status' => 2]) . '">' . $engine->_t('Denied') . '</a>') . ' (' . $status_count['2'] . ')' .
						'</p>';

	echo '<span class="right">' . $search . '</span><br>';
	echo $filter_status;

	# echo $engine->form_open('approve');

	/////////////////////////////////////////////
	//   control buttons
	/////////////////////////////////////////////

	/* $control_buttons =	'<br>' .
						'<button type="submit" id="approve-button" name="approve">' . $engine->_t('Approve') . '</button> ' .
						'<button type="submit" id="remove-button" name="remove">' . $engine->_t('Deny') . '</button> ' .
						'<input type="hidden" name="ids" value="' . implode('-', $set) . '">' .
						'<br>' . "\n" .
							'<button type="submit" name="set" id="submit">' . $engine->_t('SetButton') . '</button> ' .
							($set
								? '<button type="submit" name="reset" id="submit">' . $engine->_t('ResetButton') . '</button> ' .
								  '<small>ids: ' . implode(', ', $set) . '</small>'
								: ''
							); */

	$approve_icon	= '<img src="' . $engine->db->theme_url . 'icon/spacer.png" title="' . $engine->_t('Approve') . '" alt="' . $engine->_t('Approve') . '" class="btn-approve">';
	$deny_icon		= '<img src="' . $engine->db->theme_url . 'icon/spacer.png" title="' . $engine->_t('Deny') . '" alt="' . $engine->_t('Deny') . '" class="btn-deny">';

	# echo $control_buttons;
	echo '<br>';

	$engine->print_pagination($pagination);
?>
	<table class="approve formation listcenter lined">
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
				<th>ID</th>
				<th><a href="<?php echo $engine->href('', '', ['order' => $order_user, 'account_status' => $account_status]); ?>"><?php echo $engine->_t('UserName'); ?></a></th>
				<th><?php echo $engine->_t('Email'); ?></th>
				<th><?php echo $engine->_t('UserIP'); ?></th>
				<th><?php echo $engine->_t('Language'); ?></th>
				<th><a href="<?php echo $engine->href('', '', ['order' => $signup_time, 'account_status' => $account_status]); ?>"><?php echo $engine->_t('UserSignuptime'); ?></a></th>
				<th><?php echo $engine->_t('Enabled'); ?></th>
				<th><?php echo $engine->_t('AccountStatus'); ?></th>
				<th><?php echo $engine->_t('UserActions'); ?></th>
			</tr>
		</thead>
		<tbody>
<?php
	if ($users)
	{
		foreach ($users as $row)
		{
			echo
			'<tr>' . "\n" .
				#'<input type="hidden" name="user_id" value="' . $row['user_id'] . '">' .
				#'<td class="label a-middle" style="width:10px;">' .
				#	'<input type="checkbox" name="' . $row['user_id'] . '" value="id" ' . ( in_array($row['user_id'], $set) ? ' checked' : '') . '>' .
				#'</td>' .
				#'<td>' .
				#	'<input type="radio" name="user_id" value="' . $row['user_id'] . '">' .
				#'</td>' . <a href="' . $engine->href() . '&amp;mode=db_restore">Restore database</a>
				'<td>' . $row['user_id'] . '</td>' .
				'<td><strong><a href="' . $engine->href('', '', ['mode' => 'user_users', 'user_id' => $row['user_id']]) . '">' . $row['user_name'] . '</a></strong></td>' .
				'<td>' . $row['email'] . '</td>' .
				'<td>' . $row['user_ip'] . '</td>' .
				'<td><small><a href="' . $engine->href('', '', ['user_lang' => $row['user_lang'], 'account_status' => $account_status]) . '">' . $row['user_lang'] . '</a></small></td>' .
				'<td><small>' . $engine->sql_time_formatted($row['signup_time']) . '</small></td>' .
				'<td>' . $row['enabled'] . '</td>' .
				'<td><a href="' . $engine->href('', '', ['account_status' => $row['account_status']]) . '">' . $status[$row['account_status']] . '</a></td>' .
				'<td>' .
					(($account_status > 0) || $account_status == -1
						? '<a href="' . $engine->href('', '', ['approve' => 1, 'user_id' => $row['user_id']]) . '">' . $approve_icon . $engine->_t('Approve') . '</a>'
						: '') .
					(($account_status < 2) || $account_status == -1
						? '<a href="' . $engine->href('', '', ['approve' => 2, 'user_id' => $row['user_id']]) . '">' . $deny_icon . $engine->_t('Deny') . '</a>'
						: '') .
				'</td>' .
			'</tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="9"><br><em>' . $engine->_t('NoMatchingUser') . '</em></td></tr>';
	}
?>
		</tbody>
	</table>
<?php
	$engine->print_pagination($pagination);

	/////////////////////////////////////////////
	//   control buttons
	/////////////////////////////////////////////

	# echo $control_buttons;
	# echo $engine->form_close();
}
