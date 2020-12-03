<?php

// setup header
function my_location()
{
	global $config;

	// run in tls mode?
	if (($config['tls']
		&& (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443'))
		|| ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
			|| (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443'))
	)
	{
		$config['base_url'] =	str_replace('http://', 'https://', $config['base_url']);
	}

	[$url, ] = explode('?', $config['base_url']);

	return $url;
}

// setup header
function write_config_hidden_nodes($skip_values)
{
	global $config;

	$config_parameters = array_diff_key($config, $skip_values, ['aliases' => '', 'groups' => '']);

	if (is_array($config_parameters))
	{
		foreach ($config_parameters as $key => $value)
		{
			if (is_array($value))
			{
				$value = implode(',', $value);
			}

			echo '<input type="hidden" name="config[' . $key . ']" value="' . $value . '">' . "\n";
		}
	}
}

function output_error($error_text = '')
{
	echo '<ul class="install_error"><li>' . $error_text . "</li></ul>";
}

// Draws a tick or cross next to a result
function output_image($ok)
{
	global $lang;

	return '<img src="' . my_location() . 'setup/image/spacer.png" width="20" height="20" alt="' . ($ok ? $lang['OK'] : $lang['Problem']) . '" title="' . ($ok ? $lang['OK'] : $lang['Problem']) . '" class="tickcross ' . ($ok ? 'tick' : 'cross') . '">';
}

// TODO: refactor -> same function as in wacko class
// site config
function available_languages()
{
	$lang_list = [];

	if ($handle = opendir('lang'))
	{
		while (false !== ($file = readdir($handle)))
		{
			if ($file != '.'
			&& $file != '..'
			&& $file != 'wacko.all.php'
			&& !is_dir('lang/' . $file)
			&& 1 == preg_match('/^wacko\.(.*?)\.php$/', $file, $match))
			{
				$lang_list[] = $match[1];
			}
		}

		closedir($handle);
	}

	sort($lang_list, SORT_STRING);

	return $lang_list;
}

// database install
function test($text, $condition, $error_text = '', $dblink = '')
{
	global $config;

	echo '<li>' . $text . '   ' . output_image($condition);

	if (!$condition)
	{
		if ($error_text)
		{
			$error_output = "\n" . '<ul class="install_error"><li>' . $error_text . '<br>';

			if ($config['database_driver'] == 'mysqli_legacy')
			{
				$error_output .= mysqli_error($dblink);
			}

			$error_output .= '</li></ul>';
			echo $error_output;
		}

		echo "</li>\n";
		return false;
	}

	echo "</li>\n";

	return true;
}

function test_pdo($text, $query, $errorText = '')
{
	global $dblink;

	try
	{
		test($text, $dblink->query($query), $errorText);
	}
	catch (PDOException $e)
	{
		test($text, false, $errorText);
	}
	catch (Exception $e)
	{
		test($text, false, $errorText);
	}
}

// write config
function array_to_str ($arr, $name = '')
{
	$entries	= '';
	$arrays		= '';

	$str = "\$wacko_config" . ($name ? "[\"" . $name . "\"]" : "") . " = [\n";

	foreach ($arr as $k => $v)
	{
		if (is_array($v))
		{
			$arrays .= array_to_str($v, $k);
		}
		else
		{
			$entries .= "\t'" . $k . '\' => \'' . str_replace("\n", "\\n", $v) . "',\n";
		}
	}

	$str .= $entries . "];\n";
	$str .= $arrays;

	return $str;
}

// insert pages

/*
insert default pages, all related acls and menu item
	$tag		=
	$title		=
	$body		=
	$lang		=
	$rights		=
	$critical	=
	$set_menu	=
	$menu_title	=
	$noindex	=
*/
function insert_page($tag, $title, $body, $lang, $rights = 'Admins', $critical = false, $set_menu = 0, $menu_title = false, $noindex = 1)
{
	global $config_global, $dblink_global, $lang_global;

	$prefix				= $config_global['table_prefix'];
	$page_select		= "SELECT page_id FROM " . $prefix . "page WHERE tag='" . _quote($tag) . "'";
	$owner_id			= "SELECT user_id FROM " . $prefix . "user WHERE user_name = 'System' LIMIT 1";
	$page_id			= "SELECT page_id FROM " . $prefix . "page WHERE tag = '" . _quote($tag) . "' LIMIT 1";

	if ($set_menu != SET_MENU_ONLY)
	{
		// user_id for user 'System'
		// we specify values for columns body_r (MEDIUMTEXT) and body_toc (TEXT) that don't have defaults
		// the additional parentheses around $owner_id and $page_id are necessary for the sub-select queries
		$page_insert		= "INSERT INTO " .
									$prefix . "page (tag, title, body, body_r, body_toc, user_id, owner_id, created, modified, latest, page_size, page_lang, footer_comments, footer_files, footer_rating, noindex)
								VALUES
									('" . _quote($tag) . "', '" . _quote($title) . "' , '" . _quote($body) . "', '', '', (" . $owner_id . "), (" . $owner_id . "), UTC_TIMESTAMP(), UTC_TIMESTAMP(), 1, " . strlen($body) . ", '" . _quote($lang) . "', 0, 0, 0, " . $noindex . ")";

		$perm_insert		= "INSERT INTO " .
									$prefix . "acl (page_id, privilege, list)
								VALUES
									((" . $page_id . "), 'read',		'*'),
									((" . $page_id . "), 'write',		'" . _quote($rights) . "'),
									((" . $page_id . "), 'comment',		'$'),
									((" . $page_id . "), 'create',		'$'),
									((" . $page_id . "), 'upload',		'')";

		$insert_data[]		= [$page_insert,	$lang_global['ErrorInsertPage']];
		$insert_data[]		= [$perm_insert,	$lang_global['ErrorInsertPagePermission']];
	}

	$default_menu_item		= "INSERT INTO " .
									$prefix . "menu (user_id, page_id, menu_lang, menu_title)
								VALUES
									((" . $owner_id . "), (" . $page_id . "), '" . _quote($lang) . "', '" . _quote($menu_title) . "')
								ON DUPLICATE KEY UPDATE
									menu_title = '" . _quote($menu_title) . "'";

	if ($set_menu)
	{
		$insert_data[]		= [$default_menu_item,	$lang_global['ErrorInsertDefaultMenuItem']];
	}

	switch ($config_global['database_driver'])
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
						We flag some pages as critical in the insert.**.php file, if these don't get inserted then we have a
						serious problem and should indicate that to the user.
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

// TODO: refactor -> same function as in dbal class
function _quote($string)
{
	global $config_global, $dblink_global;

	switch ($config_global['database_driver'])
	{
		case 'mysqli_legacy':

			return mysqli_real_escape_string($dblink_global, $string);

		break;

		default:
		// return $dblink->quote($string);

		// Manually string quoting since pdo::quote is double escaping single quotes which is causing chaos
		// Got this from: http://www.gamedev.net/community/forums/topic.asp?topic_id=448909
		// More reading: http://www.sitepoint.com/forums/showthread.php?t=337881
		return strtr($string, [
			"\x00"	=> '\x00',
			"\n"	=> '\n',
			"\r"	=> '\r',
			'\\'	=> '\\\\',
			"'"		=> "\'",
			'"'		=> '\"',
			"\x1a"	=> '\x1a'
		]);

		break;
	}
}

