<?php

if (!$wakkaConfig["wakka_version"])
   {
?>
         <script language="JavaScript" type="text/javascript">
            <!--
               function check()
                  {
                     var f = document.forms.form1;
                     var re = new RegExp("^[A-Z][a-z]+[A-Z0-9][A-Za-z0-9]*$");

                     if (f.elements["config[admin_name]"].value.search(re) == -1)
                        {
                           alert('<?php echo $lang["ErrorAdminName"];?>');
                           return false;
                        }

                     if (f.elements["password"].value.length<5)
                        {
                           alert('<?php echo $lang["ErrorAdminPasswordShort"];?>');
                           return false;
                        }

                     if (f.elements["password"].value!=f.elements["password2"].value)
                        {
                           alert('<?php echo $lang["ErrorAdminPasswordMismatch"];?>');
                           return false;
                        }

                     re = new RegExp("[a-zA-Z0-9_\-]+@[a-zA-Z0-9_\-]+\.[a-zA-Z]+", "i");

                     if (f.elements["config[admin_email]"].value.search(re) == -1)
                        {
                           alert('<?php echo $lang["ErrorAdminEmail"];?>');
                           return false;
                        }

                     if (f.elements["config[base_url]"].value.indexOf( "?" ) != -1 && f.elements["config[rewrite_mode]"].value != 0)
                        {
                           if (!confirm('<?php echo addcslashes($lang["WarningRewriteMode"],"\n"); ?>'))
                              {
                                 return false;
                              }
                        }

                     return true;
                  }
            // -->
         </script>
<?php
   }
else
   {
?>
<script language="JavaScript">
   <!--
   function check()
      {
         return true;
      }
   // -->
</script>
<?php
   }
?>
         <form action="<?php echo myLocation() ?>?installAction=<?php print !$wakkaConfig["wakka_version"] ? "database-config" : "database-install" ?>" method="post" name="form1">
            <input type="hidden" name="config[language]" value="<?php echo $config["language"];?>" />
            <h2><?php echo $lang["Name"];?></h2>
            <p class="notop"><?php echo $lang["NameDesc"];?></p>
            <input type="text" maxlength="250" name="config[wakka_name]" value="<?php echo $wakkaConfig["wakka_name"] ?>" class="text_input" />
            <div class="fake_hr_seperator"><hr /></div>
            <h2><?php echo $lang["Home"];?></h2>
            <p class="notop"><?php echo $lang["HomeDesc"];?></p>
            <input type="text" maxlength="250" name="config[root_page]" value="<?php echo $wakkaConfig["root_page"] ?>" class="text_input" />
            <br />
            <div class="fake_hr_seperator"><hr /></div>
<?php

   // Don't do the following if this is an upgrade install
   if(!$wakkaConfig["wakka_version"])
      {
?>
            <h2><?php echo $lang["multilang"];?></h2>
            <p class="notop"><?php echo $lang["MultiLangDesc"];?></p>
            <label class="indented_label" for="wiki_multilanguage"><?php echo $lang["Enabled"];?></label><input type="checkbox" id="wiki_multilanguage" name="config[multilanguage]" <?php echo $wakkaConfig["multilanguage"] ? "checked=\"checked\"" : "" ?> class="checkbox_input" />
            <br />
            <div class="fake_hr_seperator"><hr /></div>
            <h2><?php echo $lang["Admin"];?></h2>
            <p class="notop"><?php echo $lang["AdminDesc"];?></p>
            <input type="text" maxlength="80" name="config[admin_name]" value="<?php echo $wakkaConfig["admin_name"] ?>" class="text_input" />
            <br />
            <div class="fake_hr_seperator"><hr /></div>
            <h2><?php echo $lang["Password"];?></h2>
            <p class="notop"><?php echo $lang["PasswDesc"];?></p>
            <input type="password" maxlength="50" name="password" value="" class="text_input" />
            <label class="label_password2" for="wiki_admin_password2"><?php echo $lang["Password2"];?></label><input type="password" maxlength="50" id="wiki_admin_password2" name="password2" value="" class="text_input" />
            <br />
            <div class="fake_hr_seperator"><hr /></div>
            <h2><?php echo $lang["Mail"];?></h2>
            <p class="notop"><?php echo $lang["MailDesc"];?></p>
            <input type="text" maxlength="320" name="config[admin_email]" value="<?php echo $wakkaConfig["admin_email"] ?>" class="text_input" />
            <br />
            <div class="fake_hr_seperator"><hr /></div>
<?php
      }
?>
            <h2><?php echo $lang["Base"];?></h2>
            <p class="notop"><?php echo $lang["BaseDesc"];?></p>
            <input type="text" maxlength="1000" name="config[base_url]" value="<?php echo $wakkaConfig["base_url"] ?>" class="text_input" style="width: 907px;" />
            <br />
            <div class="fake_hr_seperator"><hr /></div>
            <h2><?php echo $lang["Rewrite"];?></h2>
            <p class="notop"><?php echo $lang["RewriteDesc"];?></p>
            <label class="indented_label" for="wiki_rewrite"><?php echo $lang["Enabled"];?></label><input type="hidden" id="wiki_rewrite" name="config[rewrite_mode]" value="0" /><input type="checkbox" name="config[rewrite_mode]" <?php echo $wakkaConfig["rewrite_mode"] ? "checked=\"checked\"" : "" ?> class="checkbox_input" />
            <br />
            <div class="fake_hr_seperator"><hr /></div>
            <input type="submit" value="<?php echo $lang["Continue"];?>" class="next" onclick="return check();" />
         </form>
