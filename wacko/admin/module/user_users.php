<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Users												##
##########################################################
$_mode = 'user_users';

$module[$_mode] = [
		'order'	=> 410,
		'cat'	=> 'users',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Users
		'title'	=> $engine->_t($_mode)['title'],	// User management
	];

##########################################################

function admin_user_users(&$engine, &$module)
{
	$where		= '';
	$order		= '';
	$error		= '';
	$prefix		= $engine->db->table_prefix;

	#Ut::debug_print_r($_POST);
	#Ut::debug_print_r($_REQUEST);
?>
	<h1><?php echo $module['title']; ?></h1>
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

	#$user_id = (int) ($_POST['user_id'] ?? ($_GET['user_id'] ?? ''));
	$user_id	= (int) ($_REQUEST['user_id'] ?? '');
	$_order		= $_GET['order'] ?? '';

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

	// add user processing
	if (isset($_POST['create']) && isset($_POST['user_name']))
	{
		// create new account if possible
		// passing vars from user input
		$user_name		= Ut::strip_spaces($_POST['user_name']);
		$email			= Ut::strip_spaces($_POST['email']);
		$password		= $_POST['password'];
		$conf_password	= $_POST['conf_password'];
		$user_lang		= $_POST['user_lang'] ?? $engine->db->language;
		$user_lang		= $engine->known_language($user_lang) ? $user_lang : $engine->db->language;
		$complexity		= $engine->password_complexity($user_name, $password);
		$notify_signup	= (int) ($_POST['notify_signup'] ?? 0);
		$verify_email	= (int) ($_POST['verify_email'] ?? 0);

		// strip \-\_\'\.\/\\
		$user_name	= $engine->sanitize_username($user_name);

		// check if name is WikiName style
		if (!$engine->is_wiki_name($user_name) && $engine->db->disable_wikiname === false)
		{
			$error .= $engine->_t('MustBeWikiName') . " ";
		}
		else if (mb_strlen($user_name) < $engine->db->username_chars_min)
		{
			$error .= Ut::perc_replace($engine->_t('NameTooShort'), 0, $engine->db->username_chars_min) . " ";
		}
		else if (mb_strlen($user_name) > $engine->db->username_chars_max)
		{
			$error .= Ut::perc_replace($engine->_t('NameTooLong'), 0, $engine->db->username_chars_max) . " ";
		}
		// check if valid user name (and disallow '/')
		else if (!preg_match('/^(' . $engine->language['USER_NAME'] . ')$/u', $user_name))
		{
			$error .= $engine->_t('InvalidUserName') . " ";
		}
		// check if reserved word
		else if (($result = $engine->validate_reserved_words($user_name)))
		{
			$error .= Ut::perc_replace($engine->_t('UserReservedWord'), $result);
		}
		// if user name already exists
		else if ($engine->user_name_exists($user_name) === true)
		{
			$error .= $engine->_t('RegistrationUserNameOwned');

			// log event
			$engine->log(2, Ut::perc_replace($engine->_t('LogUserSimilarName', SYSTEM_LANG), $user_name));
		}
		// no email given
		else if ($email == '')
		{
			$error .= $engine->_t('SpecifyEmail') . " ";
		}
		// invalid email
		else if (!$engine->validate_email($email))
		{
			$error .= $engine->_t('NotAEmail') . " ";
		}
		// no email reuse allowed
		else if (!$engine->db->allow_email_reuse && $engine->email_exists($email))
		{
			$error .= $engine->_t('EmailTaken') . " ";
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
		else
		{
			$engine->db->sql_query(
				"INSERT INTO " . $prefix . "user SET " .
					"signup_time		= UTC_TIMESTAMP(), " .
					"email				= " . $engine->db->q($email) . ", " .
					"password			= " . $engine->db->q($engine->password_hash(['user_name' => $user_name], $password)) . ", " .
					#"real_name			= " . $engine->db->q($_POST['newrealname']) . ", " .
					"enabled			= " . (int) ($_POST['enabled'] ?? 0) . ", " .
					"user_name			= " . $engine->db->q($user_name) . " ");

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
					"typografica		= " . (($engine->db->default_typografica == 1) ? 1 : 0) . ", " .
					"user_lang			= " . $engine->db->q(($user_lang ?: $engine->db->language)) . ", " .
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

			$engine->show_message($engine->_t('UsersAdded'), 'success');
			$engine->log(4, Ut::perc_replace($engine->_t('LogUserCreated', SYSTEM_LANG), $user_name));
			unset($_POST['create']);
		}

		if ($error)
		{
			$engine->show_message($error, 'error');
			$_POST['create']	= 1;
		}
	}
	// approve user processing
	else if (isset($_POST['approve']) && $user_id )
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
	else if (isset($_POST['edit']) && $user_id && (isset($_POST['user_name']) || isset($_POST['moderator_id'])))
	{
		// do we have identical names?
		if ($engine->db->load_single(
			"SELECT user_id " .
			"FROM " . $prefix . "user " .
			"WHERE user_name = " . $engine->db->q($_POST['user_name']) . " " .
				"AND user_id <> " . (int) $_POST['user_id'] . " " .
			"LIMIT 1"))
		{
			$engine->set_message($engine->_t('RegistrationUserNameOwned'));
			$_POST['change']	= (int) $_POST['user_id'];
			$_POST['edit']		= 1;
		}
		else if (!$engine->validate_email($_POST['newemail']))
		{
			$engine->show_message($engine->_t('NotAEmail'));
			$_POST['change']	= (int) $_POST['user_id'];
			$_POST['edit'] 		= 1;
		}
		else
		{
			$engine->db->sql_query(
				"UPDATE " . $prefix . "user SET " .
					"user_name		= " . $engine->db->q($_POST['user_name']) . ", " .
					"email			= " . $engine->db->q($_POST['newemail']) . ", " .
					#"password		= " . $engine->db->q($engine->password_hash(['user_name' => $_POST['user_name']], $password)) . ", " .
					"real_name		= " . $engine->db->q($_POST['newrealname']) . ", " .
					"enabled		= " . (int) ($_POST['enabled'] ?? 0) . ", " .
					"account_status	= " . (int) $_POST['account_status'] . " " .
				"WHERE user_id		= " . (int) $_POST['user_id'] . " " .
				"LIMIT 1");

			$engine->db->sql_query(
				"UPDATE " . $prefix . "user_setting SET " .
					"user_lang		= " . $engine->db->q($_POST['user_lang']) . ", " .
					"theme			= " . $engine->db->q($_POST['theme']) . " " .
				"WHERE user_id		= " . (int) $_POST['user_id'] . " " .
				"LIMIT 1");

			$engine->show_message($engine->_t('UsersUpdated'), 'success');
			$engine->log(4, Ut::perc_replace($engine->_t('LogUserUpdated', SYSTEM_LANG), $user['user_name']));
		}
	}
	// delete user processing
	// TODO: reassign acls, uploads, pages and revisions, delete user page
	else if (isset($_POST['delete']) && ($user_id || $set == true))
	{
		if (array_filter($set) == false && empty($user_id))
		{
			$error = $engine->_t('ModerateNoItemChosen'); // no user selected
			$engine->show_message($error, 'error');
		}
			//(int) $_POST['user_id']
		if ($error != true || !empty($user_id))
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

					// remove user space
					$user_space = $engine->db->users_page . '/' . $user['user_name'];

					$engine->remove_referrers			($user_space, true);
					$engine->remove_links				($user_space, true);
					$engine->remove_category_assigments	($user_space, true);
					$engine->remove_acls				($user_space, true);
					$engine->remove_menu_items			($user_space, true);
					$engine->remove_watches				($user_space, true);
					$engine->remove_ratings				($user_space, true);
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
		echo '<table class="formation lined">' .
				'<tr>
					<th class="label">
						<label for="user_name">' . $engine->_t('UserName') . '</label>' .
					'</th>
					<td>
						<input type="text" id="user_name" name="user_name" value="' . Ut::html(($_POST['user_name'] ?? '')) . '" pattern="' . $engine->language['USER_NAME'] . '" size="20" minlength="' . $engine->db->username_chars_min . '" maxlength="' . $engine->db->username_chars_max . '" required>
						<p>' . Ut::perc_replace($engine->_t($engine->db->disable_wikiname? 'NameAlphanumOnly' : 'NameCamelCaseOnly'), $engine->db->username_chars_min, $engine->db->username_chars_max) . '</p>
					</td>
				</tr>' .
				/* '<tr>
					<th class="label">
						<label for="newrealname">' . $engine->_t('RealName') . '</label>' .
					'</th>
					<td>
						<input type="text" id="newrealname" name="newrealname" value="' . Ut::html(($_POST['newrealname'] ?? '')) . '" size="20" maxlength="100">
					</td>
				</tr>' . */

				'<tr>
					<th class="label">
						<label for="password">' . $engine->_t('RegistrationPassword') . '</label>' .
					'</th>
					<td>
						<input type="password" id="password" name="password" size="24" minlength="' . $engine->db->pwd_min_chars . '" value="' . Ut::html(($_POST['password'] ?? '')) . '" autocomplete="off" required>
					</td>
				</tr>' .
				'<tr>
					<th class="label">
						<label for="conf_password">' . $engine->_t('ConfirmPassword') . '</label>' .
					'</th>
					<td>
						<input type="password" id="conf_password" name="conf_password" size="24"  minlength="' . $engine->db->pwd_min_chars . '" value="' . Ut::html(($_POST['conf_password'] ?? '')) . '" autocomplete="off" required>
						<p>' . $engine->show_password_complexity() . '</p>
					</td>
				</tr>' .

				'<tr>
					<th class="label">
						<label for="email">' . $engine->_t('Email') . '</label>
					</th>' .
					'<td>
						<input type="email" id="email" name="email" value="' . Ut::html(($_POST['email'] ?? '')) . '" size="50" maxlength="100">
					</td>
				</tr>' .
				'<tr>
					<th class="label">
						<label for="user_lang">' . $engine->_t('YourLanguage') . '</label>
					</th>' .
					'<td>
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
				</tr>' .
				'<tr>
					<th class="label">
						<label for="enabled">' . $engine->_t('UserEnabled') . '</label>
					</th>' .
					'<td>
						<input type="checkbox" id="enabled" name="enabled" value="1" ' . (!isset($_POST['enabled']) ? ' checked' : '') . '>
					</td>
				</tr>' .
				'<tr>
					<th class="label">
						<label>' . $engine->_t('UserAccountNotify') . '</label>
					</th>' .
					'<td>
						<input type="checkbox" id="notify_signup" name="notify_signup" value="1" ' . (!isset($_POST['notify_signup']) ? '' : ' checked') . '>
						<label for="notify_signup">' . $engine->_t('UserNotifySignup') . '</label><br>
						<input type="checkbox" id="verify_email" name="verify_email" value="1" ' . (!isset($_POST['verify_email']) ? '' : ' checked') . '>
						<label for="verify_email">' . $engine->_t('UserVerifyEmail') . '</label>
					</td>
				</tr>' .
				'<tr>
					<td colspan="2">
						<br>
						<input type="submit" id="submit" name="create" value="' . $engine->_t('GroupsSaveButton') . '"> ' .
						'<a href="' . $engine->href() . '" class="btn-link"><input type="button" id="button" value="' . $engine->_t('GroupsCancelButton') . '"></a>' .
					'</td>
				</tr>' .
			'</table><br>';

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

			echo '<input type="hidden" name="user_id" value="' . (int) $user_id . '">' . "\n" .
				'<table class="formation lined">' .
				'<tr>
					<th class="label">
						<label for="user_name">' . Ut::perc_replace($engine->_t('UsersRename'), ' ' . '<code>' . Ut::html($user['user_name']) . '</code>') . ' *</label>
					</th>' .
					'<td>
						<input type="text" id="user_name" name="user_name" value="' . Ut::html(($_POST['user_name'] ?? $user['user_name'])) . '" pattern="' . $engine->language['USER_NAME'] . '" size="20" minlength="' . $engine->db->username_chars_min . '" maxlength="' . $engine->db->username_chars_max . '" required>
					</td>
				</tr>' .
				'<tr>
					<th class="label">
						<label for="newrealname">' . $engine->_t('RealName') . '</label> ' .
					'</th>
					<td>
						<input type="text" id="newrealname" name="newrealname" value="' . Ut::html(($_POST['newrealname'] ?? $user['real_name'])) . '" size="50" maxlength="100">
					</td>' .
				'</tr>' .
				'<tr>
					<th class="label">
						<label for="newemail">' . $engine->_t('Email') . '</label> ' .
					'</th>
					<td>
						<input type="email" id="newemail" name="newemail" value="' . Ut::html(($_POST['newemail'] ?? $user['email'])) . '" size="50" maxlength="100">
					</td>
				</tr>' .
				'<tr>
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
				</tr>' .
				'<tr>
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
				</tr>' .
				'<tr>
					<th class="label">
						<label for="enabled">' . $engine->_t('UserEnabled') . '</label>
					</th>' .
					'<td>
						<input type="checkbox" id="enabled" name="enabled" value="1" ' . (isset($_POST['enabled']) || $user['enabled'] == 1  ? ' checked' : '') . '>
					</td>
				</tr>' .
				'<tr>
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
				</tr>' .
				'<tr>
					<td colspan="2">
						<br>
						<small>' . $engine->_t('UsersRenameInfo') . '</small>' .
						'<br><br>
						<input type="submit" id="submit" name="edit" value="' . $engine->_t('GroupsSaveButton') . '"> ' .
						'<a href="' . $engine->href() . '" class="btn-link"><input type="button" id="button" value="' . $engine->_t('GroupsCancelButton') . '"></a>' .
					'</td>
				</tr>' .
			'</table>
			<br>';

			echo $engine->form_close();
		}
	}
	// delete user form
	else if (isset($_POST['remove']) && (isset($user_id) || $set == true))
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
				'<table class="formation">' .
					'<tr>
						<td>' .
							Ut::perc_replace($engine->_t('UsersDelete'), ' ' . $users) . ' ' .
							'<input type="submit" id="submit" name="delete" value="' . $engine->_t('Remove') . '"> ' .
							'<a href="' . $engine->href() . '" class="btn-link"><input type="button" id="button" value="' . $engine->_t('Cancel') . '"></a><br>' .
							'<small>' . $engine->_t('UsersDeleteInfo') . '</small>' .
						'</td>
					</tr>' .
				'</table>
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

			echo '<tr>' . "\n" .
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
					'<th class="label">' . $engine->_t('ChooseTheme') . '</th>' .
					'<td>' . $user['theme'] . '</td>' .
				'</tr>' .
				'<tr>' . "\n" .
					'<th class="label">' . $engine->_t('UserEnabled') . '</th>' .
					'<td>' . $user['enabled'] . '</td>' .
				'</tr>' .
				'<tr>' . "\n" .
					'<th class="label">' . $engine->_t('AccountStatus') . '</th>' .
					'<td>' . $status[$user['account_status']] . '</td>' .
				'</tr>';
?>
		</table>
		<?php

		/////////////////////////////////////////////
		//   control buttons
		/////////////////////////////////////////////

		echo '<br><input type="submit" id="button" name="edit" value="' . $engine->_t('UserEditButton') . '"> ';
		echo '<input type="submit" id="button" name="remove" value="' . $engine->_t('GroupsRemoveButton') . '"> ';
		echo '<a href="' . $engine->href() . '" class="cancel" ><input type="button" id="button" value="' . $engine->_t('GroupsCancelButton') . '"></a>';
		echo $engine->form_close();
	}
	else
	{
		// defining WHERE and ORDER clauses
		if (!empty($_GET['user']) && mb_strlen($_GET['user']) > 2)
		{
			$where				= "WHERE user_name LIKE " . $engine->db->q('%' . trim($_GET['user']) . '%') . " ";
		}

		// set signuptime ordering
		if ($_order == 'signup_asc')
		{
			$order				= 'ORDER BY signup_time ASC ';
			$signup_time		= 'signup_desc';
		}
		else if ($_order == 'signup_desc')
		{
			$order				= 'ORDER BY signup_time DESC ';
			$signup_time		= 'signup_asc';
		}
		else
		{
			$signup_time		= 'signup_asc';
		}

		// set last_visit ordering
		if ($_order == 'last_visit_asc')
		{
			$order				= 'ORDER BY last_visit ASC ';
			$last_visit			= 'last_visit_desc';
		}
		else if ($_order == 'last_visit_desc')
		{
			$order				= 'ORDER BY last_visit DESC ';
			$last_visit			= 'last_visit_asc';
		}
		else
		{
			$last_visit			= 'last_visit_asc';
		}

		// set total_pages ordering
		if ($_order == 'total_pages_asc')
		{
			$order				= 'ORDER BY total_pages ASC ';
			$order_pages		= 'total_pages_desc';
		}
		else if ($_order == 'total_pages_desc')
		{
			$order				= 'ORDER BY total_pages DESC ';
			$order_pages		= 'total_pages_asc';
		}
		else
		{
			$order_pages		= 'total_pages_asc';
		}

		// set total_comments ordering
		if ($_order == 'total_comments_asc')
		{
			$order				= 'ORDER BY total_comments ASC ';
			$order_comments		= 'total_comments_desc';
		}
		else if ($_order == 'total_comments_desc')
		{
			$order				= 'ORDER BY total_comments DESC ';
			$order_comments		= 'total_comments_asc';
		}
		else
		{
			$order_comments	= 'total_comments_asc';
		}

		// set total_revisions ordering
		if ($_order == 'total_revisions_asc')
		{
			$order				= 'ORDER BY total_revisions ASC ';
			$order_revisions	= 'total_revisions_desc';
		}
		else if ($_order == 'total_revisions_desc')
		{
			$order				= 'ORDER BY total_revisions DESC ';
			$order_revisions	= 'total_revisions_asc';
		}
		else
		{
			$order_revisions	= 'total_revisions_asc';
		}

		// set total_uploads ordering
		if ($_order == 'total_uploads_asc')
		{
			$order				= 'ORDER BY total_uploads ASC ';
			$order_uploads		= 'total_uploads_desc';
		}
		else if ($_order == 'total_uploads_desc')
		{
			$order				= 'ORDER BY total_uploads DESC ';
			$order_uploads		= 'total_uploads_asc';
		}
		else
		{
			$order_uploads		= 'total_uploads_asc';
		}

		// set user_name ordering
		if ($_order == 'user_asc')
		{
			$order				= 'ORDER BY user_name DESC ';
			$order_user			= 'user_desc';
		}
		else if ($_order == 'user_desc')
		{
			$order				= 'ORDER BY user_name ASC ';
			$order_user			= 'user_asc';
		}
		else
		{
			$order_user		= 'user_desc';
		}

		// set real_name ordering
		if ($_order == 'name_asc')
		{
			$order				= 'ORDER BY real_name DESC ';
			$order_name			= 'name_desc';
		}
		else if ($_order == 'name_desc')
		{
			$order				= 'ORDER BY real_name ASC ';
			$order_name			= 'name_asc';
		}
		else
		{
			$order_name		= 'name_desc';
		}

		// filter by account_status
		if (isset($_GET['account_status']))
		{
			$where			= "WHERE u.account_status = " . (int) $_GET['account_status'] . " ";
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
			($where ?: '')
			);

		$order_pagination	= !empty($_order) ? ['order' => Ut::html($_order)] : [];
		$pagination			= $engine->pagination($count['n'], $limit, 'p', ['mode' => $module['mode']] + $order_pagination, '', 'admin.php');

		$users = $engine->db->load_all(
			"SELECT u.user_id, u.user_name, u.email, u.total_pages, u.total_comments, u.total_revisions, u.total_uploads, u.enabled, u.account_status, u.signup_time, u.last_visit, s.user_lang " .
			"FROM " . $prefix . "user u " .
				"LEFT JOIN " . $prefix . "user_setting s ON (u.user_id = s.user_id) " .
			($where ?: "") .
			($where ? "AND " : "WHERE ") .
				"u.account_type = 0 " .
			($order ?: 'ORDER BY u.user_id DESC ') .
			$pagination['limit']);

		// user filter form
		$search =	$engine->form_open('search_user', ['form_method' => 'get']) .
					'<input type="hidden" name="mode" value="' . $module['mode'] . '">' .  // required to pass mode module via GET
					$engine->_t('UsersSearch') . ': </td><td>' .
					'<input type="search" name="user" maxchars="40" size="30" value="' . Ut::html(trim(($_GET['user'] ?? ''))) . '"> ' .
					'<input type="submit" id="submit" value="' . $engine->_t('UsersFilter') . '"> ' .
					$engine->form_close();

		echo '<span style="float: right;">' . $search . '</span>';

		echo $engine->form_open('users');

		/////////////////////////////////////////////
		//   control buttons
		/////////////////////////////////////////////

		$control_buttons =	'<br>' .
							'<input type="submit" id="create-button" name="create" value="' . $engine->_t('GroupsAddButton') . '"> ' .
							'<input type="submit" id="edit-button" name="edit" value="' . $engine->_t('UserEditButton') . '"> ' .
							#'<input type="submit" id="approve-button" name="approve" value="' . $engine->_t('Approve') . '"> ' .
							'<input type="submit" id="remove-button" name="remove" value="' . $engine->_t('GroupsRemoveButton') . '"> ' .
							'<input type="hidden" name="ids" value="' . implode('-', $set) . '">' .
							'<br>' . "\n" .
								'<input type="submit" name="set" id="submit" value="' . $engine->_t('ModerateSet') . '"> ' .
								($set
										? '<input type="submit" name="reset" id="submit" value="' . $engine->_t('ModerateReset') . '"> ' .
										'<small>ids: ' . implode(', ', $set) . '</small>'
										: ''
								);



		echo $control_buttons;

		$engine->print_pagination($pagination);
?>
		<table class="formation listcenter lined">
			<colgroup>
				<col span="1" style="width:5px;">
				<col span="1" style="width:5px;">
				<col span="1" style="width:5px;">
				<col span="1" style="width:20px;">
				<col span="1">
				<col span="1" style="width:20px;">
				<col span="1" style="width:20px;">
				<col span="1" style="width:20px;">
				<col span="1" style="width:20px;">
				<col span="1" style="width:20px;">
				<col span="1" style="width:20px;">
				<col span="1" style="width:20px;">
				<col span="1" style="width:20px;">
				<col span="1" style="width:20px;">
			</colgroup>
			<thead>
				<tr>
					<th></th>
					<th></th>
					<th>ID</th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $order_user]); ?>"><?php echo $engine->_t('UsersName');?></a></th>
					<!--<th style="width:150px;"><a href="<?php echo $engine->href('', '', ['order' => $order_name]); ?>"><?php echo $engine->_t('RealName');?></a></th>-->
					<th><?php echo $engine->_t('Email');?></th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $order_pages]); ?>"><?php echo $engine->_t('UsersPages');?></a></th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $order_comments]); ?>"><?php echo $engine->_t('UsersComments');?></a></th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $order_revisions]); ?>"><?php echo $engine->_t('UsersRevisions');?></a></th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $order_uploads]); ?>"><?php echo $engine->_t('UsersUploads');?></a></th>
					<th><?php echo $engine->_t('UserLanguage');?></th>
					<th><?php echo $engine->_t('Enabled');?></th>
					<th><?php echo $engine->_t('AccountStatus'); ?></th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $signup_time]); ?>"><?php echo $engine->_t('UsersSignup');?></a></th>
					<th><a href="<?php echo $engine->href('', '', ['order' => $last_visit]); ?>"><?php echo $engine->_t('UsersLastSession');?></a></th>
				</tr>
			<thead>
			<tbody>
