<?php

$page_lang = 'da';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png\n**Velkommen til din ((WackoWiki:Doc/English/WackoWiki WackoWiki)) installation!**\n\nKlik p� \"Rediger siden\" linket nederst for at rette denne side.\n\nDokumentation finder du p� WackoWiki:Doc/English.\n\nS�rlige wikisider: ((WackoWiki:Doc/English/Formatting Formatting)), ((S�gning)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:'.$config['admin_name'].' '.$config['admin_name'].'))', date($config['date_macro_format']));

		insert_page($config['root_page'], 'Startside', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], $admin_page_body."\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page('Category',		'Category',		'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page('Groups',		'Groups',		'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page('Users',		'Users',		'{{users}}',			$page_lang, 'Admins', false, false);
}

insert_page('Opdateringer',		'Opdateringer',		'{{changes}}',			$page_lang, 'Admins', false, true, 'Opdateringer');
insert_page('Kommentarer',		'Kommentarer',		'{{commented}}',		$page_lang, 'Admins', false, true, 'Kommentarer');
insert_page('Indhold',			'Indhold',			'{{pageindex}}',		$page_lang, 'Admins', false, true, 'Indhold');

insert_page('Registrering',		'Registrering',		'{{registration}}',		$page_lang, 'Admins', false, false);
insert_page('Password',			'Password',			'{{changepassword}}',	$page_lang, 'Admins', false, false);
insert_page('S�gning',			'S�gning',			'{{search}}',			$page_lang, 'Admins', false, false);
insert_page('Login',			'Login',			'{{login}}',			$page_lang, 'Admins', false, false);
insert_page('Indstillinger',	'Indstillinger',	'{{usersettings}}',		$page_lang, 'Admins', false, false);

?>