<!--notypo-->
<?php
if ($_GET["action"] == "logout")
{
	$this->Log(5, str_replace("%1", $this->GetUserName(), $this->GetTranslation("LogUserLoggedOut")));
	$this->LogoutUser();
	$this->SetBookmarks(BM_DEFAULT);
	//$this->SetMessage($this->GetTranslation("LoggedOut"));
	$this->context[++$this->current_context] = "";

	if ($_GET["goback"] != "")
		$this->Redirect($this->Href("", stripslashes($_GET["goback"])));
	else
		$this->Redirect($this->href());
}
else if ($user = $this->GetUser())
{
	// user is logged in; display logout form
	print($this->FormOpen());
	?>

<input type="hidden"
	name="action" value="update" />
<div class="cssform">
  <h3><?php echo $this->GetTranslation("Hello").", ".$this->ComposeLinkToPage($user["name"]) ?>!</h3>
  <p>
    <input type="button" value="<?php echo $this->GetTranslation("LogoutButton"); ?>"
			onclick="document.location='<?php echo $this->href("", "", "action=logout"); ?>'" />
  </p>
</div>
<?php
	print($this->FormClose());
}
else
{
	// user is not logged in
	$focus = 0;

	// is user trying to log in or register?
	if ($_POST["action"] == "login")
	{
		// if user name already exists, check password
		if ($existingUser = $this->LoadUser($_POST["name"]))
		{
			// check password
			if ($existingUser["password"] == md5($_POST["password"]))
			{
				$this->LogUserIn($existingUser);
				$this->SetUser($existingUser);
				$this->SetBookmarks(BM_USER);
				$this->context[++$this->current_context] = "";
				$this->Log(3, str_replace("%1", $existingUser["name"], $this->GetTranslation("LogUserLoginOK")));

				if ($_POST["goback"] != "")
					$this->Redirect($this->Href("", stripslashes($_POST["goback"]), "cache=".rand(0,1000)));
				else
					$this->Redirect($this->href());
			}
			else
			{
				$error = $this->GetTranslation("WrongPassword");
				$name = $_POST["name"];
				$focus = 1;

				// log failed attempt
				$this->Log(2, str_replace("%1", $_POST["name"], $this->GetTranslation("LogUserLoginFailed")));
			}
		}
	}
	print($this->FormOpen());
	?>
<input type="hidden" name="action" value="login" />
<input type="hidden" name="goback" value="<?php echo stripslashes($_GET["goback"]);?>" />
<div class="cssform">
	<h3><?php echo $this->GetTranslation("LoginWelcome"); ?></h3>
	<?php
	if ($error)
	{ ?>
	<div class="error"><?php print $this->Format($error); ?></div>
	<?php	}
	?>
	<p>
		<label for="name"><?php echo $this->FormatTranslation("LoginName");?>:</label>
		<input id="name" name="name" size="27" value="<?php echo $name; ?>" />
	</p>
	<p>
		<label for="password"><?php echo $this->GetTranslation("LoginPassword");?>:</label>
		<input id="password" type="password" name="password" size="24" />
	</p>
	<p>
		<input type="submit" value="<?php echo $this->GetTranslation("LoginButton"); ?>" />
	</p>
	<p><a href="<?php echo $this->Href("", "Password"); ?>"><?php echo $this->GetTranslation("ForgotLink"); ?></a></p>
	<p><?php echo $this->FormatTranslation("LoginWelcome2"); ?></p>
</div>
<script type="text/javascript">
	document.getElementById("f<?php echo $focus;?>").focus();
</script>
<?php
	print($this->FormClose());
}
?>
<!--/notypo-->