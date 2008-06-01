<?php
$lng = "nl";

if ($config["language"]==$lng)
{
 InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Welcome to your ((WackoWiki:WackoWiki WackoWiki)) site!**\n\nClick on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:DocEnglish.\n\nUseful pages: AlleenstaandePaginas, GewenstePaginas, TekstZoeken, MijnPaginas, MijnWijzigingen.\n\n", $lng);
 InsertPage('GewenstePaginas', '{{WantedPages}}', $lng);
 InsertPage('AlleenstaandePaginas', '{{OrphanedPages}}', $lng);
 InsertPage('MijnPaginas', '{{MyPages}}', $lng);
 InsertPage('MijnWijzigingen', '{{MyChanges}}', $lng);
}

InsertPage('PaginaIndex', '{{PageIndex}}', $lng);
InsertPage('LaatsteWijzigingen', '{{RecentChanges}}', $lng);
InsertPage('Gebruikers', '{{LastUsers}}', $lng);
InsertPage('LaatsteOpmerkingen', '{{RecentlyCommented}}', $lng);
InsertPage('Registratie', '{{Registration}}', $lng);

InsertPage('Password', '{{ChangePassword}}', $lng);
InsertPage('TekstZoeken', '{{Search}}', $lng);
InsertPage('Inloggen', '{{Login}}', $lng);
InsertPage('Instellingen', '{{UserSettings}}', $lng);

InsertPage('InterWiki', '{{InterWikiList}}', $lng);

?>