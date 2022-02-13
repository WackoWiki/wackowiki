<?php

$page_lang = 'ru';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Добро пожаловать в волшебный мир ((WackoWiki:Doc/Русский WackoWiki)).**' . "\n\n" .
			'Нажмите "Правка" внизу страницы, чтобы изменить её (между прочим, вы можете просто совершить двойной щелчок мышкой -- это приведёт к тому же результату).' . "\n\n" .
			'Документация по WackoWiki доступна на WackoWiki:Doc/Русский.' . "\n" .
			'Полезные страницы: ((WackoWiki:Doc/Русский/WackoСинтаксис Форматирование)), ((/Поиск Поиск)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['Стартовая страница',	$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['Категории',			'{{category}}',			false, false],
		$config['groups_page']			=> ['Группы',				'{{groups}}',			false, false],
		$config['users_page']			=> ['Пользователи',			'{{users}}',			false, false],

		# $config['help_page']			=> ['Справка',				'',						false, false],
		# $config['terms_page']			=> ['Условия использования',		'',				false, false],
		# $config['privacy_page']		=> ['Политика конфиденциальности',		'',			false, false],

		$config['registration_page']	=> ['Регистрация',			'{{registration}}',		false, false],
		$config['password_page']		=> ['Пароль',				'{{changepassword}}',	false, false],
		$config['search_page']			=> ['Поиск',				'{{search}}',			false, false],
		$config['login_page']			=> ['Вход',					'{{login}}',			false, false],
		$config['account_page']			=> ['Настройки',			'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['Изменения',			'{{changes}}',			false, SET_MENU, 'Изменения'],
		$config['comments_page']		=> ['Новые Комментарии',	'{{commented}}',		false, SET_MENU, 'Комментарии'],
		$config['index_page']			=> ['Каталог',				'{{pageindex}}',		false, SET_MENU, 'Каталог'],
		$config['random_page']			=> ['Случайная страница',	'{{randompage}}',		false, SET_MENU, 'Случайный'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Изменения'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'Комментарии'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Каталог'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Случайный'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);