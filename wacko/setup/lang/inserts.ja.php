<?php

$page_lang = 'ja';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png?right\n**あなたの ((WackoWiki:Doc/English WackoWiki)) サイトへようこそ！**\n\nClick after you have ((ログイン logged in)) on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((検索)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'ホームページ', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],		'カテゴリー',				'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'グループ',				'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'ユーザー',				'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'ヘルプ',					'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'利用規約',				'',						$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'プライバシーについて',		'',						$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'アカウント作成',			'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'パスワード',				'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'検索',					'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'ログイン',				'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'設定',					'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'最近の変化',				'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, '変化');
	insert_page($config['comments_page'],		'最近コメント',			'{{commented}}',		$page_lang, 'Admins', false, SET_MENU, 'コメント');
	insert_page($config['index_page'],			'ページインデックス',		'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, 'インデックス');
	insert_page($config['random_page'],			'ランダムページ',			'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, 'ランダム');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, '変化');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'コメント');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'インデックス');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'ランダム');
}