<?php

$lng = "ru";

if ($config['language'] == $lng)
{
	InsertPage($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Добро пожаловать в волшебный мир ((WackoWiki:Doc/Russian WackoWiki)).**\n\nНажмите \"Правка\" внизу страницы, чтобы изменить её (между прочим, вы можете просто совершить двойной щелчок мышкой -- это приведёт к тому же результату).\n\nДокументация по ~WackoWiki доступна на WackoWiki:Doc/Russian.\n\nПолезные страницы: ((WackoWiki:Doc/Russian/WackoSintaksis Форматирование)), ПропущенныеСтраницы, ЗабытыеСтраницы, ((Поиск)), МоиСтраницы, МоиИзменения.\n", $lng, "Admins", true);
	InsertPage('ПропущенныеСтраницы', 'Пропущенные Страницы', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('ЗабытыеСтраницы', 'Забытые Страницы', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('МоиСтраницы', 'Мои Страницы', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('МоиИзменения', 'Мои Изменения', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('Каталог', 'Каталог', '{{PageIndex}}', $lng);
InsertPage('Изменения', 'Изменения', '{{RecentChanges}}', $lng);
InsertPage('Пользователи', 'Пользователи', '{{LastUsers}}', $lng);
InsertPage('НовыеКомментарии', 'Новые Комментарии', '{{RecentlyCommented}}', $lng);
InsertPage('Регистрация', 'Регистрация', '{{Registration}}', $lng);

InsertPage('Password', 'Password', '{{ChangePassword}}', $lng);
InsertPage('Пароль', 'Пароль', '{{Redirect to=Password}}', $lng);
InsertPage('Поиск', 'Поиск', '{{Search}}', $lng);
InsertPage('Вход', 'Вход', '{{Login}}', $lng);
InsertPage('Настройки', 'Настройки', '{{UserSettings}}', $lng);

?>