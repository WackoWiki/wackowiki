<?php

//  Needed (for some reason) to allow config variables to be accessed within InsertPages.
global $config_global, $dblink_global, $lang_global;
$config_global = $config;
$dblink_global = $dblink;
$lang_global = $lang;

function InsertPage($tag, $title = false, $body, $lng, $rights = "Admins", $critical = false)
{
	global $config_global, $dblink_global, $lang_global;

	$page_select = "SELECT * FROM ".$config_global["table_prefix"]."page WHERE tag='".$tag."'";
	$owner_id = "SELECT user_id FROM ".$config_global["table_prefix"]."user WHERE user_name = 'System' LIMIT 1";
	# if ($title == false) $title = AddSpacesTitle(trim(substr($tag, strrpos($tag, '/')), '/'), $lng);

	// user_id for user System
	$page_insert = "INSERT INTO ".$config_global["table_prefix"]."page (tag, supertag, title, body, user_id, owner_id, created, modified, latest, lang, hide_comments, hide_files, hide_rating) VALUES ('".$tag."', '".NpjTranslit($tag, $lng)."', '".$title."' , '".$body."', (".$owner_id."), (".$owner_id."), NOW(), NOW(), '1', '".$lng."', '1', '1', '1')";

	$page_id = "SELECT page_id FROM ".$config_global["table_prefix"]."page WHERE tag = '".$tag."' LIMIT 1";

	$perm_read_insert = "INSERT INTO ".$config_global["table_prefix"]."acl (page_id, privilege, list) VALUES ((".$page_id."), 'read', '*')";
	$perm_write_insert = "INSERT INTO ".$config_global["table_prefix"]."acl (page_id, privilege, list) VALUES ((".$page_id."), 'write', '".$rights."')";
	$perm_comment_insert = "INSERT INTO ".$config_global["table_prefix"]."acl (page_id, privilege, list) VALUES ((".$page_id."), 'comment', '$')";

	switch($config_global["database_driver"])
	{
		case "mysql_legacy":
			if (0 == mysql_num_rows(mysql_query($page_select, $dblink_global)))
			{
				mysql_query($page_insert, $dblink_global);
				mysql_query($perm_read_insert, $dblink_global);
				mysql_query($perm_write_insert, $dblink_global);
				mysql_query($perm_comment_insert, $dblink_global);
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
						outputError(str_replace("%1", $tag, $lang_global["ErrorInsertingPage"])." - ".mysqli_error($dblink_global));
					}

					mysqli_query($dblink_global, $perm_read_insert);
					if(mysqli_errno($dblink_global) != 0)
					{
						outputError(str_replace("%1", $tag, $lang_global["ErrorInsertingPageReadPermission"])." - ".mysqli_error($dblink_global));
					}

					mysqli_query($dblink_global, $perm_write_insert);
					if(mysqli_errno($dblink_global) != 0)
					{
						outputError(str_replace("%1", $tag, $lang_global["ErrorInsertingPageWritePermission"])." - ".mysqli_error($dblink_global));
					}

					mysqli_query($dblink_global, $perm_comment_insert);
					if(mysqli_errno($dblink_global) != 0)
					{
						outputError(str_replace("%1", $tag, $lang_global["ErrorInsertingPageCommentPermission"])." - ".mysqli_error($dblink_global));
					}
				}
				else
				{
					mysqli_query($dblink_global, $page_insert);
					mysqli_query($dblink_global, $perm_read_insert);
					mysqli_query($dblink_global, $perm_write_insert);
					mysqli_query($dblink_global, $perm_comment_insert);
				}
			}
			else if($critical)
			{
				outputError(str_replace("%1", $tag, $lang_global["ErrorPageAlreadyExists"]));
			}
			break;
		default:
			$page_exists = false;

			if($result = @$dblink_global->query($page_select))
			{
				if ($result->fetchColumn() > 0)
				{
					$page_exists = true;
					outputError(str_replace("%1", $tag, $lang_global["ErrorPageAlreadyExists"]));
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
						outputError(str_replace("%1", $tag, $lang_global["ErrorInsertingPage"])." - ".($error[2]));
					}

					@$dblink_global->query($perm_read_insert);
					$error = $dblink_global->errorInfo();
					if($error[0] != "00000")
					{
						outputError(str_replace("%1", $tag, $lang_global["ErrorInsertingPageReadPermission"])." - ".($error[2]));
					}

					@$dblink_global->query($perm_write_insert);
					$error = $dblink_global->errorInfo();
					if($error[0] != "00000")
					{
						outputError(str_replace("%1", $tag, $lang_global["ErrorInsertingPageWritePermission"])." - ".($error[2]));
					}

					@$dblink_global->query($perm_comment_insert);
					$error = $dblink_global->errorInfo();
					if($error[0] != "00000")
					{
						outputError(str_replace("%1", $tag, $lang_global["ErrorInsertingPageCommentPermission"])." - ".($error[2]));
					}
				}
				else
				{
					@$dblink_global->query($page_insert);
					@$dblink_global->query($perm_read_insert);
					@$dblink_global->query($perm_write_insert);
					@$dblink_global->query($perm_comment_insert);
				}
			}
			break;
	}
}

function NpjTranslit($tag, $lng)
{
	$language = SetLanguage($lng);

	$tag = str_replace( "//", "/", $tag );
	$tag = str_replace( "-", "", $tag );
	$tag = str_replace( " ", "", $tag );
	$tag = str_replace( "'", "_", $tag );

	$tag = @strtr( $tag, $language["NpjLettersFrom"], $language["NpjLettersTo"] );
	$tag = @strtr( $tag, $language["NpjBiLetters"] );
	$tag = strtolower( $tag );

	return rtrim($tag, "/");
}

function SetLanguage($lng)
{
	global $config, $language, $languages;

	if ( !isset($languages[$lng]) )
	{
		$resourcefile = "lang/lang.".$lng.".php";
		if (@file_exists($resourcefile)) include($resourcefile);
		$languages[$lng] = $wackoLanguage;
	}

	$language = &$languages[$lng];
	setlocale(LC_CTYPE,$language["locale"]);
	$language["locale"] = setlocale(LC_CTYPE,0);
	return $language;
}

// Inserting base pages
$error_inserting_pages = false;

require_once("setup/lang/inserts.".$config["language"].".php");

if ( $config["multilanguage"] )
{
	$handle = opendir("setup/lang");
	while (false !== ($file = readdir($handle)))
	if(1 == preg_match("/^inserts\.(.*?)\.php$/",$file,$match))
		$langlist[] = $match[1];

	closedir($handle);

	foreach ($langlist as $_lang)
	{
		unset($lng);
		unset($languages);
		require_once("setup/lang/inserts.".$_lang.".php");
	}
}

?>