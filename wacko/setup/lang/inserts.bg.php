<?php

$lng = "bg";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**����� ����� ��� ��������� ���� �� ((WackoWiki:Doc/English/WackoWiki WackoWiki)).**\n\n�������� �� ����� ����, �� �� ����������� ���� �������� (����� ���� � ���� � ������ ������� �� ������� ������ �� ����������).\n\n������������ (�� ���������) ��� �� WackoWiki:Doc/Bulgarian.\n\n������� ����: ((WackoWiki:Doc/English/Formatting Formatting)), OrphanedPages, WantedPages, TextSearch, MyPages, MyChanges.\n\n", $lng, "Admins", true);
	insert_page('������������������', '���������� ��������', '{{WantedPages}}', $lng, "Admins", true);
	insert_page('�����������������', '��������� ��������', '{{OrphanedPages}}', $lng, "Admins", true);
	insert_page('�����������', '��� ��������', '{{MyPages}}', $lng, "Admins", true);
	insert_page('����������', '��� �������', '{{MyChanges}}', $lng, "Admins", true);
}

insert_page('�������', '�������', '{{PageIndex}}', $lng);
insert_page('���������������', '�������� �������', '{{RecentChanges}}', $lng);
insert_page('�����������', '�����������', '{{LastUsers}}', $lng);
insert_page('�������������', '���� ���������', '{{RecentlyCommented}}', $lng);
insert_page('�����������', '�����������', '{{Registration}}', $lng);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng);
insert_page('TextSearch', 'Text Search', '{{Search}}', $lng);
insert_page('Login', 'Login', '{{Login}}', $lng);
insert_page('Settings', 'Settings', '{{UserSettings}}', $lng);

?>