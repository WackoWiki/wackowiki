<?php

// Default Pages Inserts

function insert_pages($insert, $config)
{
	// insert these pages only for default language
	if ($config['language'] == $insert['lang'])
	{
		if (!$config['is_update'])
		{
			$home_page_body		= $insert['home_page_body'] . "\n\n";
			$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n" .
			#	'{{tree}}'	.
			"\n\n";
			$admin_tools_body	= '' . "\n\n" .
				'%%(wacko wrapper="shade" wrapper_type="warning")'	. "\n\n" .
				'{{admincache}}'	. "\n\n" .
				'{{admin_recovery}}' . "\n\n" .
				'%%' . "\n\n";
			$admin_page			= $config['users_page'] . '/' . $config['admin_name'];
			$admin_tools		= $config['users_page'] . '/' . $config['admin_name'] . '/' . 'Tools';

			$critical_pages = [
				$config['root_page']		=> [$insert['root_page'],			$home_page_body,		true, false, null, 0],
				$admin_page					=> [$config['admin_name'],			$admin_page_body,		true, false, null, 0],
				$admin_tools				=> [$insert['tools_page'],			$admin_tools_body,		true, SET_MENU_ADMIN, [$insert['tools_page_bm'], 4], 0],
			];
		}

		$pages = [
			$config['category_page']		=> [$insert['category_page'],		'{{category}}',			false, false],
			$config['groups_page']			=> [$insert['groups_page'],			'{{groups}}',			false, false],
			$config['users_page']			=> [$insert['users_page'],			'{{users}}',			false, false],

			# $config['help_page']			=> [$insert['help_page'],			'',						false, false],
			# $config['terms_page']			=> [$insert['terms_page'],			'',						false, false],
			# $config['privacy_page']		=> [$insert['privacy_page'],		'',						false, false],

			$config['registration_page']	=> [$insert['registration_page'],	'{{registration}}',		false, false],
			$config['password_page']		=> [$insert['password_page'],		'{{changepassword}}',	false, false],
			$config['search_page']			=> [$insert['search_page'],			'{{search}}',			false, false],
			$config['login_page']			=> [$insert['login_page'],			'{{login}}',			false, false],
			$config['account_page']			=> [$insert['account_page'],		'{{usersettings}}',		false, false],

			$config['changes_page']			=> [$insert['changes_page'],		'{{changes}}',			false, false],
			$config['comments_page']		=> [$insert['comments_page'],		'{{commented}}',		false, false],
			$config['whatsnew_page']		=> [$insert['whatsnew_page'],		'{{whatsnew}}',			false, SET_MENU, [$insert['whatsnew_page_bm'], 1]],
			$config['index_page']			=> [$insert['index_page'],			'{{pageindex}}',		false, SET_MENU, [$insert['index_page_bm'], 2]],
			$config['random_page']			=> [$insert['random_page'],			'{{randompage}}',		false, SET_MENU, [$insert['random_page_bm'], 3]],
		];
	}
	else
	{
		// set only bookmarks
		$pages = [
			# $config['changes_page']		=> ['',		'',		false, SET_MENU_ONLY, [$insert['changes_page_bm'], 1]],
			# $config['comments_page']		=> ['',		'',		false, SET_MENU_ONLY, [$insert['comments_page_bm'], 1]],
			$config['whatsnew_page']		=> ['',		'',		false, SET_MENU_ONLY, [$insert['whatsnew_page_bm'], 1]],
			$config['index_page']			=> ['',		'',		false, SET_MENU_ONLY, [$insert['index_page_bm'], 2]],
			$config['random_page']			=> ['',		'',		false, SET_MENU_ONLY, [$insert['random_page_bm'], 3]],
		];
	}

	if (!empty($critical_pages))
	{
		$pages = array_merge($critical_pages, $pages);
	}

	// insert pages
	foreach ($pages as $tag => $page)
	{
		insert_page($tag, $page, $insert['lang'], $config);
	}
}

