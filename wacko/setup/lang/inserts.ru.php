<?php
$lng = "ru";

if ($config["language"]==$lng)
{
 InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**����� ���������� � ��������� ��� ((WackoWiki:WackoWiki WackoWiki)).**\n\n������� \"������\" ����� ��������, ����� �������� � (����� ������, �� ������ ������ ��������� ������� ������ ������ - ��� ������� � ���� �� ����������).\n\n������������ �� ���� �������� �� WackoWiki:Wacko������������.\n\n�������� ��������: �������������������, ���������������, TextSearch, �����������, ������������.\n", $lng);
 InsertPage('�������������������', '{{WantedPages}}', $lng);
 InsertPage('���������������', '{{OrphanedPages}}', $lng);
 InsertPage('�����������', '{{MyPages}}', $lng);
 InsertPage('������������', '{{MyChanges}}', $lng);
}

InsertPage('�������', '{{PageIndex}}', $lng);
InsertPage('���������', '{{RecentChanges}}', $lng);
InsertPage('������������', '{{LastUsers}}', $lng);
InsertPage('����������������', '{{RecentlyCommented}}', $lng);
InsertPage('�����������', '{{Registration}}', $lng);

InsertPage('Password', '{{ChangePassword}}', $lng);
InsertPage('TextSearch', '{{Search}}', $lng);
InsertPage('Login', '{{Login}}', $lng);
InsertPage('InterWiki', '{{InterWikiList}}', $lng);
InsertPage('Settings', '{{UserSettings}}', $lng);
?>