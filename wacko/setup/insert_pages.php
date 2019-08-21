<?php

// Default Pages Inserts

// Needed (for some reason) to allow config variables to be accessed within insert_pages.
global $config_global, $dblink_global, $lang_global;
$config_global	= $config;
$dblink_global	= $dblink;
$lang_global	= $lang;

// Inserting default pages
$error_inserting_pages = false;

if (isset($config['multilanguage']) && $config['multilanguage'] == 1)
{
	if ($config['allowed_languages'])
	{
		$lang_list = explode(',', $config['allowed_languages']);

		// system language is mandatory
		if (!in_array($config['language'], $lang_list))
		{
			$lang_list[] = $config['language'];
		}
	}
	else
	{
		if ($handle = opendir('setup/lang'))
		{
			while (false !== ($file = readdir($handle)))
			{
				if (1 == preg_match('/^inserts\.(.*?)\.php$/', $file, $match))
				{
					$lang_list[] = $match[1];
				}
			}

			closedir($handle);
		}
	}

	foreach ($lang_list as $_lang)
	{
		unset($page_lang);
		unset($languages);
		$inserts_file = 'setup/lang/inserts.' . $_lang . '.php';

		if (@file_exists($inserts_file))
		{
			require_once $inserts_file;
		}
	}
}
else
{
	$inserts_file = 'setup/lang/inserts.' . $config['language'] . '.php';

	if (@file_exists($inserts_file))
	{
		require_once $inserts_file;
	}
}

?>