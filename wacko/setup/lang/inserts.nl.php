<?php

$lng = "nl";

// insert these pages only for default language
if ($config['language'] == $lng)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Welcome to your ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nClick on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((Zoeken)).\n\n", $lng, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lng, $config['admin_name'], true, false);
	}
	else
	{
		// ...
	}

	#insert_page('GewenstePaginas', 'Gewenste Paginas', '{{wanted}}', $lng, 'Admins', true, false);
	#insert_page('AlleenstaandePaginas', 'Alleenstaande Paginas', '{{orphaned}}', $lng, 'Admins', true, false);
	#insert_page('MijnPaginas', 'Mijn Paginas', '{{mypages}}', $lng, 'Admins', true, false);
	#insert_page('MijnWijzigingen', 'Mijn Wijzigingen', '{{mychanges}}', $lng, 'Admins', true, false);

	insert_page('Category', 'Category', '{{category}}', $lng, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lng, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lng, 'Admins', false, false);
	insert_page('Users', 'Gebruikers', '{{users}}', $lng, 'Admins', false, false);
}

insert_page('PaginaIndex', 'Pagina Index', '{{pageindex}}', $lng, 'Admins', false, true, 'Index');
insert_page('LaatsteWijzigingen', 'Laatste Wijzigingen', '{{changes}}', $lng, 'Admins', false, true, 'Wijzigingen');
insert_page('LaatsteOpmerkingen', 'Laatste Opmerkingen', '{{commented}}', $lng, 'Admins', false, true, 'Opmerkingen');

insert_page('Registratie', 'Registratie', '{{registration}}', $lng, 'Admins', false, false);

insert_page('Paswoord', 'Paswoord', '{{changepassword}}', $lng, 'Admins', false, false);
insert_page('Zoeken', 'Zoeken', '{{search}}', $lng, 'Admins', false, false);
insert_page('Inloggen', 'Inloggen', '{{login}}', $lng, 'Admins', false, false);
insert_page('Instellingen', 'Instellingen', '{{usersettings}}', $lng, 'Admins', false, false);

?>