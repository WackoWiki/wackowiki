<?php
@set_time_limit(0);
@ignore_user_abort(true);

// test configuration
echo "         <h2>".$lang['TestingConfiguration']."</h2>\n";

// Generic Default Inserts
if ($config['system_seed'] == '')
{
	$config['system_seed'] = random_seed(20, 3);
}

$salt_user_form			= random_seed(10, 3);
$password_hashed		= $config['admin_name'].$_POST['password'];
$password_hashed		= password_hash(
								base64_encode(
										hash('sha256', $password_hashed, true)
										),
								PASSWORD_DEFAULT
								);

$delete_table			= array();
$create_table			= array();
$insert_records			= array();
$upgrade				= array();

require_once('setup/insert_default.php');
require_once('setup/insert_config.php');

/*
 Setup the tables depending on which database we selected

 mysqli_legacy
 or pdo which is the default clause
 */

$port			= trim($config['database_port']);
$fatal_error	= false;

// check WackoWiki version
if (!isset($config['wacko_version']))
{
	$config['wacko_version'] = '';
}

if (!$version = trim($config['wacko_version']))
{
	$version = '0';
}

if (isset($config['wacko_version']))
{
	if (trim($config['wacko_version']))
	{
		$version = trim($config['wacko_version']);
	}
}

if ($config['database_driver'] == ('mysqli_legacy' || 'mysql_pdo'))
{
	// mariadb / mysql only
	require_once('setup/database_mysql.php');
	require_once('setup/database_mysql_updates.php');
}
/* else if  ($config['database_driver'] == 'pgsql')
{
	require_once('setup/database_pgsql.php');
} */

// add install array for all e.g. mysqli, mysql_pdo, etc.

// delete_tables
//		$value[0] - table name
//		$value[1] - SQL query
$delete_table[]		= array('acl',				$table_acl_drop);
$delete_table[]		= array('auth_token',		$table_auth_token_drop);
$delete_table[]		= array('menu',				$table_menu_drop);
$delete_table[]		= array('cache',			$table_cache_drop);
$delete_table[]		= array('config',			$table_config_drop);
$delete_table[]		= array('usergroup',		$table_usergroup_drop);
$delete_table[]		= array('usergroup_member',	$table_usergroup_member_drop);
$delete_table[]		= array('category',			$table_category_drop);
$delete_table[]		= array('category_page',	$table_category_page_drop);
$delete_table[]		= array('file_link',		$table_file_link_drop);
$delete_table[]		= array('link',				$table_link_drop);
$delete_table[]		= array('log',				$table_log_drop);
$delete_table[]		= array('page',				$table_page_drop);
$delete_table[]		= array('poll',				$table_poll_drop);
$delete_table[]		= array('rating',			$table_rating_drop);
$delete_table[]		= array('referrer',			$table_referrer_drop);
$delete_table[]		= array('revision',			$table_revision_drop);
#$delete_table[]	= array('tag',				$table_tag_drop);
#$delete_table[]	= array('tag_page',			$table_tag_page_drop);
$delete_table[]		= array('upload',			$table_upload_drop);
$delete_table[]		= array('user',				$table_user_drop);
$delete_table[]		= array('user_setting',		$table_user_setting_drop);
$delete_table[]		= array('watch',			$table_watch_drop);
$delete_table[]		= array('word',				$table_word_drop);

// INSTALL
// create tables
//		$value[0] - table name
//		$value[1] - SQL query
$create_table[]		= array('acl',				$table_acl);
$create_table[]		= array('auth_token',		$table_auth_token);
$create_table[]		= array('menu',				$table_menu);
$create_table[]		= array('cache',			$table_cache);
$create_table[]		= array('config',			$table_config);
$create_table[]		= array('usergroup',		$table_usergroup);
$create_table[]		= array('usergroup_member',	$table_usergroup_member);
$create_table[]		= array('category',			$table_category);
$create_table[]		= array('category_page',	$table_category_page);
$create_table[]		= array('file_link',		$table_file_link);
$create_table[]		= array('link',				$table_link);
$create_table[]		= array('log',				$table_log);
$create_table[]		= array('page',				$table_page);
$create_table[]		= array('poll',				$table_poll);
$create_table[]		= array('rating',			$table_rating);
$create_table[]		= array('referrer',			$table_referrer);
$create_table[]		= array('revision',			$table_revision);
#$create_table[]	= array('tag',				$table_tag);
#$create_table[]	= array('tag_page',			$table_tag_page);
$create_table[]		= array('upload',			$table_upload);
$create_table[]		= array('user',				$table_user);
$create_table[]		= array('user_setting',		$table_user_setting);
$create_table[]		= array('watch',			$table_watch);
$create_table[]		= array('word',				$table_word);

