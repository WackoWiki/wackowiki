<?php

$page_lang = 'bg';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png\n**Добре дошли във вълшебния свят на ((WackoWiki:Doc/English WackoWiki)).**\n\nКликнете на линка долу, за да редактирате тази страница (става също и само с двойно кликане на мишката някъде на страницата).\n\nДокументация (на английски) има на WackoWiki:Doc/Bulgarian.\n\nПолезни неща: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], '', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body."\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page('Category',		'Category',		'{{category}}', 		$page_lang, 'Admins', false, false);
	insert_page('Groups',		'Groups',		'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page('Users',		'Users',		'{{users}}',			$page_lang, 'Admins', false, false);
}

insert_page('Каталог',			'Каталог',			'{{pageindex}}',		$page_lang, 'Admins', false, true, 'Каталог');
insert_page('ПоследниПромени',	'Последни Промени',	'{{changes}}',			$page_lang, 'Admins', false, true, 'Промени');
insert_page('НовиКоментари',	'Нови Коментари',	'{{commented}}',		$page_lang, 'Admins', false, true, 'Коментари');

insert_page('Регистрация',		'Регистрация',		'{{registration}}',		$page_lang, 'Admins', false, false);
insert_page('Password',			'Password',			'{{changepassword}}',	$page_lang, 'Admins', false, false);
insert_page('Search',			'Search',			'{{search}}',			$page_lang, 'Admins', false, false);
insert_page('влизане',			'влизане',			'{{login}}',			$page_lang, 'Admins', false, false);
insert_page('Settings',			'Settings',			'{{usersettings}}',		$page_lang, 'Admins', false, false);

?>