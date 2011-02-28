<?php

$lng = "bg";

// insert these pages only for default language
if ($config['language'] == $lng)
{
	if ($config['is_update'] = false)
	{
		insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**����� ����� ��� ��������� ���� �� ((WackoWiki:Doc/English/WackoWiki WackoWiki)).**\n\n�������� �� ����� ����, �� �� ����������� ���� �������� (����� ���� � ���� � ������ ������� �� ������� ������ �� ����������).\n\n������������ (�� ���������) ��� �� WackoWiki:Doc/Bulgarian.\n\n������� ����: ((WackoWiki:Doc/English/Formatting Formatting)), TextSearch.\n\n", $lng, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "{{adminupdate}}\n\n", $lng, $config['admin_name'], true, false);
	}

	#insert_page('������������������', '���������� ��������', '{{wanted}}', $lng, 'Admins', true, false);
	#insert_page('�����������������', '��������� ��������', '{{orphaned}}', $lng, 'Admins', true, false);
	#insert_page('�����������', '��� ��������', '{{MyPages}}', $lng, 'Admins', true, false);
	#insert_page('����������', '��� �������', '{{MyChanges}}', $lng, 'Admins', true, false);

	insert_page('Category', 'Category', '{{category}}', $lng, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lng, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{usergroups}}', $lng, 'Admins', false, false);
	insert_page('Users', 'Users', '{{users}}', $lng, 'Admins', false, false);
}

insert_page('�������', '�������', '{{PageIndex}}', $lng, 'Admins', false, true, '�������');
insert_page('���������������', '�������� �������', '{{changes}}', $lng, 'Admins', false, true, '�������');
insert_page('�������������', '���� ���������', '{{commented}}', $lng, 'Admins', false, true, '���������');

insert_page('�����������', '�����������', '{{registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('TextSearch', 'Text Search', '{{search}}', $lng, 'Admins', false, false);
insert_page('Login', 'Login', '{{login}}', $lng, 'Admins', false, false);
insert_page('Settings', 'Settings', '{{UserSettings}}', $lng, 'Admins', false, false);

?>