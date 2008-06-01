<!--notypo-->
<?php
if ($_REQUEST["secret_code"]){
	//Password forgotten. Provided secret code
	$code = $_REQUEST["secret_code"];
	$user = $this->LoadSingle("select * from ".$this->config["user_table"]." where changepassword='".quote($this->dblink, $code)."'");
	if ($user){
		if ($_REQUEST["newpassword"]){

			//Password forgotten. Provided secret code and new password. Change password.
			$newpassword = $_POST["newpassword"];
			$confpassword = $_POST["confpassword"];

			// check all conditions
			if ($confpassword != $newpassword) $error = $this->GetResourceValue("PasswordsDidntMatch");
			else if (preg_match("/ /", $newpassword)) $error = $this->GetResourceValue("SpacesArentAllowed");
			else if (strlen($newpassword) < 5) $error = $this->GetResourceValue("PasswordTooShort");
			else
			{
				$this->Query("update ".$this->config["user_table"]." set ".
           "password = '".quote($this->dblink, md5($newpassword))."' ".
           "where name = '".quote($this->dblink, $user["name"])."' limit 1");

				$this->SetUser($user = $this->LoadUser($user["name"]));
				$this->LogUserIn($user);

				// forward
				$this->SetMessage($this->GetResourceValue("PasswordChanged"));
				$this->Redirect($this->href());
			}
			if ($error) echo $error;
		}else{
			//Password forgotten. Provided secret code only. Print password change form.
			print($this->FormOpen());
			echo "<input type=\"hidden\" name=\"secret_code\" value=\"".$code."\" />";
			?>
<table border="0" align="center">
	<tr>
		<td colspan="2" align="center"><strong><?php echo $this->Format( str_replace('%1', $user["name"], $this->GetResourceValue("YouWantChangePasswordForUser"))); ?></strong><br />
		<br />
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo $this->GetResourceValue("NewPassword");?>:</td>
		<td><input type="password" name="newpassword" size="24" /></td>
	</tr>
	<tr>
		<td align="right"><?php echo $this->GetResourceValue("ConfirmPassword");?>:</td>
		<td><input type="password" name="confpassword" size="24" /></td>
	</tr>
	<tr>
		<td></td>
		<td><input class="OkBtn" onmouseover='this.className="OkBtn_";'
			onmouseout='this.className="OkBtn";' type="submit" align="top"
			value="<?php echo $this->GetResourceValue("RegistrationButton"); ?>" /></td>
	</tr>
</table>
			<?php
			print($this->FormClose());
}
}else{
	echo $this->GetResourceValue("WrongCode");
}
}else if (!$forgot && $user = $this->GetUser())
{
	// is user trying to update?
	if ($_REQUEST["action"] == "change")
	{
		//Simple change password
		$password = $_POST["password"];
		$newpassword = $_POST["newpassword"];
		$confpassword = $_POST["confpassword"];

		// check all conditions
		if (md5($password)!=$user["password"]) $error = $this->GetResourceValue("WrongPassword");
		else if ($confpassword != $newpassword) $error = $this->GetResourceValue("PasswordsDidntMatch");
		else if (preg_match("/ /", $newpassword)) $error = $this->GetResourceValue("SpacesArentAllowed");
		else if (strlen($newpassword) < 5) $error = $this->GetResourceValue("PasswordTooShort");
		else
		{
			$this->Query("update ".$this->config["user_table"]." set ".
       "password = '".quote($this->dblink, md5($newpassword))."' ".
       "where name = '".quote($this->dblink, $user["name"])."' limit 1");

			$this->SetUser($user = $this->LoadUser($user["name"]));
			$this->LogUserIn($user);

			// forward
			$this->SetMessage($this->GetResourceValue("PasswordChanged"));

			$this->Redirect($this->href());
		}
	}
	//Print simple change password form
	print($this->FormOpen());
	?>
<input type="hidden"
	name="action" value="change" />
<table border="0" align="center">
	<tr>
		<td colspan="2" align="center"><strong><?php echo $this->FormatResourceValue("YouWantChangePassword"); ?></strong><br />
		<br />
		</td>
	</tr>
	<?php
	if ($error)
	{
		print("<tr><td colspan=\"2\" align=\"center\"><div class=\"error\">".$this->Format($error)."</div></td></tr>\n");
	}
	?>
	<tr>
		<td align="right"><?php echo $this->GetResourceValue("CurrentPassword");?>:</td>
		<td><input type="password" name="password" size="24" /></td>
	</tr>
	<tr>
		<td align="right"><?php echo $this->GetResourceValue("NewPassword");?>:</td>
		<td><input type="password" name="newpassword" size="24" /></td>
	</tr>
	<tr>
		<td align="right"><?php echo $this->GetResourceValue("ConfirmPassword");?>:</td>
		<td><input type="password" name="confpassword" size="24" /></td>
	</tr>
	<tr>
		<td></td>
		<td><input class="OkBtn" onmouseover='this.className="OkBtn_";'
			onmouseout='this.className="OkBtn";' type="submit" align="top"
			value="<?php echo $this->GetResourceValue("RegistrationButton"); ?>" /></td>
	</tr>
</table>
	<?php
	print($this->FormClose());

}else{
	if ($_REQUEST["action"] == "send")
	{

		//Password forgotten. Send mail
		$name = str_replace(" ","", $_POST["loginormail"]);
		$user = $this->LoadSingle("select * from ".$this->config["user_table"]." where  name='".quote($this->dblink, $name)."'  or  email='".quote($this->dblink, $name)."'");
		if ($user){
			if ($user["email_confirm"]==""){

				$code = md5(date("D d M Y H:i:s").$user["email"].rand());

				$this->Query("update ".$this->config["user_table"]." set ".
          "changepassword = '".quote($this->dblink, $code)."' ".
          "where name = '".quote($this->dblink, $user["name"])."' limit 1");

				$subject = $this->GetResourceValue("Mail.ForgotSubject").$this->GetConfigValue("wakka_name");
				$message = $this->GetResourceValue("MailHello"). $name.".<br /> <br /> ";
				$message.= str_replace('%1', $this->GetConfigValue("wakka_name"),
				str_replace('%2', $user["name"],
				str_replace('%3', $this->Href().($this->config["rewrite_mode"] ? "?" : "&amp;")."secret_code=".$code,
				$this->GetResourceValue("Mail.ForgotMessage"))))."<br />  ";
				$message.= "<br />".$this->GetResourceValue("MailGoodbye")." ".$this->GetConfigValue("wakka_name");
				$this->SendMail($user["email"], $subject, $message);

				$this->SetMessage($this->GetResourceValue("CodeWasSent"));
				$this->Redirect($this->href());

			}else{
				$error = $this->GetResourceValue("NotConfirmedMail");
			}
		}else{
			$error = $this->GetResourceValue("UserNotFound");
		}
	}
	if ($error || $_REQUEST["action"] != "send")
	{
		//View password forgot form
		print($this->FormOpen());
		?>
<input type="hidden"
	name="action" value="send" />
<table border="0" align="center">
	<tr>
		<td colspan="2" align="center"><strong><?php echo $this->FormatResourceValue("ForgotMain"); ?></strong><br />
		</td>
	</tr>
	<?php
	if ($error) {
		?>
	<tr>
		<td colspan="2" align="center"><?php echo $error; ?><br />
		</td>
	</tr>
	<?php

}
?>
	<tr>
		<td colspan="2"><?php echo $this->FormatResourceValue("ForgotComment"); ?><br />
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo $this->FormatResourceValue("ForgotField"); ?>:</td>
		<td><input type="text" name="loginormail" size="24" /></td>
	</tr>
	<tr>
		<td></td>
		<td><input class="OkBtn" onmouseover='this.className="OkBtn_";'
			onmouseout='this.className="OkBtn";' type="submit" align="top"
			value="<?php echo $this->GetResourceValue("SendButton"); ?>" /></td>
	</tr>
</table>
<?php
print($this->FormClose());
}
}
?>
<!--/notypo-->
