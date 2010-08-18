<?php

$lng = "ru";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**����� ���������� � ��������� ��� ((WackoWiki:Doc/Russian WackoWiki)).**\n\n������� \"������\" ����� ��������, ����� �������� � (����� ������, �� ������ ������ ��������� ������� ������ ������ -- ��� ������� � ���� �� ����������).\n\n������������ �� ~WackoWiki �������� �� WackoWiki:Doc/Russian.\n\n�������� ��������: ((WackoWiki:Doc/Russian/WackoSintaksis ��������������)), �������������������, ���������������, ((�����)), �����������, ������������.\n", $lng, "Admins", true);
	insert_page('�������������������', '����������� ��������', '{{WantedPages}}', $lng, "Admins", true);
	insert_page('���������������', '������� ��������', '{{OrphanedPages}}', $lng, "Admins", true);
	insert_page('�����������', '��� ��������', '{{MyPages}}', $lng, "Admins", true);
	insert_page('������������', '��� ���������', '{{MyChanges}}', $lng, "Admins", true);
}

insert_page('�������', '�������', '{{PageIndex}}', $lng);
insert_page('���������', '���������', '{{RecentChanges}}', $lng);
insert_page('������������', '������������', '{{LastUsers}}', $lng);
insert_page('����������������', '����� �����������', '{{RecentlyCommented}}', $lng);
insert_page('�����������', '�����������', '{{Registration}}', $lng);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng);
insert_page('������', '������', '{{Redirect to=Password}}', $lng);
insert_page('�����', '�����', '{{Search}}', $lng);
insert_page('����', '����', '{{Login}}', $lng);
insert_page('���������', '���������', '{{UserSettings}}', $lng);

?>