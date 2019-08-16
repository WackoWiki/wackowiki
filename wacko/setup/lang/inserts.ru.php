<?php

$page_lang = 'ru';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png?right\n**Добро пожаловать в волшебный мир ((WackoWiki:Doc/Russian WackoWiki)).**\n\nНажмите \"Правка\" внизу страницы, чтобы изменить её (между прочим, вы можете просто совершить двойной щелчок мышкой -- это приведёт к тому же результату).\n\nДокументация по WackoWiki доступна на WackoWiki:Doc/Russian.\n\nПолезные страницы: ((WackoWiki:Doc/Russian/WackoSintaksis Форматирование)), ((Поиск)).\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Стартовая страница', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],	'Категории',		'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],		'Группы',			'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],		'Пользователи',		'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],		'Справка',			'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],		'Условия использования',		'',			$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],	'Политика конфиденциальности',		'',		$page_lang, 'Admins', false, false);

	#insert_page('СлучайнаяСтраница',		'Случайная страница',	'{{randompage}}',	$page_lang, 'Admins', false, true, 'Случайный');

	insert_page($config['registration_page'],		'Регистрация',			'{{registration}}',				$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],			'Пароль',				'{{changepassword}}',			$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],				'Поиск',				'{{search}}',					$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],				'Вход',					'{{login}}',					$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],			'Настройки',			'{{usersettings}}',				$page_lang, 'Admins', false, false);
}

insert_page('Каталог',			'Каталог',				'{{pageindex}}',				$page_lang, 'Admins', false, true, 'Каталог');
insert_page('Изменения',		'Изменения',			'{{changes}}',					$page_lang, 'Admins', false, true, 'Изменения');
insert_page('НовыеКомментарии',	'Новые Комментарии',	'{{commented}}',				$page_lang, 'Admins', false, true, 'Комментарии');

?>