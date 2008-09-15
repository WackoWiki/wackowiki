<?php
$lng = "ru";

if ($config["language"]==$lng)
{
	InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Добро пожаловать в волшебный мир ((WackoWiki:Doc/English/WackoWiki WackoWiki)).**\n\nНажмите \"Правка\" внизу страницы, чтобы изменить её (между прочим, вы можете просто совершить двойной щелчок мышкой - это приведёт к тому же результату).\n\nДокументация по Ваке доступна на WackoWiki:Wacko/Документация.\n\nПолезные страницы: ПропущенныеСтраницы, ЗабытыеСтраницы, TextSearch, МоиСтраницы, МоиИзменения.\n", $lng, "Admins", true);
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
InsertPage('TextSearch', '{{Search}}', $lng);
InsertPage('Login', '{{Login}}', $lng);
InsertPage('InterWiki', '{{InterWikiList}}', $lng);
InsertPage('Настройки', '{{UserSettings}}', $lng);
?>