<!--notypo-->
<?php

// reconnect securely in ssl mode
if ($this->config["ssl"] == true && $_SERVER["HTTPS"] != "on")
{
	$this->Redirect(str_replace("http://", "https://", $this->href()));
}

if (isset($_GET["secret_code"]) && $_GET["secret_code"])
{
	// Password forgotten. Provided secret code
	$code = $_GET["secret_code"];
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
			$complexity		= $this->PasswordComplexity($user, $newpassword);
			// confirmed password mismatch
			if ($confpassword != $newpassword)
			{
				$error = $this->GetTranslation("PasswordsDidntMatch");
			}
			// spaces in password
			else if (preg_match("/ /", $newpassword))
			{
				$error = $this->GetTranslation("SpacesArentAllowed");
			}
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
			else
			{
				$this->Query(
					"UPDATE ".$this->config["user_table"]." ".
					"SET password = '".quote($this->dblink, md5($newpassword))."' ".
						"changepassword	= '' ".
					"WHERE name = '".quote($this->dblink, $user["name"])."' ".
					"LIMIT 1");

				#$this->SetUser($user = $this->LoadUser($user["name"]));
				#$this->LogUserIn($user);

				// log event
				$this->Log(3, str_replace("%1", $user["name"], $this->GetTranslation("LogUserPasswordRecovered")));

				// forward
				$this->SetMessage($this->GetTranslation("PasswordChanged"));
				$this->Redirect($this->href("", $this->GetTranslation("LoginPage")));
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
// is user trying to update?
else if (!isset($forgot) && $user = $this->GetUser())
{
	// is user trying to update?
	if (isset($_POST["action"]) && $_POST["action"] == "change")
	{
		//Simple change password
		$password = $_POST["password"];
		$newpassword = $_POST["newpassword"];
		$confpassword = $_POST["confpassword"];

		// check all conditions
		$complexity		= $this->PasswordComplexity($user["name"], $newpassword);

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
		else
		{
			// store new password
			$this->Query(
				"UPDATE ".$this->config["user_table"]." ".
				"SET password = '".quote($this->dblink, md5($newpassword))."' ".
				"WHERE name = '".quote($this->dblink, $user["name"])."' ".
				"LIMIT 1");

			// reinitialize user session
			$this->LogoutUser();
			$this->SetBookmarks(BM_DEFAULT);
			$this->context[++$this->current_context] = "";
			#$this->SetUser($user = $this->LoadUser($user["name"]));
			#$this->LogUserIn($user);

			// log event
			$this->Log(3, str_replace("%1", $user["name"], $this->GetTranslation("LogUserPasswordChanged")));

			// forward
			$this->SetMessage($this->GetTranslation("PasswordChanged"));
			$this->Redirect($this->href("", $this->GetTranslation("LoginPage")));
		}
	}

	//Print simple change password form
	print($this->FormOpen());

	if (isset($error))
	{
		$this->SetMessage($this->Format($error));
	}
	?>
	<input type="hidden" name="action" value="change" />
	<div class="cssform">
		<h3><?php echo $this->FormatTranslation("YouWantChangePassword"); ?></h3>
		<p>
			<label for="password"><?php echo $this->GetTranslation("CurrentPassword");?>:</label>
			<input type="password" id="password" name="password" size="24" />
		</p>
		<p>
			<label for="newpassword"><?php echo $this->GetTranslation("NewPassword");?>:</label>
			<input type="password" id="newpassword" name="newpassword" size="24" />
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
				$code = md5($user["password"].date("D d M Y H:i:s").$user["email"].mt_rand());

				$subject =	$this->GetTranslation("EmailForgotSubject").
							$this->GetConfigValue("wacko_name");
				$message =	$this->GetTranslation("EmailHello"). $name.".\n\n".
							str_replace('%1', $this->GetConfigValue("wacko_name"),
							str_replace('%2', $user["name"],
							str_replace('%3', $this->Href().
							($this->config["rewrite_mode"] ? "?" : "&amp;")."secret_code=".$code,
							$this->GetTranslation("EmailForgotMessage"))))."\n";
				$message.=	"\n".$this->GetTranslation("EmailGoodbye").
							"\n".$this->GetConfigValue("wacko_name").
							"\n".$this->config["base_url"];

				// update table
				$this->Query(
					"UPDATE ".$this->config["user_table"]." ".
					"SET changepassword = '".quote($this->dblink, $code)."' ".
					"WHERE name = '".quote($this->dblink, $user["name"])."' ".
					"LIMIT 1");

				// send code
				$this->SendMail($user["email"], $subject, $message);

				// log event
				$this->Log(3, str_replace("%2", $user["email"], str_replace("%1", $user["name"], $this->GetTranslation("LogUserPasswordReminded"))));

				$this->SetMessage($this->GetTranslation("CodeWasSent"));
				$this->Redirect($this->href("", $this->GetTranslation("LoginPage")));

			}
			else
			{
				$error = $this->GetTranslation("NotConfirmedEmail");
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
		if ($error)
		{
			$this->SetMessage($error);
		}

		//View password forgot form
		print($this->FormOpen());
?>
		<input type="hidden" name="action" value="send" />
		<div class="cssform">
		<h3><?php echo $this->FormatTranslation("ForgotMain"); ?></h3>
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
