<?php

// Default Pages Inserts

// Needed (for some reason) to allow config variables to be accessed within insert_pages.
global $config_global, $dblink_global, $lang_global;
$config_global	= $config;
$dblink_global	= $dblink;
$lang_global	= $lang;

// TODO: mysqli / mysql pdo PDO: Add charset to the connection string, such as charset=utf8
// indicate what character set the client will use to send SQL statements to the server
switch($config_global['database_driver'])
{
	case 'mysqli_legacy':
		mysqli_set_charset($dblink, $config['database_charset']);
		break;
}

// Inserting default pages
$error_inserting_pages = false;

if ( isset($config['multilanguage']) && $config['multilanguage'] == 1)
{
	if ($config['allowed_languages'])
	{
		$lang_list = explode(',', $config['allowed_languages']);
	}
	else
	{
		$handle = opendir('setup/lang');

		while (false !== ($file = readdir($handle)))
		{
			if(1 == preg_match('/^inserts\.(.*?)\.php$/', $file, $match))
			{
				$lang_list[] = $match[1];
			}
		}

		closedir($handle);
	}

	foreach ($lang_list as $_lang)
	{
		unset($page_lang);
		unset($languages);
		require_once('setup/lang/inserts.'.$_lang.'.php');
	}
}
else
{
	require_once('setup/lang/inserts.'.$config['language'].'.php');
}

?>