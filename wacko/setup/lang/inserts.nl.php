<?php

$page_lang = 'nl';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png?right\n**Welcome to your ((WackoWiki:Doc/English WackoWiki)) site!**\n\nClick on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((Zoeken)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Startpagina', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],	'Categorie',	'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],		'Groepen',		'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],		'Gebruikers',	'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],		'Hulp',			'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],		'Gebruiksvoorwaarden',		'',			$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],	'Privacybeleid',		'',				$page_lang, 'Admins', false, false);

	#insert_page('WillekeurigePagina',		'Willekeurige pagina',	'{{randompage}}',		$page_lang, 'Admins', false, true, 'Willekeurig');
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