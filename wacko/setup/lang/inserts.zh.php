<?php

$page_lang = 'zh';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png?right\n**欢迎来到您的 ((WackoWiki:Doc/English WackoWiki)) 网站！**\n\nClick after you have ((Login logged in)) on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((搜索)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], '首页', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],		'类别',					'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'群组',					'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'用户',					'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'帮助',					'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'使用条款',				'',						$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'隐私政策',				'',						$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'创建账户',				'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'密码',					'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'搜索',					'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'登录',					'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'帐户设置',				'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'最近更改',				'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, '更改');
	insert_page($config['comments_page'],		'最近评论',				'{{commented}}',		$page_lang, 'Admins', false, SET_MENU, '评论');
	insert_page($config['index_page'],			'页面索引',				'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, '索引');
	insert_page($config['random_page'],			'随机条目',				'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, '随机条目');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, '更改');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, '评论');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, '索引');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, '随机条目');
}

