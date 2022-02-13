<?php

$page_lang = 'hu';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Üdvözöljük ((WackoWiki:Doc/English WackoWiki)) webhelyén!**' . "\n\n" .
			'A kezdéshez kattintson a ((/Bejelentkezés Bejelentkezés)) gombra az alján található "Szerkesztés" linkre.' . "\n\n" .
			'A dokumentáció a következő címen található WackoWiki:Doc/English.' . "\n" .
			'Hasznos oldalak: ((WackoWiki:Doc/English/Formatting Formatting)), ((/Keresés Keresés)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['Kezdőlap',				$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['Kategória',			'{{category}}',			false, false],
		$config['groups_page']			=> ['Csoportok',			'{{groups}}',			false, false],
		$config['users_page']			=> ['Felhasználók',			'{{users}}',			false, false],

		# $config['help_page']			=> ['Segítség',				'',						false, false],
		# $config['terms_page']			=> ['Általános Szerződési Feltételek',	'',			false, false],
		# $config['privacy_page']		=> ['Adatvédelem',			'',						false, false],

		$config['registration_page']	=> ['Fiók létrehozása',		'{{registration}}',		false, false],
		$config['password_page']		=> ['Jelszó',				'{{changepassword}}',	false, false],
		$config['search_page']			=> ['Keresés',				'{{search}}',			false, false],
		$config['login_page']			=> ['Bejelentkezés',		'{{login}}',			false, false],
		$config['account_page']			=> ['Beállítások',			'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['Friss változtatások',	'{{changes}}',			false, SET_MENU, 'Változtatások'],
		$config['comments_page']		=> ['Utolsó megjegyzések',	'{{commented}}',		false, SET_MENU, 'Megjegyzések'],
		$config['index_page']			=> ['Oldal Index',			'{{pageindex}}',		false, SET_MENU, 'Index'],
		$config['random_page']			=> ['Lap találomra',		'{{randompage}}',		false, SET_MENU, 'Véletlenszerű'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Változtatások'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'Megjegyzések'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Index'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Véletlenszerű'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);