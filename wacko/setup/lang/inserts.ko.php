<?php

$page_lang = 'ko';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png?right\n**당신의 ((WackoWiki:Doc/English WackoWiki)) 사이트에 오신 것을 환영합니다!**\n\nClick after you have ((로그인 logged in)) on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((검색)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], '홈페이지', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],		'카테고리',				'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'그룹',					'{{groups}}',				$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'사용자',					'{{users}}',				$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'도움말',					'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'Terms',				'',						$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'Privacy',				'',						$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'계정 만들기',				'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'비밀번호',				'{{changepassword}}',		$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'검색',					'{{search}}',				$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'로그인',					'{{login}}',				$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'설정',					'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'최근 바뀜',				'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, '바뀜');
	insert_page($config['comments_page'],		'최근 댓글',				'{{commented}}',			$page_lang, 'Admins', false, SET_MENU, '댓글');
	insert_page($config['index_page'],			'페이지 색인',				'{{pageindex}}',			$page_lang, 'Admins', false, SET_MENU, '색인');
	insert_page($config['random_page'],			'임의의 문서로',			'{{randompage}}',			$page_lang, 'Admins', false, SET_MENU, '무작위');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, '바뀜');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, '댓글');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, '색인');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, '무작위');
}

