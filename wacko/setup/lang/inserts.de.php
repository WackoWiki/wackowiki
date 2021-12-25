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
			'Klicke nach der ((Anmeldung)) unten auf den Punkt "Editieren" um zu beginnen.' . "\n\n" .
			'Die Dokumentation ist unter WackoWiki:Doc/Deutsch zu finden.' . "\n" .
			'Nützliche Seiten: ((WackoWiki:Doc/Deutsch/Formatierung Formatierung)), ((Suche)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))';

		insert_page($config['root_page'], 'Startseite', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}

	insert_page($config['category_page'],		'Kategorie',			'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'Gruppen',				'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'Benutzer',				'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'Hilfe',				'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'Nutzungsbedingungen',	'',						$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'Datenschutzerklärung',	'',						$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'Registrierung',		'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Passwort',				'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Suche',				'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'Anmeldung',			'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Einstellungen',		'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'Letzte Änderungen',	'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, 'Änderungen');
	insert_page($config['comments_page'],		'Letzte Kommentare',	'{{commented}}',		$page_lang, 'Admins', false, SET_MENU, 'Kommentare');
	insert_page($config['index_page'],			'Seiten Index',			'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, 'Index');
	insert_page($config['random_page'],			'Zufällige Seite',		'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, 'Zufall');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Änderungen');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Kommentare');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Index');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Zufall');
}