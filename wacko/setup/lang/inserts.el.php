<?php

$page_lang = 'el';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Καλώς ήλθατε στο ((WackoWiki:Doc/English WackoWiki)) site σας!**' . "\n\n" .
			'Πατήστε στον σύνδεμο "Επεξεργασία Σελίδας" στο κάτω μέρος της σελίδας για να ξεκινήσετε.' . "\n\n" .
			'Η τεκμηρίωση μπορεί να βρεθεί στο WackoWiki:Doc/English.' . "\n" .
			'Χρήσιμες Σελίδες: ((WackoWiki:Doc/English/Formatting Formatting)), ((/Αναζήτηση Αναζήτηση)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['Αρχική σελίδα',		$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['Κατηγορία',			'{{category}}',			false, false],
		$config['groups_page']			=> ['Ομάδες',				'{{groups}}',			false, false],
		$config['users_page']			=> ['Χρήστες',				'{{users}}',			false, false],

		# $config['help_page']			=> ['Βοήθεια',				'',						false, false],
		# $config['terms_page']			=> ['Όροι Χρήσης',			'',						false, false],
		# $config['privacy_page']		=> ['Πολιτική προσωπικών δεδομένων',	'',			false, false],

		$config['registration_page']	=> ['Εγγραφή',				'{{registration}}',		false, false],
		$config['password_page']		=> ['Συνθηματικό',			'{{changepassword}}',	false, false],
		$config['search_page']			=> ['Αναζήτηση',			'{{search}}',			false, false],
		$config['login_page']			=> ['Σύνδεση',				'{{login}}',			false, false],
		$config['account_page']			=> ['Ρυθμίσεις',			'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['Πρόσφατες αλλαγές',	'{{changes}}',			false, SET_MENU, 'Αλλαγές'],
		$config['comments_page']		=> ['Πρόσφατα σχολιασμένες',	'{{commented}}',	false, SET_MENU, 'Σχόλια'],
		$config['index_page']			=> ['Ευρετήριο σελίδων',	'{{pageindex}}',		false, SET_MENU, 'Ευρετήριο'],
		$config['random_page']			=> ['Τυχαία σελίδα',		'{{randompage}}',		false, SET_MENU, 'Τυχαία'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Αλλαγές'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'Σχόλια'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Ευρετήριο'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Τυχαία'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);