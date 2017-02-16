<?php

$page_lang = 'bg';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png\n**����� ����� ��� ��������� ���� �� ((WackoWiki:Doc/English WackoWiki)).**\n\n�������� �� ����� ����, �� �� ����������� ���� �������� (����� ���� � ���� � ������ ������� �� ������� ������ �� ����������).\n\n������������ (�� ���������) ��� �� WackoWiki:Doc/Bulgarian.\n\n������� ����: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).\n\n";
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

insert_page('�������',			'�������',			'{{pageindex}}',		$page_lang, 'Admins', false, true, '�������');
insert_page('���������������',	'�������� �������',	'{{changes}}',			$page_lang, 'Admins', false, true, '�������');
insert_page('�������������',	'���� ���������',	'{{commented}}',		$page_lang, 'Admins', false, true, '���������');

insert_page('�����������',		'�����������',		'{{registration}}',		$page_lang, 'Admins', false, false);
insert_page('Password',			'Password',			'{{changepassword}}',	$page_lang, 'Admins', false, false);
insert_page('Search',			'Search',			'{{search}}',			$page_lang, 'Admins', false, false);
insert_page('�������',			'�������',			'{{login}}',			$page_lang, 'Admins', false, false);
insert_page('Settings',			'Settings',			'{{usersettings}}',		$page_lang, 'Admins', false, false);

?>