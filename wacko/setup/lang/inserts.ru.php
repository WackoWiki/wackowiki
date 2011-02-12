<?php

$lng = "ru";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**����� ���������� � ��������� ��� ((WackoWiki:Doc/Russian WackoWiki)).**\n\n������� \"������\" ����� ��������, ����� �������� � (����� ������, �� ������ ������ ��������� ������� ������ ������ -- ��� ������� � ���� �� ����������).\n\n������������ �� ~WackoWiki �������� �� WackoWiki:Doc/Russian.\n\n�������� ��������: ((WackoWiki:Doc/Russian/WackoSintaksis ��������������)), �������������������, ���������������, ((�����)), �����������, ������������.\n", $lng, 'Admins', true, false);
	insert_page('�������������������', '����������� ��������', '{{wanted}}', $lng, 'Admins', true, false);
	insert_page('���������������', '������� ��������', '{{orphaned}}', $lng, 'Admins', true, false);
	insert_page('�����������', '��� ��������', '{{MyPages}}', $lng, 'Admins', true, false);
	insert_page('������������', '��� ���������', '{{MyChanges}}', $lng, 'Admins', true, false);
}

insert_page('�������', '�������', '{{PageIndex}}', $lng, 'Admins', false, true, '�������');
insert_page('���������', '���������', '{{changes}}', $lng, 'Admins', false, true, '���������');
insert_page('����������������', '����� �����������', '{{RecentlyCommented}}', $lng, 'Admins', false, true, '�����������');

insert_page('Users', '������������', '{{users}}', $lng, 'Admins', false, false);
insert_page('�����������', '�����������', '{{registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('������', '������', '{{Redirect to=Password}}', $lng, 'Admins', false, false);
insert_page('�����', '�����', '{{search}}', $lng, 'Admins', false, false);
insert_page('����', '����', '{{login}}', $lng, 'Admins', false, false);
insert_page('���������', '���������', '{{UserSettings}}', $lng, 'Admins', false, false);

insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lng, 'Admins', false, false);

?>