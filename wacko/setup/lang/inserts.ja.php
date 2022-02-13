<?php

$page_lang = 'ja';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**あなたの ((WackoWiki:Doc/English WackoWiki)) サイトへようこそ！**' . "\n\n" .
			'Click after you have ((/ログイン logged in)) on the "Edit this page" link at the bottom to get started.' . "\n\n" .
			'Documentation can be found at WackoWiki:Doc/English.' . "\n" .
			'Useful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((/検索 検索)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['ホームページ',			$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['カテゴリー',				'{{category}}',			false, false],
		$config['groups_page']			=> ['グループ',				'{{groups}}',			false, false],
		$config['users_page']			=> ['ユーザー',				'{{users}}',			false, false],

		# $config['help_page']			=> ['ヘルプ',				'',						false, false],
		# $config['terms_page']			=> ['利用規約',				'',						false, false],
		# $config['privacy_page']		=> ['プライバシーについて',	'',						false, false],

		$config['registration_page']	=> ['アカウント作成',			'{{registration}}',		false, false],
		$config['password_page']		=> ['パスワード',				'{{changepassword}}',	false, false],
		$config['search_page']			=> ['検索',					'{{search}}',			false, false],
		$config['login_page']			=> ['ログイン',				'{{login}}',			false, false],
		$config['account_page']			=> ['設定',					'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['最近の変化',				'{{changes}}',			false, SET_MENU, '変化'],
		$config['comments_page']		=> ['最近コメント',			'{{commented}}',		false, SET_MENU, 'コメント'],
		$config['index_page']			=> ['ページインデックス',		'{{pageindex}}',		false, SET_MENU, 'インデックス'],
		$config['random_page']			=> ['ランダムページ',			'{{randompage}}',		false, SET_MENU, 'ランダム'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, '変化'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'コメント'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'インデックス'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'ランダム'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);