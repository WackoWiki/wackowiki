<?php

$page_lang = 'en';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], 'Home Page', "file:wacko_logo.png\n**Welcome to your ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nClick after you have ((login logged in)) on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).\n\n", $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page('Category', 'Category', '{{category}}', $page_lang, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $page_lang, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $page_lang, 'Admins', false, false);
	insert_page('Users', 'Users', '{{users}}', $page_lang, 'Admins', false, false);
}

//
insert_page('RecentChanges', 'Recent Changes', '{{changes}}', $page_lang, 'Admins', false, true, 'Changes');
insert_page('RecentlyCommented', 'Recently Commented', '{{commented}}', $page_lang, 'Admins', false, true, 'Comments');
insert_page('PageIndex', 'Page Index', '{{pageindex}}', $page_lang, 'Admins', false, true, 'Index');

insert_page('Registration', 'Registration', '{{registration}}', $page_lang, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $page_lang, 'Admins', false, false);
insert_page('Search', 'Search', '{{search}}', $page_lang, 'Admins', false, false);
insert_page('Login', 'Login', '{{login}}', $page_lang, 'Admins', false, false);
insert_page('Settings', 'Settings', '{{usersettings}}', $page_lang, 'Admins', false, false);

?>