<?php
		if ($users)
		{
			foreach ($users as $row)
			{
				echo '<tr>' . "\n" .
						'<td class="label a-middle" style="width:10px;">
							<input type="checkbox" name="' . $row['user_id'] . '" value="id" ' . ( in_array($row['user_id'], $set) ? ' checked' : '') . '/>
						</td>' .
						'<td>
							<input type="radio" name="user_id" value="' . $row['user_id'] . '">
						</td>' .
						'<td>' . $row['user_id'] . '</td>' .
						'<td style="padding-left:5px; padding-right:5px;"><strong><a href="' . $engine->href('', '', ['user_id' => $row['user_id']]) . '">' . $row['user_name'] . '</a></strong></td>' .
						#'<td style="padding-left:5px; padding-right:5px;">' . $row['real_name'] . '</td>' .
						'<td>' . $row['email'] . '</td>' .
						'<td>' . $row['total_pages'] . '</td>' .
						'<td>' . $row['total_comments'] . '</td>' .
						'<td>' . $row['total_revisions'] . '</td>' .
						'<td>' . $row['total_uploads'] . '</td>' .
						'<td><small><a href="' . $engine->href('', '', ['user_lang' => $row['user_lang']]) . '">' . $row['user_lang'] . '</a></small></td>' .
						'<td>' . $row['enabled'] . '</td>' .
						'<td><a href="' . $engine->href('', '', ['account_status' => $row['account_status']]) . '">' . $status[$row['account_status']] . '</a></td>' .
						'<td><small>' . $engine->get_time_formatted($row['signup_time']) . '</small></td>' .
						'<td><small>' . $engine->get_time_formatted($row['last_visit']) . '</small></td>' .
					'</tr>';
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

