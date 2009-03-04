<?php

if ($this->HasAccess("comment") && $this->HasAccess("read"))
   {
      // find number
      if($latestComment = $this->LoadSingle("SELECT tag, id FROM ".$this->config["table_prefix"]."pages WHERE comment_on != '' ORDER BY id DESC LIMIT 1"))
         {
            preg_match("/^Comment([0-9]+)$/", $latestComment["tag"], $matches);
            $num = $matches[1] + 1;
         }
      else
         {
            $num = "1";
         }

      $body = str_replace("\r", "", $_POST["body"]);
      $body = trim($_POST["body"]);

      if(!$body)
         {
            $this->SetMessage($this->GetTranslation("EmptyComment"));
         }
      else
         {
            // Start Comment Captcha

            // Only show captcha if the admin enabled it in the config file
            if($this->GetConfigValue("captcha_new_comment"))
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
                                          $_SESSION['freecap_old_comment'] = "";

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
                                    $error = $this->GetTranslation("SpamAlert");
                                    $this->SetMessage($this->GetTranslation("SpamAlert"));
                                    $_SESSION['freecap_old_comment'] = $body;
                                 }
                           }
                     }
               }

            if(!$error)
               {
                  // store new comment
                  $this->SavePage("Comment".$num, $body, $this->tag);
               }

            // End Comment Captcha
         }


      // redirect to page
      $this->redirect($this->href());
   }
else
   {
      print("<div id=\"page\">".$this->GetTranslation("CommentAccessDenied")."</div>\n");
   }

?>