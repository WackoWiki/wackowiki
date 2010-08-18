<?php

$lng = "bg";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Добре дошли във вълшебния свят на ((WackoWiki:Doc/English/WackoWiki WackoWiki)).**\n\nКликнете на линка долу, за да редактирате тази страница (става също и само с двойно кликане на мишката някъде на страницата).\n\nДокументация (на английски) има на WackoWiki:Doc/Bulgarian.\n\nПолезни неща: ((WackoWiki:Doc/English/Formatting Formatting)), OrphanedPages, WantedPages, TextSearch, MyPages, MyChanges.\n\n", $lng, "Admins", true);
	insert_page('ПропуснатиСтраници', 'Пропуснати Страници', '{{WantedPages}}', $lng, "Admins", true);
	insert_page('ЗабравениСтраници', 'Забравени Страници', '{{OrphanedPages}}', $lng, "Admins", true);
	insert_page('МоиСтраници', 'Мои Страници', '{{MyPages}}', $lng, "Admins", true);
	insert_page('МоиПромени', 'Мои Промени', '{{MyChanges}}', $lng, "Admins", true);
}

insert_page('Каталог', 'Каталог', '{{PageIndex}}', $lng);
insert_page('ПоследниПромени', 'Последни Промени', '{{RecentChanges}}', $lng);
insert_page('Потребители', 'Потребители', '{{LastUsers}}', $lng);
insert_page('НовиКоментари', 'Нови Коментари', '{{RecentlyCommented}}', $lng);
insert_page('Регистрация', 'Регистрация', '{{Registration}}', $lng);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng);
insert_page('TextSearch', 'Text Search', '{{Search}}', $lng);
insert_page('Login', 'Login', '{{Login}}', $lng);
insert_page('Settings', 'Settings', '{{UserSettings}}', $lng);

?>