<?php

$page_lang = 'pt';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:wacko_logo.png\n**Welcome to your ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nClick after you have ((login logged in)) on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:'.$config['admin_name'].' '.$config['admin_name'].'))', date($config['date_macro_format']));

		insert_page($config['root_page'], 'Home Page', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], $admin_page_body."\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page('Category',		'Category',		'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page('Groups',		'Groups',		'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page('Users',		'Users',		'{{users}}',			$page_lang, 'Admins', false, false);
}

insert_page('AlteraçõesRecentes',		'Alterações Recentes',		'{{changes}}',			$page_lang, 'Admins', false, true, 'Alterações');
insert_page('RecentementeComentadas',	'Recentemente Comentadas',	'{{commented}}',		$page_lang, 'Admins', false, true, 'Comentadas');
insert_page('ÍndicedePáginas',			'Índicede Páginas',			'{{pageindex}}',		$page_lang, 'Admins', false, true, 'Índicede');

insert_page('Registration',				'Registration',				'{{registration}}',		$page_lang, 'Admins', false, false);
insert_page('Password',					'Password',					'{{changepassword}}',	$page_lang, 'Admins', false, false);
insert_page('Search',					'Search',					'{{search}}',			$page_lang, 'Admins', false, false);
insert_page('Entrar',					'Entrar',					'{{login}}',			$page_lang, 'Admins', false, false);
insert_page('Settings',					'Settings',					'{{usersettings}}',		$page_lang, 'Admins', false, false);

?>