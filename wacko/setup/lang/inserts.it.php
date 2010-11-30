<?php

$lng = "it";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Benvenuto sul tuo sito ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nPer cominciare clicca su \"Edita questa pagina\" nella pagina in basso.\n\nLa documentazione, in inglese, può essere trovata  in WackoWiki:Doc/English.\n\nPagine utili: ((WackoWiki:Doc/English/Formatting Formatting)), PagineOrfane, PagineRichieste, ((Ricerca)), MiePagine, MieModifiche.\n\n", $lng, 'Admins', true, false);
	insert_page('PagineRichieste', 'Pagine Richieste', '{{wanted}}', $lng, 'Admins', true, false);
	insert_page('PagineOrfane', 'Pagine Orfane', '{{orphaned}}', $lng, 'Admins', true, false);
	insert_page('MiePagine', 'Mie Pagine', '{{MyPages}}', $lng, 'Admins', true, false);
	insert_page('MieModifiche', 'Mie Modifiche', '{{MyChanges}}', $lng, 'Admins', true, false);
}

insert_page('UltimeModifiche', 'Ultime Modifiche', '{{changes}}', $lng, 'Admins', false, true, 'Modifiche');
insert_page('UltimiCommenti', 'Ultimi Commenti', '{{RecentlyCommented}}', $lng, 'Admins', false, true, 'Commenti');
insert_page('IndicePagine', 'Indice Pagine', '{{PageIndex}}', $lng, 'Admins', false, true, 'Indice');

insert_page('Utenti', 'Utenti', '{{LastUsers}}', $lng, 'Admins', false, false);
insert_page('Registrazione', 'Registrazione', '{{Registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('Ricerca', 'Ricerca', '{{Search}}', $lng, 'Admins', false, false);
insert_page('Connessione', 'Connessione', '{{Login}}', $lng, 'Admins', false, false);
insert_page('Preferenze', 'Preferenze', '{{UserSettings}}', $lng, 'Admins', false, false);

?>