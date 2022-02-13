<?php

$page_lang = 'hi';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**आपकी ((WackoWiki:Doc/English WackoWiki)) साइट पर आपका स्वागत है!**' . "\n\n" .
			'आरंभ करने के लिए नीचे "इस पृष्ठ को संपादित करें" लिंक पर लॉग इन करने के बाद क्लिक करें।' . "\n\n" .
			'दस्तावेज़ीकरण यहां पाया जा सकता है  WackoWiki:Doc/English.' . "\n" .
			'Useful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((/खोजें खोजें)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['मुख पृष्ठ',					 $home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['वर्ग',						'{{category}}',			false, false],
		$config['groups_page']			=> ['समूह',					'{{groups}}',				false, false],
		$config['users_page']			=> ['उपयोगकर्ताओं',				'{{users}}',				false, false],

		# $config['help_page']			=> ['सहायता',					'',						false, false],
		# $config['terms_page']			=> ['उपयोग की शर्तें',				'',						false, false],
		# $config['privacy_page']		=> ['गोपनीयता नीति',				'',						false, false],

		$config['registration_page']	=> ['पंजीकरण',					'{{registration}}',		false, false],
		$config['password_page']		=> ['कूटशब्द',					'{{changepassword}}',		false, false],
		$config['search_page']			=> ['खोजें',					'{{search}}',				false, false],
		$config['login_page']			=> ['प्रवेश',					'{{login}}',				false, false],
		$config['account_page']			=> ['स्थापनायें',					'{{usersettings}}',			false, false],

		$config['changes_page']			=> ['हाल में हुए परिवर्तन',			'{{changes}}',				false, SET_MENU, 'Changes'],
		$config['comments_page']		=> ['हाल की टिप्पणियाँ',			'{{commented}}',			false, SET_MENU, 'टिप्पणियाँ'],
		$config['index_page']			=> ['Page Index',			'{{pageindex}}',		false, SET_MENU, 'अनुक्रमणिका'],
		$config['random_page']			=> ['यादृच्छिक पृष्ठ',				'{{randompage}}',			false, SET_MENU, 'यादृच्छिक'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Changes'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'टिप्पणियाँ'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'अनुक्रमणिका'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'यादृच्छिक'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);