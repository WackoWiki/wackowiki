<?php

$lng = "el";

// insert these pages only for default language
if ($config['language'] == $lng)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Καλώς ήλθατε στο ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site σας!**\n\nΠατήστε στον σύνδεμο \"Επεξεργασία Σελίδας\" στο κάτω μέρος της σελίδας για να ξεκινήσετε.\n\nΗ τεκμηρίωση μπορεί να βρεθεί στο WackoWiki:Doc/English.\n\nΧρήσιμες Σελίδες: ((WackoWiki:Doc/English/Formatting Formatting)), TextSearch.\n\n", $lng, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::+::\n\n", $lng, $config['admin_name'], true, false);
	}
	else
	{
		insert_page($config['users_page'].'/'.$config['admin_name'].'/MigrateDataToR50', 'Migrate Data to R5.0', "{{adminupdate}}\n\n", $lng, $config['admin_name'], true, false);
	}

	#insert_page('WantedPages', 'Wanted Pages', '{{wanted}}', $lng, 'Admins', true, false);
	#insert_page('OrphanedPages', 'Orphaned Pages', '{{orphaned}}', $lng, 'Admins', true, false);
	#insert_page('MyPages', 'My Pages', '{{mypages}}', $lng, 'Admins', true, false);
	#insert_page('MyChanges', 'My Changes', '{{mychanges}}', $lng, 'Admins', true, false);

	insert_page('Category', 'Category', '{{category}}', $lng, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lng, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{usergroups}}', $lng, 'Admins', false, false);
	insert_page('Users', 'Users', '{{users}}', $lng, 'Admins', false, false);
}

insert_page('RecentChanges', 'Recent Changes', '{{changes}}', $lng, 'Admins', false, true, 'Changes');
insert_page('RecentlyCommented', 'Recently Commented', '{{commented}}', $lng, 'Admins', false, true, 'Comments');
insert_page('PageIndex', 'Page Index', '{{pageindex}}', $lng, 'Admins', false, true, 'Index');

insert_page('Registration', 'Registration', '{{registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lng, 'Admins', false, false);
insert_page('TextSearch', 'Text Search', '{{search}}', $lng, 'Admins', false, false);
insert_page('Login', 'Login', '{{login}}', $lng, 'Admins', false, false);
insert_page('Settings', 'Settings', '{{usersettings}}', $lng, 'Admins', false, false);

?>