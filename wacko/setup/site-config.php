<script>
	<!--
		function check()
		{
			var f = document.forms.form1;
			//var re = new RegExp("^[A-Z][a-z]+[A-Z0-9][A-Za-z0-9]*$");

			//if (f.elements["config[admin_name]"].value.search(re) == -1)
			//{
			//	alert('<?php echo $lang['ErrorAdminName'];?>');
			//	return false;
			//}

			if (f.elements['password'].value.length<9)
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

<?php
// TODO: refactor -> same function as in wacko class
function available_languages()
{
	$handle = opendir('lang');

	while (false !== ($file = readdir($handle)))
	{
		if ($file != '.'
		&& $file != '..'
		&& $file != 'wacko.all.php'
		&& !is_dir('lang/'.$file)
		&& 1 == preg_match('/^wacko\.(.*?)\.php$/', $file, $match))
		{
			$lang_list[] = $match[1];
		}
	}

	closedir($handle);
	sort($lang_list, SORT_STRING);

	return $lang_list;
}
?>

<form action="<?php echo my_location() ?>?installAction=database-config" method="post" name="form1">
<?php

write_config_hidden_nodes(array(
	'site_name'			=> '',
	'root_page'			=> '',
	'multilanguage'		=> '',
	'allowed_languages'	=> '',
	'admin_name'		=> '',
	'password'			=> '',
	'admin_email'		=> '',
	'base_url'			=> '',
	'rewrite_mode'		=> '')
);

?>
   <h2><?php echo $lang['Name'];?></h2>
   <p class="notop"><?php echo $lang['NameDesc'];?></p>
   <input type="text" maxlength="250" name="config[site_name]" value="<?php echo $config['site_name']; ?>" class="text_input" />
   <?php
if ($config['is_update'] == false)
{?>
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <h2><?php echo $lang['Home'];?></h2>
   <p class="notop"><?php echo $lang['HomeDesc'];?></p>
   <input type="text" maxlength="250" name="config[root_page]" value="<?php isset ( $lang['HomeDefault'] ) ? print $lang['HomeDefault'] : print $config['root_page'] ; ?>" class="text_input" />
   <br />
<?php
}
else
{
	echo '<input type="hidden" value="'.$config['root_page'].'" name="config[root_page]">';
}
?>
   <div class="fake_hr_seperator">
      <hr />
   </div>

   <h2><?php echo $lang['MultiLang'];?></h2>
   <p class="notop"><?php echo $lang['MultiLangDesc'];?></p>
   <label class="indented_label" for="wiki_multilanguage"><?php echo $lang['Enabled'];?></label>
   <input type="checkbox" id="wiki_multilanguage" name="config[multilanguage]" value="1" <?php echo !empty($config['multilanguage']) ? 'checked="checked"' : '' ?> class="checkbox_input" />
   <br />

   <div class="fake_hr_seperator">
      <hr />
   </div>

   <h2><?php echo $lang['AllowedLang'];?></h2>
   <p class="notop"><?php echo $lang['AllowedLangDesc'];?></p>
   <p class="notop">
<?php

if ($config['multilanguage'] || $config['is_update'] == false)
{
	$langs = available_languages();
}
else
{
	$langs[] = $config['language'];
}

if (isset($this->config['allowed_languages']))
{
	$lang_list = explode(',', $this->config['allowed_languages']);
}
else
{
	$lang_list= array();
}

$n = 1;

echo '<table><tr>';

foreach ($langs as $_lang)
{
	echo	'<td><input type="checkbox" name="config[allowed_languages]['.$n.']" id="lang_'.$_lang.'" value="'.$_lang.'" '. (in_array($_lang, $lang_list) ? ' checked="checked"' : ''). ' />'."\n".
			'<label for="lang_'.$_lang.'">'.$languages[$lang].' ('.$_lang.')</label></td>'."\n";

	// modulus operator: every third loop add a break
	if ($n % 3 == 0)
	{
		echo '</tr>';
	}
	;
	$n++;
}

echo '</tr></table>';
echo "</p>\n";


if ($config['is_update'] == false)
{?>
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
   <input type="email" maxlength="320" name="config[admin_email]" value="<?php if ( isset ( $config['admin_email'] ) ) echo $config['admin_email']; ?>" class="text_input" />
   <br />
<?php
}
else
{
	echo '<input type="hidden" value="'.$config['admin_name'].'" name="config[admin_name]">';
	echo '<input type="hidden" value="'.$config['admin_email'].'" name="config[admin_email]">';
}
?>
   <div class="fake_hr_seperator">
      <hr />
   </div>
<?php

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
   <input type="checkbox" id="wiki_rewrite" name="config[rewrite_mode]"  value="1" <?php echo isset($config['rewrite_mode']) ? 'checked="checked"' : '' ?> class="checkbox_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <input type="submit" value="<?php echo $lang['Continue'];?>" class="next" onclick="return check();" />
</form>