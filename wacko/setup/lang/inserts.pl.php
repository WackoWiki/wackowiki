<?php

$page_lang = 'pl';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Witaj na swojej stronie ((WackoWiki:Doc/English WackoWiki))!**' . "\n\n" .
			'Klinkij na link "Edytuj stronę" na dole by rozpocząć.' . "\n\n" .
			'Dokumentacja dostępna jest w WackoWiki:Doc/English.' . "\n" .
			'Przydatne strony: ((WackoWiki:Doc/English/Formatting Formatting)), ((/Szukaj Szukaj)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['Strona startowa',		$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['Kategoria',				'{{category}}',			false, false],
		$config['groups_page']			=> ['Grupy',					'{{groups}}',			false, false],
		$config['users_page']			=> ['Użytkownicy',				'{{users}}',			false, false],

		# $config['help_page']			=> ['Pomoc',					'',						false, false],
		# $config['terms_page']			=> ['Warunki użytkowania',		'',						false, false],
		# $config['privacy_page']		=> ['Polityka ochrony prywatności',		'',				false, false],

		$config['registration_page']	=> ['Rejestracja',				'{{registration}}',		false, false],
		$config['password_page']		=> ['Hasło',					'{{changepassword}}',	false, false],
		$config['search_page']			=> ['Szukaj',					'{{search}}',			false, false],
		$config['login_page']			=> ['Login',					'{{login}}',			false, false],
		$config['account_page']			=> ['Ustawienia',				'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['Ostatnie Zmiany',			'{{changes}}',			false, SET_MENU, 'Zmiany'],
		$config['comments_page']		=> ['Ostatnio Komentowane',		'{{commented}}',		false, SET_MENU, 'Komentowane'],
		$config['index_page']			=> ['Index Stron',				'{{pageindex}}',		false, SET_MENU, 'Index'],
		$config['random_page']			=> ['Losową strona',			'{{randompage}}',		false, SET_MENU, 'Losową'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Zmiany'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'Komentowane'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Index'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Losową'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);