<?php
$lng = "el";

if ($config["language"] == $lng)
{
	InsertPage($config2["root_page"], "((file:wacko4.gif WackoWiki))\n**����� ������ ��� ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site ���!**\n\n������� ���� ������� \"����������� �������\" ��� ���� ����� ��� ������� ��� �� ����������.\n\n� ���������� ������ �� ������ ��� WackoWiki:Doc/English.\n\n�������� �������: OrphanedPages, WantedPages, TextSearch, MyPages, MyChanges.\n\n", $lng, "Admins", true);
	InsertPage('WantedPages', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('OrphanedPages', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MyPages', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MyChanges', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('RecentChanges', '{{RecentChanges}}', $lng);
InsertPage('RecentlyCommented', '{{RecentlyCommented}}', $lng);
InsertPage('PageIndex', '{{PageIndex}}', $lng);
InsertPage('Users', '{{LastUsers}}', $lng);
InsertPage('Registration', '{{Registration}}', $lng);

InsertPage('Password', '{{ChangePassword}}', $lng);
InsertPage('TextSearch', '{{Search}}', $lng);
InsertPage('Login', '{{Login}}', $lng);
InsertPage('Settings', '{{UserSettings}}', $lng);

InsertPage('InterWiki', '{{InterWikiList}}', $lng);
?>