<?php

// setup header
function my_location()
{
	global $config;

	// run in tls mode?
	if ( ($config['tls'] == true
		&& ( ( ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' )
				&& !empty($config['tls_proxy']) )
			|| ( isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ) ) )
		|| ( ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' )
			|| ( isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ) )
	)
	{
		$config['base_url'] =	str_replace('http://', 'https://'.($config['tls_proxy'] ? $config['tls_proxy'].'/' : ''), $config['base_url']);
	}

	list($url, ) = explode('?', $config['base_url']);

	return $url;
}

// setup header
function write_config_hidden_nodes($skip_values)
{
	global $config;

	$config_parameters = array_diff_key($config, $skip_values, array('aliases' => ''));

	if (is_array($config_parameters))
	{
		foreach ($config_parameters as $key => $value)
		{
			if (is_array($value))
			{
				$value = implode(',', $value);
			}

			echo '   <input type="hidden" name="config['.$key.']" value="'.$value.'" />' . "\n";
		}
	}
}

function output_error($error_text = '')
{
	echo '<ul class="install_error"><li>'.$error_text."</li></ul>";
}

// Draws a tick or cross next to a result
function output_image($ok)
{
	global $lang;

	return '<img src="'.my_location().'setup/image/spacer.png" width="20" height="20" alt="'.($ok ? $lang['OK'] : $lang['Problem']).'" title="'.($ok ? $lang['OK'] : $lang['Problem']).'" class="tickcross '.($ok ? 'tick' : 'cross').'" />';
}

// TODO: refactoring - same function in wacko class
// database install
function random_seed($length, $seed_complexity)
{
	$chars_uc	= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$chars_lc	= 'abcdefghijklmnopqrstuvwxyz';
	$digits		= '0123456789';
	$symbols	= '-_!@#%^&*(){}[]|~'; // removed '$'
	$uc = 0;
	$lc = 0;
	$di = 0;
	$sy = 0;

	if ($seed_complexity == 2)
	{
		$sy = 100;
	}

	while ($uc == 0 || $lc == 0 || $di == 0 || $sy == 0)
	{
		$seed = '';

		for ($i = 0; $i < $length; $i++)
		{
			$k = rand(0, $seed_complexity);  //randomly choose what's next

			if ($k == 0)
			{
				//uppercase
				$seed .= substr(str_shuffle($chars_uc), rand(0, count($chars_uc) - 2), 1);
				$uc++;
			}

			if ($k == 1)
			{
				//lowercase
				$seed .= substr(str_shuffle($chars_lc), rand(0, count($chars_lc) - 2), 1);
				$lc++;
			}

			if ($k == 2)
			{
				//digits
				$seed .= substr(str_shuffle($digits), rand(0, count($digits) - 2), 1);
				$di++;
			}

			if ($k == 3)
			{
				//symbols
				$seed .= substr(str_shuffle($symbols), rand(0, count($symbols) - 2), 1);
				$sy++;
			}
		}
	}

	return $seed;
}

// TODO: refactor -> same function as in wacko class
// site config
function available_languages()
{
	$handle = opendir('lang');

	while (false !== ($file = readdir($handle)))
	{
		if ($file != '.'
		&& $file != '..'
		&& $file != 'wacko.all.php'
		&& !is_dir('lang/'.$file)
		&& 1 == preg_match('/^wacko\.(.*?)\.php$/', $file, $match))
		{
			$lang_list[] = $match[1];
		}
	}

	closedir($handle);
	sort($lang_list, SORT_STRING);

	return $lang_list;
}

