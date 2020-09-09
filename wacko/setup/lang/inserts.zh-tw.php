<?php

$page_lang = 'en';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png?right\n**歡迎來到您的 ((WackoWiki:Doc/English WackoWiki)) 網站！**\n\nClick after you have ((Login logged in)) on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((搜尋)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], '首頁', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],		'分類',					'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'群組',					'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'使用者',				'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'說明',					'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'條款',					'',						$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'隱私政策',				'',						$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'建立帳號',				'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'密碼',					'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'搜尋',					'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'登入',					'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'設定',					'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'近期變動',				'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, '變動');
	insert_page($config['comments_page'],		'最近評論',				'{{commented}}',		$page_lang, 'Admins', false, SET_MENU, '回應');
	insert_page($config['index_page'],			'頁面索引',				'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, '索引');
	insert_page($config['random_page'],			'隨機頁面',				'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, '隨機的');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, '變動');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, '回應');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, '索引');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, '隨機的');
}

