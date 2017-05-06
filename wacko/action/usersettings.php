<?php

if (!defined('IN_WACKO'))
{
	exit;
}

echo "<!--notypo-->\n";
$include_tail = "<!--/notypo-->\n";

// reconnect securely in tls mode
$this->http->ensure_tls($this->href());

// hide article H1 header
$this->hide_article_header = true;

// email confirmation
if (isset($_GET['confirm']))
{
	$this->user_email_confirm_check($_GET['confirm']);
}
else if (@$_GET['action'] === 'logout')
{
	$this->log_user_out();
	$this->show_must_go_on();
}
else if (($user = $this->get_user()))
{
	$email_changed	= false;
	$user			= $this->load_user(0, $user['user_id']);
	$this->set_page_lang($this->user_lang);
	$action			= @$_POST['_action']; // set by form_open
	$email			= @$_POST['email'];
	$resend_code	= @$_GET['resend_code'];

	// is user trying to update?
	if ($action == 'user_settings_general')
	{
		$error = '';

		// no email given
		if (!$email)
		{
			$error = $this->_t('SpecifyEmail');
		}
		// invalid email
		else if (!$this->validate_email($email))
		{
			$error = $this->_t('NotAEmail');
		}

		// check for errors and store
		if ($error)
		{
			$this->set_message($error, 'error');
			$this->set_message($this->_t('SettingsNotStored'));
		}
		else
		{
			$email_changed = ($user['email'] != $email);

			// store if email hasn't been changed otherwise request authorization
			if ($email_changed || isset($_POST['real_name']))
			{
				// update users table
				$this->db->sql_query(
					"UPDATE " . $this->db->user_table . " SET " .
						"real_name		= " . $this->db->q(trim($_POST['real_name'])) . ", " .
						"email			= " . $this->db->q($email) . " " .
					"WHERE user_id = '" . $user['user_id'] . "' " .
					"LIMIT 1");

				// log event
				// $this->log(6, str_replace('%1', $user['user_name'], $this->_t('LogUserSettingsUpdate', SYSTEM_LANG)));
			}
		}
	}

	// update changed user settings
	if ($action == 'user_settings_extended')
	{
		$sql =
		"doubleclick_edit	= '" . (int) isset($_POST['doubleclick_edit']) . "', " .
		"show_comments		= '" . (int) isset($_POST['show_comments']) . "', " .
		"show_spaces		= '" . (int) isset($_POST['show_spaces']) . "', " .
		// "typografica		= '" . (int) isset($_POST['typografica']) . "', " .
		"autocomplete		= '" . (int) isset($_POST['autocomplete']) . "', " .
		"numerate_links		= '" . (int) isset($_POST['numerate_links']) . "', " .
		"dont_redirect		= '" . (int) isset($_POST['dont_redirect']) . "', " .
		"show_files			= '" . (int) isset($_POST['show_files']) . "', " .
		"hide_lastsession	= '" . (int) isset($_POST['hide_lastsession']) . "', " .
		"validate_ip		= '" . (int) isset($_POST['validate_ip']) . "', " .
		"noid_pubs			= '" . (int) isset($_POST['noid_pubs']) . "', " .
		"session_length		= '" . (int) @$_POST['session_length'] . "' "; // @ to normalize possible discrepancy
	}
	else if	($action == 'user_settings_notifications')
	{
		$sql =
		"send_watchmail		= '" . (int) isset($_POST['send_watchmail']) . "', " .
		"allow_intercom		= '" . (int) isset($_POST['allow_intercom']) . "', " .
		"notify_minor_edit	= '" . (int) isset($_POST['notify_minor_edit']) . "', " .
		"notify_page		= '" . (int) @$_POST['notify_page'] . "', ".		// @ to notify possible discrepancy
		"notify_comment		= '" . (int) @$_POST['notify_comment'] . "', ".	// @ to notify possible discrepancy
		"allow_massemail	= '" . (int) isset($_POST['allow_massemail']) . "' ";
	}
	else if	($action == 'user_settings_general')
	{
		$sql =
		"user_lang			= " . $this->db->q($_POST['user_lang']) . ", " .
		"theme				= " . $this->db->q($_POST['theme']) . ", " .
		"timezone			= '" . (float) $_POST['timezone'] . "', " .
		"dst				= '" . (int) $_POST['dst'] . "', " .
		"sorting_comments	= '" . (int) $_POST['sorting_comments'] . "', " .
		"menu_items			= '" . (int) $_POST['menu_items'] . "', " .
		"list_count			= '" . (int) $_POST['list_count'] . "' " ;
	}
	else
	{
		$sql = '';
	}

	if ($sql)
	{
		// update user_setting table
		$this->db->sql_query(
			"UPDATE " . $this->db->table_prefix . "user_setting SET " .
				$sql.
			"WHERE user_id = '" . (int) $user['user_id'] . "' " .
			"LIMIT 1");

		// log event
		$this->log(6, Ut::perc_replace($this->_t('LogUserSettingsUpdate', SYSTEM_LANG), $user['user_name']));
	}

	// (re)send email confirmation code
	if ($this->db->enable_email && ($resend_code || $email_changed))
	{
		if ($resend_code)
		{
			$email = $user['email'];
		}

		if ($email)
		{
			$save		=	$this->set_language($user['user_lang'], true);
			$subject	=	$this->_t('EmailConfirm');
			$body		=	Ut::perc_replace($this->_t('EmailVerify'),
								$this->db->site_name,
								$user['user_name'],
								$this->user_email_confirm($user['user_id'])) . "\n\n";

			$user['email'] = $email;
			$this->send_user_email($user, $subject, $body);
			$this->set_language($save, true);

			$message = $this->_t('SettingsCodeResent');
		}
		else
		{
			$message = $this->_t('SettingsCodeNotSent');
		}

		$this->set_message($message, 'success');
	}

	// reload user data
	if ($sql || $resend_code)
	{
		$user = $this->load_user(0, $user['user_id']);
		$this->set_user($user);

		$this->set_message($this->_t('UserSettingsStored', @$_POST['user_lang']), 'success');

		// forward
		if ($action == 'user_settings_extended')
		{
			$tab = 'extended';
		}
		else if ($action == 'user_settings_notifications')
		{
			$tab = 'notification';
		}
		else
		{
			$tab = '';
		}

		$this->http->redirect($this->href('', '', $tab));
	}

	// MENU
	if (isset($_GET['menu']) || isset($_POST['_user_menu']))
	{
		echo '<h3>' . $this->_t('UserSettings') . ' &raquo; ' . $this->_t('Bookmarks') . "</h3>\n";
		echo '<ul class="menu">
				<li><a href="' . $this->href('', '', '') . '">' . $this->_t('UserSettingsGeneral') . '</a></li>
				<li class="active">' . $this->_t('Bookmarks') . '</li>
				<li><a href="' . $this->href('', '', 'notification') . '">' . $this->_t('UserSettingsNotifications') . '</a></li>
				<li><a href="' . $this->href('', '', 'extended') . '">' . $this->_t('UserSettingsExtended') . "</a></li>
			</ul><br /><br />\n";
		echo $this->action('menu', ['redirect' => 1]);
	}
	// NOTIFICATIONS
	else if (isset($_GET['notification']) || $action == 'user_settings_notifications')
	{
		echo '<h3>' . $this->_t('UserSettings') . ' &raquo; ' . $this->_t('UserSettingsNotifications') . "</h3>\n";
		echo '<ul class="menu">
				<li><a href="' . $this->href('', '', '') . '">' . $this->_t('UserSettingsGeneral') . '</a></li>
				<li><a href="' . $this->href('', '', 'menu') . '">' . $this->_t('Bookmarks') . '</a></li>
				<li class="active">' . $this->_t('UserSettingsNotifications') . '</li>
				<li><a href="' . $this->href('', '', 'extended') . '">' . $this->_t('UserSettingsExtended') . "</a></li>
			</ul><br /><br />\n";
		echo $this->form_open('user_settings_notifications');
		?>
		<div class="page_settings">
		<table class="form_tbl lined">
			<colgroup>
				<col span="1" width="30%">
				<col span="1" width="70%">
			</colgroup>
		<tbody>
		<?php
		if ($this->db->enable_email && $this->db->enable_email_notification)
		{
		?>
			<tr>
				<th><?php echo $this->_t('UserSettingsEmailMe');?>&nbsp;</th>
				<td>
					<input type="checkbox" id="send_watchmail" name="send_watchmail" <?php echo $user['send_watchmail']? 'checked' : '' ?> />
					<label for="send_watchmail"><?php echo $this->_t('SendWatchEmail');?></label>
				</td>
			</tr>

		<tr>
			<th>
				<label for="notify_page"><?php echo $this->_t('NotifyPageEdit');?></label>
			</th>
			<td>
			<?php
				echo '<input type="radio" id="notify_page0" name="notify_page" value="0"' . ($user['notify_page'] == 0 ? ' checked' : '') . '/><label for="notify_page0">' . $this->_t('NotifyOff') . '</label>';
				echo '<input type="radio" id="notify_page1" name="notify_page" value="1"' . ($user['notify_page'] == 1 ? ' checked' : '') . '/><label for="notify_page1">' . $this->_t('NotifyAlways') . '</label>';
				echo '<input type="radio" id="notify_page2" name="notify_page" value="2"' . ($user['notify_page'] == 2 ? ' checked' : '') . '/><label for="notify_page2" title="' . $this->_t('NotifyPendingPageTip') .
					' ' . $this->_t('NotifyPendingTip') . '">' . $this->_t('NotifyPending') . '</label>';
				// echo '<input type="radio" id="notify_page3" name="notify_page" value="3" ' . ($user['notify_page'] == 3 ? 'checked' : '') . '/><label for="notify_page3">' . $this->_t('NotifyDigest') . '</label>';
			?>
			</td>
		</tr>
		<tr>
			<th>
				<label for="notify_comment"><?php echo $this->_t('NotifyComment');?></label>
			</th>
			<td>
<?php
				echo '<input type="radio" id="notify_comment0" name="notify_comment" value="0"' . ($user['notify_comment'] == 0 ? ' checked' : '') . '/><label for="notify_comment0">' . $this->_t('NotifyOff') . '</label>';
				echo '<input type="radio" id="notify_comment1" name="notify_comment" value="1"' . ($user['notify_comment'] == 1 ? ' checked' : '') . '/><label for="notify_comment1">' . $this->_t('NotifyAlways') . '</label>';
				echo '<input type="radio" id="notify_comment2" name="notify_comment" value="2"' . ($user['notify_comment'] == 2 ? ' checked' : '') . '/><label for="notify_comment2" title="' . $this->_t('NotifyPendingCommentTip') .
					' ' . $this->_t('NotifyPendingTip') . '">' . $this->_t('NotifyPending') . '</label>';
				// echo '<input type="radio" id="notify_comment3" name="notify_comment" value="3" ' . ($user['notify_comment'] == 3 ? 'checked' : '') . '/><label for="notify_comment3">' . $this->_t('NotifyDigest') . '</label>';
?>
			</td>
		</tr>
<?php
			// minor edit
			if ($this->page && $this->db->minor_edit != 0)
			{
?>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type="checkbox" id="notify_minor_edit" name="notify_minor_edit" <?php echo $user['notify_minor_edit']? 'checked' : '' ?> />
				<label for="notify_minor_edit"><?php echo $this->_t('NotifyMinorEdit');?></label>
			</td>
		</tr>
		<?php }?>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type="checkbox" id="allow_intercom" name="allow_intercom" <?php echo $user['allow_intercom']? 'checked' : '' ?> />
				<label for="allow_intercom"><?php echo $this->_t('AllowIntercom');?></label>
			</td>
		</tr>
	<?php	}?>

		<tr>
			<td>&nbsp;</td>
			<td>
				<input type="checkbox" id="allow_massemail" name="allow_massemail" <?php echo $user['allow_massemail']? 'checked' : '' ?> />
				<label for="allow_massemail"><?php echo $this->_t('AllowMassemail');?></label>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type="submit" class="OkBtn" id="submit" name="submit" value="<?php echo $this->_t('UpdateSettingsButton'); ?>" />
			</td>
		</tr>
	</tbody>
</table>
</div>
<?php
		echo $this->form_close();
	}
	// EXTENDED
	else if (isset($_GET['extended']) || $action == 'user_settings_extended')
	{
		echo '<h3>' . $this->_t('UserSettings') . ' &raquo; ' . $this->_t('UserSettingsExtended') . "</h3>\n";
		echo '<ul class="menu">
				<li><a href="' . $this->href('', '', '') . '">' . $this->_t('UserSettingsGeneral') . '</a></li>
				<li><a href="' . $this->href('', '', 'menu') . '">' . $this->_t('Bookmarks') . '</a></li>
				<li><a href="' . $this->href('', '', 'notification') . '">' . $this->_t('UserSettingsNotifications') . '</a></li>
				<li class="active">' . $this->_t('UserSettingsExtended') . "</li>
			</ul><br /><br />\n";
		echo $this->form_open('user_settings_extended');
?>
		<div class="page_settings">
		<table class="form_tbl lined">
			<colgroup>
				<col span="1" width="30%">
				<col span="1" width="70%">
			</colgroup>
		<tbody>
			<tr>
				<th scope="row"><?php echo $this->_t('UserSettingsOther');?></th>
				<td>
					<input type="checkbox" id="doubleclick_edit" name="doubleclick_edit" <?php echo $user['doubleclick_edit']? 'checked' : '' ?> />
					<label for="doubleclick_edit"><?php echo $this->_t('DoubleclickEditing');?></label>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="checkbox" id="autocomplete" name="autocomplete" <?php echo $user['autocomplete']? 'checked' : '' ?> />
					<label for="autocomplete"><?php echo $this->_t('WikieditAutocomplete');?></label>
				</td>
			</tr>
				<tr>
				<td>&nbsp;</td>
				<td>
					<input type="checkbox" id="numerate_links" name="numerate_links" <?php echo $user['numerate_links']? 'checked' : '' ?> />
					<label for="numerate_links"><?php echo $this->_t('NumerateLinks');?></label>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="checkbox" id="show_comments" name="show_comments" <?php echo $user['show_comments']? 'checked' : '' ?> />
					<label for="show_comments"><?php echo $this->_t('DoShowComments');?></label>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="checkbox" id="show_files" name="show_files" <?php echo $user['show_files']? 'checked' : '' ?> />
					<label for="show_files"><?php echo $this->_t('DoShowFiles');?></label>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="checkbox" id="show_spaces" name="show_spaces" <?php echo $user['show_spaces']? 'checked' : '' ?> />
					<label for="show_spaces"><?php echo $this->_t('ShowSpaces');?></label>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="checkbox" id="dont_redirect" name="dont_redirect" <?php echo $user['dont_redirect']? 'checked' : '' ?> />
					<label for="dont_redirect"><?php echo $this->_t('DontRedirect');?></label>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="checkbox" name="validate_ip" id="validate_ip" <?php echo $user['validate_ip']? 'checked' : '' ?> />
					<label for="validate_ip"><?php echo $this->_t('ValidateIP');?></label>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="checkbox" name="hide_lastsession" id="hide_lastsession" <?php echo $user['hide_lastsession']? 'checked' : '' ?> />
					<label for="hide_lastsession"><?php echo $this->_t('HideLastSession');?></label>
				</td>
			</tr>
<?php
		if ($this->db->publish_anonymously)
		{
?>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="checkbox" name="noid_pubs" id="noid_pubs" <?php echo $user['noid_pubs']? 'checked' : '' ?> />
					<label for="noid_pubs"><?php echo $this->_t('ProfileAnonymousPub');?></label>
				</td>
			</tr>
<?php
		}
?>
			<tr>
				<th><label for="session_length"><?php echo $this->_t('SessionDuration');?></label></th>
				<td>
<?php
			echo '<input type="radio" id="duration0" name="session_length" value="0"' . ($user['session_length'] == 0 ? ' checked' : '') . '/><label for="duration0">' . $this->_t('SessionDurationSession') . '</label>';
			echo '<input type="radio" id="duration1" name="session_length" value="1"' . ($user['session_length'] == 1 ? ' checked' : '') . '/><label for="duration1">' . $this->_t('SessionDurationDay') . '</label>';
			echo '<input type="radio" id="duration7" name="session_length" value="7"' . ($user['session_length'] == 7 ? ' checked' : '') . '/><label for="duration7">' . $this->_t('SessionDurationWeek') . '</label>';
			echo '<input type="radio" id="duration30" name="session_length" value="30"' . ($user['session_length'] == 30 ? ' checked' : '') . '/><label for="duration30">' . $this->_t('SessionDurationMonth') . '</label>';
?>
				</td>
			</tr>
			<!--<tr>
				<td>&nbsp;</td>
				<td>
					<input type="checkbox" id="typografica" name="typografica" <?php echo (isset($user['typografica']) && $user['typografica'] == 1) ? 'checked' : ''; ?> />
					<label for="typografica"><?php echo $this->_t('Typografica');?></label>
				</td>
			</tr>-->
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="submit" class="OkBtn" id="submit" name="submit" value="<?php echo $this->_t('UpdateSettingsButton'); ?>" />
				</td>
				</tr>
				</tbody>
			</table>
		</div>
<?php
		echo $this->form_close();

	}
	// GENERAL
	else
	{
		// user is logged in, display config form
		echo $this->form_open('user_settings_general');

		$code = $this->db->load_single(
			"SELECT email_confirm " .
			"FROM " . $this->db->user_table . " " .
			"WHERE user_id = '" . (int) $user['user_id'] . "' " .
			"LIMIT 1");

		echo '<h3>' . $this->_t('UserSettings') . ' &raquo; ' . $this->_t('UserSettingsGeneral') . "</h3>\n";
		echo '<ul class="menu">
				<li class="active">' . $this->_t('UserSettingsGeneral') . '</li>
				<li><a href="' . $this->href('', '', 'menu') . '">' . $this->_t('Bookmarks') . '</a></li>
				<li><a href="' . $this->href('', '', 'notification') . '">' . $this->_t('UserSettingsNotifications') . '</a></li>
				<li><a href="' . $this->href('', '', 'extended') . '">' . $this->_t('UserSettingsExtended') . "</a></li>
			</ul><br /><br />\n";
?>
<div class="page_settings">

<table class="form_tbl lined">
	<colgroup>
		<col span="1" width="30%">
		<col span="1" width="70%">
	</colgroup>
<tbody>
	<tr>
		<th scope="row">
			<?php echo $this->_t('UserName');?>
		</th>
		<td>
			<strong><?php echo $this->user_link($user['user_name'], '', true, false);?></strong>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="real_name"><?php echo $this->_t('RealName');?></label>
		</th>
		<td>
			<input type="text" id="real_name" name="real_name" value="<?php echo htmlentities($user['real_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) ?>" size="40" maxlength="80"/>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<a href="<?php echo $this->href('', 'Password')?>"><?php echo $this->_t('YouWantChangePassword');?></a>
		</th>
		<td>
			<a href="<?php echo $this->href('', 'password');?>" class="btn_link"><input type="button" id="button" value="<?php echo $this->_t('YouWantChangePassword');?>" name="_password"/></a>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="email"><?php echo $this->_t('EmailAddress');?></label>
		</th>
		<td>
			<input type="email" id="email" name="email" value="<?php echo htmlentities($user['email'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) ?>" size="40" />&nbsp;
<?php echo !$user['email_confirm']
		? '<img src="' . $this->db->base_url . Ut::join_path(IMAGE_DIR, 'spacer.png') . '" alt="' . $this->_t('EmailConfirmed') . '" title="' . $this->_t('EmailConfirmed') . '" class="btn-tick"/>'
		: '<img src="' . $this->db->base_url . Ut::join_path(IMAGE_DIR, 'spacer.png') . '" alt="' . $this->_t('EmailConfirm') . '" title="' . $this->_t('EmailConfirm') . '" class="btn-warning"/>' ?>
<?php
		if (!$user['email'] || $code['email_confirm'])
		{
			echo '<div class="hint"><strong class="cite">' .
				$this->_t('EmailNotVerified') . '</strong><br />' .
				'<small>' . $this->_t('EmailNotVerifiedDesc') .
				'<strong><a href="' . $this->href('', '', 'resend_code=1') . '">' . $this->_t('HereLink') . '</a></strong>.
				</small></div>';
		}
?></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<th scope="row">
			<label for="user_lang"><?php echo $this->_t('YourLanguage');?></label>
		</th>
		<td>
			<select id="user_lang" name="user_lang">
<?php

	$languages = $this->_t('LanguageArray');

	if ($this->db->multilanguage)
	{
		$langs = $this->available_languages();
	}
	else
	{
		$langs = [$this->db->language];
	}

	foreach ($langs as $lang)
	{
		echo '<option value="' . $lang . '"' .
			($user['user_lang'] == $lang
				? ' selected '
				: (!isset($user['user_lang']) && $this->db->language == $lang
					? ' selected'
					: '')
			) . '>' . $languages[$lang] . ' (' . $lang . ")</option>\n";
	}
?>
			</select>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="theme"><?php echo $this->_t('ChooseTheme');?></label>
		</th>
		<td>
			<select id="theme" name="theme">

<?php
	$themes = $this->available_themes();

	foreach ($themes as $theme)
	{
		echo '<option value="' . $theme . '"' .
			(isset($user['theme']) && $user['theme'] == $theme
				? ' selected '
				: ($this->db->theme == $theme
					? ' selected'
					: '')
			) . '>' . $theme . "</option>\n";
	}
?>
			</select>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="timezone"><?php echo $this->_t('Timezone');?></label>
		</th>
		<td>
			<select id="timezone" name="timezone">

<?php
	$timezones = $this->_t('TzZoneArray');

	foreach ($timezones as $offset => $timezone)
	{
		if (strlen($timezone) > 50)
		{
			$timezone = substr($timezone, 0, 45 ) . '...';
		}

		echo '<option value="' . $offset . '"' .
			(isset($user['timezone']) && $user['timezone'] == $offset
				? ' selected'
				: ($this->db->timezone == $offset && !isset($user['timezone'])
					? ' selected'
					: '')
			) . '>' . $timezone . "</option>\n";
	}
?>
			</select>
		</td>
	</tr>
	<tr>
		<th>
			<label for="dst"><?php echo $this->_t('DST');?></label>
		</th>
		<td>
<?php
			echo '<input type="radio" id="dst0" name="dst" value="0"' . ($user['dst'] == 0 ? ' checked' : '') . '/><label for="dst0">' . $this->_t('MetaOff') . '</label>';
			echo '<input type="radio" id="dst1" name="dst" value="1"' . ($user['dst'] == 1 ? ' checked' : '') . '/><label for="dst1">' . $this->_t('MetaOn') . '</label>';
?>
		</td>
	</tr>
	<tr>
		<th>
			<label for="sorting_comments"><?php echo $this->_t('SortComment');?></label>
		</th>
		<td>
			<select id="sorting_comments" name="sorting_comments">
				<option value="0"<?php echo ($user['sorting_comments']  == 0  ? ' selected' : '');?>><?php echo $this->_t('SortCommentAsc');?></option>
				<option value="1"<?php echo ($user['sorting_comments']  == 1  ? ' selected' : '');?>><?php echo $this->_t('SortCommentDesc');?></option>
			</select>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="menu_items"><?php echo $this->_t('MenuItemsShown');?></label></th>
		<td><input type="number" id="menu_items" name="menu_items" value="<?php echo $user['menu_items'] ?>" size="40" min="0" max="20" /></td>
	</tr>
	<tr>
		<th scope="row">
			<label for="list_count"><?php echo $this->_t('RecordsPerPage');?></label>
		</th>
		<td>
			<select id="list_count" name="list_count">
				<option value="10"<?php echo ($user['list_count']  == 10  ? ' selected' : '');?>>10</option>
				<option value="20"<?php echo ($user['list_count']  == 20  ? ' selected' : '');?>>20</option>
				<option value="30"<?php echo ($user['list_count']  == 30  ? ' selected' : '');?>>30</option>
				<option value="50"<?php echo ($user['list_count']  == 50  ? ' selected' : '');?>>50</option>
				<option value="100"<?php echo ($user['list_count'] == 100 ? ' selected' : '');?>>100</option>
			</select>
		</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input type="submit" class="OkBtn" id="submit" name="submit" value="<?php echo $this->_t('UpdateSettingsButton'); ?>" />
			&nbsp;
			<a href="<?php echo $this->href('', '', 'action=logout');?>" class="btn_link"><input type="button" class="CancelBtn" id="logout" name="logout" value="<?php echo $this->_t('LogoutButton'); ?>" /></a>
		</td>
	</tr>
	</tbody>
</table>
</div>
<br />
<?php
	//  echo $this->format_t('SeeListOfPages') . "<br />";
	echo $this->form_close();

	$percentage = 0 . '%';

	if ($this->db->upload_quota_per_user)
	{
		$percentage =  round(($this->upload_quota($user['user_id']) / (($this->db->upload_quota_per_user) / 100)) ) . '%';
	}

	echo '<aside class="page_tools">' . "\n" .
			'<table class="form_tbl lined">' . "\n" .
				'<tr>' .
					'<th scope="row">' . $this->_t('UserSpace') . "</th>" .
					'<td>' . '<a href="' . $this->href('', ($this->db->users_page . '/' . $user['user_name'])) . '">' . $this->db->users_page . '/' . $user['user_name'] . '</a></td>' .
				"</tr>\n" . '<tr>' .
					'<th scope="row">' . $this->_t('UsersSignup') . '</th>' .
					'<td>' . $this->get_time_formatted($user['signup_time']) . '</td>' .
				"</tr>\n" . '<tr>' .
					'<th scope="row">' . $this->_t('UsersLastSession') . '</th>' .
					'<td>' . $this->get_time_formatted($user['last_visit']) . '</td>' .
				"</tr>\n" . '<tr>' .
					'<th scope="row">' . $this->_t('UploadQuota') . '&nbsp;&nbsp;</th>' .
					'<td title="' . $this->_t('UploadQuotaTip') . '"><div class="meter"><span style="width: 25%;">' . $this->binary_multiples($this->upload_quota($user['user_id']), false, true, true) . ' (' . $percentage . ')</span></div></td>' .
				"</tr>\n" . '<tr>' .
					'<th scope="row">' . $this->_t('UsersPages') . "</th>" .
					'<td><a href="' . $this->href('', $this->db->users_page, 'profile=' . $user['user_name'], '', 'pages') . '" title="' . $this->_t('RevisionTip') . '">' . (int) $user['total_pages'] . '</a></td>' .
				// "</tr>\n" . '<tr>' .
					// '<th scope="row">' . $this->_t('UsersRevisions') . "</th>" .
					// '<td><a href="' . $this->href('', $this->db->users_page, 'profile=' . $user['user_name']) . '" title="' . $this->_t('RevisionTip') . '">' . (int) $user['total_revisions'] . '</a></td>' .
				"</tr>\n" . '<tr>' .
					'<th scope="row">' . $this->_t('UsersComments') . '</th>' .
					'<td><a href="' . $this->href('', $this->db->users_page, 'profile=' . $user['user_name'], '', 'comments') . '" title="' . $this->_t('ShowComments') . '">' . $user['total_comments'] . '</a></td>' .
				"</tr>\n" . '<tr>' .
					'<th scope="row">' . $this->_t('UsersUploads') . '</th>' .
					'<td><a href="' . $this->href('', $this->db->users_page, 'profile=' . $user['user_name'], '', 'uploads') . '" title="' . $this->_t('ShowComments') . '">' . number_format($user['total_uploads'], 0, ',', '.') . '</a></td>' .
				// "</tr>\n" . '<tr>' .
				// 	'<th scope="row">' . $this->_t('UsersLogins') . "</th>" .
				// 	'<td>' . number_format($user['login_count'], 0, ',', '.') . "</td>" .
				"</tr>\n" .
			"</table>\n" .
		"</aside>\n";
	}
}
else
{
	// user is not logged in
	$this->login_page();
}
