<?php

$lang = 'bg';

// insert these pages only for default language
if ($config['language'] == $lang)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**����� ����� ��� ��������� ���� �� ((WackoWiki:Doc/English/WackoWiki WackoWiki)).**\n\n�������� �� ����� ����, �� �� ����������� ���� �������� (����� ���� � ���� � ������ ������� �� ������� ������ �� ����������).\n\n������������ (�� ���������) ��� �� WackoWiki:Doc/Bulgarian.\n\n������� ����: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).\n\n", $lang, 'Admins', true, false);
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

insert_page('�������', '�������', '{{pageindex}}', $lang, 'Admins', false, true, '�������');
insert_page('���������������', '�������� �������', '{{changes}}', $lang, 'Admins', false, true, '�������');
insert_page('�������������', '���� ���������', '{{commented}}', $lang, 'Admins', false, true, '���������');

insert_page('�����������', '�����������', '{{registration}}', $lang, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lang, 'Admins', false, false);
insert_page('Search', 'Search', '{{search}}', $lang, 'Admins', false, false);
insert_page('�������', '�������', '{{login}}', $lang, 'Admins', false, false);
insert_page('Settings', 'Settings', '{{usersettings}}', $lang, 'Admins', false, false);

?>