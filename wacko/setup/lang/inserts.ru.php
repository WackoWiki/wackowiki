<?php

$page_lang = 'ru';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$admin_page_body = sprintf($config['name_date_macro'], '((user:'.$config['admin_name'].' '.$config['admin_name'].'))', date($config['date_macro_format']));

		insert_page($config['root_page'], '', "file:wacko_logo.png\n**����� ���������� � ��������� ��� ((WackoWiki:Doc/Russian WackoWiki)).**\n\n������� \"������\" ����� ��������, ����� �������� � (����� ������, �� ������ ������ ��������� ������� ������ ������ -- ��� ������� � ���� �� ����������).\n\n������������ �� ~WackoWiki �������� �� WackoWiki:Doc/Russian.\n\n�������� ��������: ((WackoWiki:Doc/Russian/WackoSintaksis ��������������)), ((�����)).\n", $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], $admin_page_body."\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page('Category',		'Category',		'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page('Permalink',	'Permalink',	'{{permalinkproxy}}',	$page_lang, 'Admins', false, false);
	insert_page('Groups',		'Groups',		'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page('Users',		'������������',	'{{users}}',			$page_lang, 'Admins', false, false);
}

insert_page('�������',			'�������',				'{{pageindex}}',				$page_lang, 'Admins', false, true, '�������');
insert_page('���������',		'���������',			'{{changes}}',					$page_lang, 'Admins', false, true, '���������');
insert_page('����������������',	'����� �����������',	'{{commented}}',				$page_lang, 'Admins', false, true, '�����������');

insert_page('�����������',		'�����������',			'{{registration}}',				$page_lang, 'Admins', false, false);
insert_page('Password',			'Password',				'{{changepassword}}',			$page_lang, 'Admins', false, false);
insert_page('������',			'������',				'{{redirect to="Password"}}',	$page_lang, 'Admins', false, false);
insert_page('�����',			'�����',				'{{search}}',					$page_lang, 'Admins', false, false);
insert_page('����',				'����',					'{{login}}',					$page_lang, 'Admins', false, false);
insert_page('���������',		'���������',			'{{usersettings}}',				$page_lang, 'Admins', false, false);

?>