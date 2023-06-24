<form action="<?php echo $base_path ?>?installAction=version-check" method="post">
<?php

// Check if Upgrade or Fresh Install
if (array_key_exists('wacko_version', $config))
{
	$min_upgrade_version = '6.0.22';

	if (version_compare($config['wacko_version'], $min_upgrade_version, '<'))
	{
		$config['is_update'] = null;

		echo '<ul class="attention"><li>' .
			Ut::perc_replace(
				$lang['PleaseUpgradeToR6'],
				'<code class="version">' . $config['wacko_version'] . '</code>',
				'<code class="version">' . $min_upgrade_version . '</code>') .
			"</li></ul>\n";
		// https://sourceforge.net/projects/wackowiki/files/
		// https://wackowiki.org/doc/Dev/Release/R6.1/Upgrade
	}
	else
	{
		$config['is_update'] = '1';

		echo '<p>' .
			Ut::perc_replace(
				$lang['UpgradeFromWacko'],
				'<code class="version">' . $config['wacko_version'] . '</code>',
				'<code class="version">' . WACKO_VERSION . '</code>') .
			"</p>\n";
		echo '<p class="msg warning">' . $lang['PleaseBackup'] . "</p>\n";
	}
}
else
{
	$config['is_update'] = '0';

	echo '<p>' . Ut::perc_replace(
				$lang['FreshInstall'],
				'<code class="version">' . WACKO_VERSION . '</code>') .
		"</p>\n";
}

echo '<input type="hidden" value="' . $config['is_update'] . '" name="config[is_update]">';

echo '<p>' . $lang['LangDesc'] . "</p>\n";

$n = 1;

echo '<br><ul class="checkbox_input column-4">' . "\n";

// available languages
foreach ($lang['LanguageArray'] as $key => $value)
{
	echo "\t<li>\n\t\t";
	echo '<input type="radio" id="lang_' . $key . '" name="config[language]" value="' . $key . '"';

	// default or selected language
	if (   (isset($_POST['config']['language']) && $_POST['config']['language'] == $key)
		|| $config['language'] == $key
	)
	{
		echo ' checked ';
	}

	echo " onClick=\"this.form.action='?installAction=lang'; submit(); \"";
	echo ' class="input_lang"><label for="lang_' . $key . '" class="label_lang">' . $value . ' (' . $key . ")</label>";
	echo "\n\t</li>\n";
}

echo "\n</ul>\n<br>\n";

if (isset($config['is_update']))
{
	echo '<button type="submit" class="next">' . $lang['Continue'] . "</button>\n";
}
?>
</form>
