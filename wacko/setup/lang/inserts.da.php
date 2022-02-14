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
			'Særlige wikisider: ((WackoWiki:Doc/English/Formatting Formatting)), ((/Søgning Søgning)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['Startside',			$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['Kategori',				'{{category}}',			false, false],
		$config['groups_page']			=> ['Grupper',				'{{groups}}',			false, false],
		$config['users_page']			=> ['Brugere',				'{{users}}',			false, false],

		# $config['help_page']			=> ['Hjælp',				'',						false, false],
		# $config['terms_page']			=> ['Brugsbetingelser',		'',						false, false],
		# $config['privacy_page']		=> ['Privacy',				'',						false, false],

		$config['registration_page']	=> ['Registrering',			'{{registration}}',		false, false],
		$config['password_page']		=> ['Password',				'{{changepassword}}',	false, false],
		$config['search_page']			=> ['Søgning',				'{{search}}',			false, false],
		$config['login_page']			=> ['Login',				'{{login}}',			false, false],
		$config['account_page']			=> ['Indstillinger',		'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['Opdateringer',			'{{changes}}',			false, SET_MENU, 'Opdateringer'],
		$config['comments_page']		=> ['Kommentarer',			'{{commented}}',		false, SET_MENU, 'Kommentarer'],
		$config['index_page']			=> ['Indhold',				'{{pageindex}}',		false, SET_MENU, 'Indhold'],
		$config['random_page']			=> ['Tilfældig side',		'{{randompage}}',		false, SET_MENU, 'Tilfældig'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Opdateringer'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'Kommentarer'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Indhold'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Tilfældig'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);