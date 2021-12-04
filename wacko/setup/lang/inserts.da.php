<?php

$page_lang = 'da';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Velkommen til din ((WackoWiki:Doc/English WackoWiki)) installation!**' . "\n\n" .
			'Klik på "Rediger siden" linket nederst for at rette denne side.' . "\n\n" .
			'Dokumentation finder du på WackoWiki:Doc/English.' . "\n" .
			'Særlige wikisider: ((WackoWiki:Doc/English/Formatting Formatting)), ((Søgning)).' . "\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Startside', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}

	insert_page($config['category_page'],		'Kategori',				'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'Grupper',				'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'Brugere',				'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'Hjælp',				'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'Brugsbetingelser',		'',						$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'Privacy',				'',						$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'Registrering',			'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Password',				'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Søgning',				'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'Login',				'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Indstillinger',		'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'Opdateringer',			'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, 'Opdateringer');
	insert_page($config['comments_page'],		'Kommentarer',			'{{commented}}',		$page_lang, 'Admins', false, SET_MENU, 'Kommentarer');
	insert_page($config['index_page'],			'Indhold',				'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, 'Indhold');
	insert_page($config['random_page'],			'Tilfældig side',		'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, 'Tilfældig');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Opdateringer');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Kommentarer');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Indhold');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Tilfældig');
}