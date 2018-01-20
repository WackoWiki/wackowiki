<?php
@set_time_limit(0);
@ignore_user_abort(true);

// test configuration
echo "         <h2>" . $lang['TestingConfiguration'] . "</h2>\n";

$delete_table			= [];
$create_table			= [];
$insert_records			= [];
$upgrade				= [];

$upgrade_msg = [
	'alter' => [
		'ok'		=> $lang['AlterTable'],
		'error'		=> $lang['ErrorAlteringTable']
	],

	'update' => [
		'ok'		=> $lang['UpdateTable'],
		'error'		=> $lang['ErrorUpdatingTable']
	],

	'delete' => [
		'ok'		=> $lang['DeletingTable'],
		'error'		=> $lang['ErrorDeletingTable']
	],

	'create' => [
		'ok'		=> $lang['CreatingTable'],
		'error'		=> $lang['ErrorCreatingTable']
	],

	'rename' => [
		'ok'		=> $lang['RenameTable'],
		'error'		=> $lang['ErrorRenamingTable']
	]
];

$db_version				= "SELECT VERSION() as mysql_version";

require_once 'setup/_insert_default.php';
require_once 'setup/_insert_config.php';

/*
 Setup the tables depending on which database we selected

 mysqli_legacy which is the default clause
 or pdo
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

switch ($config['database_driver'])
{
	case 'mysqli_legacy':

		if ( !isset ( $config['database_port'] ) )		$config['database_port']	= '3306';
		if (!$port = trim($config['database_port']))	$port						= '3306';

		echo "         <ul>\n";

		if (!test($lang['TestConnectionString'], $dblink = @mysqli_connect($config['database_host'], $config['database_user'], $config['database_password'], null, $port), $lang['ErrorDBConnection']))
		{
			/*
			 There was a problem with the connection string
			 */

			echo "         </ul>\n";
			echo "         <br>\n";

			$fatal_error = true;
		}
		else if (!test($lang['TestDatabaseExists'], @mysqli_select_db($dblink, $config['database_database']), $lang['ErrorDBExists']))
		{
			/*
			 There was a problem with the specified database name
			 */

			echo "         </ul>\n";
			echo "         <br>\n";

			$fatal_error = true;
		}
		else
		{
			/*
			 The connection string and the database name are ok, proceed
			 */

			// set charset
			mysqli_set_charset($dblink, $config['database_charset']);

			// set SESSION sql_mode
			if (isset($config['sql_mode_strict']) && $config['sql_mode_strict'])
			{
				$sql_modes = SQL_MODE_STRICT;
			}
			else
			{
				$sql_modes = SQL_MODE_PERMISSIVE;
			}

			mysqli_query($dblink, "SET SESSION sql_mode='$sql_modes'");

			echo "         </ul>\n";
			echo "         <br>\n";

			// Check if database version matches engine and switch to MyISAM if necessary
			if ($result	= mysqli_query($dblink, $db_version))
			{
				$_result		= mysqli_fetch_assoc($result);
				$mysql_version	= substr($_result['mysql_version'], 0, strpos($_result['mysql_version'], '-'));

				// InnoDb up to MariaDB / MySql 5.6.4 doesn't support FULLTEXT indexes
				if (version_compare($mysql_version, '5.6.4', '<'))
				{
					$config['database_engine'] = 'MyISAM';
				}
			}

			// mariadb / mysql only
			require_once 'setup/database_mysql.php';
			require_once 'setup/database_mysql_updates.php';
			require_once 'setup/_insert_queries.php';

			if (isset($config['DeleteTables']) && $config['DeleteTables'] == 'on')
			{
				echo "<h2>" . $lang['DeletingTables'] . "</h2>\n";
				echo "            <ol>\n";

				foreach ($delete_table as $value)
				{
					test(Ut::perc_replace($lang['DeletingTable'], $value[0]), @mysqli_query($dblink, $value[1]), Ut::perc_replace($lang['ErrorDeletingTable'], $value[0]));

					/* echo '<pre>';
					print_r($value);
					echo '</pre>'; */
				}

				echo "            <li>" . $lang['DeletingTablesEnd'] . "</li>\n";
				echo "         </ol>\n";
				echo "         <br>\n";

				$version = 0;
			}

			if (!is_null($version))
			{
				// new installation
				if ($version == '0')
				{
					echo "         <h2>" . $lang['InstallingTables'] . "</h2>\n";
					echo "         <ol>\n";

					foreach ($create_table as $value)
					{
						test(Ut::perc_replace($lang['CreatingTable'], $value[0]), @mysqli_query($dblink, $value[1]), Ut::perc_replace($lang['ErrorCreatingTable'], $value[0]));
					}

					foreach ($insert_records as $value)
					{
						test($value[0], @mysqli_query($dblink, $value[1]), Ut::perc_replace($lang['ErrorAlreadyExists'], $value[2]));
					}

					test($lang['InstallingLogoImage'], @mysqli_query($dblink, $insert_logo_image), Ut::perc_replace($lang['ErrorAlreadyExists'], 'logo image'));
					echo "            </ol>\n";
				}
				else
				{
					// The funny upgrading stuff. Make sure these are in order!
					ksort($upgrade, SORT_STRING);

					foreach ($upgrade as $to_version => $dummy)
					{
						if (version_compare($version, $to_version, '<='))
						{
							echo "         <h2>Wacko " . $to_version." " . $lang['To'] . " " . WACKO_VERSION . "</h2>\n";
							echo "         <ol>\n";

							foreach ($upgrade[$to_version] as $value)
							{
								test(Ut::perc_replace($upgrade_msg[$value[0]]['ok'], $value[1]), @mysqli_query($dblink, $value[2]), Ut::perc_replace($upgrade_msg[$value[0]]['error'], $value[1]));
							}

							echo "            </ol>\n";
						}
					}
				}

				echo "         <br>\n";
				echo "         <h2>" . $lang['InstallingDefaultData'] . "</h2>\n";
				echo "         <ul>\n";

				// inserting config values
				test($lang['InstallingConfigValues'], @mysqli_query($dblink, $insert_config), Ut::perc_replace($lang['ErrorAlreadyExists'], 'config values'));

				echo "            <li>" . $lang['InstallingPagesBegin'];
				require_once 'setup/insert_pages.php';
				echo "</li>\n";
				echo "            <li>" . $lang['InstallingPagesEnd'] . "</li>\n";
				echo "         </ul>\n";
			}
		}

		break;

	default:
		$dsn = '';
		switch ($config['database_driver'])
		{
			/* case 'sqlite3': */

			case 'mysql_pdo':
				$dsn = "mysql:host=" . $config['database_host'].($config['database_port'] != '' ? ";port=" . $config['database_port'] : '') . ";dbname=" . $config['database_database'].($config['database_charset'] != '' ? ";charset=" . $config['database_charset'] : '');
				break;

			/* case 'pgsql':
				$dsn = $config['database_driver'] . ":dbname=" . $config['database_database'] . ";host=" . $config['database_host'].($config['database_port'] != "" ? ";port=" . $config['database_port'] : "");
				break; */
		}

		echo "         <ul>\n";

		global $dblink;

		// Do the initial database connection test seperately as it is a special case.
		try
		{
			test($lang['TestConnectionString'], $dblink = @new PDO($dsn, $config['database_user'], $config['database_password']), $lang['ErrorDBConnection']);
			$dblink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e)
		{
			test($lang['TestConnectionString'], false, "PDO Error: " . $e->getMessage());
			$fatal_error = true;
		}

		// set SESSION sql_mode
		if (isset($config['sql_mode_strict']) && $config['sql_mode_strict'])
		{
			$sql_modes = SQL_MODE_STRICT;
		}
		else
		{
			$sql_modes = SQL_MODE_PERMISSIVE;
		}

		$dblink->query("SET SESSION sql_mode='$sql_modes'");

		echo "         </ul>\n";
		echo "         <br>\n";

		if (!$fatal_error)
		{
			// Check if database version matches engine and switch to MyISAM if necessary
			if ($result = $dblink->query($db_version))
			{
				$_result		= $result->fetch(PDO::FETCH_ASSOC);
				$mysql_version	= substr($_result['mysql_version'], 0, strpos($_result['mysql_version'], '-'));

				// InnoDb up to MariaDB / MySql 5.6.4 doesn't support FULLTEXT indexes
				if (version_compare($mysql_version, '5.6.4', '<'))
				{
					$config['database_engine'] = 'MyISAM';
				}
			}

			// mariadb / mysql only
			require_once 'setup/database_mysql.php';
			require_once 'setup/database_mysql_updates.php';
			require_once 'setup/_insert_queries.php';

			if (isset($config['DeleteTables']) && $config['DeleteTables'] == 'on')
			{
				echo "<h2>" . $lang['DeletingTables'] . "</h2>\n";
				echo "            <ol>\n";

				foreach ($delete_table as $value)
				{
					test_pdo(Ut::perc_replace($lang['DeletingTable'], $value[0]), $value[1], Ut::perc_replace($lang['ErrorDeletingTable'], $value[0]));
				}

				echo "            <li>" . $lang['DeletingTablesEnd'] . "</li>\n";
				echo "         </ol>\n";
				echo "         <br>\n";

				$version = 0;
			}

			if (!is_null($version))
			{
				// new installation
				if ($version == '0')
				{
					echo "         <h2>" . $lang['InstallingTables'] . "</h2>\n";
					echo "         <ol>\n";

					foreach ($create_table as $value)
					{
						test_pdo(Ut::perc_replace($lang['CreatingTable'], $value[0]), $value[1], Ut::perc_replace($lang['ErrorCreatingTable'], $value[0]));
					}

					foreach ($insert_records as $value)
					{
						test_pdo($value[0], $value[1], Ut::perc_replace($lang['ErrorAlreadyExists'], $value[2]));
					}

					test_pdo($lang['InstallingLogoImage'], $insert_logo_image, Ut::perc_replace($lang['ErrorAlreadyExists'], 'logo image'));
					echo "            </ol>\n";
				}
				else
				{
					// The funny upgrading stuff. Make sure these are in order!
					ksort($upgrade, SORT_STRING);

					foreach ($upgrade as $to_version => $dummy)
					{
						if (version_compare($version, $to_version, '<='))
						{
							echo "         <h2>Wacko " . $to_version." " . $lang['To'] . " " . WACKO_VERSION . "</h2>\n";
							echo "         <ol>\n";

							foreach ($upgrade[$to_version] as $value)
							{
								test_pdo(Ut::perc_replace($upgrade_msg[$value[0]]['ok'], $value[1]), $value[2], Ut::perc_replace($upgrade_msg[$value[0]]['error'], $value[1]));
							}

							echo "            </ol>\n";
						}
					}
				}

				echo "         <br>\n";
				echo "         <h2>" . $lang['InstallingDefaultData'] . "</h2>\n";
				echo "         <ul>\n";

				// inserting config values
				test_pdo($lang['InstallingConfigValues'], $insert_config, Ut::perc_replace($lang['ErrorAlreadyExists'], 'config values'));

				echo "            <li>" . $lang['InstallingPagesBegin'];
				require_once 'setup/insert_pages.php';
				echo "</li>\n";
				echo "            <li>" . $lang['InstallingPagesEnd'] . "</li>\n";
				echo "         </ul>\n";
			}
		}

		break;
}

if (!$fatal_error)
{
?>
<p><?php echo Ut::perc_replace($lang['NextStep'], '<code>' . CONFIG_FILE . '</code>');?></p>
<form action="<?php echo my_location(); ?>?installAction=write-config" method="post">
<?php
	write_config_hidden_nodes(['DeleteTables' => '']);
?>
	<input type="submit" value="<?php echo $lang['Continue'];?>" class="next">
</form>
<?php
}
else
{
?>
<input type="submit" value="<?php echo $lang['Back'];?>" class="next" onclick="history.go(-1);">
<input type="button" value="<?php echo $lang['TryAgain'];?>" class="next" onClick="window.location.reload( true );">
<?php
}
?>
