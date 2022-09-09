<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Users												##
##########################################################

$module['user_users'] = [
		'order'	=> 401,
		'cat'	=> 'users',
		'status'=> !RECOVERY_MODE,
	];

##########################################################

function admin_user_users(&$engine, $module)
{
	$where		= '';
	$order		= '';
	$error		= '';
	$prefix		= $engine->prefix;
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
	<p>
		<?php echo $engine->_t('UsersInfo');?>
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
	//   list change/update processing
	/////////////////////////////////////////////

	$user_id	= (int) ($_REQUEST['user_id'] ?? '');
	$_order		= $_GET['order'] ?? '';
	$action		= $_POST['_action'] ?? null;

	// get user
	if ($user_id)
	{
		$user = $engine->db->load_single(
			"SELECT u.user_id, u.user_name, u.real_name, u.email, s.theme, s.user_lang, u.enabled, u.account_status, u.email_confirm " .
			"FROM " . $prefix . "user u " .
				"LEFT JOIN " . $prefix . "user_setting s ON (u.user_id = s.user_id) " .
			"WHERE u.user_id = " . (int) $user_id . " " .
				"AND u.account_type = 0 " .
			"LIMIT 1");
	}

	if (isset($_POST['create']) || isset($_POST['edit']))
	{
		// passing vars from user input
		$user_name		= $engine->sanitize_username(($_POST['user_name'] ?? ''));
		$realname		= (string) ($_POST['realname'] ?? '');
		$email			= Ut::strip_spaces(($_POST['email'] ?? ''));
		$password		= (string) ($_POST['password'] ?? '');
		$conf_password	= (string) ($_POST['conf_password'] ?? '');
		$user_lang		= $engine->validate_language($_POST['user_lang'] ?? '');
		$theme			= $engine->validate_theme($_POST['theme'] ?? '');
		$complexity		= $engine->password_complexity($user_name, $password);
		$notify_signup	= (int) ($_POST['notify_signup'] ?? 0);
		$verify_email	= (int) ($_POST['verify_email'] ?? 0);
		$enabled		= (int) ($_POST['enabled'] ?? 0);
	}

	// add new user processing
	if ($action == 'add_user' && $user_name)
	{
		// create new account if possible
		if ($message = $engine->validate_username($user_name))
		{
			$error .= $message;
		}
		else if ($message = $engine->validate_email($email))
		{
			$error .= $message;
		}
		// confirmed password mismatch
		else if ($conf_password != $password)
		{
			$error .= $engine->_t('PasswordsDidntMatch') . " ";
		}
		// password complexity validation
		else if ($complexity)
		{
			$error .= $complexity;
		}

		if ($error)
		{
			$engine->show_message($error, 'error');
			$_POST['create']	= 1;
		}
		else
		{
			$engine->db->sql_query(
				"INSERT INTO " . $prefix . "user SET " .
					"user_name			= " . $engine->db->q($user_name) . ", " .
					"email				= " . $engine->db->q($email) . ", " .
					"password			= " . $engine->db->q($engine->password_hash(['user_name' => $user_name], $password)) . ", " .
					"enabled			= " . (int) $enabled . ", " .
					"signup_time		= UTC_TIMESTAMP()");

			// get new user_id
			$_user_id = $engine->db->load_single(
				"SELECT user_id " .
				"FROM " . $prefix . "user " .
				"WHERE user_name = " . $engine->db->q($user_name) . " " .
				"LIMIT 1");

			// INSERT user settings
			$engine->db->sql_query(
				"INSERT INTO " . $prefix . "user_setting SET " .
					"user_id			= " . (int) $_user_id['user_id'] . ", " .
					"user_lang			= " . $engine->db->q($user_lang) . ", " .
					"list_count			= " . (int) $engine->db->list_count . ", " .
					"theme				= " . $engine->db->q($engine->db->theme) . ", " .
					"diff_mode			= " . (int) $engine->db->default_diff_mode . ", " .
					"notify_minor_edit	= " . (int) $engine->db->notify_minor_edit . ", " .
					"notify_page		= " . (int) $engine->db->notify_page . ", " .
					"notify_comment		= " . (int) $engine->db->notify_comment . ", " .
					"sorting_comments	= " . (int) $engine->db->sorting_comments . ", " .
					"allow_intercom		= " . (int) $engine->db->allow_intercom . ", " .
					"allow_massemail	= " . (int) $engine->db->allow_massemail . ", " .
					"send_watchmail		= 1");

			// add user page
			$engine->add_user_page($user_name, $user_lang);

			if ($engine->db->enable_email && $notify_signup)
			{
				// 1. Send signup email to new user
				$new_user = [
					'user_id'		=> $_user_id['user_id'],
					'user_name'		=> $user_name,
					'email'			=> $email,
					'user_lang'		=> $user_lang ?: $engine->db->language
				];

				// send email to user and set email_confirm  token!
				$engine->notify_user_signup($new_user, $verify_email);
			}

			$engine->set_message($engine->_t('UsersAdded'), 'success');
			$engine->log(4, Ut::perc_replace($engine->_t('LogUserCreated', SYSTEM_LANG), $user_name));
			$engine->http->redirect($engine->href('', '', ['user_id' => $_user_id['user_id']]));
		}
	}
	// re-confirm email address
	else if (isset($_POST['confirm']) && $user_id)
	{
		$engine->notify_email_confirm($user);
	}
	// approve user processing
	else if (isset($_POST['approve']) && $user_id)
	{
		$user = $engine->db->load_single(
			"SELECT u.user_id, u.user_name, u.real_name, u.email, s.theme, s.user_lang, u.enabled, u.account_status " .
			"FROM " . $prefix . "user u " .
				"LEFT JOIN " . $prefix . "user_setting s ON (u.user_id = s.user_id) " .
			"WHERE u.user_id = " . (int) $user_id . " " .
			"AND u.account_type = 0 " .
			"LIMIT 1");

		$engine->approve_user($user, $user['account_status']);
		$engine->add_user_page($user['user_name'], $user['user_lang']);
	}
	// edit user processing
	else if ($action == 'edit_user' && $user_id && $user_name )
	{
		if ($message = $engine->validate_username($user_name, false))
		{
			$error .= $message;
		}
		else if ($message = $engine->validate_email($email, false))
		{
			$error .= $message;
		}

		if ($error)
		{
			$engine->show_message($error, 'error');
			$_POST['change']	= (int) $user_id;
			$_POST['edit']		= 1;
		}
		else
		{
			if($engine->db->enable_email && ($user['email'] != $email))
			{
				$user['email'] = $email;
				$engine->notify_email_confirm($user);
			}

			$engine->db->sql_query(
				"UPDATE " . $prefix . "user SET " .
					"user_name		= " . $engine->db->q($user_name) . ", " .
					"email			= " . $engine->db->q($email) . ", " .
					"real_name		= " . $engine->db->q($realname) . ", " .
					"enabled		= " . (int) $enabled . ", " .
					"account_status	= " . (int) $_POST['account_status'] . " " .
				"WHERE user_id		= " . (int) $user_id . " " .
				"LIMIT 1");

			$engine->db->sql_query(
				"UPDATE " . $prefix . "user_setting SET " .
					"user_lang		= " . $engine->db->q($user_lang) . ", " .
					"theme			= " . $engine->db->q($theme) . " " .
				"WHERE user_id		= " . (int) $user_id . " " .
				"LIMIT 1");

			$engine->set_message($engine->_t('UsersUpdated'), 'success');
			$engine->log(4, Ut::perc_replace($engine->_t('LogUserUpdated', SYSTEM_LANG), $user['user_name']));
			$engine->http->redirect($engine->href('', '', ['user_id' => $user_id]));
		}
	}
	// delete user processing
	// TODO: reassign acls, uploads, pages and revisions, delete user page
	else if ($action == 'delete_user' && ($user_id || $set))
	{
		if (!array_filter($set) && empty($user_id))
		{
			$error = $engine->_t('ModerateNoItemChosen'); // no user selected
			$engine->show_message($error, 'error');
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

					$engine->db->sql_query(
						"DELETE FROM " . $prefix . "user " .
						"WHERE user_id = " . (int) $user_id);
					$engine->db->sql_query(
						"DELETE FROM " . $prefix . "user_setting " .
						"WHERE user_id = " . (int) $user_id);
					$engine->db->sql_query(
						"DELETE FROM " . $prefix . "usergroup_member " .
						"WHERE user_id = " . (int) $user_id);
					$engine->db->sql_query(
						"DELETE FROM " . $prefix . "menu " .
						"WHERE user_id = " . (int) $user_id);
					$engine->db->sql_query(
						"DELETE FROM " . $prefix . "watch " .
						"WHERE user_id = " . (int) $user_id);
					$engine->db->sql_query(
						"DELETE FROM " . $prefix . "auth_token " .
						"WHERE user_id = " . (int) $user_id);

					// remove user space
					$user_space = $engine->db->users_page . '/' . $user['user_name'];

					$engine->remove_referrers			($user_space, true);
					$engine->remove_links				($user_space, true);
					$engine->remove_category_assigments	($user_space, true);
					$engine->remove_acls				($user_space, true);
					$engine->remove_menu_items			($user_space, true);
					$engine->remove_watches				($user_space, true);
					$engine->remove_comments			($user_space, true, true); // dontkeep
					$engine->remove_files_perpage		($user_space, true);
					$engine->remove_revisions			($user_space, true);

					$engine->db->sql_query(
						"DELETE FROM " . $prefix . "page " .
						"WHERE tag = " . $engine->db->q($user_space) . " " .
							"OR tag LIKE " . $engine->db->q($user_space . '/%') . " " .
							#"AND owner_id = " . (int) $user_id . " " .
						"");

					$engine->config->invalidate_config_cache();
					$engine->show_message(Ut::perc_replace($engine->_t('UsersDeleted'), ' ' . '<code>' . Ut::html($user['user_name']) . '</code>'), 'success');
					$engine->log(4, Ut::perc_replace($engine->_t('LogUserDeleted', SYSTEM_LANG), $user['user_name']));
				}
			}

			$set = [];
		}
	}

	/////////////////////////////////////////////
	//   edit forms
	/////////////////////////////////////////////

	// add new user form
	if (isset($_POST['create']))
	{
		echo $engine->form_open('add_user');

		echo '<h2>' . $engine->_t('UsersAddNew') . '</h2>';
		echo '<table class="formation lined">
				<tr>
					<th class="label">
						<label for="user_name">' . $engine->_t('UserName') . '</label>
					</th>
					<td>
						<input type="text" id="user_name" name="user_name" value="' . Ut::html($user_name) . '" pattern="' . $engine->lang['USER_NAME'] . '" size="20" minlength="' . $engine->db->username_chars_min . '" maxlength="' . $engine->db->username_chars_max . '" required autofocus>
						<p>' . Ut::perc_replace($engine->_t($engine->db->disable_wikiname? 'NameAlphanumOnly' : 'NameCamelCaseOnly'), $engine->db->username_chars_min, $engine->db->username_chars_max) . '</p>
					</td>
				</tr>
				<tr>
					<th class="label">
						<label for="password">' . $engine->_t('Password') . '</label>
					</th>
					<td>
						<input type="password" id="password" name="password" size="24" minlength="' . $engine->db->pwd_min_chars . '" value="' . Ut::html($password) . '" autocomplete="off" required>
					</td>
				</tr>
				<tr>
					<th class="label">
						<label for="conf_password">' . $engine->_t('ConfirmPassword') . '</label>
					</th>
					<td>
						<input type="password" id="conf_password" name="conf_password" size="24"  minlength="' . $engine->db->pwd_min_chars . '" value="' . Ut::html($conf_password) . '" autocomplete="off" required>
						<p>' . $engine->show_password_complexity() . '</p>
					</td>
				</tr>
				<tr>
					<th class="label">
						<label for="email">' . $engine->_t('Email') . '</label>
					</th>
					<td>
						<input type="email" id="email" name="email" value="' . Ut::html(($email ?? '')) . '" size="50" maxlength="100">
					</td>
				</tr>
				<tr>
					<th class="label">
						<label for="user_lang">' . $engine->_t('YourLanguage') . '</label>
					</th>
					<td>
						<select id="user_lang" name="user_lang">';

				$languages = $engine->_t('LanguageArray');

				if ($langs = $engine->http->available_languages())
				{
					foreach ($langs as $lang)
					{
						echo '<option value="' . $lang . '"' . ($lang == $engine->db->language ? ' selected' : '') . '>' . $languages[$lang] . ' (' . $lang . ')' . "</option>\n";
					}
				}

				echo '</select>
					</td>
				</tr>
				<tr>
					<th class="label">
						<label for="enabled">' . $engine->_t('Enabled') . '</label>
					</th>
					<td>
						<input type="checkbox" id="enabled" name="enabled" value="1" ' . (!isset($enabled) ? ' checked' : '') . '>
					</td>
				</tr>
				<tr>
					<th class="label">
						<label>' . $engine->_t('UserAccountNotify') . '</label>
					</th>
					<td>
						<input type="checkbox" id="notify_signup" name="notify_signup" value="1" ' . (!isset($notify_signup) ? '' : ' checked') . '>
						<label for="notify_signup">' . $engine->_t('UserNotifySignup') . '</label><br>
						<input type="checkbox" id="verify_email" name="verify_email" value="1" ' . (!isset($verify_email) ? '' : ' checked') . '>
						<label for="verify_email">' . $engine->_t('UserVerifyEmail') . '</label>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<br>
						<button type="submit" id="submit" name="create">' . $engine->_t('SubmitButton') . '</button>
						<a href="' . $engine->href() . '" class="btn-link"><button type="button" class="btn-cancel">' . $engine->_t('CancelButton') . '</button></a>
					</td>
				</tr>
			</table><br>';

		echo $engine->form_close();
	}
	// edit user form
	else if (isset($_POST['edit']) && $user_id)
	{
		if ($user = $engine->db->load_single(
			"SELECT u.user_name, u.real_name, u.email, s.user_lang, s.theme, u.enabled, u.account_status " .
			"FROM " . $prefix . "user u " .
				"LEFT JOIN " . $prefix . "user_setting s ON (u.user_id = s.user_id) " .
			"WHERE u.user_id = " . (int) $user_id . " " .
				"AND u.account_type = 0 " .
			"LIMIT 1"))
		{
			echo $engine->form_open('edit_user');

			echo '<input type="hidden" name="user_id" value="' . (int) $user_id . '">
				<table class="formation lined">
				<tr>
					<th class="label">
						<label for="user_name">' . Ut::perc_replace($engine->_t('UsersRename'), ' ' . '<code>' . Ut::html($user['user_name']) . '</code>') . ' *</label>
					</th>
					<td>
						<input type="text" id="user_name" name="user_name" value="' . Ut::html(($user_name ?: $user['user_name'])) . '" pattern="' . $engine->lang['USER_NAME'] . '" size="20" minlength="' . $engine->db->username_chars_min . '" maxlength="' . $engine->db->username_chars_max . '" required>
					</td>
				</tr>
				<tr>
					<th class="label">
						<label for="newrealname">' . $engine->_t('RealName') . '</label>
					</th>
					<td>
						<input type="text" id="realname" name="realname" value="' . Ut::html(($realname ?: $user['real_name'])) . '" size="50" maxlength="100">
					</td>
				</tr>
				<tr>
					<th class="label">
						<label for="newemail">' . $engine->_t('Email') . '</label>
					</th>
					<td>
						<input type="email" id="email" name="email" value="' . Ut::html(($email ?: $user['email'])) . '" size="50" maxlength="100">
					</td>
				</tr>
				<tr>
					<th class="label">
						<label for="user_lang">' . $engine->_t('YourLanguage') . '</label>
					</th>
					<td>
						<select id="user_lang" name="user_lang">
							<option value=""></option>';

						$languages = $engine->_t('LanguageArray');

						if ($langs = $engine->http->available_languages())
						{
							foreach ($langs as $lang)
							{
								echo '<option value="' . $lang . '" ' . ($user['user_lang'] == $lang ? ' selected' : '') . '>' . $languages[$lang] . ' (' . $lang . ")</option>\n";
							}
						}

					echo '</select>
					</td>
				</tr>
				<tr>
					<th class="label">
						<label for="theme">' . $engine->_t('ChooseTheme') . '</label>
					</th>
					<td>
						<select id="theme" name="theme">';

						$themes = $engine->available_themes();

						foreach ($themes as $theme)
						{
							echo '<option value="' . $theme . '" ' . ($user['theme'] == $theme ? 'selected' : '') . '>' . $theme . '</option>';
						}

					echo '</select>
					</td>
				</tr>
				<tr>
					<th class="label">
						<label for="enabled">' . $engine->_t('Enabled') . '</label>
					</th>
					<td>
						<input type="checkbox" id="enabled" name="enabled" value="1" ' . (isset($enabled) || $user['enabled'] == 1  ? ' checked' : '') . '>
					</td>
				</tr>
				<tr>
					<th class="label">
						<label for="account_status">' . $engine->_t('AccountStatus') . '</label>
					</th>
					<td>
						<select id="account_status" name="account_status">';

						$account_status = $engine->_t('AccountStatusArray');

						foreach ($account_status as $offset => $status)
						{
							echo '<option value="' . $offset . '" ' .
								(isset($user['account_status']) && $user['account_status'] == $offset
									? 'selected '
									: '') .
								'>' . $status . "</option>\n";
						}

					echo '</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<br>
						<small>' . $engine->_t('UsersRenameInfo') . '</small>
						<br><br>
						<button type="submit" id="submit" name="edit">' . $engine->_t('SubmitButton') . '</button>
						<a href="' . $engine->href() . '" class="btn-link"><button type="button" class="btn-cancel">' . $engine->_t('CancelButton') . '</button></a>
					</td>
				</tr>
			</table>
			<br>';

			echo $engine->form_close();
		}
	}
	// delete user form
	else if (isset($_POST['remove']) && (isset($user_id) || $set))
	{
		$users	= '';
		$i		= 0;

		if (!empty($user_id) && !in_array($user_id, $set))
		{
			$set[] = (int) $user_id;
		}

		echo $engine->form_open('delete_user');

		foreach ($set as $user_id)
		{
			if ((int) $user_id)
			{
				if ($i > 0)
				{
					$users	.= ', ';
				}

				if ($user = $engine->db->load_single(
					"SELECT user_name
					FROM " . $prefix . "user
					WHERE user_id = " . (int) $user_id . "
					LIMIT 1"))
				{
					$users	.= '<code>' . Ut::html($user['user_name']) . '</code>';
				}

				$i++;
			}
		}

		echo '<input type="hidden" name="user_id" value="' . (int) $user_id . '">' . "\n" .
			 '<input type="hidden" name="ids" value="' . implode('-', $set) . '">' . "\n" .
				'<table class="formation">
					<tr>
						<td>' .
							Ut::perc_replace($engine->_t('UsersDelete'), ' ' . $users) . ' ' .
							'<button type="submit" id="submit" name="delete">' . $engine->_t('Remove') . '</button> ' .
							'<a href="' . $engine->href() . '" class="btn-link"><button type="button" id="button">' . $engine->_t('Cancel') . '</button></a><br>' .
							'<small>' . $engine->_t('UsersDeleteInfo') . '</small>
						</td>
					</tr>
				</table>
				<br>';

		echo $engine->form_close();
	}
	// get user
	else if (isset($_GET['user_id']))
	{
		echo '<h2>' . $user['user_name'] . "</h2>";

		// user data
		$status = $engine->_t('AccountStatusArray');

		echo $engine->form_open('get_user');
		?>
		<input type="hidden" name="user_id" value="<?php echo (int) $user_id; ?>">

		<table class="formation lined">
		<?php

			echo
				'<tr>' . "\n" .
					'<th class="label">' . $engine->_t('UserName') . '</th>' .
					'<td><strong>' . $user['user_name'] . '</strong></td>' .
				'</tr>' .
				'<tr>' . "\n" .
					'<th  class="label">' . $engine->_t('RealName') . '</th>' .
					'<td>' . $user['real_name'] . '</td>' .
				'</tr>' .
				'<tr>' . "\n" .
					'<th class="label">' . $engine->_t('EmailAddress') . '</th>' .
					'<td>' . $user['email'] . '</td>' .
				'</tr>' .
				'<tr>' . "\n" .
					'<th class="label">' . $engine->_t('YourLanguage') . '</th>' .
					'<td>' . $user['user_lang'] . '</td>' .
				'</tr>' .
				'<tr>' . "\n" .
					'<th class="label">' . $engine->_t('Theme') . '</th>' .
					'<td>' . $user['theme'] . '</td>' .
				'</tr>' .
				'<tr>' . "\n" .
					'<th class="label">' . $engine->_t('Enabled') . '</th>' .
					'<td>' . $user['enabled'] . '</td>' .
				'</tr>' .
				'<tr>' . "\n" .
					'<th class="label">' . $engine->_t('AccountStatus') . '</th>' .
					'<td>' . $status[$user['account_status']] . '</td>' .
				'</tr>';

		if ($user['email_confirm'])
		{
			echo '<tr>' . "\n" .
					'<th class="label">' . $engine->_t('EmailNotVerified') . '</th>' .
					'<td><button type="submit" id="button" name="confirm">' . $engine->_t('UserReVerifyEmail') . '</button></td>' .
				'</tr>';
		}
?>
		</table>
		<?php

		/////////////////////////////////////////////
		//   control buttons
		/////////////////////////////////////////////

		echo '<br><button type="submit" id="button" name="edit">' . $engine->_t('EditButton') . '</button> ';
		echo '<button type="submit" id="button" name="remove" class="btn-danger">' . $engine->_t('RemoveButton') . '</button> ';
		echo '<a href="' . $engine->href() . '" class="cancel" ><button type="button" class="btn-cancel">' . $engine->_t('CancelButton') . '</button></a>';
		echo $engine->form_close();
	}
	else
	{
		// defining WHERE and ORDER clauses
		if (!empty($_GET['user']) && mb_strlen($_GET['user']) > 2)
		{
			$where				= "WHERE user_name LIKE " . $engine->db->q('%' . trim($_GET['user']) . '%') . " ";
		}

		$order = match($_order) {
			'signup_asc'			=> 'u.signup_time ASC ',
			'signup_desc'			=> 'u.signup_time DESC ',
			'last_visit_asc'		=> 'u.last_visit ASC ',
			'last_visit_desc'		=> 'u.last_visit DESC ',
			'total_pages_asc'		=> 'u.total_pages ASC ',
			'total_pages_desc'		=> 'u.total_pages DESC ',
			'total_comments_asc'	=> 'u.total_comments ASC ',
			'total_comments_desc'	=> 'u.total_comments DESC ',
			'total_revisions_asc'	=> 'u.total_revisions ASC ',
			'total_revisions_desc'	=> 'u.total_revisions DESC ',
			'total_uploads_asc'		=> 'u.total_uploads ASC ',
			'total_uploads_desc'	=> 'u.total_uploads DESC ',
			'user_asc'				=> 'u.user_name DESC ',
			'user_desc'				=> 'u.user_name ASC ',
			default					=> 'u.user_id DESC ',
		};

		// set signuptime ordering
		$signup_time = match($_order) {
			'signup_asc'			=> 'signup_desc',
			default					=> 'signup_asc',
		};

		// set last_visit ordering
		$last_visit = match($_order) {
			'last_visit_asc'		=> 'last_visit_desc',
			default					=> 'last_visit_asc',
		};

		// set total_pages ordering
		$order_pages = match($_order) {
			'total_pages_asc'		=> 'total_pages_desc',
			default					=> 'total_pages_asc',
		};

		// set total_comments ordering
		$order_comments = match($_order) {
			'total_comments_asc'	=> 'total_comments_desc',
			default					=> 'total_comments_asc',
		};

		// set total_revisions ordering
		$order_revisions = match($_order) {
			'total_revisions_asc'	=> 'total_revisions_desc',
			default					=> 'total_revisions_asc',
		};

		// set total_uploads ordering
		$order_uploads = match($_order) {
			'total_uploads_asc'		=> 'total_uploads_desc',
			default					=> 'total_uploads_asc',
		};

		// set user_name ordering
		$order_user = match($_order) {
			'user_asc'				=> 'user_desc',
			default					=> 'user_asc',
		};

		// filter by account_status
		if (isset($_GET['account_status']))
		{
			$where				= "WHERE u.account_status = " . (int) $_GET['account_status'] . " ";
		}

		// filter by lang
		if (isset($_GET['user_lang']))
		{
			$where				= "WHERE s.user_lang = " . $engine->db->q($_GET['user_lang']) . " ";
		}

		// entries to display
		$limit = 100;

		$status = $engine->_t('AccountStatusArray');

		// collecting data
		$count = $engine->db->load_single(
			"SELECT COUNT(user_name) AS n " .
			"FROM " . $prefix . "user u " .
				"LEFT JOIN " . $prefix . "user_setting s ON (u.user_id = s.user_id) " .
			($where ?: '')
			);

		$order_pagination	= !empty($_order) ? ['order' => Ut::html($_order)] : [];
		$pagination			= $engine->pagination($count['n'], $limit, 'p', ['mode' => $module] + $order_pagination, '', 'admin.php');

		$users = $engine->db->load_all(
			"SELECT u.user_id, u.user_name, u.email, u.total_pages, u.total_comments, u.total_revisions, u.total_uploads, u.enabled, u.account_status, u.signup_time, u.last_visit, s.user_lang " .
			"FROM " . $prefix . "user u " .
				"LEFT JOIN " . $prefix . "user_setting s ON (u.user_id = s.user_id) " .
			($where ?: "") .
			($where ? "AND " : "WHERE ") .
				"u.account_type = 0 " .
			"ORDER BY " . $order .
			$pagination['limit']);

		// user filter form
		$search =	$engine->form_open('search_user', ['form_method' => 'get']) .
					'<input type="hidden" name="mode" value="' . $module . '">' .  // required to pass mode module via GET
					$engine->_t('UsersSearch') . ': </td><td>' .
					'<input type="search" name="user" maxchars="40" size="30" value="' . Ut::html(trim(($_GET['user'] ?? ''))) . '"> ' .
					'<button type="submit" id="submit">' . $engine->_t('SearchButton') . '</button> ' .
					$engine->form_close();

		echo '<span class="search-box-right">' . $search . '</span>';

		echo $engine->form_open('users');

		/////////////////////////////////////////////
		//   control buttons
		/////////////////////////////////////////////

		$control_buttons =
			'<br>' .
			'<button type="submit" id="create-button" name="create">' . $engine->_t('AddButton') . '</button> ' .
			'<button type="submit" id="edit-button" name="edit">' . $engine->_t('EditButton') . '</button> ' .
			#'<button type="submit" id="approve-button" name="approve">' . $engine->_t('Approve') . '</button> ' .
			'<button type="submit" id="remove-button" name="remove" class="btn-danger">' . $engine->_t('RemoveButton') . '</button> ' .
			'<input type="hidden" name="ids" value="' . implode('-', $set) . '">' .
			'<br>' . "\n" .
				'<button type="submit" name="set" id="submit">' . $engine->_t('SetButton') . '</button> ' .
				($set
						? '<button type="submit" name="reset" id="submit">' . $engine->_t('ResetButton') . '</button> ' .
						'<small>ids: ' . implode(', ', $set) . '</small>'
						: ''
				);



		echo $control_buttons;

		$engine->print_pagination($pagination);
?>
		<table class="users formation listcenter lined">
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
				<col span="1">
				<col span="1">
				<col span="1">
				<col span="1">
				<col span="1">
			</colgroup>
			<thead>
				<tr>
					<th></th>
					<th></th>
					<th>ID</th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $order_user]); ?>"><?php echo $engine->_t('UsersName');?></a></th>
					<th><?php echo $engine->_t('Email');?></th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $order_pages]); ?>"><?php echo $engine->_t('UsersPages');?></a></th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $order_comments]); ?>"><?php echo $engine->_t('UsersComments');?></a></th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $order_revisions]); ?>"><?php echo $engine->_t('UsersRevisions');?></a></th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $order_uploads]); ?>"><?php echo $engine->_t('UsersUploads');?></a></th>
					<th><?php echo $engine->_t('Language');?></th>
					<th><?php echo $engine->_t('Enabled');?></th>
					<th><?php echo $engine->_t('AccountStatus'); ?></th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $signup_time]); ?>"><?php echo $engine->_t('UsersSignup');?></a></th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $last_visit]); ?>"><?php echo $engine->_t('UsersLastSession');?></a></th>
				</tr>
			</thead>
			<tbody>
