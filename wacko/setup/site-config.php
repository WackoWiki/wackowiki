<script type="text/javascript">
            <!--
               function check()
                  {
                     var f = document.forms.form1;
                     var re = new RegExp("^[A-Z][a-z]+[A-Z0-9][A-Za-z0-9]*$");

                     if (f.elements["config[admin_name]"].value.search(re) == -1)
                        {
                           alert('<?php echo $lang['ErrorAdminName'];?>');
                           return false;
                        }

                     if (f.elements['password'].value.length<8)
                        {
                           alert('<?php echo $lang['ErrorAdminPasswordShort'];?>');
                           return false;
                        }

                     if (f.elements['password'].value!=f.elements["password2"].value)
                        {
                           alert('<?php echo $lang['ErrorAdminPasswordMismatch'];?>');
                           return false;
                        }

                     re = new RegExp("[a-zA-Z0-9_\-]+@[a-zA-Z0-9_\-]+\.[a-zA-Z]+", "i");

                     if (f.elements["config[admin_email]"].value.search(re) == -1)
                        {
                           alert('<?php echo $lang['ErrorAdminEmail'];?>');
                           return false;
                        }

                     return true;
                  }
            // -->
         </script>

<form action="<?php echo myLocation() ?>?installAction=<?php echo "database-config" ; ?>" method="post" name="form1">
<?php
   writeConfigHiddenNodes(array('wacko_name' => '', 'root_page' => '', 'multilanguage' => '', 'admin_name' => '', 'password' => '', 'admin_email' => '', 'base_url' => '', 'rewrite_mode' => ''));
?>
   <h2><?php echo $lang['Name'];?></h2>
   <p class="notop"><?php echo $lang['NameDesc'];?></p>
   <input type="text" maxlength="250" name="config[wacko_name]" value="<?php !isset ( $config['wakka_name'] ) ? print $config['wacko_name'] : print $config['wakka_name'] ; ?>" class="text_input" />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <h2><?php echo $lang['Home'];?></h2>
   <p class="notop"><?php echo $lang['HomeDesc'];?></p>
   <input type="text" maxlength="250" name="config[root_page]" value="<?php isset ( $lang['HomeDefault'] ) ? print $lang['HomeDefault'] : print $config['root_page'] ; ?>" class="text_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>

   <h2><?php echo $lang['MultiLang'];?></h2>
   <p class="notop"><?php echo $lang['MultiLangDesc'];?></p>
   <label class="indented_label" for="wiki_multilanguage"><?php echo $lang['Enabled'];?></label>
   <input type="checkbox" id="wiki_multilanguage" name="config[multilanguage]" <?php echo $config['multilanguage'] ? "checked=\"checked\"" : "" ?> class="checkbox_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <h2><?php echo $lang['Admin'];?></h2>
   <p class="notop"><?php echo $lang['AdminDesc'];?></p>
   <input type="text" maxlength="80" name="config[admin_name]" value="<?php if ( isset ( $config['admin_name'] ) ) echo $config['admin_name']; ?>" class="text_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <h2><?php echo $lang['Password'];?></h2>
   <p class="notop"><?php echo $lang['PasswordDesc'];?></p>
   <input type="password" maxlength="50" name="password" value="" class="text_input" />
   <label class="label_password2" for="wiki_admin_password2"><?php echo $lang['Password2'];?></label>
   <input type="password" maxlength="50" id="wiki_admin_password2" name="password2" value="" class="text_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <h2><?php echo $lang['Mail'];?></h2>
   <p class="notop"><?php echo $lang['MailDesc'];?></p>
   <input type="text" maxlength="320" name="config[admin_email]" value="<?php if ( isset ( $config['admin_email'] ) ) echo $config['admin_email']; ?>" class="text_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
<?php

// 4.3rc1 -> 4.3.rc2: remove obsolete appendix 'index.php?page='
$config['base_url'] = preg_replace('#/[^/]*$#', '/', $config['base_url']);

?>
   <h2><?php echo $lang['Base'];?></h2>
   <p class="notop"><?php echo $lang['BaseDesc'];?></p>
   <input type="text" maxlength="1000" name="config[base_url]" value="<?php echo $config['base_url'] ?>" class="text_input" style="width: 907px;" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <h2><?php echo $lang['Rewrite'];?></h2>
   <p class="notop"><?php echo $lang['RewriteDesc'];?></p>
   <label class="indented_label" for="wiki_rewrite"><?php echo $lang['Enabled'];?></label>
   <input type="checkbox" id="wiki_rewrite" name="config[rewrite_mode]" <?php echo $config['rewrite_mode'] ? "checked=\"checked\"" : "" ?> class="checkbox_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <input type="submit" value="<?php echo $lang['Continue'];?>" class="next" onclick="return check();" />
</form>