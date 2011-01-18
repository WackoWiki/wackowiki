<!--notypo-->
<?php

// reconnect securely in tls mode
if ($this->config['tls'] == true && ( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'on' && empty($this->config['tls_proxy'])) || $_SERVER['SERVER_PORT'] != '443' ))
{
	$this->redirect(str_replace('http://', 'https://'.($this->config['tls_proxy'] ? $this->config['tls_proxy'].'/' : ''), $this->href()));
}

// email confirmation
if (isset($_GET['confirm']))
{
	if ($temp = $this->load_single(
			"SELECT user_name, email, email_confirm ".
			"FROM ".$this->config['user_table']." ".
			"WHERE email_confirm = '".quote($this->dblink, $_GET['confirm'])."'"))
	{
		$this->query(
			"UPDATE ".$this->config['user_table']." ".
			"SET email_confirm = '' ".
			"WHERE email_confirm = '".quote($this->dblink, $_GET['confirm'])."'");

		echo '<div class="info">'.$this->get_translation('EmailConfirmed').'</div>';

		// log event
		$this->log(4, str_replace('%2', $temp['user_name'], str_replace('%1', $temp['email'], $this->get_translation('LogUserEmailActivated', $this->config['language']))));

		// TODO: reset user (session data)
		#$this->set_user($this->load_user($user['user_name']), 0, 1);

		unset($temp);
	}
	else
	{
		echo "<br /><br />".str_replace('%1', $this->compose_link_to_page('Settings', '', $this->get_translation('SettingsText'), 0), $this->get_translation('EmailNotConfirmed'))."<br /><br />";
	}
}
else if (isset($_POST['action']) && $_POST['action'] == 'logout')
{
	$this->logout_user();
	$this->set_bookmarks(BM_DEFAULT);
	$this->set_message($this->get_translation('LoggedOut'));
	$this->redirect($this->href());
}
else if ($user = $this->get_user())
{
	$email_changed = '';
	$this->set_page_lang($this->user_lang);

	// is user trying to update?
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		// no email given
		if (!$_POST['email'])
		{
			$error .= $this->get_translation('SpecifyEmail')." ";
		}
		// invalid email
		else if (!preg_match('/^[\w.-]+?\@[\w.-]+?\.[\w]+$/', $_POST['email']))
		{
			$error .= $this->get_translation('NotAEmail')." ";
		}

		// check for errors and store
		if ($error)
		{
			$this->set_message($error.$this->get_translation('SettingsNotStored'));
		}
		else
		{
			if ($user['email'] != $_POST['email'])
			{
				$email_changed = true;
			}

			// store if email hasn't been changed otherwise request authorization
			if ($email_changed === true || isset($_POST['real_name']))
			{
				// update users table
				$this->query(
					"UPDATE ".$this->config['user_table']." SET ".
						"real_name			= '".quote($this->dblink, trim($_POST['real_name']))."', ".
						"email				= '".quote($this->dblink, $_POST['email'])."' ".
					"WHERE user_id = '".quote($this->dblink, $user['user_id'])."' ".
					"LIMIT 1");

				$this->set_message($this->get_translation('UserSettingsStored'));

				// log event
				$this->log(6, str_replace('%1', $user['user_name'], $this->get_translation('LogUserSettingsUpdate', $this->config['language'])));
			}
		}
	}

	if (isset($_POST['action']) && ($_POST['action'] == 'update_extended' || $_POST['action'] == 'update'))
	{
		// update user_setting table
		$this->query(
			"UPDATE ".$this->config['table_prefix']."user_setting SET ".
			($_POST['action'] == 'update_extended'
				?	"doubleclick_edit	= '".quote($this->dblink, (int)$_POST['doubleclick_edit'])."', ".
					"show_comments		= '".quote($this->dblink, (int)$_POST['show_comments'])."', ".
					"show_spaces		= '".quote($this->dblink, (int)$_POST['show_spaces'])."', ".
					#"typografica		= '".quote($this->dblink, (int)$_POST['typografica'])."', ".
					"autocomplete		= '".quote($this->dblink, (int)$_POST['autocomplete'])."', ".
					"numerate_links		= '".quote($this->dblink, (int)$_POST['numerate_links'])."', ".
					"dont_redirect		= '".quote($this->dblink, (int)$_POST['dont_redirect'])."', ".
					"send_watchmail		= '".quote($this->dblink, (int)$_POST['send_watchmail'])."', ".
					"show_files			= '".quote($this->dblink, (int)$_POST['show_files'])."', ".
					"allow_intercom		= '".quote($this->dblink, (int)$_POST['allow_intercom'])."', ".
					"hide_lastsession	= '".quote($this->dblink, (int)$_POST['hide_lastsession'])."', ".
					"validate_ip		= '".quote($this->dblink, (int)$_POST['validate_ip'])."', ".
					"noid_pubs			= '".quote($this->dblink, (int)$_POST['noid_pubs'])."' "
				:	"lang				= '".quote($this->dblink, $_POST['lang'])."', ".
					"theme				= '".quote($this->dblink, $_POST['theme'])."', ".
					"revisions_count	= '".quote($this->dblink, (int)$_POST['revisions_count'])."', ".
					"changes_count		= '".quote($this->dblink, (int)$_POST['changes_count'])."' "
				).
			"WHERE user_id = '".quote($this->dblink, $user['user_id'])."' ".
			"LIMIT 1");

		$this->set_message($this->get_translation('UserSettingsStored'));

		// log event
		$this->log(6, str_replace('%1', $user['user_name'], $this->get_translation('LogUserSettingsUpdate', $this->config['language'])));
	}

	// (re)send email confirmation code
	if ((isset($_GET['resend_code']) && $_GET['resend_code'] == 1) || $email_changed === true)
	{
		if ($email = ( $_GET['resend_code'] == 1 ? $user['email'] : $_POST['email'] ))
		{
			$confirm = hash('sha256', $user['password'].mt_rand().time().mt_rand().$email.mt_rand());

			$this->query(
				"UPDATE {$this->config['user_table']} ".
				"SET email_confirm = '".quote($this->dblink, $confirm)."' ".
				"WHERE user_name = '".quote($this->dblink, $user['user_name'])."' ".
				"LIMIT 1");

			$subject = $this->config['wacko_name'].". ".$this->get_translation('EmailConfirm');
			$body = $this->get_translation('EmailHello'). $user['user_name'].".\n\n".
						str_replace('%1', $this->config['wacko_name'],
						str_replace('%2', $user['user_name'],
						str_replace('%3', $this->href().
						($this->config['rewrite_mode'] ? "?" : "&amp;")."confirm=".$confirm,
						$this->get_translation('EmailVerify'))))."\n\n".
						$this->get_translation('EmailGoodbye')."\n".
						$this->config['wacko_name']."\n".
						$this->config['base_url'];
			$this->send_mail($email, $subject, $body);
		}
		else
		{
			$this->set_message($this->get_translation('SettingsCodeNotSent'));
		}
	}

	// reload user data
	if ( (isset($_POST['action']) && ($_POST['action'] == 'update' || $_POST['action'] == 'update_extended')) || (isset($_GET['resend_code']) && $_GET['resend_code'] == 1))
	{
		$this->set_user($this->load_user($user['user_name']), 0, 1);
		$this->set_bookmarks(BM_USER);

		// forward
		$this->set_message($this->get_translation('UserSettingsStored', $_POST['lang']));

		$this->redirect(($_POST['action'] == 'update_extended' ? $this->href('', '', 'extended') : $this->href()));
		$user = $this->get_user();
	}

	#echo "<h3>".$this->get_translation('UserSettings')."</h3>";

	// BOOKMARKS
	if (isset($_GET['bookmarks']) || isset($_POST['_user_bookmarks']) )
	{
		echo "<h3>".$this->get_translation('UserSettings')." &raquo; ".$this->get_translation('Bookmarks')."</h3>";
		echo "<ul class=\"menu\"><li><a href=\"".$this->href('', '', '')."\">".$this->get_translation('UserSettingsGeneral')."</a></li><li class=\"active\">".$this->get_translation('Bookmarks')."</li><li><a href=\"".$this->href('', '', 'extended')."\">".$this->get_translation('UserSettingsExtended')."</a></li></ul><br /><br />\n";
		echo $this->action('bookmarks');
	}

	// EXTENDED
	else if (isset($_GET['extended']) || (isset($_POST['action'])&& $_POST['action'] == 'update_extended'))
	{
		echo "<h3>".$this->get_translation('UserSettings')." &raquo; ".$this->get_translation('UserSettingsExtended')."</h3>";
		echo "<ul class=\"menu\"><li><a href=\"".$this->href('', '', '')."\">".$this->get_translation('UserSettingsGeneral')."</a></li><li><a href=\"".$this->href('', '', 'bookmarks')."\">".$this->get_translation('Bookmarks')."</a></li><li class=\"active\">".$this->get_translation('UserSettingsExtended')."</li></ul><br /><br />\n";
		echo $this->form_open();
		echo "<input type=\"hidden\" name=\"action\" value=\"update_extended\" />";
		?>
		<div class="page_settings">
		<table class="form_tbl">
		<tbody>
			<tr class="lined">
		<th class="form_left" scope="row"><?php echo $this->get_translation('UserSettingsOther');?></th>
		<td class="form_right"><input type="hidden" name="doubleclick_edit" value="0" />
			<input type="checkbox" id="doubleclick_edit" name="doubleclick_edit" value="1" <?php echo (isset($user['doubleclick_edit']) && $user['doubleclick_edit'] == 1) ? "checked=\"checked\"" : '' ?> />
			<label for="doubleclick_edit"><?php echo $this->get_translation('DoubleclickEditing');?></label>
		</td>
	</tr>
	<tr class="lined">
		<td class="form_left">&nbsp;</td>
		<td class="form_right"><input type="hidden" name="autocomplete" value="0" />
			<input type="checkbox" id="autocomplete" name="autocomplete" value="1" <?php echo (isset($user['autocomplete']) && $user['autocomplete'] == 1) ? "checked=\"checked\"" : '' ?> />
			<label for="autocomplete"><?php echo $this->get_translation('WikieditAutocomplete');?></label>
		</td>
	</tr>
		<tr class="lined">
		<td class="form_left">&nbsp;</td>
		<td class="form_right"><input type="hidden" name="numerate_links" value="0" />
			<input type="checkbox" id="numerate_links" name="numerate_links" value="1" <?php echo (isset($user['numerate_links']) && $user['numerate_links'] == 1) ? "checked=\"checked\"" : '' ?> />
			<label for="numerate_links"><?php echo $this->get_translation('NumerateLinks');?></label>
		</td>
	</tr>
	<tr class="lined">
		<td class="form_left">&nbsp;</td>
		<td class="form_right"><input type="hidden" name="show_comments" value="0" />
			<input type="checkbox" id="show_comments" name="show_comments" value="1" <?php echo (isset($user['show_comments']) && $user['show_comments'] == 1) ? "checked=\"checked\"" : '' ?> />
			<label for="show_comments"><?php echo $this->get_translation('ShowComments?');?></label>
		</td>
	</tr>
	<tr class="lined">
		<td class="form_left">&nbsp;</td>
		<td class="form_right"><input type="hidden" name="show_files" value="0" />
			<input type="checkbox" id="show_files" name="show_files" value="1" <?php echo (isset($user['show_files']) && $user['show_files'] == 1) ? "checked=\"checked\"" : '' ?> />
			<label for="show_files"><?php echo $this->get_translation('ShowFiles?');?></label>
		</td>
	</tr>
	<tr class="lined">
		<td class="form_left">&nbsp;</td>
		<td class="form_right"><input type="hidden" name="show_spaces" value="0" />
			<input type="checkbox" id="show_spaces" name="show_spaces" value="1" <?php echo (isset($user['show_spaces']) && $user['show_spaces'] == 1) ? "checked=\"checked\"" : '' ?> />
			<label for="show_spaces"><?php echo $this->get_translation('ShowSpaces');?></label>
		</td>
	</tr>
	<tr class="lined">
		<td class="form_left">&nbsp;</td>
		<td class="form_right"><input type="hidden" name="dont_redirect" value="0" />
			<input type="checkbox" id="dont_redirect" name="dont_redirect" value="1" <?php echo (isset($user['dont_redirect']) && $user['dont_redirect'] == 1) ? "checked=\"checked\"" : '' ?> />
			<label for="dont_redirect"><?php echo $this->get_translation('DontRedirect');?></label>
		</td>
	</tr>
	<tr class="lined">
		<td class="form_left">&nbsp;</td>
		<td class="form_right">
			<input type="hidden" name="send_watchmail" value="0" />
			<input type="checkbox" id="send_watchmail" name="send_watchmail" value="1" <?php echo (isset($user['send_watchmail']) && $user['send_watchmail'] == 1) ? "checked=\"checked\"" : '' ?> />
			<label for="send_watchmail"><?php echo $this->get_translation('SendWatchEmail');?></label>
		</td>
	</tr>
	<tr class="lined">
		<td class="form_left">&nbsp;</td>
		<td class="form_right"><input type="hidden" name="allow_intercom" value="0" />
			<input type="checkbox" id="allow_intercom" name="allow_intercom" value="1" <?php echo (isset($user['allow_intercom']) && $user['allow_intercom'] == 1) ? "checked=\"checked\"" : '' ?> />
			<label for="allow_intercom"><?php echo $this->get_translation('AllowIntercom');?></label>
		</td>
	</tr>
	<tr class="lined">
		<td class="form_left">&nbsp;</td>
		<td class="form_right">
			<input type="hidden" name="validate_ip" value="0" />
			<input type="checkbox" name="validate_ip" id="validate_ip" value="1" <?php echo (isset($user['validate_ip']) && $user['validate_ip'] == 1) ? 'checked' : '' ?> />
			<label for="validate_ip"><?php echo $this->get_translation('ValidateIP');?></label>
		</td>
	</tr>
	<tr class="lined">
		<td class="form_left">&nbsp;</td>
		<td class="form_right">
			<input type="hidden" name="hide_lastsession" value="0" />
			<input type="checkbox" name="hide_lastsession" id="hide_lastsession" value="1" <?php echo (isset($user['hide_lastsession']) && $user['hide_lastsession'] == 1) ? 'checked' : '' ?> />
			<label for="hide_lastsession"><?php echo $this->get_translation('HideLastSession');?></label>
		</td>
	</tr>
	<tr class="lined">
		<td class="form_left">&nbsp;</td>
		<td class="form_right">
			<input type="hidden" name="noid_pubs" value="0" />
			<input type="checkbox" name="noid_pubs" id="noid_pubs" value="1" <?php echo (isset($user['noid_pubs']) && $user['noid_pubs'] == 1) ? 'checked' : '' ?> />
			<label for="noid_pubs"><?php echo $this->get_translation('ProfileAnonymousPub');?></label>
		</td>
	</tr>
	<!--<tr>
		<td class="form_left">&nbsp;</td>
		<td class="form_right">
			<input type="hidden" name="typografica" value="0" /><input type="checkbox" id="typografica" name="typografica" value="1" <?php echo (isset($user['typografica']) && $user['typografica'] == 1) ? "checked=\"checked\"" : "" ?> />
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
		<input id="submit" name="submit" type="submit" value="<?php echo $this->get_translation('UpdateSettingsButton'); ?>" />
		&nbsp;
		<input id="button" name="button" type="button" onclick="document.location='<?php echo $this->href('', '', 'action=logout'); ?>'" value="<?php echo $this->get_translation('LogoutButton'); ?>" />
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
		echo $this->form_open();

		$code = $this->load_single(
			"SELECT email_confirm ".
			"FROM {$this->config['user_table']} ".
			"WHERE user_name = '".quote($this->dblink, $user['user_name'])."'");

		echo "<h3>".$this->get_translation('UserSettings')." &raquo; ".$this->get_translation('UserSettingsGeneral')."</h3>";
		echo "<ul class=\"menu\"><li class=\"active\">".$this->get_translation('UserSettingsGeneral')."</li><li><a href=\"".$this->href('', '', 'bookmarks')."\">".$this->get_translation('Bookmarks')."</a></li><li><a href=\"".$this->href('', '', 'extended')."\">".$this->get_translation('UserSettingsExtended')."</a></li></ul><br /><br />\n";
?>
<input type="hidden" name="action" value="update" />
<div class="page_settings">

<table class="form_tbl">
<tbody>
	<tr class="lined">
		<th class="form_left" scope="row"><?php echo $this->get_translation('UserName');?></th>
		<td><strong><?php echo "<a href=\"".$this->href('', $this->config['users_page'], 'profile='.$user['user_name'])."\">".$user['user_name']."</a>";?></strong></td>
	</tr>
	<tr class="lined">
		<th class="form_left" scope="row"><label for="real_name"><?php echo $this->get_translation('RealName');?></label></th>
		<td><input id="real_name" name="real_name" value="<?php echo htmlentities($user['real_name']) ?>" size="40" />
		</td>
	</tr>
	<tr class="lined">
		<th class="form_left" scope="row"><a href="<?php echo $this->href('', 'Password')?>"><?php echo $this->get_translation('YouWantChangePassword');?></a></th>
		<td><input id="button" type="button" onclick="location.href='password'" value="<?php echo $this->get_translation('YouWantChangePassword');?>" name="_password"/></td>
	</tr>
	<tr class="lined">
		<th class="form_left" scope="row"><label for="email"><?php echo $this->get_translation('YourEmail');?></label></th>
		<td><input id="email" name="email" value="<?php echo htmlentities($user['email']) ?>" size="40" />&nbsp;<?php echo $user['email_confirm'] == '' ? '<img src="'.$this->config['base_url'].'images/tick.png" alt="'.$this->get_translation('EmailConfirmed').'" title="'.$this->get_translation('EmailConfirmed').'" width="20" height="20" />' : '<img src="'.$this->config['base_url'].'images/warning.gif" alt="'.$this->get_translation('EmailConfirm').'" title="'.$this->get_translation('EmailConfirm').'" width="16" height="16" />' ?>
<?php
		if (!$user['email'] || $code['email_confirm'])
			echo "<div class=\"BewareChangeLang\"><strong class=\"cite\">".
				$this->get_translation('EmailNotVerified')."</strong><br />".
				"<small>".$this->get_translation('EmailNotVerifiedDesc')."<strong><a href=\"?resend_code=1\">".$this->get_translation('HereLink')."</a></strong>.</small></div>";
?></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr class="lined">
	<th class="form_left" scope="row"><label for="lang"><?php echo $this->get_translation('YourLanguage');?></label></th>
	<td class="form_right"><select id="lang" name="lang">
	<?php
	$langs = $this->available_languages();
	for ($i = 0; $i < count($langs); $i++)
	{
		echo "<option value=\"".$langs[$i]."\" ".
			($user['lang'] == $langs[$i]
				? " selected=\"selected\""
				: (!isset($user['lang']) && $this->config['language'] == $langs[$i]
					? "selected=\"selected\""
					: "")
			).">".$langs[$i]."</option>\n";
	}
	?>
</select></td>
	</tr>
	<tr class="lined">
		<th class="form_left" scope="row"><label for="theme"><?php echo $this->get_translation('ChooseTheme');?></label></th>
		<td class="form_right"><select id="theme" name="theme">

<?php
	$themes = $this->available_themes();
	for ($i = 0; $i < count($themes); $i++)
	{
		echo '<option value="'.$themes[$i].'" '.
			(isset($user['theme']) && $user['theme'] == $themes[$i]
				? "selected=\"selected\""
				: ($this->config['theme'] == $themes[$i]
					? "selected=\"selected\""
					: "")
			).">".$themes[$i]."</option>\n";
	}
	?>
		</select></td>
	</tr>
	<tr class="lined">
		<th class="form_left" scope="row"><label for="changes_count"><?php echo $this->get_translation('RecentChangesLimit');?></label></th>
		<td class="form_right"><input id="changes_count" name="changes_count"
	value="<?php echo htmlentities($user['changes_count']) ?>" size="40" /></td>
	</tr>
	<tr class="lined">
		<th class="form_left" scope="row"><label for="revisions_count"><?php echo $this->get_translation('RevisionListLimit');?></label></th>
		<td class="form_right"><input id="revisions_count" name="revisions_count"
	value="<?php echo htmlentities($user['revisions_count']) ?>" size="40" /></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
	<td class="form_left">&nbsp;</td>
	<td class="form_right">
		<input id="submit" name="submit" type="submit" value="<?php echo $this->get_translation('UpdateSettingsButton'); ?>" />
		&nbsp;
		<input id="button" name="button" type="button" onclick="document.location='<?php echo $this->href('', '', 'action=logout'); ?>'" value="<?php echo $this->get_translation('LogoutButton'); ?>" />
	</td>
	</tr>
	</tbody>
</table>
</div>
<br />
	<?php
	//  echo $this->format_translation('SeeListOfPages')."<br />";
	echo $this->form_close();
	}
}
else
{
	// user is not logged in
	echo $this->action('login', array());
}
?>
<!--/notypo-->