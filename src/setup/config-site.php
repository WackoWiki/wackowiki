<?php
$msg_pwd_short	= _t('ErrorAdminPasswordShort');
$msg_pwd_short	= (is_string($msg_pwd_short) && $msg_pwd_short !== '')
					? Ut::perc_replace($msg_pwd_short, (int) $config['pwd_admin_min_chars'])
					: 'The password must be at least ' . (int) $config['pwd_admin_min_chars'] . ' characters long.';

$msg_pwd_mismatch	= _t('ErrorAdminPasswordMismatch');
$msg_pwd_mismatch	= (is_string($msg_pwd_mismatch) && $msg_pwd_mismatch !== '')
					? $msg_pwd_mismatch
					: 'The passwords do not match.';
?>
<form action="<?php echo Ut::html((string) $base_path) ?>?installAction=config-database" method="post" name="config_site"
	data-pwd-min-chars="<?php echo (int) $config['pwd_admin_min_chars']; ?>"
	data-msg-pwd-short="<?php echo Ut::html((string) $msg_pwd_short) ?>"
	data-msg-pwd-mismatch="<?php echo Ut::html((string) $msg_pwd_mismatch) ?>">
<?php
write_config_hidden_nodes($config_parameters);

?>
	<label class="label_top" for="site_name"><?php echo _t('SiteName');?></label>
	<p class="notop"><?php echo _t('SiteNameDesc');?></p>
	<input type="text" maxlength="250" id="site_name" name="config[site_name]" value="<?php echo Ut::html((string) ($config['is_update'] ? ($config['site_name'] ?? '') : (_t('SiteNameDefault') !== '' ? _t('SiteNameDefault') : ($config['site_name'] ?? '')))); ?>" class="text_input" required>
<?php
if (!$config['is_update'])
{
	echo $separator; ?>
	<label class="label_top" for="root_page"><?php echo _t('HomePage');?></label>
	<p class="notop"><?php echo _t('HomePageDesc');?></p>
	<input type="text" maxlength="250" id="root_page" name="config[root_page]" value="<?php echo Ut::html((string) (_t('HomePageDefault') !== '' ? _t('HomePageDefault') : ($config['root_page'] ?? ''))); ?>" class="text_input" required>
	<br>
<?php
}
else
{
	echo '<input type="hidden" value="' . Ut::html((string) $config['root_page']) . '" name="config[root_page]">';
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
$_languages	= is_array($_languages) ? $_languages : [];
$n			= 1;

echo '<ul class="checkbox_input column-4">' . "\n";

foreach ($langs as $_lang)
{
	echo	"\t<li>\n\t\t" .
		'<input type="checkbox" name="config[allowed_languages][' . $n . ']" id="lang_' . Ut::html((string) $_lang) . '" value="' . Ut::html((string) $_lang) . '" ' . (in_array($_lang, $lang_list) ? ' checked' : '') . '>' . "\n\t\t\t" .
		'<label for="lang_' . Ut::html((string) $_lang) . '">' . Ut::html((string) ($_languages[$_lang] ?? $_lang)) . ' (' . Ut::html((string) $_lang) . ')</label>' .
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
	<input type="text" minlength="<?php echo (int) $config['username_chars_min'] ?>" maxlength="<?php echo (int) $config['username_chars_max'] ?>" id="admin_nam" name="config[admin_name]" value="<?php echo Ut::html((string) ($config['admin_name'] ?? '')) ?>" class="text_input" pattern="[\p{L}\p{Nd}]+" title="<?php echo Ut::html((string) $name_pattern); ?>" required>
	<br>
<?php echo $separator; ?>
	<label class="label_top" for="password"><?php echo _t('Password');?></label>
	<p class="notop"><?php echo Ut::perc_replace(_t('PasswordDesc'), $config['pwd_admin_min_chars']);?></p>
	<input type="password" minlength="<?php echo (int) $config['pwd_admin_min_chars'] ?>" id="password" name="password" value="" class="text_input" required>
	<label class="label_password2" for="wiki_admin_password2"><?php echo _t('PasswordConfirm');?></label>
	<input type="password" minlength="<?php echo (int) $config['pwd_admin_min_chars'] ?>" id="wiki_admin_password2" name="password2" value="" class="text_input" required>
	<br>
<?php echo $separator; ?>
	<label class="label_top" for="admin_email"><?php echo _t('Mail');?></label>
	<p class="notop"><?php echo _t('MailDesc');?></p>
	<input type="email" maxlength="320" id="admin_email" name="config[admin_email]" value="<?php echo Ut::html((string) ($config['admin_email'] ?? '')) ?>" class="text_input" required>
	<br>
<?php
}
else
{
	echo '<input type="hidden" value="' . Ut::html((string) $config['admin_name']) . '" name="config[admin_name]">';
	echo '<input type="hidden" value="' . Ut::html((string) $config['admin_email']) . '" name="config[admin_email]">';
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
	<input type="url" maxlength="1000" id="base_url" name="config[base_url]" value="<?php echo Ut::html((string) $config['base_url']) ?>" class="text_input" required>
	<br>
<?php echo $separator; ?>
	<h2><?php echo _t('Rewrite');?></h2>
	<p class="notop"><?php echo _t('RewriteDesc');?></p>
	<label class="indented_label" for="wiki_rewrite"><?php echo _t('Enabled');?></label>
	<input type="checkbox" id="wiki_rewrite" name="config[rewrite_mode]"  value="1" <?php echo isset($config['rewrite_mode']) ? 'checked' : '' ?> class="checkbox_input">
	<br>
<?php echo $separator; ?>
	<button type="submit" class="next"><?php echo _t('Continue');?></button>
</form>
