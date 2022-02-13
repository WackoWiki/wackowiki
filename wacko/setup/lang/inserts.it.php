<?php

$page_lang = 'it';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Benvenuto sul tuo sito ((WackoWiki:Doc/English WackoWiki)) site!**' . "\n\n" .
			'Per cominciare clicca su "Edita questa pagina" nella pagina in basso.' . "\n\n" .
			'La documentazione, in inglese, può essere trovata  in WackoWiki:Doc/English.' . "\n" .
			'Pagine utili: ((WackoWiki:Doc/English/Formatting Formatting)), ((/Ricerca Ricerca)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['Home Page',			$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['Categoria',			'{{category}}',			false, false],
		$config['groups_page']			=> ['Gruppi',				'{{groups}}',			false, false],
		$config['users_page']			=> ['Utenti',				'{{users}}',			false, false],

		# $config['help_page']			=> ['Aiuto',				'',						false, false],
		# $config['terms_page']			=> ['Condizioni di utilizzo',		'',				false, false],
		# $config['privacy_page']		=> ['Informativa sulla privacy',		'',			false, false],

		$config['registration_page']	=> ['Registrazione',		'{{registration}}',		false, false],
		$config['password_page']		=> ['Password',				'{{changepassword}}',	false, false],
		$config['search_page']			=> ['Ricerca',				'{{search}}',			false, false],
		$config['login_page']			=> ['Connessione',			'{{login}}',			false, false],
		$config['account_page']			=> ['Preferenze',			'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['Ultime Modifiche',		'{{changes}}',			false, SET_MENU, 'Modifiche'],
		$config['comments_page']		=> ['Ultimi Commenti',		'{{commented}}',		false, SET_MENU, 'Commenti'],
		$config['index_page']			=> ['Indice Pagine',		'{{pageindex}}',		false, SET_MENU, 'Indice'],
		$config['random_page']			=> ['Pagina a caso',		'{{randompage}}',		false, SET_MENU, 'Casuale'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Modifiche'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'Commenti'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Indice'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Casuale'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);