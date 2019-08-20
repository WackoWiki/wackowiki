<?php

$page_lang = 'pl';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png?right\n**Witaj na swojej stronie ((WackoWiki:Doc/English WackoWiki))!**\n\nKlinkij na link \"Edytuj stronę\" na dole by rozpocząć.\n\nDokumentacja dostępna jest w WackoWiki:Doc/English.\n\nPrzydatne strony: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Strona startowa', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],	'Kategoria',		'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],		'Grupy',		'{{groups}}',				$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],		'Użytkownicy',	'{{users}}',				$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],		'Pomoc',		'',							$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],		'Warunki użytkowania',		'',				$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],	'Polityka ochrony prywatności',		'',		$page_lang, 'Admins', false, false);

	#insert_page($config['random_page'],			'Losową strona',	'{{randompage}}',		$page_lang, 'Admins', false, true, 'Losową');

	insert_page($config['registration_page'],	'Rejestracja',				'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Hasło',					'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Szukaj',					'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'Login',					'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Ustawienia',				'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'Ostatnie Zmiany',			'{{changes}}',			$page_lang, 'Admins', false, true, 'Zmiany');
	insert_page($config['comments_page'],		'Ostatnio Komentowane',		'{{commented}}',		$page_lang, 'Admins', false, true, 'Komentowane');
	insert_page($config['index_page'],			'Index Stron',				'{{pageindex}}',		$page_lang, 'Admins', false, true, 'Index');
}
else
{
	// set only bookmarks
}

