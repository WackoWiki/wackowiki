<!--notypo-->
<?php
// reconnect securely in ssl mode
if ($this->config["ssl"] == true && $_SERVER["HTTPS"] != "on")
{
	$this->Redirect(str_replace("http://", "https://", $this->href()));
}

// is user trying to confirm email, login or register?
if ($_GET["confirm"])
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

		echo "<div class=\"info\">".$this->GetTranslation("EmailConfirmed")."</div><br />";

		// log event
		$this->Log(4, str_replace("%2", $temp["user_name"], str_replace("%1", $temp["email"], $this->GetTranslation("LogUserEmailActivated"))));

		unset($temp);
	}
	else
	{
		echo "<div class=\"info\">".str_replace('%1', $this->ComposeLinkToPage('Settings', '', $this->GetTranslation("SettingsText"), 0), $this->GetTranslation("EmailNotConfirmed"))."</div><br />";
	}
}
else if ($_POST["action"] == "login")
{
	// create new account if possible
	if ($this->GetConfigValue("allow_registration") || $this->IsAdmin())
	{
		// passing vars from user input
		$name = trim($_POST["name"]);
		$email = trim($_POST["email"]);
		$password = $_POST["password"];
		$confpassword = $_POST["confpassword"];
		$lang = $_POST["lang"];
		$complexity	= $this->PasswordComplexity($name, $password);

		// Start Registration Captcha

		// Only show captcha if the admin enabled it in the config file
		if(!$this->IsAdmin() && $this->GetConfigValue("captcha_registration"))
		{
			// Don't load the captcha at all if the GD extension isn't enabled
			if(extension_loaded('gd'))
			{
				// check whether anonymous user
				// anonymous user has no name
				// if false, we assume it's anonymous
				if($this->GetUserName() == false)
				{
					//anonymous user, check the captcha
					if(!empty($_SESSION['freecap_word_hash']) && !empty($_POST['word']))
					{
						if($_SESSION['hash_func'](strtolower($_POST['word'])) == $_SESSION['freecap_word_hash'])
						{
							// reset freecap session vars
							// cannot stress enough how important it is to do this
							// defeats re-use of known image with spoofed session id
							$_SESSION['freecap_attempts'] = 0;
							$_SESSION['freecap_word_hash'] = false;

							// now process form
							$word_ok = true;
						}
						else
						{
							$word_ok = false;
						}
					}
					else
					{
						$word_ok = false;
					}

					if(!$word_ok)
					{
						//not the right word
						$error = $this->GetTranslation("SpamAlert");
						$this->SetMessage($this->GetTranslation("SpamAlert"));
					}
				}
			}
		}
		// End Comment Captcha

		if (($word_ok) || $this->IsAdmin() || !$this->GetConfigValue("captcha_registration"))
		{
			// check if name is WikiName style
			if (!$this->IsWikiName($name))
				$error .= $this->GetTranslation("MustBeWikiName")." ";
			// if user name already exists
			else if ($this->UsernameExists($name) === true)
			{
				$error .= $this->GetTranslation("RegistrationNameOwned");

				// log event
				$this->Log(2, str_replace("%1", $name, $this->GetTranslation("LogUserSimiliarName")));
			}
			// no email given
			else if ($email == "")
				$error .= $this->GetTranslation("SpecifyEmail")." ";
			// invalid email
			else if (!preg_match("/^.+?\@.+$/", $email))
				$error .= $this->GetTranslation("NotAEmail")." ";

			// confirmed password mismatch
			else if ($confpassword != $password)
				$error .= $this->GetTranslation("PasswordsDidntMatch")." ";
			// spaces in password
			else if (preg_match("/ /", $password))
				$error .= $this->GetTranslation("SpacesArentAllowed")." ";
			// password complexity validation
			else if ($complexity > 0)
			{
				if ($complexity >= 5)
				{
					$error .= $this->GetTranslation("PwdCplxWeak")." ";
					$complexity -= 5;
				}
				if ($complexity >= 2)
				{
					$error .= $this->GetTranslation("PwdCplxShort")." ";
					$complexity -= 2;
				}
				if ($complexity >= 1)
				{
					$error .= $this->GetTranslation("PwdCplxEquals")." ";
					$complexity -= 1;
				}
			}

			// submitting input to DB
			else
			{
				$confirm = md5($password.mt_rand().time().mt_rand().$email.mt_rand());
				$more = $this->ComposeOptions(array(
					"theme" => $this->GetConfigValue("theme"),
					"send_watchmail" => "1",
				));

				$this->Query(
					"INSERT INTO ".$this->config["user_table"]." ".
					"SET ".
						"signup_time = NOW(), ".
						"user_name = '".quote($this->dblink, $name)."', ".
						"email = '".quote($this->dblink, $email)."', ".
						"email_confirm = '".quote($this->dblink, $confirm)."', ".
						"bookmarks = '".quote($this->dblink, $this->GetDefaultBookmarks($lang))."', ".
						"typografica = '".(($this->config["default_typografica"] == 1) ? "1" : "0")."', ".
						"more = '".quote($this->dblink, $more)."', ".
						($lang
							? "lang = '".quote($this->dblink, $lang)."', "
							: "").
						"password = md5('".quote($this->dblink, $_POST["password"])."')");

				$subject = 	$this->GetTranslation("EmailWelcome").
							$this->GetConfigValue("wacko_name");
				$message = 	$this->GetTranslation("EmailHello"). $name.".\n\n".
							str_replace('%1', $this->GetConfigValue("wacko_name"),
							str_replace('%2', $name,
							str_replace('%3', $this->Href().
							($this->config["rewrite_mode"] ? "?" : "&amp;")."confirm=".$confirm,
							$this->GetTranslation("EmailRegistered"))))."\n\n".
							$this->GetTranslation("EmailGoodbye")."\n".
							$this->GetConfigValue("wacko_name")."\n".
							$this->config["base_url"];
				$this->SendMail($email, $subject, $message);

				// log event
				$this->Log(4, str_replace("%2", $email, str_replace("%1", $name, $this->GetTranslation("LogUserRegistered"))));

				// forward
				$this->SetMessage($this->GetTranslation("SiteRegistered").
					$this->config["wacko_name"].". ".
					$this->GetTranslation("SiteEmailConfirm"));
				$this->context[++$this->current_context] = "";
				$this->Redirect($this->Href("", $this->GetTranslation("LoginPage")));
			}
		}
	}
}

