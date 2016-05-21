<?php

$page_lang = 'it';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$admin_page_body = sprintf($config['name_date_macro'], '((user:'.$config['admin_name'].' '.$config['admin_name'].'))', date($config['date_macro_format']));

		insert_page($config['root_page'], '', "file:wacko_logo.png\n**Benvenuto sul tuo sito ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nPer cominciare clicca su \"Edita questa pagina\" nella pagina in basso.\n\nLa documentazione, in inglese, può essere trovata  in WackoWiki:Doc/English.\n\nPagine utili: ((WackoWiki:Doc/English/Formatting Formatting)), ((Ricerca)).\n\n", $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], $admin_page_body."\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page('Category',		'Category',		'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page('Permalink',	'Permalink',	'{{permalinkproxy}}',	$page_lang, 'Admins', false, false);
	insert_page('Groups',		'Groups',		'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page('Users',		'Utenti',		'{{users}}',			$page_lang, 'Admins', false, false);
}

insert_page('UltimeModifiche',		'Ultime Modifiche',		'{{changes}}',			$page_lang, 'Admins', false, true, 'Modifiche');
insert_page('UltimiCommenti',		'Ultimi Commenti',		'{{commented}}',		$page_lang, 'Admins', false, true, 'Commenti');
insert_page('IndicePagine',			'Indice Pagine',		'{{pageindex}}',		$page_lang, 'Admins', false, true, 'Indice');

insert_page('Registrazione',		'Registrazione',		'{{registration}}',		$page_lang, 'Admins', false, false);
insert_page('Password',				'Password',				'{{changepassword}}',	$page_lang, 'Admins', false, false);
insert_page('Ricerca',				'Ricerca',				'{{search}}',			$page_lang, 'Admins', false, false);
insert_page('Connessione',			'Connessione',			'{{login}}',			$page_lang, 'Admins', false, false);
insert_page('Preferenze',			'Preferenze',			'{{usersettings}}',		$page_lang, 'Admins', false, false);

?>