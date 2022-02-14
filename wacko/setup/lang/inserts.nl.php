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
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['Startpagina',			$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['Categorie',			'{{category}}',			false, false],
		$config['groups_page']			=> ['Groepen',				'{{groups}}',			false, false],
		$config['users_page']			=> ['Gebruikers',			'{{users}}',			false, false],

		# $config['help_page']			=> ['Hulp',					'',						false, false],
		# $config['terms_page']			=> ['Gebruiksvoorwaarden',	'',						false, false],
		# $config['privacy_page']		=> ['Privacybeleid',		'',						false, false],

		$config['registration_page']	=> ['Registratie',			'{{registration}}',		false, false],
		$config['password_page']		=> ['Paswoord',				'{{changepassword}}',	false, false],
		$config['search_page']			=> ['Zoeken',				'{{search}}',			false, false],
		$config['login_page']			=> ['Inloggen',				'{{login}}',			false, false],
		$config['account_page']			=> ['Instellingen',			'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['Laatste Wijzigingen',	'{{changes}}',			false, SET_MENU, 'Wijzigingen'],
		$config['comments_page']		=> ['Laatste Opmerkingen',	'{{commented}}',		false, SET_MENU, 'Opmerkingen'],
		$config['index_page']			=> ['Pagina Index',			'{{pageindex}}',		false, SET_MENU, 'Index'],
		$config['random_page']			=> ['Willekeurige pagina',	'{{randompage}}',		false, SET_MENU, 'Willekeurig'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Wijzigingen'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'Opmerkingen'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Index'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Willekeurig'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);