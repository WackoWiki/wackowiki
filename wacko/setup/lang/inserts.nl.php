<?php
$lng = "nl";

if ($config["language"]==$lng)
{
	InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Welcome to your ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nClick on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), AlleenstaandePaginas, GewenstePaginas, TekstZoeken, MijnPaginas, MijnWijzigingen.\n\n", $lng, "Admins", true);
	InsertPage('GewenstePaginas', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('AlleenstaandePaginas', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MijnPaginas', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MijnWijzigingen', '{{MyChanges}}', $lng, "Admins", true);
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