// insert_records
//		$value[0] - table name
//		$value[1] - SQL query
//		$value[2] - record
$insert_records[]	= array($lang['InstallingSystemAccount'],	$insert_system,					'system account');
$insert_records[]	= array($lang['InstallingAdmin'],			$insert_admin,					'admin user');
$insert_records[]	= array($lang['InstallingAdminSetting'],	$insert_admin_setting,			'admin user settings');
$insert_records[]	= array($lang['InstallingAdminGroup'],		$insert_admin_group,			'admin group');
$insert_records[]	= array($lang['InstallingAdminGroupMember'],$insert_admin_group_member,		'admin group member');
$insert_records[]	= array($lang['InstallingEverybodyGroup'],	$insert_everybody_group,		'everybody group');
$insert_records[]	= array($lang['InstallingRegisteredGroup'],	$insert_registered_group,		'registered group');
$insert_records[]	= array($lang['InstallingModeratorGroup'],	$insert_moderator_group,		'moderator group');
$insert_records[]	= array($lang['InstallingReviewerGroup'],	$insert_reviewer_group,			'reviewer group');

// UPGRADE
// update tables
//		$value[0] - message
//		$value[1] - table name
//		$value[2] - SQL query
//		$value[3] - error message

// 5.1.0 ############
// cache
$upgrade['5.1.0'][]	= array($lang['AlterTable'],	'cache',		$alter_cache_r5_1_0,		$lang['ErrorAlteringTable']);
$upgrade['5.1.0'][]	= array($lang['AlterTable'],	'cache',		$alter_cache_r5_1_1,		$lang['ErrorAlteringTable']);

// link
$upgrade['5.1.0'][]	= array($lang['AlterTable'],	'link',			$alter_link_r5_1_0,			$lang['ErrorAlteringTable']);

// page
$upgrade['5.1.0'][]	= array($lang['AlterTable'],	'page',			$alter_page_r5_1_0,			$lang['ErrorAlteringTable']);

$upgrade['5.1.0'][]	= array($lang['UpdateTable'],	'page',			$update_page_r5_1_0,		$lang['ErrorUpdatingTable']);

// revision
$upgrade['5.1.0'][]	= array($lang['AlterTable'],	'revision',		$alter_revision_r5_1_0,		$lang['ErrorAlteringTable']);

// upload
$upgrade['5.1.0'][]	= array($lang['AlterTable'],	'upload',		$alter_upload_r5_1_0,		$lang['ErrorAlteringTable']);
$upgrade['5.1.0'][]	= array($lang['AlterTable'],	'upload',		$alter_upload_r5_1_1,		$lang['ErrorAlteringTable']);
$upgrade['5.1.0'][]	= array($lang['AlterTable'],	'upload',		$alter_upload_r5_1_2,		$lang['ErrorAlteringTable']);
$upgrade['5.1.0'][]	= array($lang['AlterTable'],	'upload',		$alter_upload_r5_1_3,		$lang['ErrorAlteringTable']);

// 5.4.0 ############

// auth_token
$upgrade['5.4.0'][]	= array($lang['CreatingTable'],	'auth_token',	$table_auth_token_r5_4_0,	$lang['ErrorCreatingTable']);

// cache
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'cache',		$alter_cache_r5_4_0,		$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'cache',		$alter_cache_r5_4_1,		$lang['ErrorAlteringTable']);

// category
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'category',		$alter_category_r5_4_0,		$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'category',		$alter_category_r5_4_1,		$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'category',		$alter_category_r5_4_2,		$lang['ErrorAlteringTable']);