<?php
		if ($users)
		{
			foreach ($users as $row)
			{
				echo '<tr>
						<td class="label">
							<input type="checkbox" name="' . $row['user_id'] . '" value="id" ' . (in_array($row['user_id'], $set) ? ' checked' : '') . '/>
						</td>
						<td>
							<input type="radio" name="user_id" value="' . $row['user_id'] . '">
						</td>
						<td>' . $row['user_id'] . '</td>
						<td><a href="' . $engine->href('', '', ['user_id' => $row['user_id']]) . '">' . $row['user_name'] . '</a></td>
						<td>' . $row['email'] . '</td>
						<td>' . $row['total_pages'] . '</td>
						<td>' . $row['total_comments'] . '</td>
						<td>' . $row['total_revisions'] . '</td>
						<td>' . $row['total_uploads'] . '</td>
						<td><small><a href="' . $engine->href('', '', ['user_lang' => $row['user_lang']]) . '">' . $row['user_lang'] . '</a></small></td>
						<td>' . $row['enabled'] . '</td>
						<td><a href="' . $engine->href('', '', ['account_status' => $row['account_status']]) . '">' . $status[$row['account_status']] . '</a></td>
						<td><small>' . $engine->sql_time_formatted($row['signup_time']) . '</small></td>
						<td><small>' . $engine->sql_time_formatted($row['last_visit']) . '</small></td>
					</tr>';
			}
		}
		else
		{
			echo '<tr><td colspan="5"><br><em>' . $engine->_t('UsersNoMatching') . '</em></td></tr>';
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
