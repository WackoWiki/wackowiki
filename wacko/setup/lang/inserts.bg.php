<?php

$page_lang = 'bg';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Добре дошли във вълшебния свят на ((WackoWiki:Doc/English WackoWiki)).**' . "\n\n" .
			'Кликнете на линка долу, за да редактирате тази страница (става също и само с двойно кликане на мишката някъде на страницата).' . "\n\n" .
			'Документация (на английски) има на WackoWiki:Doc/English.' . "\n" .
			'Полезни неща: ((WackoWiki:Doc/English/Formatting Formatting)), ((/Търсене Търсене)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['Начална страница',		$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['Категория',			'{{category}}',			false, false],
		$config['groups_page']			=> ['Групи',				'{{groups}}',			false, false],
		$config['users_page']			=> ['Потребители',			'{{users}}',			false, false],

		# $config['help_page']			=> ['Помощ',				'',						false, false],
		# $config['terms_page']			=> ['Условия за ползване',	'',						false, false],
		# $config['privacy_page']		=> ['Поверителност',		'',						false, false],

		$config['registration_page']	=> ['Регистрация',			'{{registration}}',		false, false],
		$config['password_page']		=> ['Парола',				'{{changepassword}}',	false, false],
		$config['search_page']			=> ['Търсене',				'{{search}}',			false, false],
		$config['login_page']			=> ['Влизане',				'{{login}}',			false, false],
		$config['account_page']			=> ['Настройки',			'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['Последни Промени',		'{{changes}}',			false, SET_MENU, 'Промени'],
		$config['comments_page']		=> ['Нови Коментари',		'{{commented}}',		false, SET_MENU, 'Коментари'],
		$config['index_page']			=> ['Каталог',				'{{pageindex}}',		false, SET_MENU, 'Каталог'],
		$config['random_page']			=> ['Случайна страница',	'{{randompage}}',		false, SET_MENU, 'Случаен'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Промени'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'Коментари'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Каталог'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Случаен'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);