// Insert default page, all related acls and menu items
// We flag some pages as critical in the insert.<lang>.php file, if these don't get inserted
// then we have a serious problem and should indicate that to the user.
function insert_page($tag, $page, $lang, $config)
{
	global $config_global, $dblink_global;

	$title			= $page[0];
	$body			= $page[1];
	$critical		= $page[2] ?? false;
	$set_menu		= $page[3];
	$menu_title		= $page[4][0] ?? false;
	$menu_position	= $page[4][1] ?? 0;
	$noindex		= $page[5] ?? 1; // it won't accept null

	$public_pages	= [
		$config['login_page'],
		$config['password_page'],
		$config['registration_page']
	];

	$admin_pages	= [
		$config['users_page'] . '/' . $config['admin_name'] . '/' . 'Tools'
	];

	// set rights
	$read_rights	= match (true)
	{
		in_array($tag, $public_pages)	=> '*',
		in_array($tag, $admin_pages)	=> 'Admins',
		default							=> $config['default_read_acl']
	};

	$write_rights	= 'Admins';

	sanitize_page_tag($tag);

	$prefix				= $config_global['table_prefix'];
	$q_owner_id			= "SELECT user_id FROM " . $prefix . "user WHERE user_name = 'System' LIMIT 1";
	$q_admin_id			= "SELECT user_id FROM " . $prefix . "user WHERE user_name = '" . _q($config['admin_name']) . "' LIMIT 1";
	$q_page_id			= "SELECT page_id FROM " . $prefix . "page WHERE tag = '" . _q($tag) . "' LIMIT 1";
	$page_select		= $q_page_id;

	if ($set_menu != SET_MENU_ONLY)
	{
		// user_id for user 'System'
		// we specify values for columns body_r (MEDIUMTEXT) and body_toc (TEXT) that don't have defaults
		// the additional parentheses around $owner_id and $page_id are necessary for the sub-select queries
		$page_insert	=
			"INSERT INTO " . $prefix . "page (
				tag,
				title,
				body,
				body_r,
				body_toc,
				user_id,
				owner_id,
				created,
				modified,
				latest,
				page_size,
				page_lang,
				footer_comments,
				footer_files,
				noindex
			)
			VALUES (
				'" . _q($tag) . "',
				'" . _q($title) . "' ,
				'" . _q($body) . "',
				'',
				'',
				(" . $q_owner_id . "),
				(" . $q_owner_id . "),
				" . utc_dt() . ",
				" . utc_dt() . ",
				1,
				" . strlen($body) . ",
				'" . _q($lang) . "',
				0,
				0,
				" . (int) $noindex . "
			)";

		$perm_insert	=
			"INSERT INTO " . $prefix . "acl (
				page_id, privilege, list
			)
			VALUES
				((" . $q_page_id . "), 'read',		'" . _q($read_rights) . "'),
				((" . $q_page_id . "), 'write',		'" . _q($write_rights) . "'),
				((" . $q_page_id . "), 'comment',		'$'),
				((" . $q_page_id . "), 'create',		'" . _q($write_rights) . "'),
				((" . $q_page_id . "), 'upload',		'')";

		$insert_data[]	= [$page_insert,	_t('ErrorInsertPage')];
		$insert_data[]	= [$perm_insert,	_t('ErrorInsertPagePermission')];

		$admin_menu_item	=
			"INSERT INTO " . $prefix . "menu (
				user_id,
				page_id,
				menu_lang,
				menu_title,
				menu_position
			)
			VALUES (
				(" . $q_admin_id . "),
				(" . $q_page_id . "),
				'" . _q($lang) . "',
				'" . _q($menu_title) . "',
				'" . (int) $menu_position . "'
			)" .
			(!in_array($config_global['db_driver'], ['sqlite', 'sqlite_pdo'])
				? "ON DUPLICATE KEY UPDATE
					menu_title = '" . _q($menu_title) . "'"
				: "ON CONFLICT(user_id, page_id, menu_lang) DO UPDATE SET
					menu_title = excluded.menu_title;"
				);

		if ($set_menu)
		{
			$insert_data[]	= [$admin_menu_item,	_t('ErrorInsertDefaultMenuItem')];
		}
	}

	$default_menu_item	=
		"INSERT INTO " . $prefix . "menu (
			user_id,
			page_id,
			menu_lang,
			menu_title,
			menu_position
		)
		VALUES (
			(" . $q_owner_id . "),
			(" . $q_page_id . "),
			'" . _q($lang) . "',
			'" . _q($menu_title) . "',
			'" . (int) $menu_position . "'
		)" .
		(!in_array($config_global['db_driver'], ['sqlite', 'sqlite_pdo'])
			? "ON DUPLICATE KEY UPDATE
				menu_title = '" . _q($menu_title) . "'"
			: "ON CONFLICT(user_id, page_id, menu_lang) DO UPDATE SET
				menu_title = excluded.menu_title;"
		);

	if ($set_menu && $set_menu != SET_MENU_ADMIN)
	{
		$insert_data[]	= [$default_menu_item,	_t('ErrorInsertDefaultMenuItem')];
	}

	switch ($config_global['db_driver'])
	{
		case 'mysqli':
			$add_page = false;

			if ($result = mysqli_query($dblink_global, $page_select))
			{
				$add_page = (0 == mysqli_num_rows($result));
			}

			if ($add_page || $set_menu == SET_MENU_ONLY)
			{
				foreach ($insert_data as $data)
				{
					mysqli_query($dblink_global, $data[0]);

					if ($critical)
					{
						if (mysqli_errno($dblink_global) != 0)
						{
							output_error(Ut::perc_replace($data[1], $tag) . ' - ' . mysqli_error($dblink_global));
						}
					}
				}
			}
			else if ($critical)
			{
				output_error(Ut::perc_replace(_t('ErrorPageAlreadyExists'), $tag));
			}

			break;

		case 'sqlite':
			$add_page = false;

			if ($result = $dblink_global->query($page_select))
			{
				$rows = [];

				while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
					$rows[] = $row;
				}

				$add_page = (0 == count($rows));
			}

			if ($add_page || $set_menu == SET_MENU_ONLY)
			{
				foreach ($insert_data as $data)
				{
					$dblink_global->query($data[0]);

					if ($critical)
					{
						if ($dblink_global->lastErrorCode() != 0)
						{
							output_error(Ut::perc_replace($data[1], $tag) . ' - ' . $dblink_global->lastErrorMsg());
						}
					}
				}
			}
			else if ($critical)
			{
				output_error(Ut::perc_replace(_t('ErrorPageAlreadyExists'), $tag));
			}

			break;

		default:
			$page_exists = false;

			if ($result = @$dblink_global->query($page_select))
			{
				if ($result->fetchColumn() > 0)
				{
					$page_exists = true;

					if ($critical)
					{
						output_error(Ut::perc_replace(_t('ErrorPageAlreadyExists'), $tag));
					}
				}

				$result->closeCursor();
			}

			if (!$page_exists || $set_menu == SET_MENU_ONLY)
			{
				foreach ($insert_data as $data)
				{
					$dblink_global->query($data[0]);

					if ($critical)
					{
						$error = $dblink_global->errorInfo();

						if ($error[0] != '00000')
						{
							output_error(Ut::perc_replace($data[1], $tag) . ' - ' . ($error[2]));
						}
					}
				}
			}

			break;
	}
}

// Inserting default pages

if (isset($config['multilanguage']) && $config['multilanguage'] == 1)
{
	if ($config['allowed_languages'])
	{
		$lang_list = explode(',', $config['allowed_languages']);
	}
	else
	{
		if ($handle = opendir('setup/lang'))
		{
			while (false !== ($file = readdir($handle)))
			{
				if (1 == preg_match('/^inserts\.([a-z]{2}(-[a-z]{2})?)\.php$/', $file, $match))
				{
					$lang_list[] = $match[1];
				}
			}

			closedir($handle);
		}
	}

	$lang_list = array_diff($lang_list, [$config['language']]);

	// system language is mandatory and must be the first include
	array_unshift($lang_list, $config['language']);

	foreach ($lang_list as $_lang)
	{
		unset($languages, $insert);
		$inserts_file = 'setup/lang/inserts.' . $_lang . '.php';

		if (@file_exists($inserts_file))
		{
			require_once $inserts_file;
			insert_pages($insert, $config);
		}
	}
}
else
{
	$inserts_file = 'setup/lang/inserts.' . $config['language'] . '.php';

	if (@file_exists($inserts_file))
	{
		require_once $inserts_file;
		insert_pages($insert, $config);
	}
}
