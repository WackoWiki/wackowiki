<?php
$lng = "ru";

if ($config["language"]==$lng)
{
	InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Добро пожаловать в волшебный мир ((WackoWiki:Doc/English/WackoWiki WackoWiki)).**\n\nНажмите \"Правка\" внизу страницы, чтобы изменить её (между прочим, вы можете просто совершить двойной щелчок мышкой -- это приведёт к тому же результату).\n\nДокументация по WackoWiki доступна на WackoWiki:Wacko/Документация.\n\nПолезные страницы: ((WackoWiki:Doc/Russian/Sintaksis Форматирование)), ПропущенныеСтраницы, ЗабытыеСтраницы, TextSearch, МоиСтраницы, МоиИзменения.\n", $lng, "Admins", true);
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

InsertPage('Пароль', '{{ChangePassword}}', $lng);
InsertPage('Поиск', '{{Search}}', $lng);
InsertPage('Вход', '{{Login}}', $lng);
InsertPage('InterWiki', '{{InterWikiList}}', $lng);
InsertPage('Настройки', '{{UserSettings}}', $lng);
?>