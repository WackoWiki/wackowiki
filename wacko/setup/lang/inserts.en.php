<?php

$page_lang = 'en';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Welcome to your ((WackoWiki:Doc/English WackoWiki)) site!**' . "\n\n" .
			'Click after you have ((Login logged in)) on the "Edit this page" link at the bottom to get started.' . "\n\n" .
			'Documentation can be found at WackoWiki:Doc/English.' . "\n" .
			'Useful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).' . "\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Home Page', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}

	insert_page($config['category_page'],		'Category',				'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'Groups',				'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'Users',				'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'Help',					'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'Terms',				'',						$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'Privacy',				'',						$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'Registration',			'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Password',				'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Search',				'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'Login',				'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Settings',				'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'Recent Changes',		'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, 'Changes');
	insert_page($config['comments_page'],		'Recently Commented',	'{{commented}}',		$page_lang, 'Admins', false, SET_MENU, 'Comments');
	insert_page($config['index_page'],			'Page Index',			'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, 'Index');
	insert_page($config['random_page'],			'Random Page',			'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, 'Random');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Changes');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Comments');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Index');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Random');
}

