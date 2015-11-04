<?php

$lang = 'ru';

// insert these pages only for default language
if ($config['language'] == $lang)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**����� ���������� � ��������� ��� ((WackoWiki:Doc/Russian WackoWiki)).**\n\n������� \"������\" ����� ��������, ����� �������� � (����� ������, �� ������ ������ ��������� ������� ������ ������ -- ��� ������� � ���� �� ����������).\n\n������������ �� ~WackoWiki �������� �� WackoWiki:Doc/Russian.\n\n�������� ��������: ((WackoWiki:Doc/Russian/WackoSintaksis ��������������)), ((�����)).\n", $lang, 'Admins', true, false, null, 1);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lang, $config['admin_name'], true, false, null, 1);
	}
	else
	{
		// ...
	}

	insert_page('Category', 'Category', '{{category}}', $lang, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lang, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lang, 'Admins', false, false);
	insert_page('Users', '������������', '{{users}}', $lang, 'Admins', false, false);
}

insert_page('�������', '�������', '{{pageindex}}', $lang, 'Admins', false, true, '�������');
insert_page('���������', '���������', '{{changes}}', $lang, 'Admins', false, true, '���������');
insert_page('����������������', '����� �����������', '{{commented}}', $lang, 'Admins', false, true, '�����������');

insert_page('�����������', '�����������', '{{registration}}', $lang, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lang, 'Admins', false, false);
insert_page('������', '������', '{{Redirect to=Password}}', $lang, 'Admins', false, false);
insert_page('�����', '�����', '{{search}}', $lang, 'Admins', false, false);
insert_page('����', '����', '{{login}}', $lang, 'Admins', false, false);
insert_page('���������', '���������', '{{usersettings}}', $lang, 'Admins', false, false);

?>