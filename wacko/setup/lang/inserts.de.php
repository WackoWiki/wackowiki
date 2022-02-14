<?php

$page_lang = 'de';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Willkommen zu Deiner ((WackoWiki:Doc/Deutsch WackoWiki)) Installation!**' . "\n\n" .
			'Klicke nach der ((/Anmeldung Anmeldung)) unten auf den Punkt "Editieren" um zu beginnen.' . "\n\n" .
			'Die Dokumentation ist unter WackoWiki:Doc/Deutsch zu finden.' . "\n" .
			'Nützliche Seiten: ((WackoWiki:Doc/Deutsch/Formatierung Formatierung)), ((/Suche Suche)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['Startseite',			$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['Kategorie',			'{{category}}',			false, false],
		$config['groups_page']			=> ['Gruppen',				'{{groups}}',			false, false],
		$config['users_page']			=> ['Benutzer',				'{{users}}',			false, false],

		# $config['help_page'			=> ['Hilfe',				'',						false, false],
		# $config['terms_page'			=> ['Nutzungsbedingungen',	'',						false, false],
		# $config['privacy_page'		=> ['Datenschutzerklärung',	'',						false, false],

		$config['registration_page']	=> ['Registrierung',		'{{registration}}',		false, false],
		$config['password_page']		=> ['Passwort',				'{{changepassword}}',	false, false],
		$config['search_page']			=> ['Suche',				'{{search}}',			false, false],
		$config['login_page']			=> ['Anmeldung',			'{{login}}',			false, false],
		$config['account_page']			=> ['Einstellungen',		'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['Letzte Änderungen',	'{{changes}}',			false, SET_MENU, 'Änderungen'],
		$config['comments_page']		=> ['Letzte Kommentare',	'{{commented}}',		false, SET_MENU, 'Kommentare'],
		$config['index_page']			=> ['Seiten Index',			'{{pageindex}}',		false, SET_MENU, 'Index'],
		$config['random_page']			=> ['Zufällige Seite',		'{{randompage}}',		false, SET_MENU, 'Zufall'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Änderungen'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'Kommentare'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Index'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Zufall'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);
