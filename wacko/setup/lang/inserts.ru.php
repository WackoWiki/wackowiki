<?php

$page_lang = 'ru';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$admin_page_body = sprintf($config['name_date_macro'], '((user:'.$config['admin_name'].' '.$config['admin_name'].'))', date($config['date_macro_format']));

		insert_page($config['root_page'], '', "file:wacko_logo.png\n**Добро пожаловать в волшебный мир ((WackoWiki:Doc/Russian WackoWiki)).**\n\nНажмите \"Правка\" внизу страницы, чтобы изменить её (между прочим, вы можете просто совершить двойной щелчок мышкой -- это приведёт к тому же результату).\n\nДокументация по ~WackoWiki доступна на WackoWiki:Doc/Russian.\n\nПолезные страницы: ((WackoWiki:Doc/Russian/WackoSintaksis Форматирование)), ((Поиск)).\n", $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], $admin_page_body."\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page('Category',		'Category',		'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page('Permalink',	'Permalink',	'{{permalinkproxy}}',	$page_lang, 'Admins', false, false);
	insert_page('Groups',		'Groups',		'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page('Users',		'Пользователи',	'{{users}}',			$page_lang, 'Admins', false, false);
}

insert_page('Каталог',			'Каталог',				'{{pageindex}}',				$page_lang, 'Admins', false, true, 'Каталог');
insert_page('Изменения',		'Изменения',			'{{changes}}',					$page_lang, 'Admins', false, true, 'Изменения');
insert_page('НовыеКомментарии',	'Новые Комментарии',	'{{commented}}',				$page_lang, 'Admins', false, true, 'Комментарии');

insert_page('Регистрация',		'Регистрация',			'{{registration}}',				$page_lang, 'Admins', false, false);
insert_page('Password',			'Password',				'{{changepassword}}',			$page_lang, 'Admins', false, false);
insert_page('Пароль',			'Пароль',				'{{redirect to="Password"}}',	$page_lang, 'Admins', false, false);
insert_page('Поиск',			'Поиск',				'{{search}}',					$page_lang, 'Admins', false, false);
insert_page('Вход',				'Вход',					'{{login}}',					$page_lang, 'Admins', false, false);
insert_page('Настройки',		'Настройки',			'{{usersettings}}',				$page_lang, 'Admins', false, false);

?>