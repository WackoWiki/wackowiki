<!--notypo-->
<?php
if ($_REQUEST["confirm"])
{
   if ($this->LoadSingle("select * from ".$this->config["user_table"]." where email_confirm = '".
   quote($this->dblink, $_REQUEST["confirm"])."'"))
   {
      $this->Query("UPDATE ".$this->config["user_table"]." SET email_confirm = '' WHERE email_confirm = '".
      quote($this->dblink, $_REQUEST["confirm"])."'");
      echo "<br /><br /><center>".$this->GetResourceValue("EmailConfirmed")."</center><br /><br />";
   }
   else
      echo "<br /><br /><center>".str_replace('%1', $this->ComposeLinkToPage('Settings', '', $this->GetResourceValue("SettingsText"), 0), $this->GetResourceValue("EmailNotConfirmed"))."</center><br /><br />";
}
else if ($_REQUEST["action"] == "logout")
{
   $this->LogoutUser();
   $this->SetMessage($this->GetResourceValue("LoggedOut"));
   $this->Redirect($this->href());
}
else if ($user = $this->GetUser())
{
   $this->SetPageLang($this->userlang);

   // is user trying to update?
   if ($_REQUEST["action"] == "update")
   {
      $bookmarks = str_replace("\r", "", $_POST["bookmarks"]);

      $more = $this->ComposeOptions(array(
     "theme"=>$_POST["theme"],
     "autocomplete"=>$_POST["autocomplete"],
     "dont_redirect"=>$_POST["dont_redirect"],
     "send_watchmail"=>$_POST["send_watchmail"],
     "show_files"=>$_POST["show_files"],
      ));

      if ($user["email"]!=$_POST["email"])
      {
         $confirm = md5(rand().$_POST["email"].rand());

         $subject = $this->GetResourceValue("EmailConfirm");
         $message = $this->GetResourceValue("MailHello"). $user["name"].".<br /> <br /> ";
         $message.= str_replace('%1', $this->GetConfigValue("wakka_name"),
         str_replace('%2', $user["name"],
         str_replace('%3', $this->Href().($this->config["rewrite_mode"] ? "?" : "&amp;")."confirm=".$confirm,
         $this->GetResourceValue("EmailVerify"))))."<br />  ";
         $message.= "<br />".$this->GetResourceValue("MailGoodbye")." ".$this->GetConfigValue("wakka_name");
         $this->SendMail($_POST["email"], $subject, $message);
      }

      $this->Query("update ".$this->config["user_table"]." set ".
      "email = '".quote($this->dblink, $_POST["email"])."', ".
      ($confirm?"email_confirm = '".quote($this->dblink, $confirm)."', ":"").
      "doubleclickedit = '".quote($this->dblink, $_POST["doubleclickedit"])."', ".
      "showdatetime = '".quote($this->dblink, $_POST["showdatetimeinlinks"])."', ".
      "show_comments = '".quote($this->dblink, $_POST["show_comments"])."', ".
      "revisioncount = '".quote($this->dblink, $_POST["revisioncount"])."', ".
      "changescount = '".quote($this->dblink, $_POST["changescount"])."', ".
      "motto = '".quote($this->dblink, $_POST["motto"])."', ".
      "bookmarks = '".quote($this->dblink, $bookmarks)."', ".
      "show_spaces = '".quote($this->dblink, $_POST["show_spaces"])."', ".
      "typografica = '".quote($this->dblink, $_POST["typografica"])."', ".
      "lang = '".quote($this->dblink, $_POST["lang"])."', ".
      "more = '".quote($this->dblink, $more)."' ".
      "where name = '".quote($this->dblink, $user["name"])."' limit 1");

      $this->SetUser($this->LoadUser($user["name"]));
      $this->SetBookmarks(BM_USER);

      // forward
      $this->SetMessage($this->GetResourceValue("SettingsStored",$_POST["lang"]));

      $this->Redirect($this->href());
   }
   // user is logged in; display config form
   print($this->FormOpen());
   ?>

<input type="hidden" name="action" value="update" />
<div id="cssform1">
  <h3><?php echo $this->GetResourceValue("Hello").", ".$this->ComposeLinkToPage($user["name"]) ?>!</h3>
  <p><a href="<?php echo $this->href("", "Password")?>"><?php echo $this->GetResourceValue("YouWantChangePassword");?></a></p>
  <p>
    <label for="email"><?php echo $this->GetResourceValue("YourEmail");?>:</label>
    <input id="email" name="email" value="<?php echo htmlentities($user["email"]) ?>" size="40" />
    &nbsp;<?php echo $user["email_confirm"] == "" ? '<img src="'.$this->GetConfigValue("root_url").'images/tick.png" alt="'.$this->GetResourceValue("EmailConfirmed").'" title="'.$this->GetResourceValue("EmailConfirmed").'" width="20" height="20" />' : '<img src="'.$this->GetConfigValue("root_url").'images/warning.png" alt="'.$this->GetResourceValue("EmailConfirm").'" title="'.$this->GetResourceValue("EmailConfirm").'" width="20" height="23" />' ?> </p>
  <p>
    <label for="doubleclickedit"><?php echo $this->GetResourceValue("DoubleclickEditing");?>:</label>
    <input type="hidden" name="doubleclickedit" value="N" />
    <input
         type="checkbox" id="doubleclickedit" name="doubleclickedit" value="Y"
         <?php echo $user["doubleclickedit"] == "Y" ? "checked=\"checked\"" : "" ?> />
  </p>
  <p>
    <label for="autocomplete"><?php echo $this->GetResourceValue("WikieditAutocomplete");?>:</label>
    <input type="hidden" name="autocomplete" value="N" />
    <input
         type="checkbox" id="autocomplete" name="autocomplete" value="Y"
         <?php echo $user["options"]["autocomplete"] == "Y" ? "checked=\"checked\"" : "" ?> />
  </p>
  <p>
    <label for="showdatetimeinlinks"><?php echo $this->GetResourceValue("ShowDateTimeInLinks");?>:</label>
    <input type="hidden" name="showdatetimeinlinks" value="N" />
    <input
         type="checkbox" id="showdatetimeinlinks" name="showdatetimeinlinks" value="Y"
         <?php echo $user["showdatetime"] == "Y" ? "checked=\"checked\"" : "" ?> />
  </p>
  <p>
    <label for="show_comments"><?php echo $this->GetResourceValue("ShowComments?");?>:</label>
    <input type="hidden" name="show_comments" value="N" />
    <input
         type="checkbox" id="show_comments" name="show_comments" value="Y"
         <?php echo $user["show_comments"] == "Y" ? "checked=\"checked\"" : "" ?> />
  </p>
  <p>
    <label for="show_files"><?php echo $this->GetResourceValue("ShowFiles?");?>:</label>
    <input type="hidden" name="show_files" value="N" />
    <input
         type="checkbox" id="show_files" name="show_files" value="Y"
         <?php echo $user["options"]["show_files"] == "Y" ? "checked=\"checked\"" : "" ?> />
  </p>
  <p>
    <label for="show_spaces"><?php echo $this->GetResourceValue("ShowSpaces");?>:</label>
    <input type="hidden" name="show_spaces" value="N" />
    <input
         type="checkbox" id="show_spaces" name="show_spaces" value="Y"
         <?php echo $user["show_spaces"] == "Y" ? "checked=\"checked\"" : "" ?> />
  </p>
  <p>
    <label for="dont_redirect"><?php echo $this->GetResourceValue("DontRedirect");?>:</label>
    <input type="hidden" name="dont_redirect" value="N" />
    <input
         type="checkbox" id="dont_redirect" name="dont_redirect" value="Y"
         <?php echo $user["options"]["dont_redirect"] == "Y" ? "checked=\"checked\"" : "" ?> />
  </p>
  <p>
    <label for="send_watchmail"><?php echo $this->GetResourceValue("SendWatchMail");?>:</label>
    <input type="hidden" name="send_watchmail" value="N" />
    <input
         type="checkbox" id="send_watchmail" name="send_watchmail" value="Y"
         <?php echo $user["options"]["send_watchmail"] == "Y" ? "checked=\"checked\"" : "" ?> />
  </p>
  <!--
      <p><label for="typografica"><?php echo $this->GetResourceValue("Typografica");?>:</label><input type="hidden" name="typografica" value="N" /><input type="checkbox" id="typografica" name="typografica" value="Y" <?php echo $user["typografica"] == "Y" ? "checked=\"checked\"" : "" ?> /></p>
    -->
  <p>
    <label for="lang"><?php echo $this->GetResourceValue("YourLanguage");?>:</label>
    <select id="lang" name="lang">
      <option value=""></option>
      <?php
         $langs = $this->AvailableLanguages();
         for ($i=0;$i<count($langs);$i++) {
            echo '<option value="'.$langs[$i].'"'.($user["lang"]==$langs[$i]?"selected=\"selected\"":"").'>'.$langs[$i].'</option>';
         }
         ?>
    </select>
  </p>
  <p>
    <label for="theme"><?php echo $this->GetResourceValue("ChooseTheme");?>:</label>
    <select id="theme" name="theme">
      <option value=""></option>
      <?php
         $themes = $this->AvailableThemes();
         for ($i=0;$i<count($themes);$i++) {
            echo '<option value="'.$themes[$i].'" '.($user["options"]["theme"]==$themes[$i]?"selected=\"selected\"":"").'>'.$themes[$i].'</option>';
         }
         ?>
    </select>
  </p>
  <p>
    <label for="changescount"><?php echo $this->GetResourceValue("RecentChangesLimit");?>:</label>
    <input id="changescount" name="changescount"
         value="<?php echo htmlentities($user["changescount"]) ?>" size="40" />
  </p>
  <p>
    <label for="revisioncount"><?php echo $this->GetResourceValue("RevisionListLimit");?>:</label>
    <input id="revisioncount" name="revisioncount"
         value="<?php echo htmlentities($user["revisioncount"]) ?>" size="40" />
  </p>
  <p>
    <label for="motto"><?php echo $this->GetResourceValue("YourMotto");?>:</label>
    <input id="motto" name="motto"
         value="<?php echo htmlspecialchars($user["motto"]) ?>" size="40" />
  </p>
  <p>
    <label for="bookmarks"><?php echo $this->GetResourceValue("YourBookmarks");?>:</label>
    <textarea id="bookmarks" name="bookmarks" cols="40" rows="10"><?php echo htmlspecialchars($user["bookmarks"]) ?></textarea>
  </p>
  <p>
    <input class="OkBtn"
         onmouseover='this.className="OkBtn_";'
         onmouseout='this.className="OkBtn";' type="submit" align="top"
         value="<?php echo $this->GetResourceValue("UpdateSettingsButton"); ?>" />
    &nbsp;
    <input class="CancelBtn"
         onmouseover='this.className="CancelBtn_";'
         onmouseout='this.className="CancelBtn";' type="button" align="top"
         value="<?php echo $this->GetResourceValue("LogoutButton"); ?>"
         onclick="document.location='<?php echo $this->href("", "", "action=logout"); ?>'" />
  </p>
</div>
<br />
<?php
         //  echo $this->FormatResourceValue("SeeListOfPages")."<br />";
         print($this->FormClose());
}
else
{
   // user is not logged in
   echo $this->Action("login", array());
}
?>
<!--/notypo-->
