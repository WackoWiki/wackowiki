<?php

$page_lang = 'hu';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png?right\n**Welcome to your ((WackoWiki:Doc/English WackoWiki)) site!**\n\nClick after you have ((Bejelentkezés logged in)) on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((Keresés)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Kezdőlap', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],		'Kategória',			'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'Csoportok',			'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'Felhasználók',			'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'Segítség',				'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'Terms',				'',						$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'Privacy',				'',						$page_lang, 'Admins', false, false);

	#insert_page($config['random_page'],		'Lap találomra',		'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, 'Random');

	insert_page($config['registration_page'],	'Fiók létrehozása',		'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Jelszó',				'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Keresés',				'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'Bejelentkezés',		'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Beállítások',			'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'Friss változtatások',	'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, 'Változtatások');
	insert_page($config['comments_page'],		'Utolsó megjegyzések',	'{{commented}}',		$page_lang, 'Admins', false, SET_MENU, 'Megjegyzések');
	insert_page($config['index_page'],			'Oldal Index',			'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, 'Index');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Változtatások');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Megjegyzések');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Index');

	#insert_page($config['random_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Random');

}

