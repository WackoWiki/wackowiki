<?php

$page_lang = 'de';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png?right\n**Willkommen zu Deiner ((WackoWiki:Doc/Deutsch WackoWiki)) Installation!**\n\nKlicke nach der ((Anmeldung)) unten auf den Punkt \"Editieren\" um zu beginnen.\n\nDie Dokumentation ist unter WackoWiki:Doc/Deutsch zu finden.\n\nNützliche Seiten: ((WackoWiki:Doc/Deutsch/Formatierung Formatierung)), ((Suche)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Startseite', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],	'Kategorie',	'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],		'Gruppen',		'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],		'Benutzer',		'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],		'Hilfe',					'',			$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],		'Nutzungsbedingungen',		'',			$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],	'Datenschutzerklärung',		'',			$page_lang, 'Admins', false, false);

	#insert_page($config['random_page'],				'Zufällige Seite',	'{{randompage}}',		$page_lang, 'Admins', false, true, 'Zufall');

	insert_page($config['registration_page'],	'Registrierung',		'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Passwort',				'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Suche',				'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'Anmeldung',			'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Einstellungen',		'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'Letzte Änderungen',	'{{changes}}',			$page_lang, 'Admins', false, true, 'Änderungen');
	insert_page($config['comments_page'],		'Letzte Kommentare',	'{{commented}}',		$page_lang, 'Admins', false, true, 'Kommentare');
	insert_page($config['index_page'],			'Seiten Index',			'{{pageindex}}',		$page_lang, 'Admins', false, true, 'Index');
}
else
{
	// set only bookmarks
}

?>