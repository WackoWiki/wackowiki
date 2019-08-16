<?php

$page_lang = 'bg';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png?right\n**Добре дошли във вълшебния свят на ((WackoWiki:Doc/English WackoWiki)).**\n\nКликнете на линка долу, за да редактирате тази страница (става също и само с двойно кликане на мишката някъде на страницата).\n\nДокументация (на английски) има на WackoWiki:Doc/Bulgarian.\n\nПолезни неща: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], '', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],	'категория',		'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],		'Групи',			'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],		'Потребители',		'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],		'Помощ',			'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],		'Условия за ползване',			'',			$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],	'Поверителност',	'',						$page_lang, 'Admins', false, false);

	#insert_page('СлучайнаСтраница',		'Случайна страница',	'{{randompage}}',	$page_lang, 'Admins', false, true, 'Случаен');

	insert_page($config['registration_page'],	'Регистрация',		'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Password',			'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Търсене',			'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'влизане',			'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Settings',			'{{usersettings}}',		$page_lang, 'Admins', false, false);
}

insert_page('Каталог',			'Каталог',			'{{pageindex}}',		$page_lang, 'Admins', false, true, 'Каталог');
insert_page('ПоследниПромени',	'Последни Промени',	'{{changes}}',			$page_lang, 'Admins', false, true, 'Промени');
insert_page('НовиКоментари',	'Нови Коментари',	'{{commented}}',		$page_lang, 'Admins', false, true, 'Коментари');

?>