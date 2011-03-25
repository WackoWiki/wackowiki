<?php

$lng = "bg";

// insert these pages only for default language
if ($config['language'] == $lng)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Добре дошли във вълшебния свят на ((WackoWiki:Doc/English/WackoWiki WackoWiki)).**\n\nКликнете на линка долу, за да редактирате тази страница (става също и само с двойно кликане на мишката някъде на страницата).\n\nДокументация (на английски) има на WackoWiki:Doc/Bulgarian.\n\nПолезни неща: ((WackoWiki:Doc/English/Formatting Formatting)), TextSearch.\n\n", $lng, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::+::\n\n", $lng, $config['admin_name'], true, false);
	}
	else
	{
		insert_page($config['users_page'].'/'.$config['admin_name'].'/MigrateDataToR50', 'Migrate Data to R5.0', "{{adminupdate}}\n\n", $lng, $config['admin_name'], true, false);
	}

	#insert_page('ПропуснатиСтраници', 'Пропуснати Страници', '{{wanted}}', $lng, 'Admins', true, false);
	#insert_page('ЗабравениСтраници', 'Забравени Страници', '{{orphaned}}', $lng, 'Admins', true, false);
	#insert_page('МоиСтраници', 'Мои Страници', '{{mypages}}', $lng, 'Admins', true, false);
	#insert_page('МоиПромени', 'Мои Промени', '{{mychanges}}', $lng, 'Admins', true, false);

	insert_page('Category', 'Category', '{{category}}', $lng, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lng, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{usergroups}}', $lng, 'Admins', false, false);
	insert_page('Users', 'Users', '{{users}}', $lng, 'Admins', false, false);
}

insert_page('Каталог', 'Каталог', '{{pageindex}}', $lng, 'Admins', false, true, 'Каталог');
insert_page('ПоследниПромени', 'Последни Промени', '{{changes}}', $lng, 'Admins', false, true, 'Промени');
insert_page('НовиКоментари', 'Нови Коментари', '{{commented}}', $lng, 'Admins', false, true, 'Коментари');

insert_page('Регистрация', 'Регистрация', '{{registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lng, 'Admins', false, false);
insert_page('TextSearch', 'Text Search', '{{search}}', $lng, 'Admins', false, false);
insert_page('Login', 'Login', '{{login}}', $lng, 'Admins', false, false);
insert_page('Settings', 'Settings', '{{usersettings}}', $lng, 'Admins', false, false);

?>