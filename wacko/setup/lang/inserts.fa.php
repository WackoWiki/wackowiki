<?php

$page_lang = 'fa';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?left' . "\n" .
			'**به سایت ((WackoWiki:Doc/English WackoWiki)) خود خوش آمدید!**' . "\n\n" .
			'Click after you have ((ورود logged in)) on the "Edit this page" link at the bottom to get started.' . "\n\n" .
			'Documentation can be found at WackoWiki:Doc/English.' . "\n" .
			'صفحات مفید: ((WackoWiki:Doc/English/Formatting Formatting)), ((جستجو)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['خانه',					$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['دسته',					'{{category}}',			false, false],
		$config['groups_page']			=> ['گروه‌ها',				'{{groups}}',			false, false],
		$config['users_page']			=> ['کاربران',				'{{users}}',			false, false],

		# $config['help_page']			=> ['راهنما',				'',						false, false],
		# $config['terms_page']			=> ['شرایط خدمات',			'',						false, false],
		# $config['privacy_page']		=> ['سیاست محرمانگی',		'',						false, false],

		$config['registration_page']	=> ['نام‌نویسی',				'{{registration}}',		false, false],
		$config['password_page']		=> ['گذرواژه',				'{{changepassword}}',	false, false],
		$config['search_page']			=> ['جستجو',				'{{search}}',			false, false],
		$config['login_page']			=> ['ورود به سامانه',		'{{login}}',			false, false],
		$config['account_page']			=> ['تنظیمات',				'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['تغییرات اخیر',			'{{changes}}',			false, SET_MENU, 'تغییرات'],
		$config['comments_page']		=> ['دیدگاه‌های اخیر',		'{{commented}}',		false, SET_MENU, 'دیدگاه'],
		$config['index_page']			=> ['Page Index',			'{{pageindex}}',		false, SET_MENU, 'شاخص'],
		$config['random_page']			=> ['صفحه تصادفی',			'{{randompage}}',		false, SET_MENU, 'تصادفی'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'تغییرات'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'دیدگاه'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'شاخص'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'تصادفی'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);