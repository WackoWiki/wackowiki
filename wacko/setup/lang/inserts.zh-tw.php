<?php

$page_lang = 'zh-tw';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**歡迎來到您的 ((WackoWiki:Doc/English WackoWiki)) 網站！**' . "\n\n" .
			'Click after you have ((/登入 logged in)) on the "編輯" link at the bottom to get started.' . "\n\n" .
			'Documentation can be found at WackoWiki:Doc/English.' . "\n" .
			'Useful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((/搜尋 搜尋)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['首頁',					$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['分類',					'{{category}}',			false, false],
		$config['groups_page']			=> ['群組',					'{{groups}}',			false, false],
		$config['users_page']			=> ['使用者',				'{{users}}',			false, false],

		# $config['help_page']			=> ['說明',					'',						false, false],
		# $config['terms_page']			=> ['條款',					'',						false, false],
		# $config['privacy_page']		=> ['隱私政策',				'',						false, false],

		$config['registration_page']	=> ['建立帳號',				'{{registration}}',		false, false],
		$config['password_page']		=> ['密碼',					'{{changepassword}}',	false, false],
		$config['search_page']			=> ['搜尋',					'{{search}}',			false, false],
		$config['login_page']			=> ['登入',					'{{login}}',			false, false],
		$config['account_page']			=> ['設定',					'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['近期變動',				'{{changes}}',			false, SET_MENU, '變動'],
		$config['comments_page']		=> ['最近評論',				'{{commented}}',		false, SET_MENU, '回應'],
		$config['index_page']			=> ['頁面索引',				'{{pageindex}}',		false, SET_MENU, '索引'],
		$config['random_page']			=> ['隨機頁面',				'{{randompage}}',		false, SET_MENU, '隨機的'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, '變動'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, '回應'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, '索引'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, '隨機的'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);