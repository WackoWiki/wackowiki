<?php

$lng = "pl";

// insert these pages only for default language
if ($config['language'] == $lng)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Witaj na swojej stronie ((WackoWiki:Doc/English/WackoWiki WackoWiki))!**\n\nKlinkij na link \"Edytuj stronê\" na dole by rozpocz±æ.\n\nDokumentacja dostêpna jest w WackoWiki:Doc/English.\n\nPrzydatne strony: ((WackoWiki:Doc/English/Formatting Formatting)), TextSearch.\n\n", $lng, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::+::\n\n", $lng, $config['admin_name'], true, false);
	}
	else
	{
		insert_page($config['users_page'].'/'.$config['admin_name'].'/MigrateDataToR50', 'Migrate Data to R5.0', "{{adminupdate}}\n\n", $lng, $config['admin_name'], true, false);
	}

	#insert_page('PotrzebneStrony', 'Potrzebne Strony', '{{wanted}}', $lng, 'Admins', true, false);
	#insert_page('OsieroconeStrony', 'Osierocone Strony', '{{orphaned}}', $lng, 'Admins', true, false);
	#insert_page('MojeStrony', 'Moje Strony', '{{mypages}}', $lng, 'Admins', true, false);
	#insert_page('MojeZmiany', 'Moje Zmiany', '{{mychanges}}', $lng, 'Admins', true, false);

	insert_page('Category', 'Category', '{{category}}', $lng, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lng, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{usergroups}}', $lng, 'Admins', false, false);
	insert_page('Users', 'U¿ytkownicy', '{{users}}', $lng, 'Admins', false, false);
}

insert_page('OstatnieZmiany', 'Ostatnie Zmiany', '{{changes}}', $lng, 'Admins', false, true, 'Zmiany');
insert_page('OstatnioKomentowane', 'Ostatnio Komentowane', '{{commented}}', $lng, 'Admins', false, true, 'Komentowane');
insert_page('IndexStron', 'Index Stron', '{{pageindex}}', $lng, 'Admins', false, true, 'Index');

insert_page('Rejestracja', 'Rejestracja', '{{registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lng, 'Admins', false, false);
insert_page('TextSearch', 'Text Search', '{{search}}', $lng, 'Admins', false, false);
insert_page('Login', 'Login', '{{login}}', $lng, 'Admins', false, false);
insert_page('Ustawienia', 'Ustawienia', '{{usersettings}}', $lng, 'Admins', false, false);

?>