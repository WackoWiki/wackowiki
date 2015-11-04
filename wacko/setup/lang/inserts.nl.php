<?php

$lang = 'nl';

// insert these pages only for default language
if ($config['language'] == $lang)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Welcome to your ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nClick on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((Zoeken)).\n\n", $lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page('Category', 'Category', '{{category}}', $lang, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lang, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lang, 'Admins', false, false);
	insert_page('Users', 'Gebruikers', '{{users}}', $lang, 'Admins', false, false);
}

insert_page('PaginaIndex', 'Pagina Index', '{{pageindex}}', $lang, 'Admins', false, true, 'Index');
insert_page('LaatsteWijzigingen', 'Laatste Wijzigingen', '{{changes}}', $lang, 'Admins', false, true, 'Wijzigingen');
insert_page('LaatsteOpmerkingen', 'Laatste Opmerkingen', '{{commented}}', $lang, 'Admins', false, true, 'Opmerkingen');

insert_page('Registratie', 'Registratie', '{{registration}}', $lang, 'Admins', false, false);

insert_page('Paswoord', 'Paswoord', '{{changepassword}}', $lang, 'Admins', false, false);
insert_page('Zoeken', 'Zoeken', '{{search}}', $lang, 'Admins', false, false);
insert_page('Inloggen', 'Inloggen', '{{login}}', $lang, 'Admins', false, false);
insert_page('Instellingen', 'Instellingen', '{{usersettings}}', $lang, 'Admins', false, false);

?>