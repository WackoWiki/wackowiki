<?php

$lng = "it";

if ($config['language'] == $lng)
{
	InsertPage($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Benvenuto sul tuo sito ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nPer cominciare clicca su \"Edita questa pagina\" nella pagina in basso.\n\nLa documentazione, in inglese, può essere trovata  in WackoWiki:Doc/English.\n\nPagine utili: ((WackoWiki:Doc/English/Formatting Formatting)), PagineOrfane, PagineRichieste, ((Ricerca)), MiePagine, MieModifiche.\n\n", $lng, "Admins", true);
	InsertPage('PagineRichieste', 'Pagine Richieste', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('PagineOrfane', 'Pagine Orfane', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MiePagine', 'Mie Pagine', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MieModifiche', 'Mie Modifiche', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('UltimeModifiche', 'Ultime Modifiche', '{{RecentChanges}}', $lng);
InsertPage('UltimiCommenti', 'Ultimi Commenti', '{{RecentlyCommented}}', $lng);
InsertPage('IndicePagine', 'Indice Pagine', '{{PageIndex}}', $lng);
InsertPage('Utenti', 'Utenti', '{{LastUsers}}', $lng);
InsertPage('Registrazione', 'Registrazione', '{{Registration}}', $lng);

InsertPage('Password', 'Password', '{{ChangePassword}}', $lng);
InsertPage('Ricerca', 'Ricerca', '{{Search}}', $lng);
InsertPage('Connessione', 'Connessione', '{{Login}}', $lng);
InsertPage('Preferenze', 'Preferenze', '{{UserSettings}}', $lng);

?>