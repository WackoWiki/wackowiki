<?php

$lng = "bg";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Добре дошли във вълшебния свят на ((WackoWiki:Doc/English/WackoWiki WackoWiki)).**\n\nКликнете на линка долу, за да редактирате тази страница (става също и само с двойно кликане на мишката някъде на страницата).\n\nДокументация (на английски) има на WackoWiki:Doc/Bulgarian.\n\nПолезни неща: ((WackoWiki:Doc/English/Formatting Formatting)), OrphanedPages, WantedPages, TextSearch, MyPages, MyChanges.\n\n", $lng, 'Admins', true, false);
	insert_page('ПропуснатиСтраници', 'Пропуснати Страници', '{{wanted}}', $lng, 'Admins', true, false);
	insert_page('ЗабравениСтраници', 'Забравени Страници', '{{orphaned}}', $lng, 'Admins', true, false);
	insert_page('МоиСтраници', 'Мои Страници', '{{MyPages}}', $lng, 'Admins', true, false);
	insert_page('МоиПромени', 'Мои Промени', '{{MyChanges}}', $lng, 'Admins', true, false);
}

insert_page('Каталог', 'Каталог', '{{PageIndex}}', $lng, 'Admins', false, true, 'Каталог');
insert_page('ПоследниПромени', 'Последни Промени', '{{changes}}', $lng, 'Admins', false, true, 'Промени');
insert_page('НовиКоментари', 'Нови Коментари', '{{RecentlyCommented}}', $lng, 'Admins', false, true, 'Коментари');

insert_page('Потребители', 'Потребители', '{{LastUsers}}', $lng, 'Admins', false, false);
insert_page('Регистрация', 'Регистрация', '{{Registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('TextSearch', 'Text Search', '{{Search}}', $lng, 'Admins', false, false);
insert_page('Login', 'Login', '{{Login}}', $lng, 'Admins', false, false);
insert_page('Settings', 'Settings', '{{UserSettings}}', $lng, 'Admins', false, false);

?>