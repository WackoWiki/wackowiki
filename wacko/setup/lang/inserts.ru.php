<?php

$lng = "ru";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Добро пожаловать в волшебный мир ((WackoWiki:Doc/Russian WackoWiki)).**\n\nНажмите \"Правка\" внизу страницы, чтобы изменить её (между прочим, вы можете просто совершить двойной щелчок мышкой -- это приведёт к тому же результату).\n\nДокументация по ~WackoWiki доступна на WackoWiki:Doc/Russian.\n\nПолезные страницы: ((WackoWiki:Doc/Russian/WackoSintaksis Форматирование)), ПропущенныеСтраницы, ЗабытыеСтраницы, ((Поиск)), МоиСтраницы, МоиИзменения.\n", $lng, 'Admins', true, false);
	insert_page('ПропущенныеСтраницы', 'Пропущенные Страницы', '{{wanted}}', $lng, 'Admins', true, false);
	insert_page('ЗабытыеСтраницы', 'Забытые Страницы', '{{orphaned}}', $lng, 'Admins', true, false);
	insert_page('МоиСтраницы', 'Мои Страницы', '{{MyPages}}', $lng, 'Admins', true, false);
	insert_page('МоиИзменения', 'Мои Изменения', '{{MyChanges}}', $lng, 'Admins', true, false);
}

insert_page('Каталог', 'Каталог', '{{PageIndex}}', $lng, 'Admins', false, true, 'Каталог');
insert_page('Изменения', 'Изменения', '{{changes}}', $lng, 'Admins', false, true, 'Изменения');
insert_page('НовыеКомментарии', 'Новые Комментарии', '{{RecentlyCommented}}', $lng, 'Admins', false, true, 'Комментарии');

insert_page('Пользователи', 'Пользователи', '{{LastUsers}}', $lng, 'Admins', false, false);
insert_page('Регистрация', 'Регистрация', '{{Registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('Пароль', 'Пароль', '{{Redirect to=Password}}', $lng, 'Admins', false, false);
insert_page('Поиск', 'Поиск', '{{Search}}', $lng, 'Admins', false, false);
insert_page('Вход', 'Вход', '{{Login}}', $lng, 'Admins', false, false);
insert_page('Настройки', 'Настройки', '{{UserSettings}}', $lng, 'Admins', false, false);

?>