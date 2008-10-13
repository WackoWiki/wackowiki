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
      echo "<br /><br /><center>".str_replace('%1', $this->ComposeLinkToPage('Settings', '', $this->GetResourceValue("SettingsText"), 0), $this->GetResourceValue("EmailNotConfirmed"))."</center><br /><br />";
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

   // Start Comment Captcha

   // Only show captcha if the admin enabled it in the config file
   if(!$this->IsAdmin() && $this->GetConfigValue("captcha_registration"))
      {
         // Don't load the captcha at all if the GD extension isn't enabled
         if(extension_loaded('gd'))
            {
               //check whether anonymous user
               //anonymous user has the IP or host name as name
               //if name contains '.', we assume it's anonymous
               if(strpos($this->GetUserName(), '.'))
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
                           $error = $this->GetResourceValue("SpamAlert");
                           $this->SetMessage($this->GetResourceValue("SpamAlert"));
                        }
                  }
            }
         }
      // End Comment Captcha

      if($word_ok)
         {
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

               $subject = $this->GetResourceValue("EmailWelcome").$this->GetConfigValue("wakka_name");
               $message = $this->GetResourceValue("MailHello"). $name.".<br /> <br /> ";
               $message.= str_replace('%1', $this->GetConfigValue("wakka_name"),
               str_replace('%2', $name,
               str_replace('%3', $this->Href().($this->config["rewrite_mode"] ? "?" : "&amp;")."confirm=".$confirm,
               $this->GetResourceValue("EmailRegistered"))))."<br />  ";
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
}
//  else
if (!$_REQUEST["confirm"])
if ($this->GetConfigValue("allow_registration") || $this->IsAdmin())
{
   print($this->FormOpen());
   ?>

<input type="hidden"
   name="action" value="login" />
<div class="cssform">
  <h3><?php echo $this->FormatResourceValue("RegistrationWelcome"); ?></h3>
  <?php
   if ($error)
   {
      print("<div class=\"error\">".$this->Format($error)."</div>\n");
   }
   if ($this->GetConfigValue("multilanguage"))
   {
      ?>
  <p>
    <label for="lang"><?php echo $this->FormatResourceValue("RegistrationLang");?>:</label>
    <select id="lang" name="lang">
      <option value=""></option>
      <?php
         $langs = $this->AvailableLanguages();
         for ($i=0;$i<count($langs);$i++)
         echo '<option value="'.$langs[$i].'"'.($lang == $langs[$i] ? 'selected="selected"' : '').'>'.$langs[$i].'</option>';
         ?>
    </select>
  </p>
  <?php
}
?>
  <p>
    <label for="name"><?php echo $this->FormatResourceValue("RegistrationName");?>:</label>
    <input id="name" name="name" size="27"
         value="<?php echo htmlspecialchars($name); ?>" />
  </p>
  <p>
    <label for="password"><?php echo $this->GetResourceValue("RegistrationPassword");?>:</label>
    <input type="password" id="password" name="password" size="24" value="<?php echo $password ?>" />
  </p>
  <p>
    <label for="confpassword"><?php echo $this->GetResourceValue("ConfirmPassword");?>:</label>
    <input type="password" id="confpassword" name="confpassword" size="24" value="<?php echo $confpassword ?>" />
  </p>
  <p>
    <label for="email"><?php echo $this->GetResourceValue("Email");?>:</label>
    <input id="email" name="email" size="30"
         value="<?php echo htmlspecialchars($email); ?>" />
  </p>
<?php
            // captcha code starts

            // Only show captcha if the admin enabled it in the config file
            if($this->GetConfigValue("captcha_registration"))
               {
                  // Don't load the captcha at all if the GD extension isn't enabled
                  if(extension_loaded('gd'))
                     {
                        if(strpos($this->GetUserName(), '.'))
                           {
          ?>
<p><label for="captcha"><?php echo $this->GetResourceValue("Captcha");?>:</label>
<img src="<?php echo $this->GetConfigValue("root_url");?>lib/captcha/freecap.php" id="freecap" alt="<?php echo $this->GetResourceValue("Captcha");?>" /> <a href="" onclick="this.blur(); new_freecap(); return false;" title="<?php echo $this->GetResourceValue("CaptchaReload"); ?>"><img src="<?php echo $this->GetConfigValue("root_url");?>images/reload.png" width="18" height="17" alt="<?php echo $this->GetResourceValue("CaptchaReload"); ?>" /></a>
<br />
<input id="captcha" type="text" name="word" maxlength="6" style="width: 273px;" />
</p>
<?php
                           }
                     }
               }
            // end captcha
?>
  <p>
    <input class="OkBtn" onmouseover='this.className="OkBtn_";'
         onmouseout='this.className="OkBtn";' type="submit" align="top"
         value="<?php echo $this->GetResourceValue("RegistrationButton"); ?>" />
  </p>
</div>
<?php
print($this->FormClose());
}
else
echo($this->GetResourceValue("RegistrationClosed"));
?>
<!--/notypo-->