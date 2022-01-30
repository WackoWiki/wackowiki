<?php

// config values
if (($config['db_driver'] == ('mysqli_legacy' || 'mysql_pdo')) && empty($config['db_port']))
{
	$config['db_port'] = '3306';
}

if ($config['db_collation'] == '0')
{
	$config['db_collation'] = 'utf8mb4_unicode_520_ci';
}

if (!$config['system_seed'])
{
	$config['system_seed'] = Ut::random_token(20, 3);
}

if (!$config['hashid_seed'])
{
	$config['hashid_seed'] = Ut::random_token(20, 3);
}

// set version to current version, yay!
$config['wacko_version'] = WACKO_VERSION;

$config_file = [];

///////////////////////////////////////////////////////////////////////////////////////////
//	BEGIN MANDATORY CONFIGURATION
///////////////////////////////////////////////////////////////////////////////////////////
$config_file['base_url']			= $config['base_url'];
// database connection
$config_file['db_charset']			= $config['db_charset'];
$config_file['db_collation']		= $config['db_collation'];
$config_file['db_driver']			= $config['db_driver'];
$config_file['db_engine']			= $config['db_engine'];
$config_file['db_host']				= $config['db_host'];
$config_file['db_port']				= $config['db_port'];
$config_file['db_name']				= $config['db_name'];
$config_file['db_user']				= $config['db_user'];
$config_file['db_password']			= $config['db_password'];
$config_file['sql_mode_strict']		= $config['sql_mode_strict'];
$config_file['table_prefix']		= $config['table_prefix'];
// security values
$config_file['system_seed']			= $config['system_seed'];
$config_file['recovery_password']	= $config['recovery_password'];
$config_file['hashid_seed']			= $config['hashid_seed'];
// version
$config_file['wacko_version']		= $config['wacko_version'];

///////////////////////////////////////////////////////////////////////////////////////////
//	END MANDATORY CONFIGURATION
///////////////////////////////////////////////////////////////////////////////////////////

// convert config array into PHP code
$fmt			= new IntlDateFormatter(
					$lang['LangLocale'],
					IntlDateFormatter::FULL,
					IntlDateFormatter::FULL,
					null,
					null,
					'EEEEEE dd MMM yyyy HH:mm:ss zzz');
$config_code	= '<?php' . "\n" .
				'// config.php ' . $lang['WrittenAt'] . $fmt->format(time()) . "\n" .
				'// ' . $lang['ConfigDescription'] . "\n" .
				'// ' . $lang['DontChange'] . "\n\n" .
				array_to_str($config_file);

// try to write configuration file
echo '<h2>' . $lang['FinalStep'] . '</h2>' . "\n";
echo '<ul>' . "\n";
echo	'<li>' . $lang['Writing'] . '   ';

$perm_changed	= true;
$file_name		= CONFIG_FILE;

if (is_writable($file_name))
{
	$write_file		= file_put_contents($file_name, $config_code);

	if ($write_file)
	{
		// Try and make it non-writable
		@chmod($file_name, CHMOD_SAFE);
		$perm_changed = !is_writable($file_name);

		echo output_image(true) . '</li>' . "\n";

		echo '<li>' . $lang['RemovingWritePrivilege'] . '   ' . output_image($perm_changed) . '</li>' . "\n";
	}
	else
	{
		// Problem saving file
		echo output_image(false) . '</li>' . "\n";
	}
}
else
{
	// Folder is non-writable
	$write_file = false;
	echo output_image(false) . '</li>' . "\n";
}

echo '</ul>' . "\n";

// purge old cache files
Ut::purge_directory(CACHE_PAGE_DIR);
Ut::purge_directory(CACHE_SQL_DIR);
Ut::purge_directory(CACHE_CONFIG_DIR);
Ut::purge_directory(CACHE_TEMPLATE_DIR);

echo '<h2>' . $lang['SecurityConsiderations'] . '</h2>' . "\n";
echo '<ul class="security">' . "\n";

if (!$perm_changed)
{
	echo
		'<li>' .
			Ut::perc_replace($lang['SecurityRisk'],
				'<code>' . CONFIG_FILE . '</code>',
				'<code>chmod ' . decoct(CHMOD_SAFE) . ' ' . CONFIG_FILE . '</code>') .
		'</li>' . "\n";
}

echo	'<li>' .
			Ut::perc_replace($lang['RemoveSetupDirectory'],
				'<code>setup/</code>') .
		'</li>' . "\n";

if (!$write_file)
{
	echo
		'<li>' .
			Ut::perc_replace($lang['ErrorGivePrivileges'],
				'<code>' . CONFIG_FILE . '</code>',
				'<code>touch ' . CONFIG_FILE . '</code><br><code>chmod 666 ' . CONFIG_FILE . '</code>',
				'<code>chmod ' . decoct(CHMOD_SAFE) . ' ' . CONFIG_FILE . '</code>') .
		'</li>' . "\n";
}

echo	'</ul>' . "\n";

// If there was a problem then show the "Try Again" button.
if ($write_file)
{
	echo
		'<h2>' . $lang['InstallationComplete'] . '</h2>' . "\n" .
		'<p>' . Ut::perc_replace($lang['ThatsAll'], $config['base_url']) . '</p>' . "\n";
}
else
{
	echo
		'<form action="' . my_location() . '?installAction=write-config" method="post">' . "\n";
			write_config_hidden_nodes($config_parameters) .
			'<button type="submit" class="next">' . $lang['TryAgain'] . '</button>' . "\n" .
		'</form>' . "\n" .

		'<div id="config_code" class="config_code"><pre>' .
			htmlentities($config_code, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET) .
		'</pre></div>' . "\n";
}
?>
<br>