// config
$upgrade['5.4.0'][]	= array($lang['UpdateTable'],	'config',		$update_config_r5_4_0,		$lang['ErrorUpdatingTable']);
$upgrade['5.4.0'][]	= array($lang['UpdateTable'],	'config',		$update_config_r5_4_1,		$lang['ErrorUpdatingTable']);
$upgrade['5.4.0'][]	= array($lang['UpdateTable'],	'config',		$update_config_r5_4_2,		$lang['ErrorUpdatingTable']);
$upgrade['5.4.0'][]	= array($lang['UpdateTable'],	'config',		$update_config_r5_4_3,		$lang['ErrorUpdatingTable']);
$upgrade['5.4.0'][]	= array($lang['UpdateTable'],	'config',		$update_config_r5_4_4,		$lang['ErrorUpdatingTable']);

// file link
$upgrade['5.4.0'][]	= array($lang['CreatingTable'],	'file_link',	$table_file_link_r5_4_0,	$lang['ErrorCreatingTable']);

//menu
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'menu',			$alter_menu_r5_4_0,			$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'menu',			$alter_menu_r5_4_1,			$lang['ErrorAlteringTable']);

// page
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'page',			$alter_page_r5_4_0,			$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]	= array($lang['UpdateTable'],	'page',			$update_page_r5_4_0,		$lang['ErrorUpdatingTable']);
$upgrade['5.4.0'][]	= array($lang['UpdateTable'],	'page',			$update_page_r5_4_1,		$lang['ErrorUpdatingTable']);
$upgrade['5.4.0'][]	= array($lang['UpdateTable'],	'page',			$update_page_r5_4_2,		$lang['ErrorUpdatingTable']);

// referrer
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'referrer',		$alter_referrer_r5_4_0,		$lang['ErrorAlteringTable']);


// revision
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'revision',		$alter_revision_r5_4_0,		$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]	= array($lang['UpdateTable'],	'revision',		$update_revision_r5_4_0,	$lang['ErrorUpdatingTable']);

// tag
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'tag',			$alter_tag_r5_4_0,			$lang['ErrorAlteringTable']);

// upload
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'upload',		$alter_upload_r5_4_0,		$lang['ErrorAlteringTable']);

// user
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'user',			$alter_user_r5_4_0,			$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'user',			$alter_user_r5_4_1,			$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'user',			$alter_user_r5_4_2,			$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'user',			$alter_user_r5_4_3,			$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'user',			$alter_user_r5_4_4,			$lang['ErrorAlteringTable']);

// user setting
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_0,	$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_1,	$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_2,	$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_3,	$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_4,	$lang['ErrorAlteringTable']);

// Make sure these are in order!
$upgrade['5.4.0'][]	= array($lang['UpdateTable'],	'user',			$update_user_r5_4_0,		$lang['ErrorUpdatingTable']);

// usergroup
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'usergroup',	$alter_usergroup_r5_4_0,	$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]	= array($lang['AlterTable'],	'usergroup',	$alter_usergroup_r5_4_1,	$lang['ErrorAlteringTable']);

// usergroup
$upgrade['5.4.0'][]	= array($lang['CreatingTable'],	'word',			$table_word_r5_4_0,			$lang['ErrorCreatingTable']);

