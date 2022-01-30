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
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))';

		insert_page($config['root_page'], '', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}

	insert_page($config['category_page'],		'Категория',			'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'Групи',				'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'Потребители',			'{{users}}',			$page_lang, 'Admins', false, false);

	# insert_page($config['help_page'],			'Помощ',				'',						$page_lang, 'Admins', false, false);
	# insert_page($config['terms_page'],			'Условия за ползване',	'',						$page_lang, 'Admins', false, false);
	# insert_page($config['privacy_page'],		'Поверителност',		'',						$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'Регистрация',			'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Парола',				'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Търсене',				'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'Влизане',				'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Настройки',			'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'Последни Промени',		'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, 'Промени');
	insert_page($config['comments_page'],		'Нови Коментари',		'{{commented}}',		$page_lang, 'Admins', false, SET_MENU, 'Коментари');
	insert_page($config['index_page'],			'Каталог',				'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, 'Каталог');
	insert_page($config['random_page'],			'Случайна страница',	'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, 'Случаен');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Промени');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Коментари');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Каталог');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Случаен');
}
