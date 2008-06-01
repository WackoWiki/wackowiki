<!--notypo-->
<?php
if ($_REQUEST["action"] == "logout")
{
	$this->LogoutUser();
	$this->SetBookmarks(BM_DEFAULT);
	//$this->SetMessage($this->GetResourceValue("LoggedOut"));
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
<table border="0" align="center">
	<tr>
		<td><?php echo $this->GetResourceValue("Hello").", ".$this->ComposeLinkToPage($user["name"]) ?>!</td>
		<td><img
			src="<?php echo $this->GetConfigValue("root_url");?>images/z.gif"
			width="10" height="1" alt="" border="0" /> <input class="CancelBtn"
			onmouseover='this.className="CancelBtn_";'
			onmouseout='this.className="CancelBtn";' type="button" align="top"
			value="<?php echo $this->GetResourceValue("LogoutButton"); ?>"
			onclick="document.location='<?php echo $this->href("", "", "action=logout"); ?>'" />
	
	</tr>
</table>
<br />
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
				$error = $this->GetResourceValue("WrongPassword");
				$name = $_POST["name"];
				$focus = 1;
			}
		}
	}
	print($this->FormOpen());
	?>
<input type="hidden"
	name="action" value="login" />
<table border="0" align="center">
	<tr>
		<td align="right"></td>
		<td><strong><?php echo $this->GetResourceValue("LoginWelcome"); ?></strong>
		<img src="<?php echo $this->GetConfigValue("root_url");?>images/z.gif"
			width="10" height="1" alt="" border="0" /> <small><?php echo $this->FormatResourceValue("LoginWelcome2"); ?></small>
		<br />
		<br />
		</td>
	</tr>
	<?php
	if ($error)
	{
		print("<tr><td></td><td><div class=\"error\">".$this->Format($error)."</div></td></tr>\n");
	}
	?>
	<tr>
		<td align="right"><?php echo $this->FormatResourceValue("LoginName");?>:</td>
		<td><input id="f0" name="name" size="27" value="<?php echo $name; ?>" /></td>
	</tr>
	<tr>
		<td align="right"><?php echo $this->GetResourceValue("LoginPassword");?>:</td>
		<td><input id="f1" type="password" name="password" size="24" /></td>
	</tr>
	<tr>
		<td></td>
		<td><input class="OkBtn" onmouseover='this.className="OkBtn_";'
			onmouseout='this.className="OkBtn";' type="submit" align="top"
			value="<?php echo $this->GetResourceValue("LoginButton"); ?>" /></td>
	</tr>
	<tr>
		<td></td>
		<td><a href="<?php echo $this->Href("", "Password"); ?>"><?php echo $this->GetResourceValue("ForgotLink"); ?></a></td>
	</tr>
</table>
<script language="Javascript" type="text/javascript">
   document.getElementById("f<?php echo $focus;?>").focus();
  </script>
	<?php
	print($this->FormClose());
}
?>
<!--/notypo-->
