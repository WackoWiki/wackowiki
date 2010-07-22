<?php

$lng = "el";

if ($config["language"] == $lng)
{
	InsertPage($config["root_page"], '', "((file:wacko4.png WackoWiki))\n**����� ������ ��� ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site ���!**\n\n������� ���� ������� \"����������� �������\" ��� ���� ����� ��� ������� ��� �� ����������.\n\n� ���������� ������ �� ������ ��� WackoWiki:Doc/English.\n\n�������� �������: ((WackoWiki:Doc/English/Formatting Formatting)), OrphanedPages, WantedPages, TextSearch, MyPages, MyChanges.\n\n", $lng, "Admins", true);
	InsertPage('WantedPages', 'Wanted Pages', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('OrphanedPages', 'Orphaned Pages', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MyPages', 'My Pages', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MyChanges', 'My Changes', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('RecentChanges', 'Recent Changes', '{{RecentChanges}}', $lng);
InsertPage('RecentlyCommented', 'Recently Commented', '{{RecentlyCommented}}', $lng);
InsertPage('PageIndex', 'Page Index', '{{PageIndex}}', $lng);
InsertPage('Users', 'Users', '{{LastUsers}}', $lng);
InsertPage('Registration', 'Registration', '{{Registration}}', $lng);

InsertPage('Password', 'Password', '{{ChangePassword}}', $lng);
InsertPage('TextSearch', 'Text Search', '{{Search}}', $lng);
InsertPage('Login', 'Login', '{{Login}}', $lng);
InsertPage('Settings', 'Settings', '{{UserSettings}}', $lng);

?>