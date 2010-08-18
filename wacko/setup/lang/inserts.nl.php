<?php

$lng = "nl";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Welcome to your ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nClick on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), AlleenstaandePaginas, GewenstePaginas, TekstZoeken, MijnPaginas, MijnWijzigingen.\n\n", $lng, "Admins", true);
	insert_page('GewenstePaginas', 'Gewenste Paginas', '{{WantedPages}}', $lng, "Admins", true);
	insert_page('AlleenstaandePaginas', 'Alleenstaande Paginas', '{{OrphanedPages}}', $lng, "Admins", true);
	insert_page('MijnPaginas', 'Mijn Paginas', '{{MyPages}}', $lng, "Admins", true);
	insert_page('MijnWijzigingen', 'Mijn Wijzigingen', '{{MyChanges}}', $lng, "Admins", true);
}

insert_page('PaginaIndex', 'Pagina Index', '{{PageIndex}}', $lng);
insert_page('LaatsteWijzigingen', 'Laatste Wijzigingen', '{{RecentChanges}}', $lng);
insert_page('Gebruikers', 'Gebruikers', '{{LastUsers}}', $lng);
insert_page('LaatsteOpmerkingen', 'Laatste Opmerkingen', '{{RecentlyCommented}}', $lng);
insert_page('Registratie', 'Registratie', '{{Registration}}', $lng);

insert_page('Paswoord', 'Paswoord', '{{ChangePassword}}', $lng);
insert_page('TekstZoeken', 'Tekst Zoeken', '{{Search}}', $lng);
insert_page('Inloggen', 'Inloggen', '{{Login}}', $lng);
insert_page('Instellingen', 'Instellingen', '{{UserSettings}}', $lng);

?>