<?php

$lang = 'da';

// insert these pages only for default language
if ($config['language'] == $lang)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Velkommen til din ((WackoWiki:Doc/English/WackoWiki WackoWiki)) installation!**\n\nKlik på \"Rediger siden\" linket nederst for at rette denne side.\n\nDokumentation finder du på WackoWiki:Doc/English.\n\nSærlige wikisider: ((WackoWiki:Doc/English/Formatting Formatting)), ((Søgning)).\n\n", $lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page('Category', 'Category', '{{category}}', $lang, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lang, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lang, 'Admins', false, false);
	insert_page('Users', 'Users', '{{users}}', $lang, 'Admins', false, false);
}

insert_page('Opdateringer', 'Opdateringer', '{{changes}}', $lang, 'Admins', false, true, 'Opdateringer');
insert_page('Kommentarer', 'Kommentarer', '{{commented}}', $lang, 'Admins', false, true, 'Kommentarer');
insert_page('Indhold', 'Indhold', '{{pageindex}}', $lang, 'Admins', false, true, 'Indhold');

insert_page('Registrering', 'Registrering', '{{registration}}', $lang, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lang, 'Admins', false, false);
insert_page('Søgning', 'Søgning', '{{search}}', $lang, 'Admins', false, false);
insert_page('Login', 'Login', '{{login}}', $lang, 'Admins', false, false);
insert_page('Indstillinger', 'Indstillinger', '{{usersettings}}', $lang, 'Admins', false, false);

?>