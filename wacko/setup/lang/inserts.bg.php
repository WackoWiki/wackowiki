<?php

$lang = 'bg';

// insert these pages only for default language
if ($config['language'] == $lang)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Добре дошли във вълшебния свят на ((WackoWiki:Doc/English/WackoWiki WackoWiki)).**\n\nКликнете на линка долу, за да редактирате тази страница (става също и само с двойно кликане на мишката някъде на страницата).\n\nДокументация (на английски) има на WackoWiki:Doc/Bulgarian.\n\nПолезни неща: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).\n\n", $lang, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lang, $config['admin_name'], true, false);
	}
	else
	{
		// ...
	}

	insert_page('Category', 'Category', '{{category}}', $lang, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lang, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lang, 'Admins', false, false);
	insert_page('Users', 'Users', '{{users}}', $lang, 'Admins', false, false);
}

insert_page('Каталог', 'Каталог', '{{pageindex}}', $lang, 'Admins', false, true, 'Каталог');
insert_page('ПоследниПромени', 'Последни Промени', '{{changes}}', $lang, 'Admins', false, true, 'Промени');
insert_page('НовиКоментари', 'Нови Коментари', '{{commented}}', $lang, 'Admins', false, true, 'Коментари');

insert_page('Регистрация', 'Регистрация', '{{registration}}', $lang, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lang, 'Admins', false, false);
insert_page('Search', 'Search', '{{search}}', $lang, 'Admins', false, false);
insert_page('влизане', 'влизане', '{{login}}', $lang, 'Admins', false, false);
insert_page('Settings', 'Settings', '{{usersettings}}', $lang, 'Admins', false, false);

?>