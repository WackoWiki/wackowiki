<form action="<?php echo my_location() ?>?installAction=version-check" method="post">
<?php

write_config_hidden_nodes([
	'language'		=> 0,
	'is_update'		=> '']
);

// Check if Upgrade or Fresh Install
if (array_key_exists('wacko_version', $config))
{
	$min_upgrade_version = '5.5.17';

	if (version_compare($config['wacko_version'], $min_upgrade_version, '<'))
	{
		$config['is_update'] = null;
		echo '<ul class="security"><li>' .
			Ut::perc_replace($lang['PleaseUpgradeToR5'],
				'<code class="version">' . $min_upgrade_version . '</code>',
				'<code class="version">' . $min_upgrade_version . '</code>') .
			"</li></ul>\n";
		// https://sourceforge.net/projects/wackowiki/files/
		// https://wackowiki.org/doc/Dev/Release/R6.0/Upgrade
	}
	else
	{
		$config['is_update'] = '1';
		echo '<p>' .
			Ut::perc_replace($lang['UpgradeFromWacko'],
				'<code class="version">' . $config['wacko_version'] . '</code>',
				'<code class="version">' . WACKO_VERSION . '</code>') .
			"</p>\n";
		echo '<p class="warning">' . $lang['PleaseBackup'] . "</p>\n";
	}
}
else
{
	$config['is_update'] = '0';
	echo '<p>' . Ut::perc_replace($lang['FreshInstall'], '<code class="version">' . WACKO_VERSION . '</code>') . "</p>\n";
}

echo '<input type="hidden" value="' . $config['is_update'] . '" name="config[is_update]">';

?>
	<p><?php echo $lang['LangDesc'];?></p>
<?php
// https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
$lang_codes = [];
$lang_codes['bg'] = 'български';
$lang_codes['da'] = 'Dansk';
$lang_codes['de'] = 'Deutsch';
$lang_codes['et'] = 'Eesti';
$lang_codes['en'] = 'English';
$lang_codes['el'] = 'Ελληνικά';
$lang_codes['es'] = 'Español';
$lang_codes['fr'] = 'Français';
$lang_codes['hu'] = 'Magyar';
$lang_codes['it'] = 'Italiano';
$lang_codes['nl'] = 'Nederlands';
$lang_codes['pl'] = 'Polski';
$lang_codes['pt'] = 'Portugues';
$lang_codes['ru'] = 'Русский';

foreach($lang_codes as $key => $value)
{
	echo '   <input type="radio" id="lang_' . $key . '" name="config[language]" value="' . $key . '"';

	// Default or Selected Language
	if (isset($_POST['config']['language']))
	{
		if ($_POST['config']['language'] == $key)
		{
			echo ' checked ';
		}
	}
	else if ($config['language'] == $key)
	{
		echo ' checked ';
	}

	echo " onClick=\"this.form.action='?installAction=lang'; submit(); \"";
	echo ' class="input_lang"><label for="lang_' . $key . '" class="label_lang">' . $value . ' (' . $key . ")</label><br>\n";
}

if (isset($config['is_update']))
{
?>
	<input type="submit" value="<?php echo $lang['Continue'];?>" class="next">
<?php
}?>
</form>