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
			$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
			$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

			$critical_pages = [
				$config['root_page']		=> [$insert['root_page'],			$home_page_body,		true, false, null, 0],
				$admin_page					=> [$config['admin_name'],			$admin_page_body,		true, false, null, 0],
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

			$config['changes_page']			=> [$insert['changes_page'],		'{{changes}}',			false, SET_MENU, $insert['changes_page_bm']],
			$config['comments_page']		=> [$insert['comments_page'],		'{{commented}}',		false, SET_MENU, $insert['comments_page_bm']],
			$config['index_page']			=> [$insert['index_page'],			'{{pageindex}}',		false, SET_MENU, $insert['index_page_bm']],
			$config['random_page']			=> [$insert['random_page'],			'{{randompage}}',		false, SET_MENU, $insert['random_page_bm']],
		];
	}
	else
	{
		// set only bookmarks
		$pages = [
			$config['changes_page']			=> ['',		'',		false, SET_MENU_ONLY, $insert['changes_page_bm']],
			$config['comments_page']		=> ['',		'',		false, SET_MENU_ONLY, $insert['comments_page_bm']],
			$config['index_page']			=> ['',		'',		false, SET_MENU_ONLY, $insert['index_page_bm']],
			$config['random_page']			=> ['',		'',		false, SET_MENU_ONLY, $insert['random_page_bm']],
		];
	}

	if (!empty($critical_pages))
	{
		$pages = array_merge($critical_pages, $pages);
	}

	/**
	 * [key] $tag,
	 * [0] $title,
	 * [1] $body,
	 * [default] $page_lang,
	 * [default] $rights		= 'Admins',
	 * [2] $critical			= false,
	 * [3] $set_menu			= 0,
	 * [4] $menu_title			= false,
	 * [5] $noindex				= 1
	 */
	// insert pages
	foreach ($pages as $tag => $value)
	{
		insert_page(
			$tag,
			$value[0],
			$value[1],
			$insert['lang'],
			'Admins',
			$value[2],
			$value[3],
			$value[4] ?? false,
			$value[5] ?? 1, // it won't accept null
		);
	}
}

// insert default page, all related acls and menu items
function insert_page($tag, $title, $body, $lang, $rights = 'Admins', $critical = false, $set_menu = 0, $menu_title = false, $noindex = 1)
{
	global $config_global, $dblink_global, $lang_global;

	sanitize_page_tag($tag);

	$prefix				= $config_global['table_prefix'];
	$owner_id			= "SELECT user_id FROM " . $prefix . "user WHERE user_name = 'System' LIMIT 1";
	$page_id			= "SELECT page_id FROM " . $prefix . "page WHERE tag = '" . _quote($tag) . "' LIMIT 1";
	$page_select		= $page_id;

	if ($set_menu != SET_MENU_ONLY)
	{
		// user_id for user 'System'
		// we specify values for columns body_r (MEDIUMTEXT) and body_toc (TEXT) that don't have defaults
		// the additional parentheses around $owner_id and $page_id are necessary for the sub-select queries
		$page_insert	= "INSERT INTO " .
								$prefix . "page (
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
								'" . _quote($tag) . "',
								'" . _quote($title) . "' ,
								'" . _quote($body) . "',
								'',
								'',
								(" . $owner_id . "),
								(" . $owner_id . "),
								UTC_TIMESTAMP(),
								UTC_TIMESTAMP(),
								1,
								" . strlen($body) . ",
								'" . _quote($lang) . "',
								0,
								0,
								" . (int) $noindex . "
							)";

		$perm_insert	= "INSERT INTO " .
								$prefix . "acl (
									page_id, privilege, list
								)
							VALUES
								((" . $page_id . "), 'read',		'*'),
								((" . $page_id . "), 'write',		'" . _quote($rights) . "'),
								((" . $page_id . "), 'comment',		'$'),
								((" . $page_id . "), 'create',		'$'),
								((" . $page_id . "), 'upload',		'')";

		$insert_data[]	= [$page_insert,	$lang_global['ErrorInsertPage']];
		$insert_data[]	= [$perm_insert,	$lang_global['ErrorInsertPagePermission']];
	}

	$default_menu_item	= "INSERT INTO " .
								$prefix . "menu (
									user_id,
									page_id,
									menu_lang,
									menu_title
								)
							VALUES (
								(" . $owner_id . "),
								(" . $page_id . "),
								'" . _quote($lang) . "',
								'" . _quote($menu_title) . "'
							)
							ON DUPLICATE KEY UPDATE
								menu_title = '" . _quote($menu_title) . "'";

	if ($set_menu)
	{
		$insert_data[]	= [$default_menu_item,	$lang_global['ErrorInsertDefaultMenuItem']];
	}

	switch ($config_global['db_driver'])
	{
		case 'mysqli_legacy':
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

					/*
						We flag some pages as critical in the insert.**.php file, if these don't get inserted
						then we have a serious problem and should indicate that to the user.
					*/
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
				output_error(Ut::perc_replace($lang_global['ErrorPageAlreadyExists'], $tag));
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
						output_error(Ut::perc_replace($lang_global['ErrorPageAlreadyExists'], $tag));
					}
				}

				$result->closeCursor();
			}

			if (!$page_exists || $set_menu == SET_MENU_ONLY)
			{
				foreach ($insert_data as $data)
				{
					@$dblink_global->query($data[0]);

					/* try
					{
						@$dblink_global->query($data[0]);
					}
					catch(PDOException $error)
					{
						echo $error->getMessage() . '<br>';
					} */

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
