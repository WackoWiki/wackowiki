<?php

$lng = 'ru';

// insert these pages only for default language
if ($config['language'] == $lng)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**����� ���������� � ��������� ��� ((WackoWiki:Doc/Russian WackoWiki)).**\n\n������� \"������\" ����� ��������, ����� �������� � (����� ������, �� ������ ������ ��������� ������� ������ ������ -- ��� ������� � ���� �� ����������).\n\n������������ �� ~WackoWiki �������� �� WackoWiki:Doc/Russian.\n\n�������� ��������: ((WackoWiki:Doc/Russian/WackoSintaksis ��������������)), ((�����)).\n", $lng, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lng, $config['admin_name'], true, false);
	}
	else
	{
		// ...
	}

	insert_page('Category', 'Category', '{{category}}', $lng, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lng, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lng, 'Admins', false, false);
	insert_page('Users', '������������', '{{users}}', $lng, 'Admins', false, false);
}

insert_page('�������', '�������', '{{pageindex}}', $lng, 'Admins', false, true, '�������');
insert_page('���������', '���������', '{{changes}}', $lng, 'Admins', false, true, '���������');
insert_page('����������������', '����� �����������', '{{commented}}', $lng, 'Admins', false, true, '�����������');

insert_page('�����������', '�����������', '{{registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lng, 'Admins', false, false);
insert_page('������', '������', '{{Redirect to=Password}}', $lng, 'Admins', false, false);
insert_page('�����', '�����', '{{search}}', $lng, 'Admins', false, false);
insert_page('����', '����', '{{login}}', $lng, 'Admins', false, false);
insert_page('���������', '���������', '{{usersettings}}', $lng, 'Admins', false, false);

?>