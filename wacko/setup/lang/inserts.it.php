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
			'Pagine utili: ((WackoWiki:Doc/English/Formatting Formatting)), ((Ricerca)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))';

		insert_page($config['root_page'], 'Home Page', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}

	insert_page($config['category_page'],		'Categoria',			'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'Gruppi',				'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'Utenti',				'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'Aiuto',				'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'Condizioni di utilizzo',		'',				$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'Informativa sulla privacy',		'',			$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'Registrazione',		'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Password',				'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Ricerca',				'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'Connessione',			'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Preferenze',			'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'Ultime Modifiche',		'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, 'Modifiche');
	insert_page($config['comments_page'],		'Ultimi Commenti',		'{{commented}}',		$page_lang, 'Admins', false, SET_MENU, 'Commenti');
	insert_page($config['index_page'],			'Indice Pagine',		'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, 'Indice');
	insert_page($config['random_page'],			'Pagina a caso',		'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, 'Casuale');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Modifiche');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Commenti');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Indice');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Casuale');
}