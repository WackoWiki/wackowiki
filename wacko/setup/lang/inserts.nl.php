<?php

$lng = "nl";

if ($config["language"] == $lng)
{
	InsertPage($config["root_page"], '', "((file:wacko4.png WackoWiki))\n**Welcome to your ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nClick on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), AlleenstaandePaginas, GewenstePaginas, TekstZoeken, MijnPaginas, MijnWijzigingen.\n\n", $lng, "Admins", true);
	InsertPage('GewenstePaginas', 'Gewenste Paginas', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('AlleenstaandePaginas', 'Alleenstaande Paginas', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MijnPaginas', 'Mijn Paginas', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MijnWijzigingen', 'Mijn Wijzigingen', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('PaginaIndex', 'Pagina Index', '{{PageIndex}}', $lng);
InsertPage('LaatsteWijzigingen', 'Laatste Wijzigingen', '{{RecentChanges}}', $lng);
InsertPage('Gebruikers', 'Gebruikers', '{{LastUsers}}', $lng);
InsertPage('LaatsteOpmerkingen', 'Laatste Opmerkingen', '{{RecentlyCommented}}', $lng);
InsertPage('Registratie', 'Registratie', '{{Registration}}', $lng);

InsertPage('Paswoord', 'Paswoord', '{{ChangePassword}}', $lng);
InsertPage('TekstZoeken', 'Tekst Zoeken', '{{Search}}', $lng);
InsertPage('Inloggen', 'Inloggen', '{{Login}}', $lng);
InsertPage('Instellingen', 'Instellingen', '{{UserSettings}}', $lng);

?>