<?php

$lng = 'it';

// insert these pages only for default language
if ($config['language'] == $lng)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Benvenuto sul tuo sito ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nPer cominciare clicca su \"Edita questa pagina\" nella pagina in basso.\n\nLa documentazione, in inglese, può essere trovata  in WackoWiki:Doc/English.\n\nPagine utili: ((WackoWiki:Doc/English/Formatting Formatting)), ((Ricerca)).\n\n", $lng, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lng, $config['admin_name'], true, false);
	}
	else
	{
		// ...
	}

	insert_page('Category', 'Category', '{{category}}', $lng, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lng, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lng, 'Admins', false, false);
	insert_page('Users', 'Utenti', '{{users}}', $lng, 'Admins', false, false);
}

insert_page('UltimeModifiche', 'Ultime Modifiche', '{{changes}}', $lng, 'Admins', false, true, 'Modifiche');
insert_page('UltimiCommenti', 'Ultimi Commenti', '{{commented}}', $lng, 'Admins', false, true, 'Commenti');
insert_page('IndicePagine', 'Indice Pagine', '{{pageindex}}', $lng, 'Admins', false, true, 'Indice');

insert_page('Registrazione', 'Registrazione', '{{registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lng, 'Admins', false, false);
insert_page('Ricerca', 'Ricerca', '{{search}}', $lng, 'Admins', false, false);
insert_page('Connessione', 'Connessione', '{{login}}', $lng, 'Admins', false, false);
insert_page('Preferenze', 'Preferenze', '{{usersettings}}', $lng, 'Admins', false, false);

?>