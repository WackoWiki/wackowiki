<?php
function InsertPage($tag, $body, $lng, $rights = "Admins", $critical = false)
{
	GLOBAL $config, $dblink;
	$page_select = "SELECT * FROM ".$config["table_prefix"]."pages WHERE tag='".$tag."'";
	$page_insert = "INSERT INTO ".$config["table_prefix"]."pages (tag, supertag, body, user, owner, time, latest, lang) VALUES ('".$tag."', '".NpjTranslit($tag, $lng)."', '".$body."', 'WackoInstaller', '".$config["admin_name"]."', now(), 'Y', '".$lng."')";
	$perm_read_insert = "INSERT INTO ".$config["table_prefix"]."acls (page_tag, supertag, privilege, list) VALUES ('".$tag."', '".NpjTranslit($tag, $lng)."', 'read', '*')";
	$perm_write_insert = "INSERT INTO ".$config["table_prefix"]."acls (page_tag, supertag, privilege, list) VALUES ('".$tag."', '".NpjTranslit($tag, $lng)."', 'write', '".$rights."')";
	$perm_comment_insert = "INSERT INTO ".$config["table_prefix"]."acls (page_tag, supertag, privilege, list) VALUES ('".$tag."', '".NpjTranslit($tag, $lng)."', 'comment', '$')";

	switch($config["database_driver"])
	{
		case "mysql_legacy":
			if (0 == mysql_num_rows(mysql_query($page_select, $dblink)))
			{
				mysql_query($page_insert, $dblink);
				mysql_query($perm_read_insert, $dblink);
				mysql_query($perm_write_insert, $dblink);
				mysql_query($perm_comment_insert, $dblink);
			}
			break;
		case "mysqli_legacy":
			if (0 == mysqli_num_rows(mysqli_query($dblink, $page_select)))
			{
				/*
				 We flag some pages as critical in the insert.**.php file, if these don't get inserted then we have a
				 serious problem and should indicate that to the user.
				 */

				if($critical)
				{
					mysqli_query($dblink, $page_insert);
					if(mysqli_errno($dblink) != 0)
					{
						outputError(str_replace("%1", $tag, $lang["ErrorInsertingPage"])." - ".mysqli_error($dblink));
					}

					mysqli_query($dblink, $perm_read_insert);
					if(mysqli_errno($dblink) != 0)
					{
						outputError(str_replace("%1", $tag, $lang["ErrorInsertingPageReadPermission"])." - ".mysqli_error($dblink));
					}

					mysqli_query($dblink, $perm_write_insert);
					if(mysqli_errno($dblink) != 0)
					{
						outputError(str_replace("%1", $tag, $lang["ErrorInsertingPageWritePermission"])." - ".mysqli_error($dblink));
					}

					mysqli_query($dblink, $perm_comment_insert);
					if(mysqli_errno($dblink) != 0)
					{
						outputError(str_replace("%1", $tag, $lang["ErrorInsertingPageCommentPermission"])." - ".mysqli_error($dblink));
					}
				}
				else
				{
					mysqli_query($dblink, $page_insert);
					mysqli_query($dblink, $perm_read_insert);
					mysqli_query($dblink, $perm_write_insert);
					mysqli_query($dblink, $perm_comment_insert);
				}
			}
			else if($critical)
			{
				outputError(str_replace("%1", $tag, $lang["ErrorPageAlreadyExists"]));
			}
			break;
		default:
			$page_exists = false;

			if($result = @$dblink->query($page_select))
			{
				if ($result->fetchColumn() > 0)
				{
					$page_exists = true;
					outputError(str_replace("%1", $tag, $lang["ErrorPageAlreadyExists"]));
				}

				$result->closeCursor();
			}

			if(!$page_exists)
			{
				if($critical)
				{
					@$dblink->query($page_insert);
					$error = $dblink->errorInfo();
					if($error[0] != "00000")
					{
						outputError(str_replace("%1", $tag, $lang["ErrorInsertingPage"])." - ".($error[2]));
					}

					@$dblink->query($perm_read_insert);
					$error = $dblink->errorInfo();
					if($error[0] != "00000")
					{
						outputError(str_replace("%1", $tag, $lang["ErrorInsertingPageReadPermission"])." - ".($error[2]));
					}

					@$dblink->query($perm_write_insert);
					$error = $dblink->errorInfo();
					if($error[0] != "00000")
					{
						outputError(str_replace("%1", $tag, $lang["ErrorInsertingPageWritePermission"])." - ".($error[2]));
					}

					@$dblink->query($perm_comment_insert);
					$error = $dblink->errorInfo();
					if($error[0] != "00000")
					{
						outputError(str_replace("%1", $tag, $lang["ErrorInsertingPageCommentPermission"])." - ".($error[2]));
					}
				}
				else
				{
					@$dblink->query($page_insert);
					@$dblink->query($perm_read_insert);
					@$dblink->query($perm_write_insert);
					@$dblink->query($perm_comment_insert);
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
		GLOBAL $languages;

	if ( !$languages[$lng] )
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

$error_inserting_pages = false;

require_once("setup/lang/inserts.".$config["language"].".php");

if ( $config["multilanguage"] ) {
	$handle = opendir("setup/lang");
	while (false !== ($file = readdir($handle)))
	if(1 == preg_match("/^inserts\.(.*?)\.php$/",$file,$match))
	$langlist[] = $match[1];

	closedir($handle);

	foreach ($langlist as $_lang) {
		unset($lng);
		unset($languages);
		require_once("setup/lang/inserts.".$_lang.".php");
	}
}
?>
