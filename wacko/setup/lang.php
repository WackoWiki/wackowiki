<form action="<?php echo my_location() ?>?installAction=version-check" method="post">
<?php

// Check if Upgrade or Fresh Install
if (array_key_exists('wacko_version', $config))
{
	$min_upgrade_version = '5.5.17';

	if (version_compare($config['wacko_version'], $min_upgrade_version, '<'))
	{
		$config['is_update'] = null;
		echo '<ul class="security"><li>' .
			Ut::perc_replace($lang['PleaseUpgradeToR6'],
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
// available languages
$lang_codes = [
	'bg' => 'български',
	'da' => 'Dansk',
	'de' => 'Deutsch',
	'el' => 'Ελληνικά',
	'en' => 'English',
	'es' => 'Español',
	'et' => 'Eesti',
	'fa' => 'فارسی',
	'fr' => 'Français',
	'hi' => 'हिन्दी',
	'hu' => 'Magyar',
	'it' => 'Italiano',
	'ja' => '日本語',
	'ko' => '한국어',
	'nl' => 'Nederlands',
	'pl' => 'Polski',
	'pt' => 'Português',
	'ru' => 'Русский',
	'zh' => '简体中文',
	'zh-tw' => '正體中文',
];

$n = 1;

echo '<br><table class="checkbox_input">' . "\n\t<tr>\n";

foreach($lang_codes as $key => $value)
{
	echo "\t\t<td>\n\t\t\t";
	echo '<input type="radio" id="lang_' . $key . '" name="config[language]" value="' . $key . '"';

	// default or selected language
	if (isset($_POST['config']['language']) && $_POST['config']['language'] == $key)
	{
		echo ' checked ';
	}
	else if ($config['language'] == $key)
	{
		echo ' checked ';
	}

	echo " onClick=\"this.form.action='?installAction=lang'; submit(); \"";
	echo ' class="input_lang"><label for="lang_' . $key . '" class="label_lang">' . $value . ' (' . $key . ")</label>";
	echo "\n\t\t</td>\n";

	// modulus operator: every third loop add a break
	if ($n % 3 == 0)
	{
		echo "\t</tr>\n\t<tr>\n";
	}

	$n++;
}

echo "\t</tr>\n</table>\n<br>\n";

if (isset($config['is_update']))
{
?>
	<button type="submit" class="next"><?php echo $lang['Continue'];?></button>
<?php
}?>
</form>
