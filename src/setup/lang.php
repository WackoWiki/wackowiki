<form action="<?php echo Ut::html((string) $base_path) ?>?installAction=version-check" method="post" name="set_language">
<?php
if (isset($config['auth']))
{
	echo '<input type="hidden" value="' . Ut::html((string) $config['auth']) . '" name="config[auth]">';
}

// Check if Upgrade or Fresh Install
if (array_key_exists('wacko_version', $config))
{
	if (version_compare($config['wacko_version'], MIN_VERSION, '<'))
	{
		$config['is_update'] = null;

		echo '<ul class="attention"><li>' .
				Ut::perc_replace(
					_t('PleaseUpgradeToR6'),
					'<code class="version">' . Ut::html((string) $config['wacko_version']) . '</code>',
					'<code class="version">' . Ut::html((string) MIN_VERSION) . '</code>'
				) .
				'</br></br>' .
				Ut::html((string) $config['wacko_version']) . ' → ' . Ut::html((string) MIN_VERSION) . '</br>' .
				MIN_VERSION . ' → ' . WACKO_VERSION . '</br></br>' .
				'<a href="https://wackowiki.org/doc/Dev/Release/R6.2/Upgrade">Upgrade notices for WackoWiki 6.2</a>' .
			"</li></ul>\n";
	}
	else
	{
		$config['is_update'] = '1';

		echo '<p>' .
			Ut::perc_replace(
				_t('UpgradeFromWacko'),
				'<code class="version">' . Ut::html((string) $config['wacko_version']) . '</code>',
				'<code class="version">' . WACKO_VERSION . '</code>'
			) .
			"</p>\n";
		echo '<p class="msg warning">' . _t('PleaseBackup') . "</p>\n";
	}
}
else
{
	$config['is_update'] = '0';

	echo '<p>' .
			Ut::perc_replace(
				_t('FreshInstall'),
				'<code class="version">' . WACKO_VERSION . '</code>'
			) .
		"</p>\n";
}

echo '<input type="hidden" value="' . Ut::html((string) $config['is_update']) . '" name="config[is_update]">';

echo '<p>' . _t('LangDesc') . "</p>\n";

$n = 1;

echo '<br><ul class="checkbox_input column-4">' . "\n";

// available languages
$language_array = _t('LanguageArray');
$language_array = is_array($language_array) ? $language_array : [];

foreach ($language_array as $key => $value)
{
	echo "\t<li>\n\t\t";
	echo '<input type="radio" id="lang_' . Ut::html((string) $key) . '" name="config[language]" value="' . Ut::html((string) $key) . '"';

	// default or selected language
	if (   (isset($_POST['config']['language']) && $_POST['config']['language'] == $key)
		|| $config['language'] == $key
	)
	{
		echo ' checked ';
	}

	echo ' data-submit-action="?installAction=lang"';
	echo ' class="input_lang"><label for="lang_' . Ut::html((string) $key) . '" class="label_lang">' . Ut::html((string) $value) . ' (' . Ut::html((string) $key) . ")</label>";
	echo "\n\t</li>\n";
}

echo "\n</ul>\n<br>\n";

if (isset($config['is_update']))
{
	echo '<button type="submit" class="next">' . _t('Continue') . "</button>\n";
}
?>
</form>
