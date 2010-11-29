<?php

$lng = "el";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**����� ������ ��� ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site ���!**\n\n������� ���� ������� \"����������� �������\" ��� ���� ����� ��� ������� ��� �� ����������.\n\n� ���������� ������ �� ������ ��� WackoWiki:Doc/English.\n\n�������� �������: ((WackoWiki:Doc/English/Formatting Formatting)), OrphanedPages, WantedPages, TextSearch, MyPages, MyChanges.\n\n", $lng, 'Admins', true, false);
	insert_page('WantedPages', 'Wanted Pages', '{{wanted}}', $lng, 'Admins', true, false);
	insert_page('OrphanedPages', 'Orphaned Pages', '{{orphaned}}', $lng, 'Admins', true, false);
	insert_page('MyPages', 'My Pages', '{{MyPages}}', $lng, 'Admins', true, false);
	insert_page('MyChanges', 'My Changes', '{{MyChanges}}', $lng, 'Admins', true, false);
}

insert_page('RecentChanges', 'Recent Changes', '{{changes}}', $lng, 'Admins', false, true);
insert_page('RecentlyCommented', 'Recently Commented', '{{RecentlyCommented}}', $lng, 'Admins', false, true);
insert_page('PageIndex', 'Page Index', '{{PageIndex}}', $lng, 'Admins', false, true);

insert_page('Users', 'Users', '{{LastUsers}}', $lng, 'Admins', false, false);
insert_page('Registration', 'Registration', '{{Registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('TextSearch', 'Text Search', '{{Search}}', $lng, 'Admins', false, false);
insert_page('Login', 'Login', '{{Login}}', $lng, 'Admins', false, false);
insert_page('Settings', 'Settings', '{{UserSettings}}', $lng, 'Admins', false, false);

?>