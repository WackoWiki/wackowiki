<!--notypo-->
<?php

// reconnect securely in ssl mode
if ($this->config["ssl"] == true && $_SERVER["HTTPS"] != "on")
{
	$this->Redirect(str_replace("http://", "https://", $this->href()));
}

// actions
if ($_GET["action"] == "clearcookies")
{
	foreach ($_COOKIE as $name => $value)
	{
		$this->DeleteCookie($name, true);
	}
	$_POST["action"] = "logout";
}

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

<input type="hidden" name="action" value="logout" />
<div class="cssform">
  <h3><?php echo $this->GetTranslation("Hello").", ".$this->ComposeLinkToPage($user["name"]) ?>!</h3>
<?php
				if ($user["sessiontime"] == true)
				{
?>
				Last visit was recorded <?php echo $this->GetTimeStringFormatted($user['sessiontime']); ?>.<br />
<?php
				}
?>
				The current session ends
<?php
				$cookie = explode(';', $this->GetCookie("auth"));
				// session expiry date
				echo $this->GetUnixTimeFormatted($cookie[2]).' ';
				// session time left
				$time_diff = $cookie[2] - time();
				if ($time_diff > 2 * 24 * 3600)
					echo '(in '.ceil($time_diff / 24 / 3600).' days).';
				else if ($time_diff > 5 * 3600)
					echo '(in '.ceil($time_diff / 3600).' hours).';
				else
					echo '(in '.ceil($time_diff / 60).' minutes).';

				echo "<br />";
				// Only allow your session to be used from this IP address.
?>
				Bind session to the IP-address <?php echo ( $user['options']['validate_ip'] == '1' ? 'enabled (the current IP '.$user['ip'].')' : 'Off' ); ?>.<br />
<?php
				if ($this->config["ssl"] == true)
				{
?>
				Traffic Protection <?php echo ( $_SERVER["HTTPS"] == "on" ? $_SERVER["SSL_CIPHER"].' ('.$_SERVER["SSL_PROTOCOL"].')' : 'no' ); ?>.
<?php
				}
?>
  <p>
    <input type="button" value="<?php echo $this->GetTranslation("LogoutButton"); ?>"
			onclick="document.location='<?php echo $this->href("", "", "action=logout"); ?>'" />
  </p>
  <p>
		<a href="<?php echo $this->href('', $this->config['settings_page']); ?>">Settings</a> | <a href="?action=clearcookies">Delete all cookies</a>
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
				// define session longetivity
				switch ($_POST['session'])
				{
					case '1d':
						$session = 1;
						break;
					case '7d':
						$session = 7;
						break;
					case '30d':
						$session = 30;
						break;
					default:
						$session = $this->config['cookie_session'];
				}

				$this->LogUserIn($existingUser, $_POST['persistent'], $session);
				$this->SetUser($existingUser, 1);
				$this->UpdateSessionTime($existingUser);
				$this->SetBookmarks(BM_USER);
				$this->context[++$this->current_context] = "";
				$this->Log(3, str_replace("%1", $existingUser["name"], $this->GetTranslation("LogUserLoginOK")));

				// run in ssl mode?
				if ($this->config['ssl'] == true)
				{
					$this->config['base_url'] = str_replace('http://', 'https://', $this->config['base_url']);
					$this->config['root_url'] = str_replace('http://', 'https://', $this->config['root_url']);
				}

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

	if ($error) $this->SetMessage($error);

	print($this->FormOpen());
	?>
<input type="hidden" name="action" value="login" />
<input type="hidden" name="goback" value="<?php echo stripslashes($_GET["goback"]);?>" />
<div class="cssform">
	<h3><?php echo $this->GetTranslation("LoginWelcome"); ?></h3>
	<p>
		<label for="name"><?php echo $this->FormatTranslation("LoginName");?>:</label>
		<input id="name" name="name" size="25" maxlength="25" value="<?php echo isset($name) ? $name : ""; ?>" tabindex="1" />

	</p>
	<p>
		<label for="password"><?php echo $this->GetTranslation("LoginPassword");?>:</label>
		<input id="password" type="password" name="password" size="25" tabindex="2" autocomplete="off" />

	</p>
</div>
	<p>
		<label for=""><?php echo $this->GetTranslation("SessionDuration");?>:</label>
		<small>
			<input id="1d" name="session" value="1d" type="radio" /><label for="1d">1 day</label> &nbsp;&nbsp;
			<input id="7d" name="session" value="7d" type="radio" /><label for="7d">7 days</label> &nbsp;&nbsp;
			<input id="30d" name="session" value="30d" type="radio" checked="checked" /><label for="30d">30 days</label>
		</small>
	</p>
	<p>
		<input id="persistent" name="persistent" value="1" type="checkbox" tabindex="3" checked="checked" />
		<label for="persistent"><small><?php echo $this->GetTranslation("PersistentCookie"); ?></small></label>
	</p>



	<p>
		<input type="submit" value="<?php echo $this->GetTranslation("LoginButton"); ?>" tabindex="4" />
		&nbsp;&nbsp;&nbsp;<small><a href="?action=clearcookies">Delete all cookies</a></small>
	</p>
	<p><?php echo $this->FormatTranslation("ForgotLink"); ?></p>
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