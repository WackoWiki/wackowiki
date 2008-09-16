<?php

// invoke autocomplete if needed
if ($_GET["_autocomplete"])
{
   include( dirname(__FILE__)."/_autocomplete.php" );
   return;
}

?>
<?php if (!$this->GetConfigValue("edit_table_based")) { ?>

<div class="pageedit">
  <?php } ?>
  <?php
if ($this->HasAccess("write") && $this->HasAccess("read"))
{
   if ($this->GetConfigValue("edit_table_based")) {
      ?>
</div>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
  <tr>
    <td style='padding: 0px 20px' width="100%"><?php
}
if ($_POST)
{
   // only if saving:
   if ($_POST["save"])
   {
      // check for overwriting
      if ($this->page)
         if ($this->page["time"] != $_POST["previous"])
            $error = $this->GetResourceValue("OverwriteAlert");

      if(($this->page && $this->GetConfigValue("captcha_edit_page")) || (!$this->page && $this->GetConfigValue("captcha_new_page")))
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

      // store
      if (!$error)
      {
         $body = str_replace("\r", "", $_POST["body"]);

         // add page (revisions)
         $body_r = $this->SavePage($this->tag, $body);

         // now we render it internally so we can write the updated link table.
         $this->ClearLinkTable();
         $this->StartLinkTracking();
         $dummy = $this->Format($body_r, "post_wacko");
         $this->StopLinkTracking();
         $this->WriteLinkTable();
         $this->ClearLinkTable();

         // forward
         $this->pageCache[$this->supertag] = "";
         $this->Redirect($this->href("", $this->tag).$this->AddDateTime($this->tag));
      }
   }
}

$this->NoCache();

// fetch fields
if (!$previous = $_POST["previous"]) $previous = $this->page["time"];
if (!$body = $_POST["body"]) $body = $this->page["body"];

{
   // display form
   if ($error)
   {
      $output .= "<div class=\"error\">$error</div>\n";
   }

   // append a comment?
   if ($_REQUEST["appendcomment"])
   {
      $body = trim($body)."\n\n----\n\n--".$this->GetUserName()." (".strftime("%c").")";
   }
   // "cf" attribute: it is for so called "critical fields" in the form. It is used by some javascript code, which is launched onbeforeunload and shows a pop-up dialog "You are going to leave this page, but there are some changes you made but not saved yet." Is used by this script to determine which changes it need to monitor.
   $output .= $this->FormOpen("edit", "", "post", "edit", " cf='true' ");

   if ($_REQUEST["add"]) $output .= '<input name="lang" type="hidden" value="'.$this->pagelang.'" />';
   if ($_REQUEST["add"]) $output .= '<input name="tag" type="hidden" value="'.$this->tag.'" />';
   if ($_REQUEST["add"]) $output .= '<input name="add" type="hidden" value="1" />';

   print($output);
   $output = "";

   // preview?
   if ($_POST["preview"])
   {
      ?>
      <input name="save" class="OkBtn"
         onmouseover='this.className="OkBtn_";'
         onmouseout='this.className="OkBtn";' type="submit" align="top"
         value="<?php echo $this->GetResourceValue("EditStoreButton"); ?>" />
      &nbsp;
      <input name="preview"
         class="OkBtn" onmouseover='this.className="OkBtn_";'
         onmouseout='this.className="OkBtn";' type="submit" align="top"
         value="<?php echo $this->GetResourceValue("EditPreviewButton"); ?>" />
      &nbsp;
      <input class="CancelBtn"
         onmouseover='this.className="CancelBtn_";'
         onmouseout='this.className="CancelBtn";' type="button" align="top"
         value="<?php echo $this->GetResourceValue("EditCancelButton"); ?>"
         onclick="document.location='<?php echo addslashes($this->href(""))?>';" />
      <?php

         if ($this->GetConfigValue("edit_table_based"))
         $output .= '<div class="pageBefore">&nbsp;</div><div class="page">';

         $output = "<fieldset class=\"preview\"><legend>".$this->GetResourceValue("EditPreview")."</legend>\n";

         $output .= $this->Format($body);
         $output .= "</fieldset><br />\n";

         print($output);
         $output = "";

}
?>
      <input name="save" class="OkBtn_Top"
         onmouseover='this.className="OkBtn_Top_";'
         onmouseout='this.className="OkBtn_Top";' type="submit" align="top"
         value="<?php echo $this->GetResourceValue("EditStoreButton"); ?>" />
      &nbsp;
      <input name="preview"
         class="OkBtn_Top" onmouseover='this.className="OkBtn_Top_";'
         onmouseout='this.className="OkBtn_Top";' type="submit" align="top"
         value="<?php echo $this->GetResourceValue("EditPreviewButton"); ?>" />
      &nbsp;
      <input
         class="CancelBtn_Top" onmouseover='this.className="CancelBtn_Top_";'
         onmouseout='this.className="CancelBtn_Top";' type="button"
         align="top"
         value="<?php echo str_replace("\n"," ",$this->GetResourceValue("EditCancelButton")); ?>"
         onclick="document.location='<?php echo addslashes($this->href("", "", "", 1))?>';" />
      <br />
      <?php
         $output .= "<input type=\"hidden\" name=\"previous\" value=\"".htmlspecialchars($previous)."\" /><br />";
         $output .= "<textarea id=\"postText\" name=\"body\" rows=\"40\" cols=\"60\" class=\"TextArea\">";
         $output .= htmlspecialchars($body)."</textarea><br />\n";
         print($output);

         // captcha code starts

         // Only show captcha if the admin enabled it in the config file
         if(($this->page && $this->GetConfigValue("captcha_edit_page")) || (!$this->page && $this->GetConfigValue("captcha_new_page")))
            {
               // Don't load the captcha at all if the GD extension isn't enabled
               if(extension_loaded('gd'))
                  {
                     if(strpos($this->GetUserName(), '.'))
                        {
       ?>
<p><?php echo $this->GetResourceValue("Captcha");?>:</p>
<img src="<?php echo $this->GetConfigValue("root_url");?>lib/captcha/freecap.php" id="freecap" alt="<?php echo $this->GetResourceValue("Captcha");?>" /> <a href="" onClick="this.blur(); new_freecap(); return false;" title="<?php echo $this->GetResourceValue("CaptchaReload"); ?>"><img src="<?php echo $this->GetConfigValue("theme_url");?>icons/reload.png" width="18" height="17" alt="<?php echo $this->GetResourceValue("CaptchaReload"); ?>" /></a>
<br />
<input type="text" name="word" maxlength="6" style="width: 273px;" />
<br />
<br />
<?php
                        }
                  }
            }
         // end captcha

         if ($this->GetConfigValue("edit_table_based")) {
            ?></td>
  </tr>
</table>
<div class="Wrapper" style='margin-top: 0px; padding-top: 0px'>
<div class="page" style='margin-top: 0px; padding-top: 0px'><br />
  <?php
}
?>
  <script type="text/javascript">
    wE = new WikiEdit();
    <?php
      if ($user = $this->GetUser())
      if ($user["options"]["autocomplete"])
      {
        ?>if (AutoComplete) { wEaC = new AutoComplete( wE, "<?php echo $this->href("edit");?>" ); }<?php
      }
    ?>
    wE.init('postText','WikiEdit','edname-w','<?php echo $this->GetConfigValue("root_url");?>images/wikiedit/');
  </script>
  <input name="save" class="OkBtn"
   onmouseover='this.className="OkBtn_";'
   onmouseout='this.className="OkBtn";' type="submit" align="top"
   value="<?php echo $this->GetResourceValue("EditStoreButton"); ?>" />
  &nbsp;
  <input name="preview"
   class="OkBtn" onmouseover='this.className="OkBtn_";'
   onmouseout='this.className="OkBtn";' type="submit" align="top"
   value="<?php echo $this->GetResourceValue("EditPreviewButton"); ?>" />
  &nbsp;
  <input class="CancelBtn"
   onmouseover='this.className="CancelBtn_";'
   onmouseout='this.className="CancelBtn";' type="button" align="top"
   value="<?php echo $this->GetResourceValue("EditCancelButton"); ?>"
   onclick="document.location='<?php echo addslashes($this->href(""))?>';" />
  <?php
}

print ( $this->FormClose() );
}
else
{
   print("<div class=\"page\">");
   print($this->GetResourceValue("WriteAccessDenied"));
   print("</div>");
}
?>
</div>
