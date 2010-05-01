<!--notypo-->
<?php

#	echo "  <script type=\"text/javascript\" src=\"".$this->config["base_url"]."js/protoedit.js\"></script>\n";
#	echo "  <script type=\"text/javascript\" src=\"".$this->config["base_url"]."js/wikiedit2.js\"></script>\n";
#	echo "  <script type=\"text/javascript\" src=\"".$this->config["base_url"]."js/autocomplete.js\"></script>\n";

// reconnect securely in ssl mode
if ($this->config["ssl"] == true && $_SERVER["HTTPS"] != "on")
{
	$this->Redirect(str_replace("http://", "https://", $this->href()));
}

// email confirmation
if (isset($_GET["confirm"]) && $_GET["confirm"])
{
	if ($temp = $this->LoadSingle(
			"SELECT user_name, email, email_confirm ".
			"FROM ".$this->config["user_table"]." ".
			"WHERE email_confirm = '".quote($this->dblink, $_GET["confirm"])."'"))
	{
		$this->Query(
			"UPDATE ".$this->config["user_table"]." ".
			"SET email_confirm = '' ".
			"WHERE email_confirm = '".quote($this->dblink, $_GET["confirm"])."'");

		echo "<br /><br />".$this->GetTranslation("EmailConfirmed")."<br /><br />";

		// log event
		$this->Log(4, str_replace("%2", $temp["user_name"], str_replace("%1", $temp["email"], $this->GetTranslation("LogUserEmailActivated"))));

		unset($temp);
	}
	else
	{
		echo "<br /><br />".str_replace('%1', $this->ComposeLinkToPage('Settings', '', $this->GetTranslation("SettingsText"), 0), $this->GetTranslation("EmailNotConfirmed"))."<br /><br />";
	}
}
else if (isset($_POST["action"]) && $_POST["action"] == "logout")
{
	$this->LogoutUser();
	$this->SetMessage($this->GetTranslation("LoggedOut"));
	$this->Redirect($this->href());
}
else if ($user = $this->GetUser())
{
	$this->SetPageLang($this->userlang);

	// is user trying to update?
	if (isset($_POST["action"]) && $_POST["action"] == "update")
	{
		// no email given
		if (!$_POST["email"])
			$error .= $this->GetTranslation("SpecifyEmail")." ";
		// invalid email
		else if (!preg_match("/^[\w.-]+?\@[\w.-]+?\.[\w]+$/", $_POST["email"]))
			$error .= $this->GetTranslation("NotAEmail")." ";

		// check for errors and store
		if ($error)
		{
			$this->SetMessage($error.$this->GetTranslation("SettingsNotStored"));
		}
		else
		{
			if ($user["email"] != $_POST["email"]) $email_changed = true;

			// store if email hasn't been changed otherwise request authorization
			if (!$email_changed)
			{
				$bookmarks = str_replace("\r", "", $_POST["bookmarks"]);

				// update users table
				$this->Query(
					"UPDATE ".$this->config["user_table"]." SET ".
						"real_name			= '".quote($this->dblink, $_POST["real_name"])."', ".
						"email				= '".quote($this->dblink, $_POST["email"])."' ".
					"WHERE user_id = '".quote($this->dblink, $user["user_id"])."' ".
					"LIMIT 1");

				// update users_settings table
				$this->Query(
					"UPDATE ".$this->config["table_prefix"]."users_settings SET ".
						"doubleclick_edit	= '".quote($this->dblink, $_POST["doubleclick_edit"])."', ".
						"show_comments		= '".quote($this->dblink, $_POST["show_comments"])."', ".
						"revisions_count	= '".quote($this->dblink, $_POST["revisions_count"])."', ".
						"changes_count		= '".quote($this->dblink, $_POST["changes_count"])."', ".
						"motto				= '".quote($this->dblink, $_POST["motto"])."', ".
						"bookmarks			= '".quote($this->dblink, $bookmarks)."', ".
						"show_spaces		= '".quote($this->dblink, $_POST["show_spaces"])."', ".
						"typografica		= '".quote($this->dblink, $_POST["typografica"])."', ".
						"lang				= '".quote($this->dblink, $_POST["lang"])."', ".
						"theme				= '".quote($this->dblink, $_POST["theme"])."', ".
						"autocomplete		= '".quote($this->dblink, $_POST["autocomplete"])."', ".
						"dont_redirect		= '".quote($this->dblink, $_POST["dont_redirect"])."', ".
						"send_watchmail		= '".quote($this->dblink, $_POST["send_watchmail"])."', ".
						"show_files			= '".quote($this->dblink, $_POST["show_files"])."', ".
						"allow_intercom		= '".quote($this->dblink, $_POST["allow_intercom"])."', ".
						"hide_lastsession	= '".quote($this->dblink, $_POST["hide_lastsession"])."', ".
						"validate_ip		= '".quote($this->dblink, $_POST["validate_ip"])."', ".
						"noid_pubs			= '".quote($this->dblink, $_POST["noid_pubs"])."' ".
					"WHERE user_id = '".quote($this->dblink, $user["user_id"])."' ".
					"LIMIT 1");

				$this->SetMessage($this->GetTranslation("UserSettingsStored"));

				// log event
				$this->Log(6, str_replace("%1", $user["user_name"], $this->GetTranslation("LogUserSettingsUpdate")));
			}
		}
	}

	$email_changed = "";

	// (re)send email confirmation code
	if ((isset($_GET['resend_code']) && $_GET['resend_code'] == 1) || $email_changed === true)
	{
		if ($email = ( $_GET["resend_code"] == 1 ? $user["email"] : $_POST["email"] ))
		{
			$confirm = sha1($user["password"].mt_rand().time().mt_rand().$email.mt_rand());

			$this->Query(
				"UPDATE {$this->config["user_table"]} ".
				"SET email_confirm = '".quote($this->dblink, $confirm)."' ".
				"WHERE user_name = '".quote($this->dblink, $user['user_name'])."' ".
				"LIMIT 1");

			$subject = $this->config["wacko_name"].". ".$this->GetTranslation("EmailConfirm");
			$message = $this->GetTranslation("EmailHello"). $user["user_name"].".\n\n".
						str_replace('%1', $this->config["wacko_name"],
						str_replace('%2', $user["user_name"],
						str_replace('%3', $this->Href().
						($this->config["rewrite_mode"] ? "?" : "&amp;")."confirm=".$confirm,
						$this->GetTranslation("EmailVerify"))))."\n\n".
						$this->GetTranslation("EmailGoodbye")."\n".
						$this->config["wacko_name"]."\n".
						$this->config["base_url"];
			$this->SendMail($email, $subject, $message);
		}
		else
		{
			$this->SetMessage($this->GetTranslation("SettingsCodeNotSent"));
		}
	}

	// reload user data
	if ( (isset($_REQUEST["action"]) && $_REQUEST["action"] == "update") || (isset($_GET["resend_code"]) && $_GET["resend_code"] == 1))
	{
		$this->SetUser($this->LoadUser($user["user_name"]), 0, 1);
		$this->SetBookmarks(BM_USER);

		// forward
		$this->SetMessage($this->GetTranslation("UserSettingsStored",$_POST["lang"]));

		$this->Redirect($this->href());
		$user = $this->GetUser();
	}

	// user is logged in; display config form
	echo $this->FormOpen();

	$code = $this->LoadSingle(
		"SELECT email_confirm ".
		"FROM {$this->config["user_table"]} ".
		"WHERE user_name = '".quote($this->dblink, $user["user_name"])."'");
?>
<input type="hidden" name="action" value="update" />
<div id="cssformX">
<h3><?php echo $this->GetTranslation("UserSettings"); ?></h3>
<table class="form_tbl">
<tbody>
	<tr>
		<th class="form_left" scope="row"><?php echo $this->GetTranslation("UserName");?></th>
		<td><strong><?php echo "<a href=\"".$this->href("", $this->config["users_page"], "profile=".$user["user_name"])."\">".$user["user_name"]."</a>";?></strong></td>
	</tr>
	<tr>
		<th class="form_left" scope="row"><label for="real_name"><?php echo $this->GetTranslation("RealName");?></label></th>
		<td><input id="real_name" name="real_name" value="<?php echo htmlentities($user["real_name"]) ?>" size="40" />
		</td>
	</tr>
	<tr>
		<th class="form_left" scope="row"><a href="<?php echo $this->href("", "Password")?>"><?php echo $this->GetTranslation("YouWantChangePassword");?></a></th>
		<td><input type="button" onclick="location.href='password'" value="<?php echo $this->GetTranslation("YouWantChangePassword");?>" name="_password"/></td>
	</tr>
	<tr>
		<th class="form_left" scope="row"><label for="email"><?php echo $this->GetTranslation("YourEmail");?></label></th>
		<td><input id="email" name="email" value="<?php echo htmlentities($user["email"]) ?>" size="40" />&nbsp;<?php echo $user["email_confirm"] == "" ? '<img src="'.$this->config["base_url"].'images/tick.png" alt="'.$this->GetTranslation("EmailConfirmed").'" title="'.$this->GetTranslation("EmailConfirmed").'" width="20" height="20" />' : '<img src="'.$this->config["base_url"].'images/warning.gif" alt="'.$this->GetTranslation("EmailConfirm").'" title="'.$this->GetTranslation("EmailConfirm").'" width="16" height="16" />' ?>
<?php
		if (!$user["email"] || $code["email_confirm"])
			echo "<div class=\"BewareChangeLang\"><strong class=\"cite\">".
				$this->GetTranslation("EmailNotVerified")."</strong><br />".
				"<small>".$this->GetTranslation("EmailNotVerifiedDesc")."<strong><a href=\"?resend_code=1\">".$this->GetTranslation("HereLink")."</a></strong>.</small></div>";
?></td>
	</tr>
	<tr>
		<th class="form_left" scope="row"><label for="motto"><?php echo $this->GetTranslation("YourMotto");?></label></th>
		<td class="form_right"><textarea id="motto" name="motto" cols="80" rows="2"><?php echo htmlspecialchars($user["motto"]) ?></textarea>
<?php /*
		<script type="text/javascript">
					wE = new WikiEdit();
					wE.init('motto','<a href="<?php echo $this->href('', $this->config['wiki_docs']); ?>" title="<?php echo $this->GetTranslation('WikiEditTitle'); ?>">WikiEdit</a>','edname-w','<?php echo $this->config['base_url']; ?>images/wikiedit/');
				</script>
*/ ?>
	</td>
	</tr>
	<tr class="lined">
		<td></td>
		<td></td>
	</tr>
	<tr>
	<th class="form_left" scope="row"><label for="lang"><?php echo $this->GetTranslation("YourLanguage");?></label></th>
	<td class="form_right"><select id="lang" name="lang">
	<?php
	$langs = $this->AvailableLanguages();
	for ($i = 0; $i < count($langs); $i++)
	{
		echo "<option value=\"".$langs[$i]."\" ".
			($user["lang"] == $langs[$i]
				? " selected=\"selected\""
				: (!isset($user["lang"]) && $this->config["language"] == $langs[$i]
					? "selected=\"selected\""
					: "")
			).">".$langs[$i]."</option>\n";
	}
	?>
</select></td>
	</tr>
	<tr>
		<th class="form_left" scope="row"><label for="theme"><?php echo $this->GetTranslation("ChooseTheme");?></label></th>
		<td class="form_right"><select id="theme" name="theme">

<?php
	$themes = $this->AvailableThemes();
	for ($i = 0; $i < count($themes); $i++)
	{
		echo '<option value="'.$themes[$i].'" '.
			(isset($user["theme"]) && $user["theme"] == $themes[$i]
				? "selected=\"selected\""
				: ($this->config["theme"] == $themes[$i]
					? "selected=\"selected\""
					: "")
			).">".$themes[$i]."</option>\n";
	}
	?>
		</select></td>
	</tr>
	<tr>
		<th class="form_left" scope="row"><label for="bookmarks"><?php echo $this->GetTranslation("YourBookmarks");?></label></th>
		<td class="form_right"><textarea id="bookmarks" name="bookmarks" cols="40" rows="10"><?php echo htmlspecialchars($user["bookmarks"]) ?></textarea></td>
	</tr>
	<tr>
		<th class="form_left" scope="row"><label for="changes_count"><?php echo $this->GetTranslation("RecentChangesLimit");?></label></th>
		<td class="form_right"><input id="changes_count" name="changes_count"
	value="<?php echo htmlentities($user["changes_count"]) ?>" size="40" /></td>
	</tr>
	<tr>
		<th class="form_left" scope="row"><label for="revisions_count"><?php echo $this->GetTranslation("RevisionListLimit");?></label></th>
		<td class="form_right"><input id="revisions_count" name="revisions_count"
	value="<?php echo htmlentities($user["revisions_count"]) ?>" size="40" /></td>
	</tr>
	<tr class="lined">
		<td></td>
		<td></td>
	</tr>
	<tr>
		<th class="form_left" scope="row"><?php echo $this->GetTranslation("UserSettingsOther");?></th>
		<td class="form_right"><input type="hidden" name="doubleclick_edit" value="0" />
		<input
	type="checkbox" id="doubleclick_edit" name="doubleclick_edit" value="1"
	<?php echo (isset($user["doubleclick_edit"]) && $user["doubleclick_edit"] == "1") ? "checked=\"checked\"" : "" ?> />
		<label for="doubleclick_edit"><?php echo $this->GetTranslation("DoubleclickEditing");?></label></td>
	</tr>
	<tr>
		<td class="form_left">&nbsp;</td>
		<td class="form_right"><input type="hidden" name="autocomplete" value="0" />
			<input
	type="checkbox" id="autocomplete" name="autocomplete" value="1"
	<?php echo (isset($user["autocomplete"]) && $user["autocomplete"] == "1") ? "checked=\"checked\"" : "" ?> />
			<label for="autocomplete"><?php echo $this->GetTranslation("WikieditAutocomplete");?></label></td>
	</tr>
	<tr>
		<td class="form_left">&nbsp;</td>
		<td class="form_right"><input type="hidden" name="show_comments" value="0" />
			<input
	type="checkbox" id="show_comments" name="show_comments" value="1"
	<?php echo (isset($user["show_comments"]) && $user["show_comments"] == "1") ? "checked=\"checked\"" : "" ?> />
			<label for="show_comments"><?php echo $this->GetTranslation("ShowComments?");?></label></td>
	</tr>
	<tr>
		<td class="form_left">&nbsp;</td>
		<td class="form_right"><input type="hidden" name="show_files" value="0" />
			<input
	type="checkbox" id="show_files" name="show_files" value="1"
	<?php echo (isset($user["show_files"]) && $user["show_files"] == "1") ? "checked=\"checked\"" : "" ?> />
		<label for="show_files"><?php echo $this->GetTranslation("ShowFiles?");?></label></td>
	</tr>
	<tr>
		<td class="form_left">&nbsp;</td>
		<td class="form_right"><input type="hidden" name="show_spaces" value="0" />
			<input
	type="checkbox" id="show_spaces" name="show_spaces" value="1"
	<?php echo (isset($user["show_spaces"]) && $user["show_spaces"] == "1") ? "checked=\"checked\"" : "" ?> />
		<label for="show_spaces"><?php echo $this->GetTranslation("ShowSpaces");?></label></td>
	</tr>
	<tr>
		<td class="form_left">&nbsp;</td>
		<td class="form_right"><input type="hidden" name="dont_redirect" value="0" />
			<input
	type="checkbox" id="dont_redirect" name="dont_redirect" value="1"
	<?php echo (isset($user["dont_redirect"]) && $user["dont_redirect"] == "1") ? "checked=\"checked\"" : "" ?> />
	<label for="dont_redirect"><?php echo $this->GetTranslation("DontRedirect");?></label></td>
	</tr>
	<tr>
	<td class="form_left">&nbsp;</td>
	<td class="form_right"><input type="hidden" name="send_watchmail" value="0" />
		<input
	type="checkbox" id="send_watchmail" name="send_watchmail" value="1"
	<?php echo (isset($user["send_watchmail"]) && $user["send_watchmail"] == "1") ? "checked=\"checked\"" : "" ?> />
		<label for="send_watchmail"><?php echo $this->GetTranslation("SendWatchEmail");?></label></td>
	</tr>
	<tr>
		<td class="form_left">&nbsp;</td>
		<td class="form_right"><input type="hidden" name="allow_intercom" value="0" />
		<input
	type="checkbox" id="allow_intercom" name="allow_intercom" value="1"
	<?php echo (isset($user["allow_intercom"]) && $user["allow_intercom"] == "1") ? "checked=\"checked\"" : "" ?> />
	<label for="allow_intercom"><?php echo $this->GetTranslation("AllowIntercom");?></label></td>
	</tr>

	<tr>
		<td class="form_left">&nbsp;</td>
		<td class="form_right">
			<input type="hidden" name="validate_ip" value="0" />
			<input type="checkbox" name="validate_ip" id="validate_ip" value="1" <?php echo (isset($user['validate_ip']) && $user['validate_ip'] == '1') ? 'checked' : '' ?> />
		<label for="validate_ip"><?php echo $this->GetTranslation('ValidateIP');?></label></td>
	</tr>
	<tr>
		<td class="form_left">&nbsp;</td>
		<td class="form_right">
			<input type="hidden" name="hide_lastsession" value="0" />
			<input type="checkbox" name="hide_lastsession" id="hide_lastsession" value="1" <?php echo (isset($user['hide_lastsession']) && $user['hide_lastsession'] == '1') ? 'checked' : '' ?> />
		<label for="hide_lastsession"><?php echo $this->GetTranslation('HideLastSession');?></label></td>
	</tr>
	<tr>
		<td class="form_left">&nbsp;</td>
		<td class="form_right">
			<input type="hidden" name="noid_pubs" value="0" />
			<input type="checkbox" name="noid_pubs" id="noid_pubs" value="1" <?php echo (isset($user['noid_pubs']) && $user['noid_pubs'] == '1') ? 'checked' : '' ?> />
		<label for="noid_pubs"><?php echo $this->GetTranslation('ProfileAnonymousPub');?></label></td>
	</tr>
	<!--<tr>
		<td class="form_left">&nbsp;</td>
		<td class="form_right">
	<input type="hidden" name="typografica" value="0" /><input type="checkbox" id="typografica" name="typografica" value="1" <?php echo (isset($user["typografica"]) && $user["typografica"] == "1") ? "checked=\"checked\"" : "" ?> /><label for="typografica"><?php echo $this->GetTranslation("Typografica");?></label>
	</td>
	</tr>-->
	<tr class="lined">
		<td></td>
		<td></td>
	</tr>
	<tr>
	<td class="form_left">&nbsp;</td>
	<td class="form_right">
		<input id="submit" name="submit" type="submit" value="<?php echo $this->GetTranslation("UpdateSettingsButton"); ?>" />
		&nbsp;
		<input id="button" name="button" type="button" onclick="document.location='<?php echo $this->href("", "", "action=logout"); ?>'" value="<?php echo $this->GetTranslation("LogoutButton"); ?>" />
	</td>
	</tr>
	</tbody>
</table>
</div>
<br />
	<?php
	//  echo $this->FormatTranslation("SeeListOfPages")."<br />";
	echo $this->FormClose();
}
else
{
	// user is not logged in
	echo $this->Action("login", array());
}
?>
<!--/notypo-->