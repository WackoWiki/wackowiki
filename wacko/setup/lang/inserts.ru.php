<?php
$lng = "ru";

if ($config["language"] == $lng)
{
	InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**����� ���������� � ��������� ��� ((WackoWiki:Doc/Russian WackoWiki)).**\n\n������� \"������\" ����� ��������, ����� �������� � (����� ������, �� ������ ������ ��������� ������� ������ ������ -- ��� ������� � ���� �� ����������).\n\n������������ �� ~WackoWiki �������� �� WackoWiki:Doc/Russian.\n\n�������� ��������: ((WackoWiki:Doc/Russian/WackoSintaksis ��������������)), �������������������, ���������������, ((�����)), �����������, ������������.\n", $lng, "Admins", true);
	InsertPage('�������������������', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('���������������', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('�����������', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('������������', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('�������', '{{PageIndex}}', $lng);
InsertPage('���������', '{{RecentChanges}}', $lng);
InsertPage('������������', '{{LastUsers}}', $lng);
InsertPage('����������������', '{{RecentlyCommented}}', $lng);
InsertPage('�����������', '{{Registration}}', $lng);

InsertPage('Password', '{{ChangePassword}}', $lng);
InsertPage('������', '{{Redirect to=Password}}', $lng);
InsertPage('�����', '{{Search}}', $lng);
InsertPage('����', '{{Login}}', $lng);
InsertPage('InterWiki', '{{InterWikiList}}', $lng);
InsertPage('���������', '{{UserSettings}}', $lng);
?>