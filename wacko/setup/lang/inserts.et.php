<?php

$page_lang = 'et';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png?right\n**Welcome to your ((WackoWiki:Doc/English WackoWiki)) site!**\n\nClick after you have ((Login logged in)) on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((Otsing)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Home Page', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		//...
	}

	insert_page($config['category_page'],	'Kategooria',		'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],		'Grupid',			'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],		'Kasutajad',		'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],		'Abi',				'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],		'Terms',			'',						$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],	'Andmekaitse',		'',						$page_lang, 'Admins', false, false);

	#insert_page($config['random_page'],		'Juhuslik lehekülg',	'{{randompage}}',		$page_lang, 'Admins', false, true, 'Juhuslik');

	insert_page($config['registration_page'],	'Registreerimine',			'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Parool',					'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Otsing',					'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'Login',					'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Settings',					'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'Viimased Muudatused',		'{{changes}}',			$page_lang, 'Admins', false, true, 'Muudatused');
	insert_page($config['comments_page'],		'Viimati Kommenteeritud',	'{{commented}}',		$page_lang, 'Admins', false, true, 'Kommenteeritud');
	insert_page($config['index_page'],			'Sisu Kord',				'{{pageindex}}',		$page_lang, 'Admins', false, true, 'Index');
}
else
{
	// set only bookmarks
}

