<!--notypo-->
<?php

if ($_POST["secret_code"])
{
	// Password forgotten. Provided secret code
	$code = $_POST["secret_code"];
	$user = $this->LoadSingle(
		"SELECT * ".
		"FROM ".$this->config["user_table"]." ".
		"WHERE changepassword='".quote($this->dblink, $code)."'");

	if ($user)
	{
		if ($_POST["newpassword"])
		{

			//Password forgotten. Provided secret code and new password. Change password.
			$newpassword = $_POST["newpassword"];
			$confpassword = $_POST["confpassword"];

			// check all conditions
			if ($confpassword != $newpassword)
				$error = $this->GetTranslation("PasswordsDidntMatch");
			else if (preg_match("/ /", $newpassword))
				$error = $this->GetTranslation("SpacesArentAllowed");
			else if (strlen($newpassword) < 5)
				$error = $this->GetTranslation("PasswordTooShort");
			else
			{
				$this->Query(
					"UPDATE ".$this->config["user_table"]." ".
					"SET password = '".quote($this->dblink, md5($newpassword))."' ".
					"WHERE name = '".quote($this->dblink, $user["name"])."' ".
					"LIMIT 1");

				$this->SetUser($user = $this->LoadUser($user["name"]));
				$this->LogUserIn($user);

				// log event
				$this->Log(3, str_replace("%1", $user["name"], $this->GetTranslation("LogUserPasswordRecovered")));

				// forward
				$this->SetMessage($this->GetTranslation("PasswordChanged"));
				$this->Redirect($this->href());
			}
			if ($error) $this->SetMessage($error);
		}
		else
		{
			//Password forgotten. Provided secret code only. Print password change form.
			print($this->FormOpen());
			echo "<input type=\"hidden\" name=\"secret_code\" value=\"".$code."\" />";
			?>

			<div class="cssform">
				<h3><?php echo $this->Format( str_replace('%1', $user["name"], $this->GetTranslation("YouWantChangePasswordForUser"))); ?></h3>
				<p>
					<label for="newpassword"><?php echo $this->GetTranslation("NewPassword");?>:</label>
					<input type="password" id="newpassword" name="newpassword" size="24" />
				</p>
				<p>
					<label for="confpassword"><?php echo $this->GetTranslation("ConfirmPassword");?>:</label>
					<input type="password" id="confpassword" name="confpassword" size="24" />
				</p>
				<p>
				<input type="submit" value="<?php echo $this->GetTranslation("RegistrationButton"); ?>" />
				</p>
			</div>
			<?php
			print($this->FormClose());
		}
	}
	else
	{
		echo $this->SetMessage($this->GetTranslation("WrongCode"));
	}
}
else if (!$forgot && $user = $this->GetUser())
{
	// is user trying to update?
	if ($_POST["action"] == "change")
	{
		//Simple change password
		$password = $_POST["password"];
		$newpassword = $_POST["newpassword"];
		$confpassword = $_POST["confpassword"];

		// check all conditions

		// wrong current password
		if (md5($password)!=$user["password"])
		{
			$error = $this->GetTranslation("WrongPassword");
			// log event
			$this->Log(3, str_replace("%1", $user["name"], $this->GetTranslation("LogUserPasswordMismatch")));
		}
		// confirmed password mismatch
		else if ($confpassword != $newpassword)
		{
			$error = $this->GetTranslation("PasswordsDidntMatch");
		}
		// spaces in password
		else if (preg_match("/ /", $newpassword))
		{
			$error = $this->GetTranslation("SpacesArentAllowed");
		}
		// password complexity validation
		else if (strlen($newpassword) < 5)
		{
			$error = $this->GetTranslation("PasswordTooShort");
		}
		else
		{
			// store new password
			$this->Query(
				"UPDATE ".$this->config["user_table"]." ".
				"SET password = '".quote($this->dblink, md5($newpassword))."' ".
				"WHERE name = '".quote($this->dblink, $user["name"])."' ".
				"LIMIT 1");

			$this->SetUser($user = $this->LoadUser($user["name"]));
			$this->LogUserIn($user);

			// log event
			$this->Log(3, str_replace("%1", $user["name"], $this->GetTranslation("LogUserPasswordChanged")));

			// forward
			$this->SetMessage($this->GetTranslation("PasswordChanged"));

			$this->Redirect($this->href());
		}
	}
	//Print simple change password form
	print($this->FormOpen());
	?>
	<input type="hidden" name="action" value="change" />
	<div class="cssform">
		<h3><?php echo $this->FormatTranslation("YouWantChangePassword"); ?></h3>
		<?php
	if ($error)
	{
		$this->SetMessage($this->Format($error));
	}
	?>
		<p>
			<label for="password"><?php echo $this->GetTranslation("CurrentPassword");?>:</label>
			<input type="password" id="password" name="password" size="24" />
		</p>
		<p>
			<label for="newpassword"><?php echo $this->GetTranslation("NewPassword");?>:</label>
			<input type="password" id="newpassword" name="newpassword" size="24" />
		</p>
		<p>
			<label for="confpassword"><?php echo $this->GetTranslation("ConfirmPassword");?>:</label>
			<input type="password" id="confpassword" name="confpassword" size="24" />
		</p>
		<p>
			<input type="submit" value="<?php echo $this->GetTranslation("RegistrationButton"); ?>" />
		</p>
	</div>
<?php
	print($this->FormClose());
}
//Password forgotten. Send mail
else
{
	if ($_POST["action"] == "send")
	{
		$name = str_replace(" ","", $_POST["loginormail"]);
		$user = $this->LoadSingle(
			"SELECT * ".
			"FROM ".$this->config["user_table"]." ".
			"WHERE name='".quote($this->dblink, $name)."' ".
				"OR email='".quote($this->dblink, $name)."'");

		if ($user)
		{
			if ($user["email_confirm"] == "")
			{
				$code = md5(date("D d M Y H:i:s").$user["email"].rand());

				// update table
				$this->Query(
					"UPDATE ".$this->config["user_table"]." ".
					"SET changepassword = '".quote($this->dblink, $code)."' ".
					"WHERE name = '".quote($this->dblink, $user["name"])."' ".
					"LIMIT 1");

				$subject =	$this->GetTranslation("EmailForgotSubject").
							$this->GetConfigValue("wacko_name");
				$message =	$this->GetTranslation("MailHello"). $name.".\n\n".
							str_replace('%1', $this->GetConfigValue("wacko_name"),
							str_replace('%2', $user["name"],
							str_replace('%3', $this->Href().($this->config["rewrite_mode"] ? "?" : "&amp;")."secret_code=".$code,
							$this->GetTranslation("EmailForgotMessage"))))."\n";
				$message.=	"\n".$this->GetTranslation("MailGoodbye").
							"\n".$this->GetConfigValue("wacko_name").
							"\n".$this->config["base_url"];

				// send code
				$this->SendMail($user["email"], $subject, $message);

				// log event
				$this->Log(3, str_replace("%2", $user["email"], str_replace("%1", $user["name"], $this->GetTranslation("LogUserPasswordReminded"))));

				$this->SetMessage($this->GetTranslation("CodeWasSent"));
				$this->Redirect($this->href());

			}
			else
			{
				$error = $this->GetTranslation("NotConfirmedMail");
			}
		}
		else
		{
			$error = $this->GetTranslation("UserNotFound");
		}
	}
	// View password forgot form
	if ($error || $_POST["action"] != "send")
	{
		//View password forgot form
		print($this->FormOpen());
		?>
		<input type="hidden" name="action" value="send" />
		<div class="cssform">
		<h3><?php echo $this->FormatTranslation("ForgotMain"); ?></h3>
		<?php
		if ($error)
		{
			$this->SetMessage($error);
		}
		?>
		<p><?php echo $this->FormatTranslation("ForgotComment"); ?></p>
		<p>
			<label for="loginormail"><?php echo $this->FormatTranslation("ForgotField"); ?>:</label>
			<input type="text" id="loginormail" name="loginormail" size="24" />
		</p>
		<p>
			<input type="submit" value="<?php echo $this->GetTranslation("SendButton"); ?>" />
		</p>
		</div>
		<?php
		print($this->FormClose());
	}
}

?>
<!--/notypo-->
