<?php
$lng = "bg";

if ($config["language"]==$lng)
{
 InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Добре дошли във вълшебния свят на ((WackoWiki:WackoWiki WackoWiki)).**\n\nКликнете на линка долу, за да редактирате тази страница (става също и само с двойно кликане на мишката някъде на страницата).\n\nДокументация (на английски) има на WackoWiki:DocEnglish.\n\nПолезни неща: OrphanedPages, WantedPages, TextSearch, MyPages, MyChanges.\n\n", $lng);
 InsertPage('ПропуснатиСтраници', '{{WantedPages}}', $lng);
 InsertPage('ЗабравениСтраници', '{{OrphanedPages}}', $lng);
 InsertPage('МоиСтраници', '{{MyPages}}', $lng);
 InsertPage('МоиПромени', '{{MyChanges}}', $lng);
}

InsertPage('Каталог', '{{PageIndex}}', $lng);
InsertPage('ПоследниПромени', '{{RecentChanges}}', $lng);
InsertPage('Потребители', '{{LastUsers}}', $lng);
InsertPage('НовиКоментари', '{{RecentlyCommented}}', $lng);
InsertPage('Регистрация', '{{Registration}}', $lng);

InsertPage('Password', '{{ChangePassword}}', $lng);
InsertPage('TextSearch', '{{Search}}', $lng);
InsertPage('Login', '{{Login}}', $lng);
InsertPage('InterWiki', '{{InterWikiList}}', $lng);
InsertPage('Settings', '{{UserSettings}}', $lng);
?>