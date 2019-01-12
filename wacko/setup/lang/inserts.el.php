<?php

$page_lang = 'el';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png\n**����� ������ ��� ((WackoWiki:Doc/English WackoWiki)) site ���!**\n\n������� ���� ������� \"����������� �������\" ��� ���� ����� ��� ������� ��� �� ����������.\n\n� ���������� ������ �� ������ ��� WackoWiki:Doc/English.\n\n�������� �������: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], '������ ������', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],	'���������',	'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],		'������',		'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],		'�������',		'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],		'�������',				'',				$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],		'���� ������',			'',				$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],	'�������� ���������� ���������',	'',	$page_lang, 'Admins', false, false);

	#insert_page('RandomPage',				'������ ������',	'{{randompage}}',	$page_lang, 'Admins', false, true, '������');
}

insert_page('RecentChanges',		'Recent Changes',		'{{changes}}',		$page_lang, 'Admins', false, true, '�������');
insert_page('RecentlyCommented',	'Recently Commented',	'{{commented}}',	$page_lang, 'Admins', false, true, '������');
insert_page('PageIndex',			'Page Index',			'{{pageindex}}',	$page_lang, 'Admins', false, true, 'Index');

insert_page('Registration',			'Registration',		'{{registration}}',		$page_lang, 'Admins', false, false);
insert_page('Password',				'Password',			'{{changepassword}}',	$page_lang, 'Admins', false, false);
insert_page('Search',				'Search',			'{{search}}',			$page_lang, 'Admins', false, false);
insert_page('Login',				'Login',			'{{login}}',			$page_lang, 'Admins', false, false);
insert_page('Settings',				'Settings',			'{{usersettings}}',		$page_lang, 'Admins', false, false);

?>