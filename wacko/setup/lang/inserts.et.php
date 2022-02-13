<?php

$page_lang = 'et';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Tere tulemast oma ((WackoWiki:Doc/English WackoWiki)) saidile!**' . "\n\n" .
			'Pärast sisselogimist klõpsake allosas olevale lingile "Muuda lehte", et alustada.' . "\n\n" .
			'Dokumentatsioon on kättesaadav aadressil WackoWiki:Doc/English.' . "\n" .
			'Kasulikud leheküljed: ((WackoWiki:Doc/English/Formatting Formatting)), ((/Otsing Otsing)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['Koduleht',				$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['Kategooria',				'{{category}}',			false, false],
		$config['groups_page']			=> ['Grupid',					'{{groups}}',			false, false],
		$config['users_page']			=> ['Kasutajad',				'{{users}}',			false, false],

		# $config['help_page']			=> ['Abi',						'',						false, false],
		# $config['terms_page']			=> ['Terms',					'',						false, false],
		# $config['privacy_page']		=> ['Andmekaitse',				'',						false, false],

		$config['registration_page']	=> ['Registreerimine',			'{{registration}}',		false, false],
		$config['password_page']		=> ['Parool',					'{{changepassword}}',	false, false],
		$config['search_page']			=> ['Otsing',					'{{search}}',			false, false],
		$config['login_page']			=> ['Login',					'{{login}}',			false, false],
		$config['account_page']			=> ['Settings',					'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['Viimased Muudatused',		'{{changes}}',			false, SET_MENU, 'Muudatused'],
		$config['comments_page']		=> ['Viimati Kommenteeritud',	'{{commented}}',		false, SET_MENU, 'Kommenteeritud'],
		$config['index_page']			=> ['Sisu Kord',				'{{pageindex}}',		false, SET_MENU, 'Index'],
		$config['random_page']			=> ['Juhuslik lehekülg',		'{{randompage}}',		false, SET_MENU, 'Juhuslik'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Muudatused'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'Kommenteeritud'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Index'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Juhuslik'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);