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

<div class="cssform">
  <h3><?php echo $this->Format( str_replace('%1', $user["name"], $this->GetResourceValue("YouWantChangePasswordForUser"))); ?></h3>
  <p>
    <label for="newpassword"><?php echo $this->GetResourceValue("NewPassword");?>:</label>
    <input type="password" id="newpassword" name="newpassword" size="24" />
  </p>
  <p>
    <label for="confpassword"><?php echo $this->GetResourceValue("ConfirmPassword");?>:</label>
    <input type="password" id="confpassword" name="confpassword" size="24" />
  </p>
  <p>
    <input class="OkBtn" onmouseover='this.className="OkBtn_";'
			onmouseout='this.className="OkBtn";' type="submit" align="top"
			value="<?php echo $this->GetResourceValue("RegistrationButton"); ?>" />
  </p>
</div>
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
<div class="cssform">
  <h3><?php echo $this->FormatResourceValue("YouWantChangePassword"); ?></h3>
  <?php
	if ($error)
	{ ?>
  <div class="error"><?php print $this->Format($error); ?></div>
  <?php	}
	?>
  <p>
    <label for="password"><?php echo $this->GetResourceValue("CurrentPassword");?>:</label>
    <input type="password" id="password" name="password" size="24" />
  </p>
  <p>
    <label for="newpassword"><?php echo $this->GetResourceValue("NewPassword");?>:</label>
    <input type="password" id="newpassword" name="newpassword" size="24" />
  </p>
  <p>
    <label for="confpassword"><?php echo $this->GetResourceValue("ConfirmPassword");?>:</label>
    <input type="password" id="confpassword" name="confpassword" size="24" />
  </p>
  <p>
    <input class="OkBtn" onmouseover='this.className="OkBtn_";'
			onmouseout='this.className="OkBtn";' type="submit" align="top"
			value="<?php echo $this->GetResourceValue("RegistrationButton"); ?>" />
  </p>
</div>
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

				$subject = $this->GetResourceValue("EmailForgotSubject").$this->GetConfigValue("wakka_name");
				$message = $this->GetResourceValue("MailHello"). $name.".<br /> <br /> ";
				$message.= str_replace('%1', $this->GetConfigValue("wakka_name"),
				str_replace('%2', $user["name"],
				str_replace('%3', $this->Href().($this->config["rewrite_mode"] ? "?" : "&amp;")."secret_code=".$code,
				$this->GetResourceValue("EmailForgotMessage"))))."<br />  ";
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
<div class="cssform">
  <h3><?php echo $this->FormatResourceValue("ForgotMain"); ?></h3>
  <?php
	if ($error) {
		?>
  <div class="error"><?php echo $error; ?></div>
  <?php

}
?>
  <p><?php echo $this->FormatResourceValue("ForgotComment"); ?></p>
  <p>
    <label for="loginormail"><?php echo $this->FormatResourceValue("ForgotField"); ?>:</label>
    <input type="text" id="loginormail" name="loginormail" size="24" />
  </p>
  <p>
    <input class="OkBtn" onmouseover='this.className="OkBtn_";'
			onmouseout='this.className="OkBtn";' type="submit" align="top"
			value="<?php echo $this->GetResourceValue("SendButton"); ?>" />
  </p>
</div>
<?php
print($this->FormClose());
}
}
?>
<!--/notypo-->
