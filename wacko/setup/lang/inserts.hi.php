<?php

$page_lang = 'en';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Welcome to your ((WackoWiki:Doc/English WackoWiki)) site!**' . "\n\n" .
			'Click after you have ((प्रवेश logged in)) on the "Edit this page" link at the bottom to get started.' . "\n\n" .
			'Documentation can be found at WackoWiki:Doc/English.' . "\n" .
			'Useful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((खोजें)).' . "\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Home Page', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}

	insert_page($config['category_page'],		'वर्ग',						'{{category}}',				$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'समूह',					'{{groups}}',				$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'उपयोगकर्ताओं',				'{{users}}',				$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'सहायता',					'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'उपयोग की शर्तें',				'',						$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'गोपनीयता नीति',				'',						$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'पंजीकरण',					'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'कूटशब्द',					'{{changepassword}}',		$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'खोजें',					'{{search}}',				$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'प्रवेश',					'{{login}}',				$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'स्थापनायें',					'{{usersettings}}',			$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'हाल में हुए परिवर्तन',			'{{changes}}',				$page_lang, 'Admins', false, SET_MENU, 'Changes');
	insert_page($config['comments_page'],		'हाल की टिप्पणियाँ',			'{{commented}}',			$page_lang, 'Admins', false, SET_MENU, 'टिप्पणियाँ');
	insert_page($config['index_page'],			'Page Index',			'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, 'अनुक्रमणिका');
	insert_page($config['random_page'],			'यादृच्छिक पृष्ठ',				'{{randompage}}',			$page_lang, 'Admins', false, SET_MENU, 'यादृच्छिक');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Changes');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'टिप्पणियाँ');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'अनुक्रमणिका');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'यादृच्छिक');
}

