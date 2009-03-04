<!--notypo-->
<?php
if ($_REQUEST["action"] == "logout")
{
	$this->LogoutUser();
	$this->SetBookmarks(BM_DEFAULT);
	//$this->SetMessage($this->GetTranslation("LoggedOut"));
	$this->context[++$this->current_context] = "";
	if ($_REQUEST["goback"] != "") $this->Redirect($this->Href("", stripslashes($_REQUEST["goback"])));
	else $this->Redirect($this->href());
}
else if ($user = $this->GetUser())
{

	// user is logged in; display config form
	print($this->FormOpen());
	?>

<input type="hidden"
	name="action" value="update" />
<div class="cssform">
  <h3><?php echo $this->GetTranslation("Hello").", ".$this->ComposeLinkToPage($user["name"]) ?>!</h3>
  <p>
    <input class="CancelBtn"
			onmouseover='this.className="CancelBtn_";'
			onmouseout='this.className="CancelBtn";' type="button" align="top"
			value="<?php echo $this->GetTranslation("LogoutButton"); ?>"
			onclick="document.location='<?php echo $this->href("", "", "action=logout"); ?>'" />
  </p>
</div>
<?php
	print($this->FormClose());
}
else
{
	// user is not logged in
	$focus=0;

	// is user trying to log in or register?
	if ($_REQUEST["action"] == "login")
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
				if ($_REQUEST["goback"] != "") $this->Redirect($this->Href("", stripslashes($_REQUEST["goback"]), "cache=".rand(0,1000)));
				$this->Redirect($this->href());
			}
			else
			{
				$error = $this->GetTranslation("WrongPassword");
				$name = $_POST["name"];
				$focus = 1;
			}
		}
	}
	print($this->FormOpen());
	?>
<input type="hidden" name="action" value="login" />
<input type="hidden" name="goback" value="<?php echo stripslashes($_REQUEST["goback"]);?>" />
<div class="cssform">
  <h3><?php echo $this->GetTranslation("LoginWelcome"); ?></h3>
  <?php
	if ($error)
	{ ?>
  <div class="error"><?php print $this->Format($error); ?></div>
  <?php	}
	?>
  <p>
    <label for="name"><?php echo $this->FormatResourceValue("LoginName");?>:</label>
    <input id="name" name="name" size="27" value="<?php echo $name; ?>" />
  </p>
  <p>
    <label for="password"><?php echo $this->GetTranslation("LoginPassword");?>:</label>
    <input id="password" type="password" name="password" size="24" />
  </p>
  <p>
    <input class="OkBtn" onmouseover='this.className="OkBtn_";'
			onmouseout='this.className="OkBtn";' type="submit" align="top"
			value="<?php echo $this->GetTranslation("LoginButton"); ?>" />
  </p>
  <p><a href="<?php echo $this->Href("", "Password"); ?>"><?php echo $this->GetTranslation("ForgotLink"); ?></a></p>
  <p><?php echo $this->FormatResourceValue("LoginWelcome2"); ?></p>
</div>
<script type="text/javascript">
   document.getElementById("f<?php echo $focus;?>").focus();
  </script>
<?php
	print($this->FormClose());
}
?>
<!--/notypo-->