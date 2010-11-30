<?php

$lng = "nl";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Welcome to your ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nClick on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), AlleenstaandePaginas, GewenstePaginas, TekstZoeken, MijnPaginas, MijnWijzigingen.\n\n", $lng, 'Admins', true, false);
	insert_page('GewenstePaginas', 'Gewenste Paginas', '{{wanted}}', $lng, 'Admins', true, false);
	insert_page('AlleenstaandePaginas', 'Alleenstaande Paginas', '{{orphaned}}', $lng, 'Admins', true, false);
	insert_page('MijnPaginas', 'Mijn Paginas', '{{MyPages}}', $lng, 'Admins', true, false);
	insert_page('MijnWijzigingen', 'Mijn Wijzigingen', '{{MyChanges}}', $lng, 'Admins', true, false);
}

insert_page('PaginaIndex', 'Pagina Index', '{{PageIndex}}', $lng, 'Admins', false, true, 'Index');
insert_page('LaatsteWijzigingen', 'Laatste Wijzigingen', '{{changes}}', $lng, 'Admins', false, true, 'Wijzigingen');
insert_page('LaatsteOpmerkingen', 'Laatste Opmerkingen', '{{RecentlyCommented}}', $lng, 'Admins', false, true, 'Opmerkingen');

insert_page('Gebruikers', 'Gebruikers', '{{LastUsers}}', $lng, 'Admins', false, false);
insert_page('Registratie', 'Registratie', '{{Registration}}', $lng, 'Admins', false, false);

insert_page('Paswoord', 'Paswoord', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('TekstZoeken', 'Tekst Zoeken', '{{Search}}', $lng, 'Admins', false, false);
insert_page('Inloggen', 'Inloggen', '{{Login}}', $lng, 'Admins', false, false);
insert_page('Instellingen', 'Instellingen', '{{UserSettings}}', $lng, 'Admins', false, false);

?>