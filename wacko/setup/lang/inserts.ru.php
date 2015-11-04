<?php

$lang = 'ru';

// insert these pages only for default language
if ($config['language'] == $lang)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Добро пожаловать в волшебный мир ((WackoWiki:Doc/Russian WackoWiki)).**\n\nНажмите \"Правка\" внизу страницы, чтобы изменить её (между прочим, вы можете просто совершить двойной щелчок мышкой -- это приведёт к тому же результату).\n\nДокументация по ~WackoWiki доступна на WackoWiki:Doc/Russian.\n\nПолезные страницы: ((WackoWiki:Doc/Russian/WackoSintaksis Форматирование)), ((Поиск)).\n", $lang, 'Admins', true, false, null, 1);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lang, $config['admin_name'], true, false, null, 1);
	}
	else
	{
		// ...
	}

	insert_page('Category', 'Category', '{{category}}', $lang, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lang, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lang, 'Admins', false, false);
	insert_page('Users', 'Пользователи', '{{users}}', $lang, 'Admins', false, false);
}

insert_page('Каталог', 'Каталог', '{{pageindex}}', $lang, 'Admins', false, true, 'Каталог');
insert_page('Изменения', 'Изменения', '{{changes}}', $lang, 'Admins', false, true, 'Изменения');
insert_page('НовыеКомментарии', 'Новые Комментарии', '{{commented}}', $lang, 'Admins', false, true, 'Комментарии');

insert_page('Регистрация', 'Регистрация', '{{registration}}', $lang, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lang, 'Admins', false, false);
insert_page('Пароль', 'Пароль', '{{Redirect to=Password}}', $lang, 'Admins', false, false);
insert_page('Поиск', 'Поиск', '{{search}}', $lang, 'Admins', false, false);
insert_page('Вход', 'Вход', '{{login}}', $lang, 'Admins', false, false);
insert_page('Настройки', 'Настройки', '{{usersettings}}', $lang, 'Admins', false, false);

?>