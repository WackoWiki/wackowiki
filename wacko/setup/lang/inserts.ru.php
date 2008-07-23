<?php
$lng = "ru";

if ($config["language"]==$lng)
{
 InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Добро пожаловать в волшебный мир ((WackoWiki:WackoWiki WackoWiki)).**\n\nНажмите \"Правка\" внизу страницы, чтобы изменить её (между прочим, вы можете просто совершить двойной щелчок мышкой - это приведёт к тому же результату).\n\nДокументация по Ваке доступна на WackoWiki:WackoДокументация.\n\nПолезные страницы: ПропущенныеСтраницы, ЗабытыеСтраницы, TextSearch, МоиСтраницы, МоиИзменения.\n", $lng);
 InsertPage('ПропущенныеСтраницы', '{{WantedPages}}', $lng);
 InsertPage('ЗабытыеСтраницы', '{{OrphanedPages}}', $lng);
 InsertPage('МоиСтраницы', '{{MyPages}}', $lng);
 InsertPage('МоиИзменения', '{{MyChanges}}', $lng);
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
InsertPage('Settings', '{{UserSettings}}', $lng);
?>