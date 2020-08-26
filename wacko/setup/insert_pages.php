<?php

// Default Pages Inserts

// Inserting default pages
$error_inserting_pages = false;

if (isset($config['multilanguage']) && $config['multilanguage'] == 1)
{
	if ($config['allowed_languages'])
	{
		$lang_list = explode(',', $config['allowed_languages']);
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

	$lang_list = array_diff($lang_list, [$config['language']]);

	// system language is mandatory and must be the first include
	array_unshift($lang_list , $config['language']);

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
