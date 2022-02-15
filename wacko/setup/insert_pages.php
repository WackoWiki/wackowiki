<?php

// Default Pages Inserts

// Inserting default pages
$error_inserting_pages = false;

function insert_pages($insert, $config)
{
	// insert these pages only for default language
	if ($config['language'] == $insert['lang'])
	{
		if (!$config['is_update'])
		{
			$home_page_body		= $insert['home_page_body'] . "\n\n";
			$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
			$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

			$critical_pages = [
				$config['root_page']		=> [$insert['root_page'],			$home_page_body,		true, false, null, 0],
				$admin_page					=> [$config['admin_name'],			$admin_page_body,		true, false, null, 0],
			];
		}

		$pages = [
			$config['category_page']		=> [$insert['category_page'],		'{{category}}',			false, false],
			$config['groups_page']			=> [$insert['groups_page'],			'{{groups}}',			false, false],
			$config['users_page']			=> [$insert['users_page'],			'{{users}}',			false, false],

			# $config['help_page']			=> [$insert['help_page'],			'',						false, false],
			# $config['terms_page']			=> [$insert['terms_page'],			'',						false, false],
			# $config['privacy_page']		=> [$insert['privacy_page'],		'',						false, false],

			$config['registration_page']	=> [$insert['registration_page'],	'{{registration}}',		false, false],
			$config['password_page']		=> [$insert['password_page'],		'{{changepassword}}',	false, false],
			$config['search_page']			=> [$insert['search_page'],			'{{search}}',			false, false],
			$config['login_page']			=> [$insert['login_page'],			'{{login}}',			false, false],
			$config['account_page']			=> [$insert['account_page'],		'{{usersettings}}',		false, false],

			$config['changes_page']			=> [$insert['changes_page'],		'{{changes}}',			false, SET_MENU, $insert['changes_page_bm']],
			$config['comments_page']		=> [$insert['comments_page'],		'{{commented}}',		false, SET_MENU, $insert['comments_page_bm']],
			$config['index_page']			=> [$insert['index_page'],			'{{pageindex}}',		false, SET_MENU, $insert['index_page_bm']],
			$config['random_page']			=> [$insert['random_page'],			'{{randompage}}',		false, SET_MENU, $insert['random_page_bm']],
		];
	}
	else
	{
		// set only bookmarks
		$pages = [
			$config['changes_page']			=> ['',		'',		false, SET_MENU_ONLY, $insert['changes_page_bm']],
			$config['comments_page']		=> ['',		'',		false, SET_MENU_ONLY, $insert['comments_page_bm']],
			$config['index_page']			=> ['',		'',		false, SET_MENU_ONLY, $insert['index_page_bm']],
			$config['random_page']			=> ['',		'',		false, SET_MENU_ONLY, $insert['random_page_bm']],
		];
	}

	if (!empty($critical_pages))
	{
		$pages = array_merge($critical_pages, $pages);
	}

	/**
	 * [key] $tag,
	 * [0] $title,
	 * [1] $body,
	 * [default] $page_lang,
	 * [default] $rights		= 'Admins',
	 * [2] $critical			= false,
	 * [3] $set_menu			= 0,
	 * [4] $menu_title			= false,
	 * [5] $noindex				= 1
	 */
	// insert pages
	foreach ($pages as $tag => $value)
	{
		insert_page(
			$tag,
			$value[0],
			$value[1],
			$insert['lang'],
			'Admins',
			$value[2],
			$value[3],
			$value[4],
			$value[5] ?? 1, // it won't accept null
		);
	}
}

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
	array_unshift($lang_list, $config['language']);

	foreach ($lang_list as $_lang)
	{
		unset($languages, $insert);
		$inserts_file = 'setup/lang/inserts.' . $_lang . '.php';

		if (@file_exists($inserts_file))
		{
			require_once $inserts_file;
			insert_pages($insert, $config);
		}
	}
}
else
{
	$inserts_file = 'setup/lang/inserts.' . $config['language'] . '.php';

	if (@file_exists($inserts_file))
	{
		require_once $inserts_file;
		insert_pages($insert, $config);
	}
}
