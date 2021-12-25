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
			'Полезные страницы: ((WackoWiki:Doc/Русский/WackoСинтаксис Форматирование)), ((Поиск)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))';

		insert_page($config['root_page'], 'Стартовая страница', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}

	insert_page($config['category_page'],		'Категории',			'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'Группы',				'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'Пользователи',			'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'Справка',				'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'Условия использования',		'',				$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'Политика конфиденциальности',		'',			$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'Регистрация',			'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Пароль',				'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Поиск',				'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'Вход',					'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Настройки',			'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'Изменения',			'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, 'Изменения');
	insert_page($config['comments_page'],		'Новые Комментарии',	'{{commented}}',		$page_lang, 'Admins', false, SET_MENU, 'Комментарии');
	insert_page($config['index_page'],			'Каталог',				'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, 'Каталог');
	insert_page($config['random_page'],			'Случайная страница',	'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, 'Случайный');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Изменения');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Комментарии');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Каталог');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Случайный');
}