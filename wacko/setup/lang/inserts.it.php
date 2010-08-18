<?php

$lng = "it";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Benvenuto sul tuo sito ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nPer cominciare clicca su \"Edita questa pagina\" nella pagina in basso.\n\nLa documentazione, in inglese, può essere trovata  in WackoWiki:Doc/English.\n\nPagine utili: ((WackoWiki:Doc/English/Formatting Formatting)), PagineOrfane, PagineRichieste, ((Ricerca)), MiePagine, MieModifiche.\n\n", $lng, "Admins", true);
	insert_page('PagineRichieste', 'Pagine Richieste', '{{WantedPages}}', $lng, "Admins", true);
	insert_page('PagineOrfane', 'Pagine Orfane', '{{OrphanedPages}}', $lng, "Admins", true);
	insert_page('MiePagine', 'Mie Pagine', '{{MyPages}}', $lng, "Admins", true);
	insert_page('MieModifiche', 'Mie Modifiche', '{{MyChanges}}', $lng, "Admins", true);
}

insert_page('UltimeModifiche', 'Ultime Modifiche', '{{RecentChanges}}', $lng);
insert_page('UltimiCommenti', 'Ultimi Commenti', '{{RecentlyCommented}}', $lng);
insert_page('IndicePagine', 'Indice Pagine', '{{PageIndex}}', $lng);
insert_page('Utenti', 'Utenti', '{{LastUsers}}', $lng);
insert_page('Registrazione', 'Registrazione', '{{Registration}}', $lng);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng);
insert_page('Ricerca', 'Ricerca', '{{Search}}', $lng);
insert_page('Connessione', 'Connessione', '{{Login}}', $lng);
insert_page('Preferenze', 'Preferenze', '{{UserSettings}}', $lng);

?>