<?php

$page_lang = 'ko';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**당신의 ((WackoWiki:Doc/English WackoWiki)) 사이트에 오신 것을 환영합니다!**' . "\n\n" .
			'시작하려면 하단의 "이 페이지 편집" 링크에 로그인한 후 클릭하십시오. ' . "\n\n" .
			'문서는 다음에서 찾을 수 있습니다 WackoWiki:Doc/English.' . "\n" .
			'유용한 페이지들: ((WackoWiki:Doc/English/Formatting Formatting)), ((/검색 검색)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['홈페이지',				$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['카테고리',				'{{category}}',			false, false],
		$config['groups_page']			=> ['그룹',					'{{groups}}',				false, false],
		$config['users_page']			=> ['사용자',					'{{users}}',				false, false],

		# $config['help_page']			=> ['도움말',					'',						false, false],
		# $config['terms_page']			=> ['서비스이용약관',			'',						false, false],
		# $config['privacy_page']		=> ['개인정보처리방침',			'',					false, false],

		$config['registration_page']	=> ['계정 만들기',				'{{registration}}',		false, false],
		$config['password_page']		=> ['비밀번호',				'{{changepassword}}',		false, false],
		$config['search_page']			=> ['검색',					'{{search}}',				false, false],
		$config['login_page']			=> ['로그인',					'{{login}}',				false, false],
		$config['account_page']			=> ['설정',					'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['최근 바뀜',				'{{changes}}',			false, SET_MENU, '바뀜'],
		$config['comments_page']		=> ['최근 댓글',				'{{commented}}',			false, SET_MENU, '댓글'],
		$config['index_page']			=> ['페이지 색인',				'{{pageindex}}',			false, SET_MENU, '색인'],
		$config['random_page']			=> ['임의의 문서로',			'{{randompage}}',			false, SET_MENU, '무작위'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, '바뀜'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, '댓글'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, '색인'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, '무작위'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);