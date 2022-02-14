<?php

$page_lang = 'en';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Welcome to your ((WackoWiki:Doc/English WackoWiki)) site!**' . "\n\n" .
			'Click after you have ((/Login logged in)) on the "Edit this page" link at the bottom to get started.' . "\n\n" .
			'Documentation can be found at WackoWiki:Doc/English.' . "\n" .
			'Useful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((/Search Search)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['Home Page',			$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['Category',				'{{category}}',			false, false],
		$config['groups_page']			=> ['Groups',				'{{groups}}',			false, false],
		$config['users_page']			=> ['Users',				'{{users}}',			false, false],

		# $config['help_page']			=> ['Help',					'',						false, false],
		# $config['terms_page']			=> ['Terms of Use',			'',						false, false],
		# $config['privacy_page']		=> ['Privacy policy',		'',						false, false],

		$config['registration_page']	=> ['Registration',			'{{registration}}',		false, false],
		$config['password_page']		=> ['Password',				'{{changepassword}}',	false, false],
		$config['search_page']			=> ['Search',				'{{search}}',			false, false],
		$config['login_page']			=> ['Login',				'{{login}}',			false, false],
		$config['account_page']			=> ['Settings',				'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['Recent Changes',		'{{changes}}',			false, SET_MENU, 'Changes'],
		$config['comments_page']		=> ['Recently Commented',	'{{commented}}',		false, SET_MENU, 'Comments'],
		$config['index_page']			=> ['Page Index',			'{{pageindex}}',		false, SET_MENU, 'Index'],
		$config['random_page']			=> ['Random Page',			'{{randompage}}',		false, SET_MENU, 'Random'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Changes'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'Comments'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Index'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Random'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);