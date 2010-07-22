<?php

$lng = "bg";

if ($config["language"] == $lng)
{
	InsertPage($config["root_page"], '', "((file:wacko4.png WackoWiki))\n**Добре дошли във вълшебния свят на ((WackoWiki:Doc/English/WackoWiki WackoWiki)).**\n\nКликнете на линка долу, за да редактирате тази страница (става също и само с двойно кликане на мишката някъде на страницата).\n\nДокументация (на английски) има на WackoWiki:Doc/Bulgarian.\n\nПолезни неща: ((WackoWiki:Doc/English/Formatting Formatting)), OrphanedPages, WantedPages, TextSearch, MyPages, MyChanges.\n\n", $lng, "Admins", true);
	InsertPage('ПропуснатиСтраници', 'Пропуснати Страници', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('ЗабравениСтраници', 'Забравени Страници', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('МоиСтраници', 'Мои Страници', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('МоиПромени', 'Мои Промени', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('Каталог', 'Каталог', '{{PageIndex}}', $lng);
InsertPage('ПоследниПромени', 'Последни Промени', '{{RecentChanges}}', $lng);
InsertPage('Потребители', 'Потребители', '{{LastUsers}}', $lng);
InsertPage('НовиКоментари', 'Нови Коментари', '{{RecentlyCommented}}', $lng);
InsertPage('Регистрация', 'Регистрация', '{{Registration}}', $lng);

InsertPage('Password', 'Password', '{{ChangePassword}}', $lng);
InsertPage('TextSearch', 'Text Search', '{{Search}}', $lng);
InsertPage('Login', 'Login', '{{Login}}', $lng);
InsertPage('Settings', 'Settings', '{{UserSettings}}', $lng);

?>