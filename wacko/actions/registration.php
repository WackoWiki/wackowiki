<!--notypo-->
<?php
// user is not logged in or logged in -- nomatter

// is user trying to confirm email, login or register?
if ($_REQUEST["confirm"])
{
	if ($this->LoadSingle("SELECT name, email, email_confirm FROM ".$this->config["user_table"]." WHERE email_confirm = '".
	quote($this->dblink, $_REQUEST["confirm"])."'"))
	{
		$this->Query("UPDATE ".$this->config["user_table"]." SET email_confirm = '' WHERE email_confirm = '".
		quote($this->dblink, $_REQUEST["confirm"])."'");
		echo "<br /><br /><center>".$this->GetResourceValue("EmailConfirmed")."</center><br /><br />";
	}
	else
	//TODO: add case "EmailAlreadyConfirmed" -> check for empty email_confirm field
	echo "<br /><br /><center>".$this->GetResourceValue("EmailNotConfirmed")."</center><br /><br />";
}
else if ($_REQUEST["action"] == "login")
{
	// if user name already exists, check password
	if ($existingUser = $this->LoadUser($_POST["name"]))
	{
		$error = $this->GetResourceValue("RegistrationNameOwned");
	}
	// otherwise, create new account
	else if ($this->GetConfigValue("allow_registration") || $this->IsAdmin())
	{
		$name = trim($_POST["name"]);
		$email = trim($_POST["email"]);
		$password = $_POST["password"];
		$confpassword = $_POST["confpassword"];
		$lang = $_POST["lang"];

		// check if name is WikiName style
		if (!$this->IsWikiName($name)) $error = $this->GetResourceValue("MustBeWikiName");
		else if (!$email) $error = $this->GetResourceValue("SpecifyEmail");
		else if (!preg_match("/^.+?\@.+$/", $email)) $error = $this->GetResourceValue("NotAEmail");
		else if ($confpassword != $password) $error = $this->GetResourceValue("PasswordsDidntMatch");
		else if (preg_match("/ /", $password)) $error = $this->GetResourceValue("SpacesArentAllowed");
		else if (strlen($password) < 5) $error = $this->GetResourceValue("PasswordTooShort");
		else
		{
			$confirm = md5(rand().$email.rand());
			$more = $this->ComposeOptions(array("send_watchmail"=>"Y",));

			$this->Query("INSERT INTO ".$this->config["user_table"]." SET ".
          "signuptime = now(), ".
          "name = '".quote($this->dblink, $name)."', ".
          "email = '".quote($this->dblink, $email)."', ".
          "email_confirm = '".quote($this->dblink, $confirm)."', ".
          "bookmarks = '".quote($this->dblink, $this->GetDefaultBookmarks($lang))."', ".
          "typografica = '".(($this->config["default_typografica"]==1)?"Y":"N")."', ".
          "showdatetime = '".(($this->config["default_showdatetime"]==1)?"Y":"N")."', ".
          "more = '".quote($this->dblink, $more)."', ".
			($lang?"lang = '".quote($this->dblink, $lang)."', ":"").
          "password = md5('".quote($this->dblink, $_POST["password"])."')");

			$subject = $this->GetResourceValue("Mail.Welcome").$this->GetConfigValue("wakka_name");
			$message = $this->GetResourceValue("MailHello"). $name.".<br /> <br /> ";
			$message.= str_replace('%1', $this->GetConfigValue("wakka_name"),
			str_replace('%2', $name,
			str_replace('%3', $this->Href().($this->config["rewrite_mode"] ? "?" : "&amp;")."confirm=".$confirm,
			$this->GetResourceValue("Mail.Registered"))))."<br />  ";
			$message.= "<br />".$this->GetResourceValue("MailGoodbye")." ".$this->GetConfigValue("wakka_name");
			$this->SendMail($email, $subject, $message);

			// log in
			$this->SetUser($this->LoadUser($name));
			$this->LogUserIn($this->GetUser());

			// forward
			$this->context[++$this->current_context] = "";
			$this->Redirect($this->Href("",$name,"",1));
		}
	}
}
//  else
if (!$_REQUEST["confirm"])
if ($this->GetConfigValue("allow_registration") || $this->IsAdmin())
{
	print($this->FormOpen());
	?>
<input type="hidden"
	name="action" value="login" />
<table border="0" align="center">
	<tr>
		<td colspan="2" align="center"><strong><?php echo $this->FormatResourceValue("RegistrationWelcome"); ?></strong><br />
		<br />
		</td>
	</tr>
	<?php
	if ($error)
	{
		print("<tr><td colspan=\"2\" align=\"center\"><div class=\"error\">".$this->Format($error)."</div></td></tr>\n");
	}
	if ($this->GetConfigValue("multilanguage"))
	{
		?>
	<tr>
		<td align="right"><?php echo $this->FormatResourceValue("RegistrationLang");?>:</td>
		<td><select name="lang">
			<option value=""></option>
			<?php
			$langs = $this->AvailableLanguages();
			for ($i=0;$i<count($langs);$i++)
			echo '<option value="'.$langs[$i].'">'.$langs[$i].'</option>';
			?>
		</select></td>
	</tr>
	<?php
}
?>
	<tr>
		<td align="right"><?php echo $this->FormatResourceValue("RegistrationName");?>:</td>
		<td><input name="name" size="27"
			value="<?php echo htmlspecialchars($name); ?>" /></td>
	</tr>
	<tr>
		<td align="right"><?php echo $this->GetResourceValue("RegistrationPassword");?>:</td>
		<td><input type="password" name="password" size="24" /></td>
	</tr>
	<tr>
		<td align="right"><?php echo $this->GetResourceValue("ConfirmPassword");?>:</td>
		<td><input type="password" name="confpassword" size="24" /></td>
	</tr>
	<tr>
		<td align="right"><?php echo $this->GetResourceValue("Email");?>:</td>
		<td><input name="email" size="30"
			value="<?php echo htmlspecialchars($email); ?>" /></td>
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
else
echo($this->GetResourceValue("RegistrationClosed"));
?>
<!--/notypo-->
