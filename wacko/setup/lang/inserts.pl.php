<?php

$lang = 'pl';

// insert these pages only for default language
if ($config['language'] == $lang)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Witaj na swojej stronie ((WackoWiki:Doc/English/WackoWiki WackoWiki))!**\n\nKlinkij na link \"Edytuj stronê\" na dole by rozpocz±æ.\n\nDokumentacja dostêpna jest w WackoWiki:Doc/English.\n\nPrzydatne strony: ((WackoWiki:Doc/English/Formatting Formatting)), ((Search)).\n\n", $lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page('Category', 'Category', '{{category}}', $lang, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lang, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lang, 'Admins', false, false);
	insert_page('Users', 'U¿ytkownicy', '{{users}}', $lang, 'Admins', false, false);
}

insert_page('OstatnieZmiany', 'Ostatnie Zmiany', '{{changes}}', $lang, 'Admins', false, true, 'Zmiany');
insert_page('OstatnioKomentowane', 'Ostatnio Komentowane', '{{commented}}', $lang, 'Admins', false, true, 'Komentowane');
insert_page('IndexStron', 'Index Stron', '{{pageindex}}', $lang, 'Admins', false, true, 'Index');

insert_page('Rejestracja', 'Rejestracja', '{{registration}}', $lang, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lang, 'Admins', false, false);
insert_page('Search', 'Poszukiwanie', '{{search}}', $lang, 'Admins', false, false);
insert_page('Login', 'Login', '{{login}}', $lang, 'Admins', false, false);
insert_page('Ustawienia', 'Ustawienia', '{{usersettings}}', $lang, 'Admins', false, false);

?>