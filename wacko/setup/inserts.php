<?php

//  Needed (for some reason) to allow config variables to be accessed within insert_pages.
global $config_global, $dblink_global, $lang_global;
$config_global	= $config;
$dblink_global	= $dblink;
$lang_global	= $lang;

// TODO: mysqli / mysql pdo
// indicate what character set the client will use to send SQL statements to the server
switch($config_global['database_driver'])
{
	case "mysqli_legacy":
		mysqli_set_charset($dblink, $config['database_charset']);
		break;
}

function insert_page($tag, $title = false, $body, $lang, $rights = 'Admins', $critical = false, $is_menu = false, $menu_title = false)
{
	global $config_global, $dblink_global, $lang_global;

	$page_select			= "SELECT page_id FROM ".$config_global['table_prefix']."page WHERE tag='".$tag."'";
	$owner_id				= "SELECT user_id FROM ".$config_global['table_prefix']."user WHERE user_name = 'System' LIMIT 1";

	// user_id for user System
	$page_insert			= "INSERT INTO ".$config_global['table_prefix']."page (tag, supertag, title, body, user_id, owner_id, created, modified, latest, lang, footer_comments, footer_files, footer_rating) VALUES ('".$tag."', '".translit($tag, $lang)."', '".$title."' , '".$body."', (".$owner_id."), (".$owner_id."), NOW(), NOW(), '1', '".$lang."', '0', '0', '0')";

	$page_id				= "SELECT page_id FROM ".$config_global['table_prefix']."page WHERE tag = '".$tag."' LIMIT 1";

	$perm_read_insert		= "INSERT INTO ".$config_global['table_prefix']."acl (page_id, privilege, list) VALUES ((".$page_id."), 'read', '*')";
	$perm_write_insert		= "INSERT INTO ".$config_global['table_prefix']."acl (page_id, privilege, list) VALUES ((".$page_id."), 'write', '".$rights."')";
	$perm_comment_insert	= "INSERT INTO ".$config_global['table_prefix']."acl (page_id, privilege, list) VALUES ((".$page_id."), 'comment', '$')";
	$perm_create_insert		= "INSERT INTO ".$config_global['table_prefix']."acl (page_id, privilege, list) VALUES ((".$page_id."), 'create', '$')";
	$perm_upload_insert		= "INSERT INTO ".$config_global['table_prefix']."acl (page_id, privilege, list) VALUES ((".$page_id."), 'upload', '')";

	$default_menu_item		= "INSERT INTO ".$config_global['table_prefix']."menu (user_id, page_id, lang, menu_title) VALUES ((".$owner_id."), (".$page_id."), '".$lang."', '".$menu_title."')";
	#$site_menu_item			= "INSERT INTO ".$config_global['table_prefix']."menu (user_id, page_id, lang, menu_title) VALUES ((".$owner_id."), (".$page_id."), '".$lang."', '".$menu_title."')";

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

function set_language($lang)
{
	global $config, $language, $languages;

	if ( !isset($languages[$lang]) )
	{
		$lang_file = 'lang/lang.'.$lang.'.php';
		if (@file_exists($lang_file)) include($lang_file);
		$languages[$lang] = $wacko_language;
	}

	$language = &$languages[$lang];
	setlocale(LC_CTYPE,$language['locale']);
	$language['locale'] = setlocale(LC_CTYPE,0);
	return $language;
}

// Inserting base pages
$error_inserting_pages = false;

require_once('setup/lang/inserts.'.$config['language'].'.php');

if ( isset($config['multilanguage']) && $config['multilanguage'] == 1)
{
	$handle = opendir('setup/lang');

	while (false !== ($file = readdir($handle)))
	{
		if(1 == preg_match('/^inserts\.(.*?)\.php$/', $file, $match))
		{
			$lang_list[] = $match[1];
		}
	}

	closedir($handle);

	foreach ($lang_list as $_lang)
	{
		unset($lang);
		unset($languages);
		require_once('setup/lang/inserts.'.$_lang.'.php');
	}
}

?>