switch($config['database_driver'])
{
	case 'mysqli_legacy':

		if ( !isset ( $config['database_port'] ) )		$config['database_port']	= '3306';
		if (!$port = trim($config['database_port']))	$port						= '3306';

		echo "         <ul>\n";

		if(!test($lang['TestConnectionString'], $dblink = @mysqli_connect($config['database_host'], $config['database_user'], $config['database_password'], null, $port), $lang['ErrorDBConnection']))
		{
			/*
			 There was a problem with the connection string
			 */

			echo "         </ul>\n";
			echo "         <br />\n";

			$fatal_error = true;
		}
		else if(!test($lang['TestDatabaseExists'], @mysqli_select_db($dblink, $config['database_database']), $lang['ErrorDBExists']))
		{
			/*
			 There was a problem with the specified database name
			 */

			echo "         </ul>\n";
			echo "         <br />\n";

			$fatal_error = true;
		}
		else
		{
			/*
			 The connection string and the database name are ok, proceed
			 */
			echo "         </ul>\n";
			echo "         <br />\n";

			// Check if database version matches engine and switch to MyISAM if necessary
			if ($_mysql_version	= mysqli_get_server_info($dblink))
			{
				$mysql_version	= substr($_mysql_version, 0, strpos($_mysql_version, '-'));

				if (version_compare($mysql_version, '5.6.4', '<'));
				{
					$config['database_engine'] = 'MyISAM';
				}
			}

			if (isset($config['DeleteTables']) && $config['DeleteTables'] == 'on')
			{
				echo "<h2>".$lang['DeletingTables']."</h2>\n";
				echo "            <ol>\n";

				foreach ($delete_table as $value)
				{
					test(str_replace('%1', $value[0], $lang['DeletingTable']), @mysqli_query($dblink, $value[1]), str_replace('%1', $value[0], $lang['ErrorDeletingTable']));

					/* echo '<pre>';
					print_r($value);
					echo '</pre>'; */
				}

				echo "            <li>".$lang['DeletingTablesEnd']."</li>\n";
				echo "         </ol>\n";
				echo "         <br />\n";

				$version = 0;
			}

			if (!is_null($version))
			{
				// new installation
				if ($version == '0')
				{
					echo "         <h2>".$lang['InstallingTables']."</h2>\n";
					echo "         <ol>\n";

					foreach ($create_table as $value)
					{
						test(str_replace('%1', $value[0], $lang['CreatingTable']), @mysqli_query($dblink, $value[1]), str_replace('%1', $value[0], $lang['ErrorCreatingTable']));
					}

					foreach ($insert_records as $value)
					{
						test($value[0], @mysqli_query($dblink, $value[1]), str_replace('%1', $value[2], $lang['ErrorAlreadyExists']));
					}

					test($lang['InstallingLogoImage'], @mysqli_query($dblink, $insert_logo_image), str_replace('%1', 'logo image', $lang['ErrorAlreadyExists']));
					echo "            </ol>\n";
				}
				else
				{
					// The funny upgrading stuff. Make sure these are in order!

					foreach ($upgrade as $to_version => $dummy)
					{
						if (version_compare($version, $to_version, '<='))
						{
							echo "         <h2>Wacko ".$to_version." ".$lang['To']." ".WACKO_VERSION."</h2>\n";
							echo "         <ol>\n";

							foreach ($upgrade[$to_version] as $value)
							{
								test(str_replace('%1', $value[1], $value[0]), @mysqli_query($dblink, $value[2]), str_replace('%1', $value[1], $value[3]));
							}

							echo "            </ol>\n";
						}
					}
				}

				echo "         <br />\n";
				echo "         <h2>".$lang['InstallingDefaultData']."</h2>\n";
				echo "         <ul>\n";

				// inserting config values
				test($lang['InstallingConfigValues'], @mysqli_query($dblink, $insert_config), str_replace('%1', 'config values', $lang['ErrorAlreadyExists']));

				echo "            <li>".$lang['InstallingPagesBegin'];
				require_once('setup/insert_pages.php');
				echo "</li>\n";
				echo "            <li>".$lang['InstallingPagesEnd']."</li>\n";
				echo "         </ul>\n";
			}
		}

		break;

	default:
		$dsn = '';
		switch($config['database_driver'])
		{
			/* case 'sqlite2': */
			case 'mysql_pdo':

				if ($config['database_driver'] == 'mysql_pdo')
				{
					#$config['database_driver'] = 'mysql';
				}

				$dsn = "mysql:host=".$config['database_host'].($config['database_port'] != '' ? ";port=".$config['database_port'] : '').";dbname=".$config['database_database'].($config['database_charset'] != '' ? ";charset=".$config['database_charset'] : '');
				break;
			/* case 'pgsql':
				$dsn = $config['database_driver'].":dbname=".$config['database_database'].";host=".$config['database_host'].($config['database_port'] != "" ? ";port=".$config['database_port'] : "");
				break; */
		}

		echo "         <ul>\n";

		#require_once('setup/database-install-pdo.php');
		global $dblink;

		// Do the initial database connection test seperately as it is a special case.
		try
		{
			test($lang['TestConnectionString'], $dblink = @new PDO($dsn, $config['database_user'], $config['database_password']), $lang['ErrorDBConnection']);
			$dblink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			test($lang['TestConnectionString'], false, "PDO Error: ".$e->getMessage());
			$fatal_error = true;
		}

		echo "         </ul>\n";
		echo "         <br />\n";

		if(!$fatal_error)
		{
			// Check if database version matches engine and switch to MyISAM if necessary
			if ($_mysql_version = $dblink->getAttribute(PDO::ATTR_SERVER_VERSION))
			{
				$mysql_version = substr($_mysql_version, 0, strpos($_mysql_version, '-'));

				if (version_compare($mysql_version, '5.6.4', '<'));
				{
					$config['database_engine'] = 'MyISAM';
				}
			}

			if (isset($config['DeleteTables']) && $config['DeleteTables'] == 'on')
			{
				echo "<h2>".$lang['DeletingTables']."</h2>\n";
				echo "            <ol>\n";

				foreach ($delete_table as $value)
				{
					test_pdo(str_replace('%1', $value[0], $lang['DeletingTable']), $value[1], str_replace('%1', $value[0], $lang['ErrorDeletingTable']));
				}

				echo "            <li>".$lang['DeletingTablesEnd']."</li>\n";
				echo "         </ol>\n";
				echo "         <br />\n";

				$version = 0;
			}

			if (!is_null($version))
			{
				// new installation
				if ($version == '0')
				{
					echo "         <h2>".$lang['InstallingTables']."</h2>\n";
					echo "         <ol>\n";

					foreach ($create_table as $value)
					{
						test_pdo(str_replace('%1', $value[0], $lang['CreatingTable']), $value[1], str_replace('%1', $value[0], $lang['ErrorCreatingTable']));
					}

					foreach ($insert_records as $value)
					{
						test_pdo($value[0], $value[1], str_replace('%1', $value[2], $lang['ErrorAlreadyExists']));
					}

					test_pdo($lang['InstallingLogoImage'], $insert_logo_image, str_replace('%1', 'logo image', $lang['ErrorAlreadyExists']));
					echo "            </ol>\n";
				}
				else
				{
					// The funny upgrading stuff. Make sure these are in order!

					foreach ($upgrade as $to_version => $dummy)
					{
						if (version_compare($version, $to_version, '<='))
						{
							echo "         <h2>Wacko ".$to_version." ".$lang['To']." ".WACKO_VERSION."</h2>\n";
							echo "         <ol>\n";

							foreach ($upgrade[$to_version] as $value)
							{
								test_pdo(str_replace('%1', $value[1], $value[0]), $value[2], str_replace('%1', $value[1], $value[3]));
							}

							echo "            </ol>\n";
						}
					}
				}

				echo "         <br />\n";
				echo "         <h2>".$lang['InstallingDefaultData']."</h2>\n";
				echo "         <ul>\n";

				// inserting config values
				test_pdo($lang['InstallingConfigValues'], $insert_config, str_replace('%1', 'config values', $lang['ErrorAlreadyExists']));

				echo "            <li>".$lang['InstallingPagesBegin'];
				require_once('setup/insert_pages.php');
				echo "</li>\n";
				echo "            <li>".$lang['InstallingPagesEnd']."</li>\n";
				echo "         </ul>\n";
			}
		}

		break;
}

if(!$fatal_error)
{
?>
<p><?php echo $lang['NextStep'];?></p>
<form action="<?php echo my_location(); ?>?installAction=write-config" method="post">
<?php
	write_config_hidden_nodes(array('DeleteTables' => ''));
?>
	<input type="submit" value="<?php echo $lang['Continue'];?>" class="next" />
</form>
<?php
}
else
{
?>
<input type="submit" value="<?php echo $lang['Back'];?>" class="next" onclick="javascript: history.go(-1);" />
<input type="button" value="<?php echo $lang['TryAgain'];?>" class="next" onClick="window.location.reload( true );" />
<?php
}
?>