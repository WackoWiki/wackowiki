<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<!--notypo-->
<?php

// reconnect securely in tls mode
$this->http->ensure_tls($this->href());

// hide article H1 header
$this->hide_article_header = true;

// email confirmation
if (isset($_GET['confirm']))
{
	$hash = hash('sha256', $_GET['confirm'] . hash('sha256', $this->config['system_seed']));

	if ($temp = $this->load_single(
			"SELECT user_name, email, email_confirm ".
			"FROM ".$this->config['user_table']." ".
			"WHERE email_confirm = '".quote($this->dblink, $hash)."' ".
			"LIMIT 1"))
	{
		$this->sql_query(
			"UPDATE ".$this->config['user_table']." SET ".
				"email_confirm = '' ".
			"WHERE email_confirm = '".quote($this->dblink, $hash)."'");

		$this->show_message($this->get_translation('EmailConfirmed'));

		// log event
		$this->log(4, Ut::perc_replace($this->get_translation('LogUserEmailActivated', $this->config['language']), $temp['email'], $temp['user_name']));

		// TODO: reset user (session data)
		// $this->set_user($this->load_user(0, $user['user_id'], 0, true), 1);
	}
	else
	{
		$this->show_message(Ut::perc_replace($this->get_translation('EmailNotConfirmed'), $this->compose_link_to_page('Settings', '', $this->get_translation('SettingsText'), 0)));
	}
}
else if (isset($_GET['action']) && $_GET['action'] == 'logout')
{
	$this->log_user_out();
	$this->set_menu(MENU_DEFAULT);
	$this->set_message($this->get_translation('LoggedOut')); // // TODO: message is reset with session before it it can display the message set after the redirect
	$this->redirect($this->href());
}
else if ($user = $this->get_user())
{
	$email_changed	= false;
	$user = $this->load_user(0, $user['user_id'], 0, false);
	$this->set_page_lang($this->user_lang);
	$action = @$_POST['action'];
	$email = @$_POST['email'];
	$resend_code = @$_GET['resend_code'];

	// is user trying to update?
	if ($action == 'update_general')
	{
		$error = '';
		// no email given
		if (!$email)
		{
			$error = $this->get_translation('SpecifyEmail');
		}
		// invalid email
		else if (!$this->validate_email($email))
		{
			$error = $this->get_translation('NotAEmail');
		}

		// check for errors and store
		if ($error)
		{
			$this->set_message($error, 'error');
			$this->set_message($this->get_translation('SettingsNotStored'));
		}
		else
		{
			$email_changed = ($user['email'] != $email);

			// store if email hasn't been changed otherwise request authorization
			if ($email_changed || isset($_POST['real_name']))
			{
				// update users table
				$this->sql_query(
					"UPDATE ".$this->config['user_table']." SET ".
						"real_name			= '".quote($this->dblink, trim($_POST['real_name']))."', ".
						"email				= '".quote($this->dblink, $email)."' ".
					"WHERE user_id = '".$user['user_id']."' ".
					"LIMIT 1");

				// log event
				// $this->log(6, str_replace('%1', $user['user_name'], $this->get_translation('LogUserSettingsUpdate', $this->config['language'])));
			}
		}
	}

	if ($action == 'update_extended')
	{
		$sql =
		"doubleclick_edit	= '".(int)$_POST['doubleclick_edit']."', ".
		"show_comments		= '".(int)$_POST['show_comments']."', ".
		"show_spaces		= '".(int)$_POST['show_spaces']."', ".
		// "typografica		= '".(int)$_POST['typografica']."', ".
		"autocomplete		= '".(int)$_POST['autocomplete']."', ".
		"numerate_links		= '".(int)$_POST['numerate_links']."', ".
		"dont_redirect		= '".(int)$_POST['dont_redirect']."', ".
		"show_files			= '".(int)$_POST['show_files']."', ".
		"hide_lastsession	= '".(int)$_POST['hide_lastsession']."', ".
		"validate_ip		= '".(int)$_POST['validate_ip']."', ".
		"noid_pubs			= '".(int)$_POST['noid_pubs']."', ".
		"session_length		= '".(int)$_POST['session_length']."' ";
	}
	else if	($action == 'update_notifications')
	{
		$sql =
		"send_watchmail		= '".(int)$_POST['send_watchmail']."', ".
		"allow_intercom		= '".(int)$_POST['allow_intercom']."', ".
		"notify_minor_edit	= '".(int)$_POST['notify_minor_edit']."', ".
		"notify_page		= '".(int)$_POST['notify_page']."', ".
		"notify_comment		= '".(int)$_POST['notify_comment']."', ".
		"allow_massemail	= '".(int)$_POST['allow_massemail']."' ";
	}
	else if	($action == 'update_general')
	{
		$sql =
		"user_lang			= '".quote($this->dblink, $_POST['user_lang'])."', ".
		"theme				= '".quote($this->dblink, $_POST['theme'])."', ".
		"timezone			= '".(float)$_POST['timezone']."', ".
		"dst				= '".(int)$_POST['dst']."', ".
		"sorting_comments	= '".(int)$_POST['sorting_comments']."', ".
		"menu_items			= '".(int)$_POST['menu_items']."', ".
		"list_count			= '".(int)$_POST['list_count']."' " ;
	}
	else
	{
		$sql = '';
	}

	if ($sql)
	{
		// update user_setting table
		$this->sql_query(
			"UPDATE ".$this->config['table_prefix']."user_setting SET ".
				$sql.
			"WHERE user_id = '".(int)$user['user_id']."' ".
			"LIMIT 1");

		// log event
		$this->log(6, Ut::perc_replace($this->get_translation('LogUserSettingsUpdate', $this->config['language']), $user['user_name']));
	}

	// (re)send email confirmation code
	if ($this->config['enable_email'] && ($resend_code || $email_changed))
	{
		if ($resend_code)
		{
			$email = $user['email'];
		}
		if ($email)
		{
			$confirm		= hash('sha256', $user['password'] . mt_rand() . time() . mt_rand() . $email . mt_rand());
			$confirm_hash	= hash('sha256', $confirm . hash('sha256', $this->config['system_seed']));

			$this->sql_query(
				"UPDATE {$this->config['user_table']} SET ".
					"email_confirm = '".quote($this->dblink, $confirm_hash)."' ".
				"WHERE user_id = '".(int)$user['user_id']."' ".
				"LIMIT 1");

			$save = $this->set_language($user['user_lang'], true);
			$subject	=	$this->get_translation('EmailConfirm');
			$body		=	Ut::perc_replace($this->get_translation('EmailVerify'),
							$this->config['site_name'],
							$user['user_name'],
							$this->href('', '', 'confirm='.$confirm))."\n\n";

			$this->send_user_email($user['user_name'], $email, $subject, $body, $user['user_lang']);
			$this->set_language($save, true);

			$message = $this->get_translation('SettingsCodeResent');
		}
		else
		{
			$message = $this->get_translation('SettingsCodeNotSent');
		}
		$this->set_message($message, 'success');
	}

	// reload user data
	if ($sql || $resend_code)
	{
		$this->set_user($this->load_user(0, $user['user_id'], 0, false), 1);
		$this->set_menu(MENU_USER);

		$user = $this->get_user();

		$this->set_message($this->get_translation('UserSettingsStored', @$_POST['user_lang']), 'success');

		// forward
		if ($action == 'update_extended')
		{
			$tab = 'extended';
		}
		else if ($action == 'update_notifications')
		{
			$tab = 'notification';
		}
		else
		{
			$tab = '';
		}

		$this->redirect($this->href('', '', $tab));
	}

	// MENU
	if (isset($_GET['menu']) || isset($_POST['_user_menu']))
	{
		echo '<h3>'.$this->get_translation('UserSettings').' &raquo; '.$this->get_translation('Bookmarks').'</h3>';
		echo '<ul class="menu">
				<li><a href="'.$this->href('', '', '').'">'.$this->get_translation('UserSettingsGeneral').'</a></li>
				<li class="active">'.$this->get_translation('Bookmarks').'</li>
				<li><a href="'.$this->href('', '', 'notification').'">'.$this->get_translation('UserSettingsNotifications').'</a></li>
				<li><a href="'.$this->href('', '', 'extended').'">'.$this->get_translation('UserSettingsExtended')."</a></li>
				</ul><br /><br />\n";
		echo $this->action('menu', array('redirect' => 1));
	}
	// NOTIFICATIONS
	else if (isset($_GET['notification']) || $action == 'update_notifications')
	{
		echo '<h3>'.$this->get_translation('UserSettings').' &raquo; '.$this->get_translation('UserSettingsNotifications').'</h3>';
		echo '<ul class="menu">
				<li><a href="'.$this->href('', '', '').'">'.$this->get_translation('UserSettingsGeneral').'</a></li>
				<li><a href="'.$this->href('', '', 'menu').'">'.$this->get_translation('Bookmarks').'</a></li>
				<li class="active">'.$this->get_translation('UserSettingsNotifications').'</li>
				<li><a href="'.$this->href('', '', 'extended').'">'.$this->get_translation('UserSettingsExtended')."</a></li>
			</ul><br /><br />\n";
		echo $this->form_open('user_settings_notifications');
		echo '<input type="hidden" name="action" value="update_notifications" />';
		?>
		<div class="page_settings">
		<table class="form_tbl">
		<tbody>
		<?php
		if ($this->config['enable_email'] && $this->config['enable_email_notification'])
		{
	?>
			<tr class="lined">
				<td class="form_left"><?php echo $this->get_translation('UserSettingsEmailMe');?>&nbsp;</td>
				<td class="form_right">
					<input type="hidden" name="send_watchmail" value="0" />
					<input type="checkbox" id="send_watchmail" name="send_watchmail" value="1" <?php echo $user['send_watchmail']? 'checked="checked"' : '' ?> />
					<label for="send_watchmail"><?php echo $this->get_translation('SendWatchEmail');?></label>
				</td>
			</tr>

		<tr class="lined">
			<th class="form_left">
				<label for="notify_page"><?php echo $this->get_translation('NotifyPageEdit');?></label>
			</th>
			<td class="form_right">
		<?php
				echo '<input type="radio" id="notify_page0" name="notify_page" value="0" '.( $user['notify_page'] == 0 ? 'checked="checked"' : '' ).'/><label for="notify_page0">'.$this->get_translation('NotifyOff').'</label>';
				echo '<input type="radio" id="notify_page1" name="notify_page" value="1" '.( $user['notify_page'] == 1 ? 'checked="checked"' : '' ).'/><label for="notify_page1">'.$this->get_translation('NotifyAlways').'</label>';
				echo '<input type="radio" id="notify_page2" name="notify_page" value="2" '.( $user['notify_page'] == 2 ? 'checked="checked"' : '' ).'/><label for="notify_page2" title="'.$this->get_translation('NotifyPendingPageTip').
					' '.$this->get_translation('NotifyPendingTip').'">'.$this->get_translation('NotifyPending').'</label>';
				// echo '<input type="radio" id="notify_page3" name="notify_page" value="3" '.( $user['notify_page'] == 3 ? 'checked="checked"' : '' ).'/><label for="notify_page3">'.$this->get_translation('NotifyDigest').'</label>';
		?>
			</td>
		</tr>
		<tr class="lined">
			<th class="form_left">
				<label for="notify_comment"><?php echo $this->get_translation('NotifyComment');?></label>
			</th>
			<td class="form_right">
<?php
				echo '<input type="radio" id="notify_comment0" name="notify_comment" value="0" '.( $user['notify_comment'] == 0 ? 'checked="checked"' : '' ).'/><label for="notify_comment0">'.$this->get_translation('NotifyOff').'</label>';
				echo '<input type="radio" id="notify_comment1" name="notify_comment" value="1" '.( $user['notify_comment'] == 1 ? 'checked="checked"' : '' ).'/><label for="notify_comment1">'.$this->get_translation('NotifyAlways').'</label>';
				echo '<input type="radio" id="notify_comment2" name="notify_comment" value="2" '.( $user['notify_comment'] == 2 ? 'checked="checked"' : '' ).'/><label for="notify_comment2" title="'.$this->get_translation('NotifyPendingCommentTip').
					' '.$this->get_translation('NotifyPendingTip').'">'.$this->get_translation('NotifyPending').'</label>';
				// echo '<input type="radio" id="notify_comment3" name="notify_comment" value="3" '.( $user['notify_comment'] == 3 ? 'checked="checked"' : '' ).'/><label for="notify_comment3">'.$this->get_translation('NotifyDigest').'</label>';
?>
			</td>
		</tr>
<?php
			// minor edit
			if ($this->page && $this->config['minor_edit'] != 0)
			{
	?>
		<tr class="lined">
			<td class="form_left">&nbsp;</td>
			<td class="form_right">
				<input type="hidden" name="notify_minor_edit" value="0" />
				<input type="checkbox" id="notify_minor_edit" name="notify_minor_edit" value="1" <?php echo $user['notify_minor_edit']? 'checked="checked"' : '' ?> />
				<label for="notify_minor_edit"><?php echo $this->get_translation('NotifyMinorEdit');?></label>
			</td>
		</tr>
		<?php }?>
		<tr class="lined">
			<td class="form_left">&nbsp;</td>
			<td class="form_right">
				<input type="hidden" name="allow_intercom" value="0" />
				<input type="checkbox" id="allow_intercom" name="allow_intercom" value="1" <?php echo $user['allow_intercom']? 'checked="checked"' : '' ?> />
				<label for="allow_intercom"><?php echo $this->get_translation('AllowIntercom');?></label>
			</td>
		</tr>
	<?php	}?>

		<tr class="lined">
			<td class="form_left">&nbsp;</td>
			<td class="form_right">
				<input type="hidden" name="allow_massemail" value="0" />
				<input type="checkbox" id="allow_massemail" name="allow_massemail" value="1" <?php echo $user['allow_massemail']? 'checked="checked"' : '' ?> />
				<label for="allow_massemail"><?php echo $this->get_translation('AllowMassemail');?></label>
			</td>
		</tr>
		<tr>
			<td class="form_left">&nbsp;</td>
			<td class="form_right">
				<input type="submit" class="OkBtn" id="submit" name="submit" value="<?php echo $this->get_translation('UpdateSettingsButton'); ?>" />
			</td>
		</tr>
	</tbody>
</table>
</div>
<?php
		echo $this->form_close();
	}
	// EXTENDED
	else if (isset($_GET['extended']) || $action == 'update_extended')
	{
		echo '<h3>'.$this->get_translation('UserSettings').' &raquo; '.$this->get_translation('UserSettingsExtended').'</h3>';
		echo '<ul class="menu">
				<li><a href="'.$this->href('', '', '').'">'.$this->get_translation('UserSettingsGeneral').'</a></li>
				<li><a href="'.$this->href('', '', 'menu').'">'.$this->get_translation('Bookmarks').'</a></li>
				<li><a href="'.$this->href('', '', 'notification').'">'.$this->get_translation('UserSettingsNotifications').'</a></li>
				<li class="active">'.$this->get_translation('UserSettingsExtended')."</li>
				</ul><br /><br />\n";
		echo $this->form_open('user_settings_extended');
		echo '<input type="hidden" name="action" value="update_extended" />';
?>
		<div class="page_settings">
		<table class="form_tbl">
		<tbody>
			<tr class="lined">
				<th class="form_left" scope="row"><?php echo $this->get_translation('UserSettingsOther');?></th>
				<td class="form_right">
					<input type="hidden" name="doubleclick_edit" value="0" />
					<input type="checkbox" id="doubleclick_edit" name="doubleclick_edit" value="1" <?php echo $user['doubleclick_edit']? 'checked="checked"' : '' ?> />
					<label for="doubleclick_edit"><?php echo $this->get_translation('DoubleclickEditing');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td class="form_left">&nbsp;</td>
				<td class="form_right">
					<input type="hidden" name="autocomplete" value="0" />
					<input type="checkbox" id="autocomplete" name="autocomplete" value="1" <?php echo $user['autocomplete']? 'checked="checked"' : '' ?> />
					<label for="autocomplete"><?php echo $this->get_translation('WikieditAutocomplete');?></label>
				</td>
			</tr>
				<tr class="lined">
				<td class="form_left">&nbsp;</td>
				<td class="form_right">
					<input type="hidden" name="numerate_links" value="0" />
					<input type="checkbox" id="numerate_links" name="numerate_links" value="1" <?php echo $user['numerate_links']? 'checked="checked"' : '' ?> />
					<label for="numerate_links"><?php echo $this->get_translation('NumerateLinks');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td class="form_left">&nbsp;</td>
				<td class="form_right">
					<input type="hidden" name="show_comments" value="0" />
					<input type="checkbox" id="show_comments" name="show_comments" value="1" <?php echo $user['show_comments']? 'checked="checked"' : '' ?> />
					<label for="show_comments"><?php echo $this->get_translation('DoShowComments');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td class="form_left">&nbsp;</td>
				<td class="form_right">
					<input type="hidden" name="show_files" value="0" />
					<input type="checkbox" id="show_files" name="show_files" value="1" <?php echo $user['show_files']? 'checked="checked"' : '' ?> />
					<label for="show_files"><?php echo $this->get_translation('DoShowFiles');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td class="form_left">&nbsp;</td>
				<td class="form_right">
					<input type="hidden" name="show_spaces" value="0" />
					<input type="checkbox" id="show_spaces" name="show_spaces" value="1" <?php echo $user['show_spaces']? 'checked="checked"' : '' ?> />
					<label for="show_spaces"><?php echo $this->get_translation('ShowSpaces');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td class="form_left">&nbsp;</td>
				<td class="form_right">
					<input type="hidden" name="dont_redirect" value="0" />
					<input type="checkbox" id="dont_redirect" name="dont_redirect" value="1" <?php echo $user['dont_redirect']? 'checked="checked"' : '' ?> />
					<label for="dont_redirect"><?php echo $this->get_translation('DontRedirect');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td class="form_left">&nbsp;</td>
				<td class="form_right">
					<input type="hidden" name="validate_ip" value="0" />
					<input type="checkbox" name="validate_ip" id="validate_ip" value="1" <?php echo $user['validate_ip']? 'checked' : '' ?> />
					<label for="validate_ip"><?php echo $this->get_translation('ValidateIP');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td class="form_left">&nbsp;</td>
				<td class="form_right">
					<input type="hidden" name="hide_lastsession" value="0" />
					<input type="checkbox" name="hide_lastsession" id="hide_lastsession" value="1" <?php echo $user['hide_lastsession']? 'checked' : '' ?> />
					<label for="hide_lastsession"><?php echo $this->get_translation('HideLastSession');?></label>
				</td>
			</tr>
<?php
		if ($this->config['publish_anonymously'])
		{
?>
			<tr class="lined">
				<td class="form_left">&nbsp;</td>
				<td class="form_right">
					<input type="hidden" name="noid_pubs" value="0" />
					<input type="checkbox" name="noid_pubs" id="noid_pubs" value="1" <?php echo $user['noid_pubs']? 'checked' : '' ?> />
					<label for="noid_pubs"><?php echo $this->get_translation('ProfileAnonymousPub');?></label>
				</td>
			</tr>
<?php
		}
?>
			<tr class="lined">
				<th class="form_left"><label for="session_length"><?php echo $this->get_translation('SessionDuration');?></label></th>
				<td class="form_right">
<?php
			echo '<input type="radio" id="duration1" name="session_length" value="1" '.( $user['session_length'] == 1 ? 'checked="checked"' : '' ).'/><label for="duration1">'.$this->get_translation('SessionDurationDay').'</label>';
			echo '<input type="radio" id="duration7" name="session_length" value="7" '.( $user['session_length'] == 7 ? 'checked="checked"' : '' ).'/><label for="duration7">'.$this->get_translation('SessionDurationWeek').'</label>';
			echo '<input type="radio" id="duration30" name="session_length" value="30" '.( $user['session_length'] == 30 ? 'checked="checked"' : '' ).'/><label for="duration30">'.$this->get_translation('SessionDurationMonth').'</label>';
?>
				</td>
			</tr>
			<!--<tr>
				<td class="form_left">&nbsp;</td>
				<td class="form_right">
					<input type="hidden" name="typografica" value="0" /><input type="checkbox" id="typografica" name="typografica" value="1" <?php echo (isset($user['typografica']) && $user['typografica'] == 1) ? 'checked="checked"' : ''; ?> />
					<label for="typografica"><?php echo $this->get_translation('Typografica');?></label>
				</td>
			</tr>-->
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="form_left">&nbsp;</td>
				<td class="form_right">
					<input type="submit" class="OkBtn" id="submit" name="submit" value="<?php echo $this->get_translation('UpdateSettingsButton'); ?>" />
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

		$code = $this->load_single(
			"SELECT email_confirm ".
			"FROM {$this->config['user_table']} ".
			"WHERE user_id = '".(int)$user['user_id']."' ".
			"LIMIT 1");

		echo '<h3>'.$this->get_translation('UserSettings').' &raquo; '.$this->get_translation('UserSettingsGeneral').'</h3>';
		echo '<ul class="menu">
				<li class="active">'.$this->get_translation('UserSettingsGeneral').'</li>
				<li><a href="'.$this->href('', '', 'menu').'">'.$this->get_translation('Bookmarks').'</a></li>
				<li><a href="'.$this->href('', '', 'notification').'">'.$this->get_translation('UserSettingsNotifications').'</a></li>
				<li><a href="'.$this->href('', '', 'extended').'">'.$this->get_translation('UserSettingsExtended')."</a></li>
				</ul><br /><br />\n";
?>
<input type="hidden" name="action" value="update_general" />
<div class="page_settings">

<table class="form_tbl">
<tbody>
	<tr class="lined">
		<th class="form_left" scope="row">
			<?php echo $this->get_translation('UserName');?>
		</th>
		<td>
			<strong><?php echo $this->user_link($user['user_name'], '', true, false);?></strong>
		</td>
	</tr>
	<tr class="lined">
		<th class="form_left" scope="row">
			<label for="real_name"><?php echo $this->get_translation('RealName');?></label>
		</th>
		<td>
			<input type="text" id="real_name" name="real_name" value="<?php echo htmlentities($user['real_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) ?>" size="40" />
		</td>
	</tr>
	<tr class="lined">
		<th class="form_left" scope="row">
			<a href="<?php echo $this->href('', 'Password')?>"><?php echo $this->get_translation('YouWantChangePassword');?></a>
		</th>
		<td>
			<a href="<?php echo $this->href('', 'password');?>" style="text-decoration: none;"><input type="button" id="button" value="<?php echo $this->get_translation('YouWantChangePassword');?>" name="_password"/></a>
		</td>
	</tr>
	<tr class="lined">
		<th class="form_left" scope="row">
			<label for="email"><?php echo $this->get_translation('EmailAddress');?></label>
		</th>
		<td>
			<input type="email" id="email" name="email" value="<?php echo htmlentities($user['email'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) ?>" size="40" />&nbsp;
<?php echo !$user['email_confirm']
		? '<img src="'.$this->config['base_url'].'image/spacer.png" alt="'.$this->get_translation('EmailConfirmed').'" title="'.$this->get_translation('EmailConfirmed').'" class="btn-tick"/>'
		: '<img src="'.$this->config['base_url'].'image/spacer.png" alt="'.$this->get_translation('EmailConfirm').'" title="'.$this->get_translation('EmailConfirm').'" class="btn-warning"/>' ?>
<?php
		if (!$user['email'] || $code['email_confirm'])
			echo '<div class="hint"><strong class="cite">'.
				$this->get_translation('EmailNotVerified').'</strong><br />'.
				'<small>'.$this->get_translation('EmailNotVerifiedDesc').
				'<strong><a href="'.$this->href('', '', 'resend_code=1').'">'.$this->get_translation('HereLink').'</a></strong>.
				</small></div>';
?></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr class="lined">
	<th class="form_left" scope="row">
		<label for="user_lang"><?php echo $this->get_translation('YourLanguage');?></label>
	</th>
	<td class="form_right">
		<select id="user_lang" name="user_lang">
<?php

	$languages = $this->get_translation('LanguageArray');

	if ($this->config['multilanguage'])
	{
		$langs = $this->available_languages();
	}
	else
	{
		$langs = [$this->config['language']];
	}

	foreach ($langs as $lang)
	{
		echo '<option value="'.$lang.'" '.
			($user['user_lang'] == $lang
				? ' selected="selected" '
				: (!isset($user['user_lang']) && $this->config['language'] == $lang
					? 'selected="selected"'
					: '')
			).'>'.$languages[$lang].' ('.$lang.")</option>\n";
	}
?>
</select></td>
	</tr>
	<tr class="lined">
		<th class="form_left" scope="row">
			<label for="theme"><?php echo $this->get_translation('ChooseTheme');?></label>
		</th>
		<td class="form_right">
			<select id="theme" name="theme">

<?php
	$themes = $this->available_themes();

	foreach ($themes as $theme)
	{
		echo '<option value="'.$theme.'" '.
			(isset($user['theme']) && $user['theme'] == $theme
				? 'selected="selected" '
				: ($this->config['theme'] == $theme
					? 'selected="selected" '
					: '')
			).'>'.$theme."</option>\n";
	}
?>
		</select></td>
	</tr>
		<tr class="lined">
		<th class="form_left" scope="row">
			<label for="timezone"><?php echo $this->get_translation('Timezone');?></label>
		</th>
		<td class="form_right">
			<select id="timezone" name="timezone">

<?php
	$timezones = $this->get_translation('TzZoneArray');

	foreach ($timezones as $offset => $timezone)
	{
		if (strlen($timezone) > 50)
		{
			$timezone = substr($timezone, 0, 45 ).'...';
		}

		echo '<option value="'.$offset.'" '.
			(isset($user['timezone']) && $user['timezone'] == $offset
				? 'selected="selected" '
				: ($this->config['timezone'] == $offset && !isset($user['timezone'])
					? 'selected="selected" '
					: '')
			).'>'.$timezone."</option>\n";
	}
?>
		</select></td>
	</tr>
	<tr class="lined">
		<th class="form_left">
			<label for="dst"><?php echo $this->get_translation('DST');?></label>
		</th>
		<td class="form_right">
<?php
			echo '<input type="radio" id="dst0" name="dst" value="0" '.( $user['dst'] == 0 ? 'checked="checked"' : '' ).'/><label for="dst0">'.$this->get_translation('MetaOff').'</label>';
			echo '<input type="radio" id="dst1" name="dst" value="1" '.( $user['dst'] == 1 ? 'checked="checked"' : '' ).'/><label for="dst1">'.$this->get_translation('MetaOn').'</label>';
?>
		</td>
	</tr>
	<tr class="lined">
		<th class="form_left">
			<label for="sorting_comments"><?php echo $this->get_translation('SortComment');?></label>
		</th>
		<td class="form_right">
			<select id="sorting_comments" name="sorting_comments">
				<option value="0" <?php echo ( $user['sorting_comments']  == 0  ? ' selected="selected"' : '' );?>><?php echo $this->get_translation('SortCommentAsc');?></option>
				<option value="1" <?php echo ( $user['sorting_comments']  == 1  ? ' selected="selected"' : '' );?>><?php echo $this->get_translation('SortCommentDesc');?></option>
			</select>
		</td>
	</tr>
	<tr class="lined">
		<th class="form_left" scope="row"><label for="menu_items"><?php echo $this->get_translation('MenuItemsShown');?></label></th>
		<td class="form_right"><input type="number" id="menu_items" name="menu_items" value="<?php echo $user['menu_items'] ?>" size="40" min="0" max="20" /></td>
	</tr>
	<tr class="lined">
		<th class="form_left" scope="row">
			<label for="list_count"><?php echo $this->get_translation('RecordsPerPage');?></label>
		</th>
		<td class="form_right">
			<select id="list_count" name="list_count">
				<option value="10" <?php echo ( $user['list_count']  == 10  ? ' selected="selected"' : '' );?>>10</option>
				<option value="20" <?php echo ( $user['list_count']  == 20  ? ' selected="selected"' : '' );?>>20</option>
				<option value="30" <?php echo ( $user['list_count']  == 30  ? ' selected="selected"' : '' );?>>30</option>
				<option value="50" <?php echo ( $user['list_count']  == 50  ? ' selected="selected"' : '' );?>>50</option>
				<option value="100" <?php echo ( $user['list_count'] == 100 ? ' selected="selected"' : '' );?>>100</option>
			</select>
		</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
	<td class="form_left">&nbsp;</td>
	<td class="form_right">
		<input type="submit" class="OkBtn" id="submit" name="submit" value="<?php echo $this->get_translation('UpdateSettingsButton'); ?>" />
		&nbsp;
		<a href="<?php echo $this->href('', '', 'action=logout');?>" style="text-decoration: none;"><input type="button" class="CancelBtn" id="logout" name="logout" value="<?php echo $this->get_translation('LogoutButton'); ?>" /></a>
	</td>
	</tr>
	</tbody>
</table>
</div>
<br />
<?php
	//  echo $this->format_translation('SeeListOfPages')."<br />";
	echo $this->form_close();

	$percentage = 0 . '%';

	if ($this->config['upload_quota_per_user'])
	{
		$percentage =  round( ($this->upload_quota($user['user_id']) / (($this->config['upload_quota_per_user']) / 100)) ).'%';
	}

	echo '<aside class="page_tools">'.
			'<table class="form_tbl">'.
				'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('UserSpace')."</th>".
					'<td class="form_right">'."<a href=\"".$this->href('', ($this->config['users_page'].'/'.$user['user_name']))."\">".$this->config['users_page'].'/'.$user['user_name']."</a>"."</td>".
				"</tr>\n".'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('UsersSignup')."</th>".
					'<td class="form_right">'.$this->get_time_formatted($user['signup_time'])."</td>".
				"</tr>\n".'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('UsersLastSession')."</th>".
					'<td class="form_right">'.$this->get_time_formatted($user['last_visit'])."</td>".
				"</tr>\n".'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('UploadQuota')."&nbsp;&nbsp;</th>".

					'<td class="form_right" title="'.$this->get_translation('UploadQuotaTip').'"><div class="meter"><span style="width: 25%">'.$this->binary_multiples($this->upload_quota($user['user_id']), false, true, true).' ('.$percentage.")</span></div></td>".
				"</tr>\n".'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('UsersPages')."</th>".
					'<td class="form_right"><a href="'.$this->href('', $this->config['users_page'], 'profile='.$user['user_name'], '', 'pages').'" title="'.$this->get_translation('RevisionTip').'">'.(int)$user['total_pages']."</a></td>".
				// "</tr>\n".'<tr class="lined">'.
					// '<th class="form_left" scope="row">'.$this->get_translation('UsersRevisions')."</th>".
					// '<td class="form_right"><a href="'.$this->href('', $this->config['users_page'], 'profile='.$user['user_name']).'" title="'.$this->get_translation('RevisionTip').'">'.(int)$user['total_revisions']."</a></td>".
				"</tr>\n".'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('UsersComments')."</th>".
					'<td class="form_right"><a href="'.$this->href('', $this->config['users_page'], 'profile='.$user['user_name'], '', 'comments').'" title="'.$this->get_translation('ShowComments').'">'.$user['total_comments'].'</a></td>'.
				"</tr>\n".'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('UsersUploads')."</th>".
					'<td class="form_right"><a href="'.$this->href('', $this->config['users_page'], 'profile='.$user['user_name'], '', 'uploads').'" title="'.$this->get_translation('ShowComments').'">'.number_format($user['total_uploads'], 0, ',', '.').'</a></td>'.
				// "</tr>\n".'<tr class="lined">'.
				// 	'<th class="form_left" scope="row">'.$this->get_translation('UsersLogins')."</th>".
				// 	'<td class="form_right">'.number_format($user['login_count'], 0, ',', '.')."</td>".
				"</tr>\n".
			"</table>\n".
		"</aside>";
	}
}
else
{
	// user is not logged in
	echo $this->action('login', array());
}
?>
<!--/notypo-->
