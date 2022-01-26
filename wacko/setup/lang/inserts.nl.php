<?php

$page_lang = 'nl';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right\n**' .
			'Welkom op uw ((WackoWiki:Doc/English WackoWiki)) site!**' . "\n\n" .
			'Klik nadat je bent ingelogd op de "Bewerk deze pagina" link onderaan om te beginnen.' . "\n\n" .
			'Documentatie is te vinden op WackoWiki:Doc/English.' . "\n" .
			'Nuttige pagina\'s: ((WackoWiki:Doc/English/Formatting Formatting)), ((/Zoeken Zoeken)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))';

		insert_page($config['root_page'], 'Startpagina', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}

	insert_page($config['category_page'],		'Categorie',			'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'Groepen',				'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'Gebruikers',			'{{users}}',			$page_lang, 'Admins', false, false);

	# insert_page($config['help_page'],			'Hulp',					'',						$page_lang, 'Admins', false, false);
	# insert_page($config['terms_page'],			'Gebruiksvoorwaarden',	'',						$page_lang, 'Admins', false, false);
	# insert_page($config['privacy_page'],		'Privacybeleid',		'',						$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'Registratie',			'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Paswoord',				'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Zoeken',				'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'Inloggen',				'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Instellingen',			'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'Laatste Wijzigingen',	'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, 'Wijzigingen');
	insert_page($config['comments_page'],		'Laatste Opmerkingen',	'{{commented}}',		$page_lang, 'Admins', false, SET_MENU, 'Opmerkingen');
	insert_page($config['index_page'],			'Pagina Index',			'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, 'Index');
	insert_page($config['random_page'],			'Willekeurige pagina',	'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, 'Willekeurig');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Wijzigingen');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Opmerkingen');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Index');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Willekeurig');
}