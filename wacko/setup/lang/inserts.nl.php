<?php

$page_lang = 'nl';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png\n**Welcome to your ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nClick on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((Zoeken)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:'.$config['admin_name'].' '.$config['admin_name'].'))', date($config['date_macro_format']));

		insert_page($config['root_page'], 'Homepage', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], $admin_page_body."\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page('Category',		'Category',		'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page('Groups',		'Groups',		'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page('Users',		'Gebruikers',	'{{users}}',			$page_lang, 'Admins', false, false);
}

insert_page('PaginaIndex',			'Pagina Index',			'{{pageindex}}',		$page_lang, 'Admins', false, true, 'Index');
insert_page('LaatsteWijzigingen',	'Laatste Wijzigingen',	'{{changes}}',			$page_lang, 'Admins', false, true, 'Wijzigingen');
insert_page('LaatsteOpmerkingen',	'Laatste Opmerkingen',	'{{commented}}',		$page_lang, 'Admins', false, true, 'Opmerkingen');

insert_page('Registratie',			'Registratie',			'{{registration}}',		$page_lang, 'Admins', false, false);
insert_page('Paswoord',				'Paswoord',				'{{changepassword}}',	$page_lang, 'Admins', false, false);
insert_page('Zoeken',				'Zoeken',				'{{search}}',			$page_lang, 'Admins', false, false);
insert_page('Inloggen',				'Inloggen',				'{{login}}',			$page_lang, 'Admins', false, false);
insert_page('Instellingen',			'Instellingen',			'{{usersettings}}',		$page_lang, 'Admins', false, false);

?>