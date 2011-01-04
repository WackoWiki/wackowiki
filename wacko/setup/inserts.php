<?php

//  Needed (for some reason) to allow config variables to be accessed within insert_pages.
global $config_global, $dblink_global, $lang_global;
$config_global = $config;
$dblink_global = $dblink;
$lang_global = $lang;

function insert_page($tag, $title = false, $body, $lng, $rights = 'Admins', $critical = false, $is_bookmark = false, $bm_title = false)
{
	global $config_global, $dblink_global, $lang_global;

	$page_select			= "SELECT * FROM ".$config_global['table_prefix']."page WHERE tag='".$tag."'";
	$owner_id				= "SELECT user_id FROM ".$config_global['table_prefix']."user WHERE user_name = 'System' LIMIT 1";
	# if ($title == false) $title = add_spaces_title(trim(substr($tag, strrpos($tag, '/')), '/'), $lng);

	// user_id for user System
	$page_insert			= "INSERT INTO ".$config_global['table_prefix']."page (tag, supertag, title, body, user_id, owner_id, created, modified, latest, lang, hide_comments, hide_files, hide_rating) VALUES ('".$tag."', '".npj_translit($tag, $lng)."', '".$title."' , '".$body."', (".$owner_id."), (".$owner_id."), NOW(), NOW(), '1', '".$lng."', '1', '1', '1')";

	$page_id				= "SELECT page_id FROM ".$config_global['table_prefix']."page WHERE tag = '".$tag."' LIMIT 1";

	$perm_read_insert		= "INSERT INTO ".$config_global['table_prefix']."acl (page_id, privilege, list) VALUES ((".$page_id."), 'read', '*')";
	$perm_write_insert		= "INSERT INTO ".$config_global['table_prefix']."acl (page_id, privilege, list) VALUES ((".$page_id."), 'write', '".$rights."')";
	$perm_comment_insert	= "INSERT INTO ".$config_global['table_prefix']."acl (page_id, privilege, list) VALUES ((".$page_id."), 'comment', '$')";
	$perm_create_insert		= "INSERT INTO ".$config_global['table_prefix']."acl (page_id, privilege, list) VALUES ((".$page_id."), 'create', '$')";
	$perm_upload_insert		= "INSERT INTO ".$config_global['table_prefix']."acl (page_id, privilege, list) VALUES ((".$page_id."), 'upload', '')";

	$default_bookmark		= "INSERT INTO ".$config_global['table_prefix']."bookmark (user_id, page_id, lang, bm_title) VALUES ((".$owner_id."), (".$page_id."), '".$lng."', '".$bm_title."')";
	#$site_bookmark			= "INSERT INTO ".$config_global['table_prefix']."bookmark (user_id, page_id, lang, bm_title) VALUES ((".$owner_id."), (".$page_id."), '".$lng."', '".$bm_title."')";

	switch($config_global['database_driver'])
	{
		case "mysql_legacy":
			if (0 == mysql_num_rows(mysql_query($page_select, $dblink_global)))
			{
				// page
				mysql_query($page_insert, $dblink_global);
				// rights
				mysql_query($perm_read_insert, $dblink_global);
				mysql_query($perm_write_insert, $dblink_global);
				mysql_query($perm_comment_insert, $dblink_global);
				mysql_query($perm_create_insert, $dblink_global);
				mysql_query($perm_upload_insert, $dblink_global);

				if($is_bookmark)
				{
					mysql_query($default_bookmark, $dblink_global);
				}
			}
			break;
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

					if($is_bookmark)
					{
						mysqli_query($dblink_global, $default_bookmark);
						if(mysqli_errno($dblink_global) != 0)
						{
							output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingDefaultBookmark'])." - ".mysqli_error($dblink_global));
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

					if($is_bookmark)
					{
						mysqli_query($dblink_global, $default_bookmark);
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

					if($is_bookmark)
					{
						@$dblink_global->query($default_bookmark);
						$error = $dblink_global->errorInfo();
						if($error[0] != "00000")
						{
							output_error(str_replace('%1', $tag, $lang_global['ErrorInsertingDefaultBookmark'])." - ".($error[2]));
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

					if($is_bookmark)
					{
						@$dblink_global->query($default_bookmark);
					}
				}
			}
			break;
	}
}

function npj_translit($tag, $lng)
{
	$language = set_language($lng);

	$tag = str_replace( '//', '/', $tag );
	$tag = str_replace( '-', '', $tag );
	$tag = str_replace( ' ', '', $tag );
	$tag = str_replace( "'", '_', $tag );

	$tag = @strtr( $tag, $language['NpjLettersFrom'], $language['NpjLettersTo'] );
	$tag = @strtr( $tag, $language['NpjBiLetters'] );
	$tag = strtolower( $tag );

	return rtrim($tag, '/');
}

function set_language($lng)
{
	global $config, $language, $languages;

	if ( !isset($languages[$lng]) )
	{
		$resourcefile = 'lang/lang.'.$lng.'.php';
		if (@file_exists($resourcefile)) include($resourcefile);
		$languages[$lng] = $wacko_language;
	}

	$language = &$languages[$lng];
	setlocale(LC_CTYPE,$language['locale']);
	$language['locale'] = setlocale(LC_CTYPE,0);
	return $language;
}

// Inserting base pages
$error_inserting_pages = false;

require_once('setup/lang/inserts.'.$config['language'].'.php');

if ( isset($config['multilanguage']) )
{
	$handle = opendir('setup/lang');
	while (false !== ($file = readdir($handle)))
	if(1 == preg_match('/^inserts\.(.*?)\.php$/', $file, $match))
		$langlist[] = $match[1];

	closedir($handle);

	foreach ($langlist as $_lang)
	{
		unset($lng);
		unset($languages);
		require_once('setup/lang/inserts.'.$_lang.'.php');
	}
}

?>