<?php

$page_lang = 'el';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png\n**Καλώς ήλθατε στο ((WackoWiki:Doc/English WackoWiki)) site σας!**\n\nΠατήστε στον σύνδεμο \"Επεξεργασία Σελίδας\" στο κάτω μέρος της σελίδας για να ξεκινήσετε.\n\nΗ τεκμηρίωση μπορεί να βρεθεί στο WackoWiki:Doc/English.\n\nΧρήσιμες Σελίδες: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Αρχική σελίδα', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],	'Κατηγορία',	'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],		'Ομάδες',		'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],		'Χρήστες',		'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],		'Βοήθεια',				'',				$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],		'Όροι Χρήσης',			'',				$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],	'Πολιτική προσωπικών δεδομένων',	'',	$page_lang, 'Admins', false, false);

	#insert_page('RandomPage',				'Τυχαία σελίδα',	'{{randompage}}',	$page_lang, 'Admins', false, true, 'Τυχαία');
}

insert_page('RecentChanges',		'Recent Changes',		'{{changes}}',		$page_lang, 'Admins', false, true, 'Αλλαγές');
insert_page('RecentlyCommented',	'Recently Commented',	'{{commented}}',	$page_lang, 'Admins', false, true, 'Σχόλια');
insert_page('PageIndex',			'Page Index',			'{{pageindex}}',	$page_lang, 'Admins', false, true, 'Index');

insert_page('Registration',			'Registration',		'{{registration}}',		$page_lang, 'Admins', false, false);
insert_page('Password',				'Password',			'{{changepassword}}',	$page_lang, 'Admins', false, false);
insert_page('Search',				'Search',			'{{search}}',			$page_lang, 'Admins', false, false);
insert_page('Login',				'Login',			'{{login}}',			$page_lang, 'Admins', false, false);
insert_page('Settings',				'Settings',			'{{usersettings}}',		$page_lang, 'Admins', false, false);

?>