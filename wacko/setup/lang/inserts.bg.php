<?php

$lng = "bg";

// insert these pages only for default language
if ($config['language'] == $lng)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**����� ����� ��� ��������� ���� �� ((WackoWiki:Doc/English/WackoWiki WackoWiki)).**\n\n�������� �� ����� ����, �� �� ����������� ���� �������� (����� ���� � ���� � ������ ������� �� ������� ������ �� ����������).\n\n������������ (�� ���������) ��� �� WackoWiki:Doc/Bulgarian.\n\n������� ����: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).\n\n", $lng, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lng, $config['admin_name'], true, false);
	}
	else
	{
		insert_page($config['users_page'].'/'.$config['admin_name'].'/MigrateDataToR50', 'Migrate Data to R5.0', "{{adminupdate}}\n\n", $lng, $config['admin_name'], true, false);
	}

	#insert_page('������������������', '���������� ��������', '{{wanted}}', $lng, 'Admins', true, false);
	#insert_page('�����������������', '��������� ��������', '{{orphaned}}', $lng, 'Admins', true, false);
	#insert_page('�����������', '��� ��������', '{{mypages}}', $lng, 'Admins', true, false);
	#insert_page('����������', '��� �������', '{{mychanges}}', $lng, 'Admins', true, false);

	insert_page('Category', 'Category', '{{category}}', $lng, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lng, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lng, 'Admins', false, false);
	insert_page('Users', 'Users', '{{users}}', $lng, 'Admins', false, false);
}

insert_page('�������', '�������', '{{pageindex}}', $lng, 'Admins', false, true, '�������');
insert_page('���������������', '�������� �������', '{{changes}}', $lng, 'Admins', false, true, '�������');
insert_page('�������������', '���� ���������', '{{commented}}', $lng, 'Admins', false, true, '���������');

insert_page('�����������', '�����������', '{{registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lng, 'Admins', false, false);
insert_page('Search', 'Search', '{{search}}', $lng, 'Admins', false, false);
insert_page('Login', 'Login', '{{login}}', $lng, 'Admins', false, false);
insert_page('Settings', 'Settings', '{{usersettings}}', $lng, 'Admins', false, false);

?>