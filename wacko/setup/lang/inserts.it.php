<?php
$lng = "it";

if ($config["language"]==$lng)
{
 InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Benvenuto sul tuo sito ((WackoWiki:WackoWiki WackoWiki)) site!**\n\nPer cominciare clicca su \"Edita questa pagina\" nella pagina in basso.\n\nLa documentazione, in inglese, può essere trovata  in WackoWiki:DocEnglish.\n\nPagine utili: PagineOrfane, PagineRichieste, ((Ricerca)), MiePagine, MieModifiche.\n\n", $lng, "Admins", true);
 InsertPage('PagineRichieste', '{{WantedPages}}', $lng, "Admins", true);
 InsertPage('PagineOrfane', '{{OrphanedPages}}', $lng, "Admins", true);
 InsertPage('MiePagine', '{{MyPages}}', $lng, "Admins", true);
 InsertPage('MieModifiche', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('UltimeModifiche', '{{RecentChanges}}', $lng);
InsertPage('UltimiCommenti', '{{RecentlyCommented}}', $lng);
InsertPage('IndicePagine', '{{PageIndex}}', $lng);
InsertPage('Utenti', '{{LastUsers}}', $lng);
InsertPage('Registrazione', '{{Registration}}', $lng);

InsertPage('Password', '{{ChangePassword}}', $lng);
InsertPage('Ricerca', '{{Search}}', $lng);
InsertPage('Connessione', '{{Login}}', $lng);
InsertPage('Preferenze', '{{UserSettings}}', $lng);

InsertPage('InterWiki', '{{InterWikiList}}', $lng);

?>