<!--notypo-->
<?php

// email confirmation
if ($_POST["confirm"])
{
	if ($temp = $this->LoadSingle(
			"SELECT name, email, email_confirm ".
			"FROM ".$this->config["user_table"]." ".
			"WHERE email_confirm = '".quote($this->dblink, $_POST["confirm"])."'"))
	{
		$this->Query(
			"UPDATE ".$this->config["user_table"]." ".
			"SET email_confirm = '' ".
			"WHERE email_confirm = '".quote($this->dblink, $_POST["confirm"])."'");

		echo "<br /><br />".$this->GetTranslation("EmailConfirmed")."<br /><br />";

		// log event
		$this->Log(4, str_replace("%2", $temp["name"], str_replace("%1", $temp["email"], $this->GetTranslation("LogUserEmailActivated"))));

		unset($temp);
	}
	else
	echo "<br /><br />".str_replace('%1', $this->ComposeLinkToPage('Settings', '', $this->GetTranslation("SettingsText"), 0), $this->GetTranslation("EmailNotConfirmed"))."<br /><br />";
}
else if ($_POST["action"] == "logout")
{
	$this->LogoutUser();
	$this->SetMessage($this->GetTranslation("LoggedOut"));
	$this->Redirect($this->href());
}
else if ($user = $this->GetUser())
{
	$this->SetPageLang($this->userlang);

	// is user trying to update?
	if ($_POST["action"] == "update")
	{
		$bookmarks = str_replace("\r", "", $_POST["bookmarks"]);

		$more = $this->ComposeOptions(array(
		"theme" => $_POST["theme"],
		"autocomplete" => $_POST["autocomplete"],
		"dont_redirect" => $_POST["dont_redirect"],
		"send_watchmail" => $_POST["send_watchmail"],
		"show_files" => $_POST["show_files"],
		));

		if ($user["email"] != $_POST["email"])
		{
			$confirm = md5(rand().$_POST["email"].rand());

			$subject = $this->config["wacko_name"].". ".$this->GetTranslation("EmailConfirm");
			$message = $this->GetTranslation("MailHello"). $user["name"].".<br /> <br /> ";
			$message.= str_replace('%1', $this->GetConfigValue("wacko_name"),
			str_replace('%2', $user["name"],
			str_replace('%3', $this->Href().($this->config["rewrite_mode"] ? "?" : "&amp;")."confirm=".$confirm,
			$this->GetTranslation("EmailVerify"))))."<br />  ";
			$message.= "<br />".$this->GetTranslation("MailGoodbye")." ".$this->GetConfigValue("wacko_name");
			$this->SendMail($_POST["email"], $subject, $message);
		}

		$this->Query(
			"UPDATE ".$this->config["user_table"]." SET ".
				"email = '".quote($this->dblink, $_POST["email"])."', ".
		($confirm ? "email_confirm = '".quote($this->dblink, $confirm)."', " : "").
				"doubleclickedit = '".quote($this->dblink, $_POST["doubleclickedit"])."', ".
				"show_datetime = '".quote($this->dblink, $_POST["showdatetimeinlinks"])."', ".
				"show_comments = '".quote($this->dblink, $_POST["show_comments"])."', ".
				"revisioncount = '".quote($this->dblink, $_POST["revisioncount"])."', ".
				"changescount = '".quote($this->dblink, $_POST["changescount"])."', ".
				"motto = '".quote($this->dblink, $_POST["motto"])."', ".
				"bookmarks = '".quote($this->dblink, $bookmarks)."', ".
				"show_spaces = '".quote($this->dblink, $_POST["show_spaces"])."', ".
				"typografica = '".quote($this->dblink, $_POST["typografica"])."', ".
				"lang = '".quote($this->dblink, $_POST["lang"])."', ".
				"more = '".quote($this->dblink, $more)."' ".
			"WHERE name = '".quote($this->dblink, $user["name"])."' LIMIT 1");

		$this->SetUser($this->LoadUser($user["name"]));
		$this->SetBookmarks(BM_USER);

		// forward
		$this->SetMessage($this->GetTranslation("SettingsStored",$_POST["lang"]));

		// log event
		$this->Log(6, str_replace("%1", $user["name"], $this->GetTranslation("LogUserSettingsUpdate")));

		$this->Redirect($this->href());
	}
	// user is logged in; display config form
	print($this->FormOpen());
	?>

<input type="hidden"
	name="action" value="update" />
<div id="cssformX">
<h3><?php echo $this->GetTranslation("Hello").", ".$this->ComposeLinkToPage($user["name"]) ?>!</h3>
<p>&nbsp;</p>
<table class="form_tbl">
<tbody>
  <tr>
    <td class="form_left"><a href="<?php echo $this->href("", "Password")?>"><?php echo $this->GetTranslation("YouWantChangePassword");?></a></td>
    <td><input type="button" onclick="location.href='password'" value="<?php echo $this->GetTranslation("YouWantChangePassword");?>" name="_password"/></td>
  </tr>
  <tr>
    <td class="form_left"><label for="email"><?php echo $this->GetTranslation("YourEmail");?>:</label></td>
    <td><input id="email" name="email"
	value="<?php echo htmlentities($user["email"]) ?>" size="40" />
&nbsp;<?php echo $user["email_confirm"] == "" ? '<img src="'.$this->GetConfigValue("root_url").'images/tick.png" alt="'.$this->GetTranslation("EmailConfirmed").'" title="'.$this->GetTranslation("EmailConfirmed").'" width="20" height="20" />' : '<img src="'.$this->GetConfigValue("root_url").'images/warning.gif" alt="'.$this->GetTranslation("EmailConfirm").'" title="'.$this->GetTranslation("EmailConfirm").'" width="16" height="16" />' ?> </td>
  </tr>
  <tr>
    <td class="form_left">other tuning</td>
    <td class="form_right"><input type="hidden" name="doubleclickedit" value="0" />
      <input
	type="checkbox" id="doubleclickedit" name="doubleclickedit" value="1"
	<?php echo $user["doubleclickedit"] == "1" ? "checked=\"checked\"" : "" ?> />
      <label for="doubleclickedit"><?php echo $this->GetTranslation("DoubleclickEditing");?></label></td>
  </tr>
  <tr>
    <td class="form_left">&nbsp;</td>
    <td class="form_right"><input type="hidden" name="autocomplete" value="0" />
      <input
	type="checkbox" id="autocomplete" name="autocomplete" value="1"
	<?php echo $user["options"]["autocomplete"] == "1" ? "checked=\"checked\"" : "" ?> />
      <label for="autocomplete"><?php echo $this->GetTranslation("WikieditAutocomplete");?></label></td>
  </tr>
  <tr>
    <td class="form_left">&nbsp;</td>
    <td class="form_right"><input type="hidden" name="showdatetimeinlinks" value="0" />
      <input
	type="checkbox" id="showdatetimeinlinks" name="showdatetimeinlinks"
	value="1"
	<?php echo $user["show_datetime"] == "1" ? "checked=\"checked\"" : "" ?> />
      <label for="showdatetimeinlinks"><?php echo $this->GetTranslation("ShowDateTimeInLinks");?></label></td>
  </tr>
  <tr>
    <td class="form_left">&nbsp;</td>
    <td class="form_right"><input type="hidden" name="show_comments" value="0" />
      <input
	type="checkbox" id="show_comments" name="show_comments" value="1"
	<?php echo $user["show_comments"] == "1" ? "checked=\"checked\"" : "" ?> />
      <label for="show_comments"><?php echo $this->GetTranslation("ShowComments?");?></label></td>
  </tr>
  <tr>
    <td class="form_left">&nbsp;</td>
    <td class="form_right"><input type="hidden" name="show_files" value="0" />
      <input
	type="checkbox" id="show_files" name="show_files" value="1"
	<?php echo $user["options"]["show_files"] == "1" ? "checked=\"checked\"" : "" ?> />
      <label for="show_files"><?php echo $this->GetTranslation("ShowFiles?");?></label></td>
  </tr>
  <tr>
    <td class="form_left">&nbsp;</td>
    <td class="form_right"><input type="hidden" name="show_spaces" value="0" />
      <input
	type="checkbox" id="show_spaces" name="show_spaces" value="1"
	<?php echo $user["show_spaces"] == "1" ? "checked=\"checked\"" : "" ?> />
      <label for="show_spaces"><?php echo $this->GetTranslation("ShowSpaces");?></label></td>
  </tr>
  <tr>
    <td class="form_left">&nbsp;</td>
    <td class="form_right"><input type="hidden" name="dont_redirect" value="0" />
      <input
	type="checkbox" id="dont_redirect" name="dont_redirect" value="1"
	<?php echo $user["options"]["dont_redirect"] == "1" ? "checked=\"checked\"" : "" ?> />
      <label for="dont_redirect"><?php echo $this->GetTranslation("DontRedirect");?></label></td>
  </tr>
  <tr>
    <td class="form_left">&nbsp;</td>
    <td class="form_right"><input type="hidden" name="send_watchmail" value="0" />
      <input
	type="checkbox" id="send_watchmail" name="send_watchmail" value="1"
	<?php echo $user["options"]["send_watchmail"] == "1" ? "checked=\"checked\"" : "" ?> />
      <label for="send_watchmail"><?php echo $this->GetTranslation("SendWatchMail");?></label></td>
  </tr>
  <tr>
    <!--<td class="form_left">&nbsp;</td>
    <td class="form_right">
	<input type="hidden" name="typografica" value="0" /><input type="checkbox" id="typografica" name="typografica" value="1" <?php echo $user["typografica"] == "1" ? "checked=\"checked\"" : "" ?> /><label for="typografica"><?php echo $this->GetTranslation("Typografica");?></label>
	</td>
  </tr>-->
  <tr>
    <td class="form_left"><label for="lang"><?php echo $this->GetTranslation("YourLanguage");?>:</label></td>
    <td class="form_right"><select id="lang" name="lang">
	<option value=""></option>
	<?php
	$langs = $this->AvailableLanguages();
	for ($i = 0; $i < count($langs); $i++)
	{
		echo '<option value="'.$langs[$i].'"'.($user["lang"] == $langs[$i] ? "selected=\"selected\"" : "").'>'.$langs[$i].'</option>';
	}
	?>
</select></td>
  </tr>
  <tr>
    <td class="form_left"><label for="theme"><?php echo $this->GetTranslation("ChooseTheme");?>:</label></td>
    <td class="form_right"><select id="theme" name="theme">
      <option value=""></option>
      <?php
	$themes = $this->AvailableThemes();
	for ($i = 0; $i < count($themes); $i++)
	{
		echo '<option value="'.$themes[$i].'" '.($user["options"]["theme"] == $themes[$i] ? "selected=\"selected\"" : "").'>'.$themes[$i].'</option>';
	}
	?>
    </select></td>
  </tr>
  <tr>
    <td class="form_left"><label for="label"><?php echo $this->GetTranslation("RecentChangesLimit");?>:</label></td>
    <td class="form_right"><input id="changescount" name="changescount"
	value="<?php echo htmlentities($user["changescount"]) ?>" size="40" /></td>
  </tr>
  <tr>
    <td class="form_left"><label for="label"><?php echo $this->GetTranslation("RevisionListLimit");?>:</label></td>
    <td class="form_right"><input id="revisioncount" name="revisioncount"
	value="<?php echo htmlentities($user["revisioncount"]) ?>" size="40" /></td>
  </tr>
  <tr>
    <td class="form_left"><label for="label"><?php echo $this->GetTranslation("YourMotto");?>:</label></td>
    <td class="form_right"><input id="motto" name="motto"
	value="<?php echo htmlspecialchars($user["motto"]) ?>" size="40" /></td>
  </tr>
  <tr>
    <td class="form_left"><label for="label"><?php echo $this->GetTranslation("YourBookmarks");?>:</label></td>
    <td class="form_right"><textarea id="bookmarks" name="bookmarks" cols="40" rows="10"><?php echo htmlspecialchars($user["bookmarks"]) ?></textarea></td>
  </tr>
  <tr>
    <td class="form_left">&nbsp;</td>
    <td class="form_right"><input name="submit" type="submit" value="<?php echo $this->GetTranslation("UpdateSettingsButton"); ?>" />
&nbsp;
<input name="button" type="button"
	onclick="document.location='<?php echo $this->href("", "", "action=logout"); ?>'" value="<?php echo $this->GetTranslation("LogoutButton"); ?>" /></td>
  </tr>
  </tbody>
</table>
</div>
<br />
	<?php
	//  echo $this->FormatTranslation("SeeListOfPages")."<br />";
	print($this->FormClose());
}
else
{
	// user is not logged in
	echo $this->Action("login", array());
}
?>
<!--/notypo-->