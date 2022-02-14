<?php

$page_lang = 'zh';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**欢迎来到您的 ((WackoWiki:Doc/English WackoWiki)) 网站！**' . "\n\n" .
			'Click after you have ((/登录 logged in)) on the "Edit this page" link at the bottom to get started.' . "\n\n" .
			'文件可在以下网址找到 WackoWiki:Doc/English.' . "\n" .
			'Useful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((/搜索 搜索)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['首页',					$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['类别',					'{{category}}',			false, false],
		$config['groups_page']			=> ['群组',					'{{groups}}',			false, false],
		$config['users_page']			=> ['用户',					'{{users}}',			false, false],

		# $config['help_page']			=> ['帮助',					'',						false, false],
		# $config['terms_page']			=> ['使用条款',				'',						false, false],
		# $config['privacy_page']		=> ['隐私政策',				'',						false, false],

		$config['registration_page']	=> ['创建账户',				'{{registration}}',		false, false],
		$config['password_page']		=> ['密码',					'{{changepassword}}',	false, false],
		$config['search_page']			=> ['搜索',					'{{search}}',			false, false],
		$config['login_page']			=> ['登录',					'{{login}}',			false, false],
		$config['account_page']			=> ['帐户设置',				'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['最近更改',				'{{changes}}',			false, SET_MENU, '更改'],
		$config['comments_page']		=> ['最近评论',				'{{commented}}',		false, SET_MENU, '评论'],
		$config['index_page']			=> ['页面索引',				'{{pageindex}}',		false, SET_MENU, '索引'],
		$config['random_page']			=> ['随机条目',				'{{randompage}}',		false, SET_MENU, '随机条目'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, '更改'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, '评论'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, '索引'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, '随机条目'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);