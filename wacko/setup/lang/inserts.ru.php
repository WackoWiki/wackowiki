<?php

$lng = "ru";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Добро пожаловать в волшебный мир ((WackoWiki:Doc/Russian WackoWiki)).**\n\nНажмите \"Правка\" внизу страницы, чтобы изменить её (между прочим, вы можете просто совершить двойной щелчок мышкой -- это приведёт к тому же результату).\n\nДокументация по ~WackoWiki доступна на WackoWiki:Doc/Russian.\n\nПолезные страницы: ((WackoWiki:Doc/Russian/WackoSintaksis Форматирование)), ПропущенныеСтраницы, ЗабытыеСтраницы, ((Поиск)), МоиСтраницы, МоиИзменения.\n", $lng, "Admins", true);
	insert_page('ПропущенныеСтраницы', 'Пропущенные Страницы', '{{WantedPages}}', $lng, "Admins", true);
	insert_page('ЗабытыеСтраницы', 'Забытые Страницы', '{{OrphanedPages}}', $lng, "Admins", true);
	insert_page('МоиСтраницы', 'Мои Страницы', '{{MyPages}}', $lng, "Admins", true);
	insert_page('МоиИзменения', 'Мои Изменения', '{{MyChanges}}', $lng, "Admins", true);
}

insert_page('Каталог', 'Каталог', '{{PageIndex}}', $lng);
insert_page('Изменения', 'Изменения', '{{RecentChanges}}', $lng);
insert_page('Пользователи', 'Пользователи', '{{LastUsers}}', $lng);
insert_page('НовыеКомментарии', 'Новые Комментарии', '{{RecentlyCommented}}', $lng);
insert_page('Регистрация', 'Регистрация', '{{Registration}}', $lng);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng);
insert_page('Пароль', 'Пароль', '{{Redirect to=Password}}', $lng);
insert_page('Поиск', 'Поиск', '{{Search}}', $lng);
insert_page('Вход', 'Вход', '{{Login}}', $lng);
insert_page('Настройки', 'Настройки', '{{UserSettings}}', $lng);

?>