<?php

$page_lang = 'pl';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png\n**Witaj na swojej stronie ((WackoWiki:Doc/English WackoWiki))!**\n\nKlinkij na link \"Edytuj stronê\" na dole by rozpocz±æ.\n\nDokumentacja dostêpna jest w WackoWiki:Doc/English.\n\nPrzydatne strony: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Strona startowa', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body."\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],	'Category',		'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],		'Groups',		'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],		'U¿ytkownicy',	'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['terms_page'],		'Terms',		'',			$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],	'Privacy',		'',			$page_lang, 'Admins', false, false);

	#insert_page('RandomPage',				'Random Page',	'{{randompage}}',		$page_lang, 'Admins', false, true, 'Random');
}

insert_page('OstatnieZmiany',		'Ostatnie Zmiany',			'{{changes}}',			$page_lang, 'Admins', false, true, 'Zmiany');
insert_page('OstatnioKomentowane',	'Ostatnio Komentowane',		'{{commented}}',		$page_lang, 'Admins', false, true, 'Komentowane');
insert_page('IndexStron',			'Index Stron',				'{{pageindex}}',		$page_lang, 'Admins', false, true, 'Index');

insert_page('Rejestracja',			'Rejestracja',				'{{registration}}',		$page_lang, 'Admins', false, false);
insert_page('Password',				'Password',					'{{changepassword}}',	$page_lang, 'Admins', false, false);
insert_page('Search',				'Poszukiwanie',				'{{search}}',			$page_lang, 'Admins', false, false);
insert_page('Login',				'Login',					'{{login}}',			$page_lang, 'Admins', false, false);
insert_page('Ustawienia',			'Ustawienia',				'{{usersettings}}',		$page_lang, 'Admins', false, false);

?>