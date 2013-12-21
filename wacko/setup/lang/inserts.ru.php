<?php

$lng = 'ru';

// insert these pages only for default language
if ($config['language'] == $lng)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Добро пожаловать в волшебный мир ((WackoWiki:Doc/Russian WackoWiki)).**\n\nНажмите \"Правка\" внизу страницы, чтобы изменить её (между прочим, вы можете просто совершить двойной щелчок мышкой -- это приведёт к тому же результату).\n\nДокументация по ~WackoWiki доступна на WackoWiki:Doc/Russian.\n\nПолезные страницы: ((WackoWiki:Doc/Russian/WackoSintaksis Форматирование)), ((Поиск)).\n", $lng, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lng, $config['admin_name'], true, false);
	}
	else
	{
		// ...
	}

	insert_page('Category', 'Category', '{{category}}', $lng, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lng, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lng, 'Admins', false, false);
	insert_page('Users', 'Пользователи', '{{users}}', $lng, 'Admins', false, false);
}

insert_page('Каталог', 'Каталог', '{{pageindex}}', $lng, 'Admins', false, true, 'Каталог');
insert_page('Изменения', 'Изменения', '{{changes}}', $lng, 'Admins', false, true, 'Изменения');
insert_page('НовыеКомментарии', 'Новые Комментарии', '{{commented}}', $lng, 'Admins', false, true, 'Комментарии');

insert_page('Регистрация', 'Регистрация', '{{registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lng, 'Admins', false, false);
insert_page('Пароль', 'Пароль', '{{Redirect to=Password}}', $lng, 'Admins', false, false);
insert_page('Поиск', 'Поиск', '{{search}}', $lng, 'Admins', false, false);
insert_page('Вход', 'Вход', '{{login}}', $lng, 'Admins', false, false);
insert_page('Настройки', 'Настройки', '{{usersettings}}', $lng, 'Admins', false, false);

?>