// database install
function test($text, $condition, $error_text = '', $dblink = '')
{
	global $lang;
	global $config;
	global $dblink;

	echo "            <li>".$text."   ".output_image($condition);

	if(!$condition)
	{
		if($error_text)
		{
			$error_output = "\n".'<ul class="install_error"><li>'.$error_text." <br />";

			if ($config['database_driver'] == 'mysqli_legacy')
			{
				$error_output .= mysqli_error($dblink);
			}

			$error_output .= "</li></ul>";
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
	catch(PDOException $e)
	{
		test($text, false, $errorText);
	}
	catch(Exception $e)
	{
		test($text, false, $errorText);
	}
}

// write config
function array_to_str ($arr, $name = '')
{
	$entries	= '';
	$arrays		= '';

	$str = "\$wacko_config".($name ? "[\"".$name."\"]" : "")." = array(\n";

	foreach ($arr as $k => $v)
	{
		if(is_array($v))
		{
			$arrays .= array_to_str($v, $k);
		}
		else
		{
			$entries .= "\t'".$k.'\' => \''.str_replace("\n", "\\n", $v)."',\n";
		}
	}

	$str .= $entries.");\n";
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
	$is_menu	=
	$menu_title	=
	$noindex	=
*/
function insert_page($tag, $title = false, $body, $lang, $rights = 'Admins', $critical = false, $is_menu = false, $menu_title = false, $noindex = 1)
{
	global $config_global, $dblink_global, $lang_global;

	$page_select				= "SELECT page_id FROM ".$config_global['table_prefix']."page WHERE tag='".$tag."'";
	$owner_id					= "SELECT user_id FROM ".$config_global['table_prefix']."user WHERE user_name = 'System' LIMIT 1";

	// user_id for user System
	$page_insert				= "INSERT INTO ".$config_global['table_prefix']."page (tag, supertag, title, body, user_id, owner_id, created, modified, latest, page_lang, footer_comments, footer_files, footer_rating, noindex) VALUES ('".$tag."', '".translit($tag, $lang)."', '".$title."' , '".$body."', (".$owner_id."), (".$owner_id."), NOW(), NOW(), '1', '".$lang."', '0', '0', '0', '".$noindex."')";

	$page_id					= "SELECT page_id FROM ".$config_global['table_prefix']."page WHERE tag = '".$tag."' LIMIT 1";

	$perm_read_insert			= "INSERT INTO ".$config_global['table_prefix']."acl (page_id, privilege, list) VALUES ((".$page_id."), 'read', '*')";
	$perm_write_insert			= "INSERT INTO ".$config_global['table_prefix']."acl (page_id, privilege, list) VALUES ((".$page_id."), 'write', '".$rights."')";
	$perm_comment_insert		= "INSERT INTO ".$config_global['table_prefix']."acl (page_id, privilege, list) VALUES ((".$page_id."), 'comment', '$')";
	$perm_create_insert			= "INSERT INTO ".$config_global['table_prefix']."acl (page_id, privilege, list) VALUES ((".$page_id."), 'create', '$')";
	$perm_upload_insert			= "INSERT INTO ".$config_global['table_prefix']."acl (page_id, privilege, list) VALUES ((".$page_id."), 'upload', '')";

	$default_menu_item			= "INSERT INTO ".$config_global['table_prefix']."menu (user_id, page_id, menu_lang, menu_title) VALUES ((".$owner_id."), (".$page_id."), '".$lang."', '".$menu_title."')";
	#$site_menu_item			= "INSERT INTO ".$config_global['table_prefix']."menu (user_id, page_id, menu_lang, menu_title) VALUES ((".$owner_id."), (".$page_id."), '".$lang."', '".$menu_title."')";

	switch($config_global['database_driver'])
	{
		case "mysqli_legacy":
			if (0 == mysqli_num_rows(mysqli_query($dblink_global, $page_select)))
			{
				/*
				 We flag some pages as critical in the insert.**.php file, if these don't get inserted then we have a
				 serious problem and should indicate that to the user.
				 */

				if($critical)
				{
					mysqli_query($dblink_global, $page_insert);

					if(mysqli_errno($dblink_global) != 0)
					{
						output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingPage'])." - ".mysqli_error($dblink_global));
					}

					mysqli_query($dblink_global, $perm_read_insert);

					if(mysqli_errno($dblink_global) != 0)
					{
						output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingPageReadPermission'])." - ".mysqli_error($dblink_global));
					}

					mysqli_query($dblink_global, $perm_write_insert);

					if(mysqli_errno($dblink_global) != 0)
					{
						output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingPageWritePermission'])." - ".mysqli_error($dblink_global));
					}

					mysqli_query($dblink_global, $perm_comment_insert);

					if(mysqli_errno($dblink_global) != 0)
					{
						output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingPageCommentPermission'])." - ".mysqli_error($dblink_global));
					}

					mysqli_query($dblink_global, $perm_create_insert);

					if(mysqli_errno($dblink_global) != 0)
					{
						output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingPageCreatePermission'])." - ".mysqli_error($dblink_global));
					}

					mysqli_query($dblink_global, $perm_upload_insert);

					if(mysqli_errno($dblink_global) != 0)
					{
						output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingPageUploadPermission'])." - ".mysqli_error($dblink_global));
					}

					if($is_menu)
					{
						mysqli_query($dblink_global, $default_menu_item);

						if(mysqli_errno($dblink_global) != 0)
						{
							output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingDefaultMenuItem'])." - ".mysqli_error($dblink_global));
						}
					}
				}
				else
				{
					// page
					mysqli_query($dblink_global, $page_insert);
					// rights
					mysqli_query($dblink_global, $perm_read_insert);
					mysqli_query($dblink_global, $perm_write_insert);
					mysqli_query($dblink_global, $perm_comment_insert);
					mysqli_query($dblink_global, $perm_create_insert);
					mysqli_query($dblink_global, $perm_upload_insert);

					if($is_menu)
					{
						mysqli_query($dblink_global, $default_menu_item);
					}
				}
			}
			else if($critical)
			{
				output_error(str_replace('%1', $tag, $lang_global['ErrorPageAlreadyExists']));
			}

			break;

		default:
			$page_exists = false;

			if($result = @$dblink_global->query($page_select))
			{
				if ($result->fetchColumn() > 0)
				{
					$page_exists = true;
					output_error(str_replace('%1', $tag, $lang_global['ErrorPageAlreadyExists']));
				}

				$result->closeCursor();
			}

			if(!$page_exists)
			{
				if($critical)
				{
					@$dblink_global->query($page_insert);
					$error = $dblink_global->errorInfo();

					if($error[0] != "00000")
					{
						output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingPage'])." - ".($error[2]));
					}

					@$dblink_global->query($perm_read_insert);
					$error = $dblink_global->errorInfo();

					if($error[0] != "00000")
					{
						output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingPageReadPermission'])." - ".($error[2]));
					}

					@$dblink_global->query($perm_write_insert);
					$error = $dblink_global->errorInfo();

					if($error[0] != "00000")
					{
						output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingPageWritePermission'])." - ".($error[2]));
					}

					@$dblink_global->query($perm_comment_insert);
					$error = $dblink_global->errorInfo();

					if($error[0] != "00000")
					{
						output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingPageCommentPermission'])." - ".($error[2]));
					}

					@$dblink_global->query($perm_create_insert);
					$error = $dblink_global->errorInfo();

					if($error[0] != "00000")
					{
						output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingPageCreatePermission'])." - ".($error[2]));
					}

					@$dblink_global->query($perm_upload_insert);
					$error = $dblink_global->errorInfo();

					if($error[0] != "00000")
					{
						output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingPageUploadPermission'])." - ".($error[2]));
					}

					if($is_menu)
					{
						@$dblink_global->query($default_menu_item);
						$error = $dblink_global->errorInfo();

						if($error[0] != "00000")
						{
							output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingDefaultMenuItem'])." - ".($error[2]));
						}
					}
				}
				else
				{
					// page
					@$dblink_global->query($page_insert);
					// rights
					@$dblink_global->query($perm_read_insert);
					@$dblink_global->query($perm_write_insert);
					@$dblink_global->query($perm_comment_insert);
					@$dblink_global->query($perm_create_insert);
					@$dblink_global->query($perm_upload_insert);

					if($is_menu)
					{
						@$dblink_global->query($default_menu_item);
					}
				}
			}

			break;
	}
}

function set_language($lang)
{
	global $config, $language, $languages;

	if ( !isset($languages[$lang]) )
	{
		$lang_file = 'lang/lang.'.$lang.'.php';

		if (@file_exists($lang_file))
		{
			include($lang_file);
		}

		$languages[$lang] = $wacko_language;
	}

	$language = &$languages[$lang];
	setlocale(LC_CTYPE,$language['locale']);
	$language['locale'] = setlocale(LC_CTYPE,0);

	return $language;
}

// TODO: refactor -> same function as in wacko class
function translit($tag, $lang)
{
	$language = set_language($lang);

	$tag = str_replace( '//', '/', $tag );
	$tag = str_replace( '-', '', $tag );
	$tag = str_replace( ' ', '', $tag );
	$tag = str_replace( "'", '_', $tag );

	$tag = @strtr( $tag, $language['TranslitLettersFrom'], $language['TranslitLettersTo'] );
	$tag = @strtr( $tag, $language['TranslitBiLetters'] );
	$tag = strtolower( $tag );

	return rtrim($tag, '/');
}

?>