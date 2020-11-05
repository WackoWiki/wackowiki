<?php

$page_lang = 'el';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png?right\n**Καλώς ήλθατε στο ((WackoWiki:Doc/English WackoWiki)) site σας!**\n\nΠατήστε στον σύνδεμο \"Επεξεργασία Σελίδας\" στο κάτω μέρος της σελίδας για να ξεκινήσετε.\n\nΗ τεκμηρίωση μπορεί να βρεθεί στο WackoWiki:Doc/English.\n\nΧρήσιμες Σελίδες: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Αρχική σελίδα', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],		'Κατηγορία',			'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'Ομάδες',				'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'Χρήστες',				'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'Βοήθεια',				'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'Όροι Χρήσης',			'',						$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'Πολιτική προσωπικών δεδομένων',	'',			$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'Εγγραφή',				'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Συνθηματικό',			'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Αναζήτηση',			'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'Σύνδεση',				'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Ρυθμίσεις',			'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'Πρόσφατες αλλαγές',	'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, 'Αλλαγές');
	insert_page($config['comments_page'],		'Πρόσφατα σχολιασμένες',	'{{commented}}',	$page_lang, 'Admins', false, SET_MENU, 'Σχόλια');
	insert_page($config['index_page'],			'Ευρετήριο σελίδων',	'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, 'Ευρετήριο');
	insert_page($config['random_page'],			'Τυχαία σελίδα',		'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, 'Τυχαία');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Αλλαγές');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Σχόλια');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Ευρετήριο');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Τυχαία');
}