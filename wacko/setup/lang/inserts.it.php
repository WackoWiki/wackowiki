<?php

$lang = 'it';

// insert these pages only for default language
if ($config['language'] == $lang)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Benvenuto sul tuo sito ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nPer cominciare clicca su \"Edita questa pagina\" nella pagina in basso.\n\nLa documentazione, in inglese, può essere trovata  in WackoWiki:Doc/English.\n\nPagine utili: ((WackoWiki:Doc/English/Formatting Formatting)), ((Ricerca)).\n\n", $lang, 'Admins', true, false, null, 1);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lang, $config['admin_name'], true, false, null, 1);
	}
	else
	{
		// ...
	}

	insert_page('Category', 'Category', '{{category}}', $lang, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lang, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lang, 'Admins', false, false);
	insert_page('Users', 'Utenti', '{{users}}', $lang, 'Admins', false, false);
}

insert_page('UltimeModifiche', 'Ultime Modifiche', '{{changes}}', $lang, 'Admins', false, true, 'Modifiche');
insert_page('UltimiCommenti', 'Ultimi Commenti', '{{commented}}', $lang, 'Admins', false, true, 'Commenti');
insert_page('IndicePagine', 'Indice Pagine', '{{pageindex}}', $lang, 'Admins', false, true, 'Indice');

insert_page('Registrazione', 'Registrazione', '{{registration}}', $lang, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lang, 'Admins', false, false);
insert_page('Ricerca', 'Ricerca', '{{search}}', $lang, 'Admins', false, false);
insert_page('Connessione', 'Connessione', '{{login}}', $lang, 'Admins', false, false);
insert_page('Preferenze', 'Preferenze', '{{usersettings}}', $lang, 'Admins', false, false);

?>