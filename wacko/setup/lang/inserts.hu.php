<?php

$page_lang = 'hu';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png?right\n**Welcome to your ((WackoWiki:Doc/English WackoWiki)) site!**\n\nClick after you have ((Bejelentkezés logged in)) on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((Keresés)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Kezdőlap', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],	'Kategória',		'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],		'Csoportok',		'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],		'Felhasználók',		'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],		'Segítség',		'',			$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],		'Terms',		'',			$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],	'Privacy',		'',			$page_lang, 'Admins', false, false);

	#insert_page('LapTalálomra',			'Lap találomra',	'{{randompage}}',		$page_lang, 'Admins', false, true, 'Random');
}

//
insert_page('FrissVáltoztatások',	'Friss változtatások',	'{{changes}}',			$page_lang, 'Admins', false, true, 'Változtatások');
insert_page('UtolsóMegjegyzések',	'Utolsó megjegyzések',	'{{commented}}',		$page_lang, 'Admins', false, true, 'Megjegyzések');
insert_page('OldalIndex',			'Oldal Index',			'{{pageindex}}',		$page_lang, 'Admins', false, true, 'Index');

insert_page('Regisztráció',			'Fiók létrehozása',		'{{registration}}',		$page_lang, 'Admins', false, false);
insert_page('Jelszó',				'Jelszó',				'{{changepassword}}',	$page_lang, 'Admins', false, false);
insert_page('Keresés',				'Keresés',				'{{search}}',			$page_lang, 'Admins', false, false);
insert_page('Bejelentkezés',		'Bejelentkezés',		'{{login}}',			$page_lang, 'Admins', false, false);
insert_page('Beállítások',			'Beállítások',			'{{usersettings}}',		$page_lang, 'Admins', false, false);

?>