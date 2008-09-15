<?php
$lng = "bg";

if ($config["language"]==$lng)
{
	InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Добре дошли във вълшебния свят на ((WackoWiki:Doc/English/WackoWiki WackoWiki)).**\n\nКликнете на линка долу, за да редактирате тази страница (става също и само с двойно кликане на мишката някъде на страницата).\n\nДокументация (на английски) има на WackoWiki:Doc/English.\n\nПолезни неща: OrphanedPages, WantedPages, TextSearch, MyPages, MyChanges.\n\n", $lng, "Admins", true);
	InsertPage('ПропуснатиСтраници', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('ЗабравениСтраници', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('МоиСтраници', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('МоиПромени', '{{MyChanges}}', $lng, "Admins", true);
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