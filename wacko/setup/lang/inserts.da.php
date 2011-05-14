<?php

$lng = "da";

// insert these pages only for default language
if ($config['language'] == $lng)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Velkommen til din ((WackoWiki:Doc/English/WackoWiki WackoWiki)) installation!**\n\nKlik på \"Rediger siden\" linket nederst for at rette denne side.\n\nDokumentation finder du på WackoWiki:Doc/English.\n\nSærlige wikisider: ((WackoWiki:Doc/English/Formatting Formatting)), ((Søgning)).\n\n", $lng, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::+::\n\n", $lng, $config['admin_name'], true, false);
	}
	else
	{
		insert_page($config['users_page'].'/'.$config['admin_name'].'/MigrateDataToR50', 'Migrate Data to R5.0', "{{adminupdate}}\n\n", $lng, $config['admin_name'], true, false);
	}

	#insert_page('WantedPages', 'Wanted Pages', '{{wanted}}', $lng, 'Admins', true, false);
	#insert_page('OrphanedPages', 'Orphaned Pages', '{{orphaned}}', $lng, 'Admins', true, false);
	#insert_page('MineSider', 'Mine Sider', '{{mypages}}', $lng, 'Admins', true, false);
	#insert_page('MineOpdateringer', 'Mine Opdateringer', '{{mychanges}}', $lng, 'Admins', true, false);

	insert_page('Category', 'Category', '{{category}}', $lng, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lng, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{usergroups}}', $lng, 'Admins', false, false);
	insert_page('Users', 'Users', '{{users}}', $lng, 'Admins', false, false);
}

insert_page('Opdateringer', 'Opdateringer', '{{changes}}', $lng, 'Admins', false, true, 'Opdateringer');
insert_page('Kommentarer', 'Kommentarer', '{{commented}}', $lng, 'Admins', false, true, 'Kommentarer');
insert_page('Indhold', 'Indhold', '{{pageindex}}', $lng, 'Admins', false, true, 'Indhold');

insert_page('Registrering', 'Registrering', '{{registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lng, 'Admins', false, false);
insert_page('Søgning', 'Søgning', '{{search}}', $lng, 'Admins', false, false);
insert_page('Login', 'Login', '{{login}}', $lng, 'Admins', false, false);
insert_page('Indstillinger', 'Indstillinger', '{{usersettings}}', $lng, 'Admins', false, false);

?>