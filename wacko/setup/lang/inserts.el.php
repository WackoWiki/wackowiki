<?php

$lang = 'el';

// insert these pages only for default language
if ($config['language'] == $lang)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Καλώς ήλθατε στο ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site σας!**\n\nΠατήστε στον σύνδεμο \"Επεξεργασία Σελίδας\" στο κάτω μέρος της σελίδας για να ξεκινήσετε.\n\nΗ τεκμηρίωση μπορεί να βρεθεί στο WackoWiki:Doc/English.\n\nΧρήσιμες Σελίδες: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).\n\n", $lang, 'Admins', true, false, null, 1);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lang, $config['admin_name'], true, false, null, 1);
	}
	else
	{
		// ...
	}

	insert_page('Category', 'Category', '{{category}}', $lang, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lang, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lang, 'Admins', false, false);
	insert_page('Users', 'Users', '{{users}}', $lang, 'Admins', false, false);
}

insert_page('RecentChanges', 'Recent Changes', '{{changes}}', $lang, 'Admins', false, true, 'Changes');
insert_page('RecentlyCommented', 'Recently Commented', '{{commented}}', $lang, 'Admins', false, true, 'Comments');
insert_page('PageIndex', 'Page Index', '{{pageindex}}', $lang, 'Admins', false, true, 'Index');

insert_page('Registration', 'Registration', '{{registration}}', $lang, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lang, 'Admins', false, false);
insert_page('Search', 'Search', '{{search}}', $lang, 'Admins', false, false);
insert_page('Login', 'Login', '{{login}}', $lang, 'Admins', false, false);
insert_page('Settings', 'Settings', '{{usersettings}}', $lang, 'Admins', false, false);

?>