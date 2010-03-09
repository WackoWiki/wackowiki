<?php
$lng = "ru";

if ($config["language"] == $lng)
{
	InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Добро пожаловать в волшебный мир ((WackoWiki:Doc/Russian WackoWiki)).**\n\nНажмите \"Правка\" внизу страницы, чтобы изменить её (между прочим, вы можете просто совершить двойной щелчок мышкой -- это приведёт к тому же результату).\n\nДокументация по ~WackoWiki доступна на WackoWiki:Doc/Russian.\n\nПолезные страницы: ((WackoWiki:Doc/Russian/WackoSintaksis Форматирование)), ПропущенныеСтраницы, ЗабытыеСтраницы, ((Поиск)), МоиСтраницы, МоиИзменения.\n", $lng, "Admins", true);
	InsertPage('ПропущенныеСтраницы', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('ЗабытыеСтраницы', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('МоиСтраницы', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('МоиИзменения', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('Каталог', '{{PageIndex}}', $lng);
InsertPage('Изменения', '{{RecentChanges}}', $lng);
InsertPage('Пользователи', '{{LastUsers}}', $lng);
InsertPage('НовыеКомментарии', '{{RecentlyCommented}}', $lng);
InsertPage('Регистрация', '{{Registration}}', $lng);

InsertPage('Password', '{{ChangePassword}}', $lng);
InsertPage('Пароль', '{{Redirect to=Password}}', $lng);
InsertPage('Поиск', '{{Search}}', $lng);
InsertPage('Вход', '{{Login}}', $lng);
InsertPage('InterWiki', '{{InterWikiList}}', $lng);
InsertPage('Настройки', '{{UserSettings}}', $lng);
?>