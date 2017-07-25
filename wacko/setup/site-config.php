<script>
	<!--
		function check()
		{
			var f = document.forms.form1;

			if (f.elements['password'].value.length < <?php echo $config['pwd_admin_min_chars'];?>)
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

<form action="<?php echo my_location() ?>?installAction=database-config" method="post" name="form1">
<?php

write_config_hidden_nodes([
	'site_name'			=> '',
	'root_page'			=> '',
	'multilanguage'		=> '',
	'allowed_languages'	=> '',
	'admin_name'		=> '',
	'password'			=> '',
	'admin_email'		=> '',
	'base_url'			=> '',
	'rewrite_mode'		=> '']
);

?>
   <label class="label_top" for="site_name"><?php echo $lang['Name'];?></label>
   <p class="notop"><?php echo $lang['NameDesc'];?></p>
   <input type="text" maxlength="250" id="site_name" name="config[site_name]" value="<?php echo $config['site_name']; ?>" class="text_input" />
   <?php
if ($config['is_update'] == false)
{?>
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <label class="label_top" for="root_page"><?php echo $lang['Home'];?></label>
   <p class="notop"><?php echo $lang['HomeDesc'];?></p>
   <input type="text" maxlength="250" id="root_page" name="config[root_page]" value="<?php isset ( $lang['HomeDefault'] ) ? print $lang['HomeDefault'] : print $config['root_page'] ; ?>" class="text_input" />
   <br />
<?php
}
else
{
	echo '<input type="hidden" value="' . $config['root_page'] . '" name="config[root_page]">';
}
?>
   <div class="fake_hr_seperator">
      <hr />
   </div>

   <h2><?php echo $lang['MultiLang'];?></h2>
   <p class="notop"><?php echo $lang['MultiLangDesc'];?></p>
   <label class="indented_label" for="multilanguage"><?php echo $lang['Enabled'];?></label>
   <input type="checkbox" id="multilanguage" name="config[multilanguage]" value="1" <?php echo !empty($config['multilanguage']) ? 'checked' : '' ?> class="checkbox_input" />
   <br />

   <div class="fake_hr_seperator">
      <hr />
   </div>

   <h2><?php echo $lang['AllowedLang'];?></h2>
   <p class="notop"><?php echo $lang['AllowedLangDesc'];?></p>

<?php

if ($config['multilanguage'] || $config['is_update'] == false)
{
	$langs = available_languages();
}
else
{
	$langs[] = $config['language'];
}

if (isset($config['allowed_languages']))
{
	$lang_list = explode(',', $config['allowed_languages']);
}
else
{
	$lang_list= [];
}

$_languages = $lang['LanguageArray'];
$n = 1;

echo '<table  class="checkbox_input">' . "\n\t<tr>\n";

foreach ($langs as $_lang)
{
	echo	"\t\t<td>\n\t\t\t" .
				'<input type="checkbox" name="config[allowed_languages][' . $n . ']" id="lang_' . $_lang . '" value="' . $_lang . '" '. (in_array($_lang, $lang_list) ? ' checked' : ''). ' />' . "\n\t\t\t" .
				'<label for="lang_' . $_lang . '">' . $_languages[$_lang] . ' (' . $_lang . ')</label>' .
			"\n\t\t</td>\n";

	// modulus operator: every third loop add a break
	if ($n % 3 == 0)
	{
		echo "\t</tr>\n\t<tr>\n";
	}
	;
	$n++;
}

echo "\t</tr>\n</table>\n";


if ($config['is_update'] == false)
{?>
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <label class="label_top" for="admin_nam"><?php echo $lang['Admin'];?></label>
   <p class="notop"><?php echo $lang['AdminDesc'];?></p>
   <input type="text" minlength="<?php echo $config['username_chars_min'] ?>"  maxlength="<?php echo $config['username_chars_max'] ?>" id="admin_nam" name="config[admin_name]" value="<?php if (isset($config['admin_name'])) echo $config['admin_name']; ?>" class="text_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <label class="label_top" for="password"><?php echo $lang['Password'];?></label>
   <p class="notop"><?php echo Ut::perc_replace($lang['PasswordDesc'], $config['pwd_admin_min_chars']);?></p>
   <input type="password" minlength="<?php echo $config['pwd_admin_min_chars'] ?>" id="password" name="password" value="" class="text_input" />
   <label class="label_password2" for="wiki_admin_password2"><?php echo $lang['Password2'];?></label>
   <input type="password" minlength="<?php echo $config['pwd_admin_min_chars'] ?>" id="wiki_admin_password2" name="password2" value="" class="text_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <label class="label_top" for="admin_email"><?php echo $lang['Mail'];?></label>
   <p class="notop"><?php echo $lang['MailDesc'];?></p>
   <input type="email" maxlength="320" id="admin_email" name="config[admin_email]" value="<?php if (isset($config['admin_email'])) echo $config['admin_email']; ?>" class="text_input" />
   <br />
<?php
}
else
{
	echo '<input type="hidden" value="' . $config['admin_name'] . '" name="config[admin_name]">';
	echo '<input type="hidden" value="' . $config['admin_email'] . '" name="config[admin_email]">';
}
?>
   <div class="fake_hr_seperator">
      <hr />
   </div>
<?php

?>
   <label class="label_top" for="base_url"><?php echo $lang['Base'];?></label>
   <p class="notop"><?php echo $lang['BaseDesc'];?></p>
   <input type="text" maxlength="1000" id="base_url" name="config[base_url]" value="<?php echo $config['base_url'] ?>" class="text_input"/>
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <h2><?php echo $lang['Rewrite'];?></h2>
   <p class="notop"><?php echo $lang['RewriteDesc'];?></p>
   <label class="indented_label" for="wiki_rewrite"><?php echo $lang['Enabled'];?></label>
   <input type="checkbox" id="wiki_rewrite" name="config[rewrite_mode]"  value="1" <?php echo isset($config['rewrite_mode']) ? 'checked' : '' ?> class="checkbox_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <input type="submit" value="<?php echo $lang['Continue'];?>" class="next" onclick="return check();" />
</form>
