<?php

$page_lang = 'fa';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		=
			'file:/wacko_logo.png?left' . "\n" .
			'**!به سایت ((WackoWiki:Doc/English WackoWiki)) خود خوش آمدید!**' . "\n\n" .
			'Click after you have ((ورود logged in)) on the "Edit this page" link at the bottom to get started.' . "\n\n" .
			'Documentation can be found at WackoWiki:Doc/English.' . "\n" .
			'صفحات مفید: ((WackoWiki:Doc/English/Formatting Formatting)), ((جستجو)).' . "\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'خانه', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}

	insert_page($config['category_page'],		'دسته',					'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'گروه‌ها',				'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'کاربران',				'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'راهنما',				'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'شرایط خدمات',			'',						$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'سیاست محرمانگی',		'',						$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'نام‌نویسی',				'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'گذرواژه',				'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'جستجو',				'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'ورود به سامانه',		'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'تنظیمات',				'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'تغییرات اخیر',			'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, 'تغییرات');
	insert_page($config['comments_page'],		'دیدگاه‌های اخیر',		'{{commented}}',		$page_lang, 'Admins', false, SET_MENU, 'دیدگاه');
	insert_page($config['index_page'],			'Page Index',			'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, 'شاخص');
	insert_page($config['random_page'],			'صفحه تصادفی',			'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, 'تصادفی');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'تغییرات');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'دیدگاه');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'شاخص');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'تصادفی');
}