if (!$_POST["confirm"])
{
	if ($this->GetConfigValue("allow_registration") || $this->IsAdmin())
	{
		if ($error) $this->SetMessage($this->Format($error));

		print($this->FormOpen());
		?>
<input type="hidden"
	name="action" value="login" />
<div class="cssform">
<h3><?php echo $this->FormatTranslation("RegistrationWelcome"); ?></h3>
		<?php

		if ($this->GetConfigValue("multilanguage"))
		{
			?>
<p><label for="lang"><?php echo $this->FormatTranslation("RegistrationLang");?>:</label>
<select id="lang" name="lang">
	<!--<option value=""></option>-->
<?php
$lang = $this->UserAgentLanguage();
$langs = $this->AvailableLanguages();
for ($i = 0; $i < count($langs); $i++)
{

	echo "<option value=\"".$langs[$i]."\"".($lang == $langs[$i] ? "selected=\"selected\"" : "").">".$langs[$i]."</option>\n";
}
?>
</select></p>
<?php
		}
		?>
<p><label for="name"><?php echo $this->FormatTranslation("RegistrationName");?>:</label>
<input id="name" name="name" size="27" value="<?php echo htmlspecialchars($name); ?>" /></p>



<p><label for="password"><?php echo $this->GetTranslation("RegistrationPassword");?>:</label>
<input type="password" id="password" name="password" size="24" value="<?php echo $password ?>" />
<?php
if ($this->config["pwd_char_classes"] > 0)
{
	$PwdCplxText = $this->GetTranslation("PwdCplxDesc4");
	if 		($this->config["pwd_char_classes"] == 1)
		$PwdCplxText .= $this->GetTranslation("PwdCplxDesc41");
	else if ($this->config["pwd_char_classes"] == 2)
		$PwdCplxText .= $this->GetTranslation("PwdCplxDesc42");
	else if ($this->config["pwd_char_classes"] == 3)
		$PwdCplxText .= $this->GetTranslation("PwdCplxDesc43");
	$PwdCplxText .= ". ".$this->GetTranslation("PwdCplxDesc5");
}
echo "<br /><small>".
	 $this->GetTranslation("PwdCplxDesc1").
	 str_replace("%1", $this->config["pwd_min_chars"],
		$this->GetTranslation("PwdCplxDesc2")).
	 ($this->config["pwd_unlike_login"] > 0
		? ", ".$this->GetTranslation("PwdCplxDesc3")
		: "").
	 ($this->config["pwd_char_classes"] > 0
		? ", ".$PwdCplxText
		: "")."</small>";
?>
</p>
<p><label for="confpassword"><?php echo $this->GetTranslation("ConfirmPassword");?>:</label>
<input type="password" id="confpassword" name="confpassword" size="24"
	value="<?php echo $confpassword ?>" /></p>
<p>
<?php
/* TODO: add message -> A valid e-mail address. All e-mails from the system will be sent to this address. The e-mail address is not made public and will only be used if you wish to receive a new password or wish to receive certain news or notifications by e-mail. */ ?>
<label for="email"><?php echo $this->GetTranslation("Email");?>:</label>
<input id="email" name="email" size="30"
	value="<?php echo htmlspecialchars($email); ?>" /></p>
		<?php
		// captcha code starts

		// Only show captcha if the admin enabled it in the config file
		if($this->GetConfigValue("captcha_registration"))
		{
			// Don't load the captcha at all if the GD extension isn't enabled
			if(extension_loaded('gd'))
			{
				// check whether anonymous user
				// anonymous user has no name
				// if false, we assume it's anonymous
				if($this->GetUserName() == false)
				{
					?>
<p><label for="captcha"><?php echo $this->GetTranslation("Captcha");?>:</label>
<img
	src="<?php echo $this->GetConfigValue("root_url");?>lib/captcha/freecap.php"
	id="freecap" alt="<?php echo $this->GetTranslation("Captcha");?>" /> <a
	href="" onclick="this.blur(); new_freecap(); return false;"
	title="<?php echo $this->GetTranslation("CaptchaReload"); ?>"><img
	src="<?php echo $this->GetConfigValue("root_url");?>images/reload.png"
	width="18" height="17"
	alt="<?php echo $this->GetTranslation("CaptchaReload"); ?>" /></a> <br />
<input id="captcha" type="text" name="word" maxlength="6"
	style="width: 273px;" /></p>
					<?php
				}
			}
		}
		// end captcha
		?>
<p><input type="submit" value="<?php echo $this->GetTranslation("RegistrationButton"); ?>" /></p>
</div>
		<?php
		print($this->FormClose());
	}
	else
	{
		echo($this->GetTranslation("RegistrationClosed"));
	}
}
?>
<!--/notypo-->