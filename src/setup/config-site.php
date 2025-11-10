<script>
	<!--
		function check()
		{
			const f = document.forms.config_site;

			if (f.elements['password'].value.length < <?php echo $config['pwd_admin_min_chars'];?>)
			{
				alert('<?php echo Ut::perc_replace(_t('ErrorAdminPasswordShort'), $config['pwd_admin_min_chars']);?>');
				return false;
			}

			if (f.elements['password'].value !== f.elements["password2"].value)
			{
				alert('<?php echo _t('ErrorAdminPasswordMismatch');?>');
				return false;
			}

			return true;
		}
	// -->
</script>

<form action="<?php echo $base_path ?>?installAction=config-database" method="post" name="config_site">
<?php
write_config_hidden_nodes($config_parameters);

?>
	<label class="label_top" for="site_name"><?php echo _t('SiteName');?></label>
	<p class="notop"><?php echo _t('SiteNameDesc');?></p>
	<input type="text" maxlength="250" id="site_name" name="config[site_name]" value="<?php echo $config['is_update'] ? $config['site_name'] : (_t('SiteNameDefault') ?? $config['site_name']); ?>" class="text_input" required>
<?php
if (!$config['is_update'])
{
	echo $separator; ?>
	<label class="label_top" for="root_page"><?php echo _t('HomePage');?></label>
	<p class="notop"><?php echo _t('HomePageDesc');?></p>
	<input type="text" maxlength="250" id="root_page" name="config[root_page]" value="<?php echo _t('HomePageDefault') ?? $config['root_page']; ?>" class="text_input" required>
	<br>
<?php
}
else
{
	echo '<input type="hidden" value="' . $config['root_page'] . '" name="config[root_page]">';
}

	echo $separator; ?>

	<h2><?php echo _t('MultiLang');?></h2>
	<p class="notop"><?php echo _t('MultiLangDesc');?></p>
	<label class="indented_label" for="multilanguage"><?php echo _t('Enabled');?></label>
	<input type="checkbox" id="multilanguage" name="config[multilanguage]" value="1" <?php echo !empty($config['multilanguage']) ? 'checked' : '' ?> class="checkbox_input">
	<br>

<?php echo $separator; ?>

	<h2><?php echo _t('AllowedLang');?></h2>
	<p class="notop"><?php echo _t('AllowedLangDesc');?></p>

<?php

if (($config['is_update'] && $config['multilanguage']) || !$config['is_update'])
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

$_languages	= _t('LanguageArray');
$n			= 1;

echo '<ul class="checkbox_input column-4">' . "\n";

foreach ($langs as $_lang)
{
	echo	"\t<li>\n\t\t" .
				'<input type="checkbox" name="config[allowed_languages][' . $n . ']" id="lang_' . $_lang . '" value="' . $_lang . '" ' . (in_array($_lang, $lang_list) ? ' checked' : '') . '>' . "\n\t\t\t" .
				'<label for="lang_' . $_lang . '">' . $_languages[$_lang] . ' (' . $_lang . ')</label>' .
			"\n\t</li>\n";
}

echo "</ul>\n";

if (!$config['is_update'])
{
	echo $separator; ?>

<h2><?php echo _t('AclMode');?></h2>
	<p class="notop"><?php echo _t('AclModeDesc'); ?></p>
	<ul>
<?php
	/*
	 ACL Wiki Modes

	 [0]   :  default_read_acl value to be stored in the config
	 [1]   :  the name to display in the list here
	 */

	$acls	= [];
	$acls[]	= ['*',	_t('PublicWiki')];
	$acls[]	= ['$',	_t('PrivateWiki')];

	foreach ($acls as $m => $acl)
	{
			echo '<li>
						<input type="radio" id="acl_mode_' . $m . '" name="config[default_read_acl]" value="' . $acl[0] . '" ' .
							($config['default_read_acl'] == $acl[0]		? 'checked' : ''
							) . '>
						<label for="acl_mode_' . $m . '">' . $acl[1] . "</label>
					</li>\n";
	}
?>
	</ul>
	<br>
<?php
}

if (!$config['is_update'])
{
	echo $separator;

	$name_pattern =
	Ut::perc_replace(($config['disable_wikiname']? _t('NameAlphanumOnly') : _t('NameCamelCaseOnly')),
			$config['username_chars_min'],
			$config['username_chars_max']);
	?>

	<label class="label_top" for="admin_nam"><?php echo _t('Admin');?></label>
	<p class="notop"><?php echo _t('AdminDesc');?></p>
	<input type="text" minlength="<?php echo $config['username_chars_min'] ?>" maxlength="<?php echo $config['username_chars_max'] ?>" id="admin_nam" name="config[admin_name]" value="<?php echo $config['admin_name'] ?? null; ?>" class="text_input" pattern="[\p{L}\p{Nd}]+" title="<?php echo $name_pattern; ?>" required>
	<br>
<?php echo $separator; ?>
	<label class="label_top" for="password"><?php echo _t('Password');?></label>
	<p class="notop"><?php echo Ut::perc_replace(_t('PasswordDesc'), $config['pwd_admin_min_chars']);?></p>
	<input type="password" minlength="<?php echo $config['pwd_admin_min_chars'] ?>" id="password" name="password" value="" class="text_input" required>
	<label class="label_password2" for="wiki_admin_password2"><?php echo _t('PasswordConfirm');?></label>
	<input type="password" minlength="<?php echo $config['pwd_admin_min_chars'] ?>" id="wiki_admin_password2" name="password2" value="" class="text_input" required>
	<br>
<?php echo $separator; ?>
	<label class="label_top" for="admin_email"><?php echo _t('Mail');?></label>
	<p class="notop"><?php echo _t('MailDesc');?></p>
	<input type="email" maxlength="320" id="admin_email" name="config[admin_email]" value="<?php echo $config['admin_email'] ?? null; ?>" class="text_input" required>
	<br>
<?php
}
else
{
	echo '<input type="hidden" value="' . $config['admin_name'] . '" name="config[admin_name]">';
	echo '<input type="hidden" value="' . $config['admin_email'] . '" name="config[admin_email]">';
}

	echo $separator; ?>

	<label class="label_top" for="base_url"><?php echo _t('Base');?></label>
	<p class="notop">
	<?php echo _t('BaseDesc');?>
		<ul>
			<li><strong><code>https://example.com/</code></strong></li>
			<li><strong><code>https://example.com/wiki/</code></strong></li>
		</ul>
	</p>
	<input type="url" maxlength="1000" id="base_url" name="config[base_url]" value="<?php echo $config['base_url'] ?>" class="text_input" required>
	<br>
<?php echo $separator; ?>
	<h2><?php echo _t('Rewrite');?></h2>
	<p class="notop"><?php echo _t('RewriteDesc');?></p>
	<label class="indented_label" for="wiki_rewrite"><?php echo _t('Enabled');?></label>
	<input type="checkbox" id="wiki_rewrite" name="config[rewrite_mode]"  value="1" <?php echo isset($config['rewrite_mode']) ? 'checked' : '' ?> class="checkbox_input">
	<br>
<?php echo $separator; ?>
	<button type="submit" class="next" onclick="return check();"><?php echo _t('Continue');?></button>
</form>
