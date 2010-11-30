<?php

$lng = "bg";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**����� ����� ��� ��������� ���� �� ((WackoWiki:Doc/English/WackoWiki WackoWiki)).**\n\n�������� �� ����� ����, �� �� ����������� ���� �������� (����� ���� � ���� � ������ ������� �� ������� ������ �� ����������).\n\n������������ (�� ���������) ��� �� WackoWiki:Doc/Bulgarian.\n\n������� ����: ((WackoWiki:Doc/English/Formatting Formatting)), OrphanedPages, WantedPages, TextSearch, MyPages, MyChanges.\n\n", $lng, 'Admins', true, false);
	insert_page('������������������', '���������� ��������', '{{wanted}}', $lng, 'Admins', true, false);
	insert_page('�����������������', '��������� ��������', '{{orphaned}}', $lng, 'Admins', true, false);
	insert_page('�����������', '��� ��������', '{{MyPages}}', $lng, 'Admins', true, false);
	insert_page('����������', '��� �������', '{{MyChanges}}', $lng, 'Admins', true, false);
}

insert_page('�������', '�������', '{{PageIndex}}', $lng, 'Admins', false, true, '�������');
insert_page('���������������', '�������� �������', '{{changes}}', $lng, 'Admins', false, true, '�������');
insert_page('�������������', '���� ���������', '{{RecentlyCommented}}', $lng, 'Admins', false, true, '���������');

insert_page('�����������', '�����������', '{{LastUsers}}', $lng, 'Admins', false, false);
insert_page('�����������', '�����������', '{{Registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('TextSearch', 'Text Search', '{{Search}}', $lng, 'Admins', false, false);
insert_page('Login', 'Login', '{{Login}}', $lng, 'Admins', false, false);
insert_page('Settings', 'Settings', '{{UserSettings}}', $lng, 'Admins', false, false);

?>