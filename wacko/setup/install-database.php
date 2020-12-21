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

	'create' => [
		'ok'		=> $lang['CreatingTable'],
		'error'		=> $lang['ErrorCreatingTable']
	],

	'delete' => [
		'ok'		=> $lang['DeletingTable'],
		'error'		=> $lang['ErrorDeletingTable']
	],

	'insert' => [
		'ok'		=> $lang['InsertRecord'],
		'error'		=> $lang['ErrorInsertingRecord']
	],

	'rename' => [
		'ok'		=> $lang['RenameTable'],
		'error'		=> $lang['ErrorRenamingTable']
	],

	'update' => [
		'ok'		=> $lang['UpdateTable'],
		'error'		=> $lang['ErrorUpdatingTable']
	]
];

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

if (!empty($config['sql_mode_strict']))
{
	$sql_modes = SQL_MODE_STRICT;
}
else
{
	$sql_modes = SQL_MODE_PERMISSIVE;
}

switch ($config['database_driver'])
{
	case 'mysqli_legacy':

		if (!isset($config['database_port']))			$config['database_port']	= '3306';
		if (!$port = trim($config['database_port']))	$port						= '3306';

		echo "         <ul>\n";

		if (!test(
			$lang['TestConnectionString'],
			$dblink = @mysqli_connect($config['database_host'], $config['database_user'], $config['database_password'], null, $port),
			$lang['ErrorDBConnection'])
		)
		{
			/*
			 There was a problem with the connection string
			 */

			echo "         </ul>\n";
			echo "         <br>\n";

			$fatal_error = true;
		}
		else if (!test($lang['TestDatabaseExists'], @mysqli_select_db($dblink, $config['database_database']), $lang['ErrorDBExists'], $dblink))
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
			mysqli_query($dblink, "SET SESSION sql_mode='$sql_modes'");

			echo "         </ul>\n";
			echo "         <br>\n";

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
					test(
						Ut::perc_replace($lang['DeletingTable'], '<code>' . $value[0] . '</code>'),
						@mysqli_query($dblink, $value[1]),
						Ut::perc_replace($lang['ErrorDeletingTable'], '<code>' . $value[0] . '</code>'),
						$dblink
					);

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
						test(
							Ut::perc_replace($lang['CreatingTable'], '<code>' . $value[0] . '</code>'),
							@mysqli_query($dblink, $value[1]),
							Ut::perc_replace($lang['ErrorCreatingTable'], '<code>' . $value[0] . '</code>'),
							$dblink
						);
					}

					foreach ($insert_records as $value)
					{
						test(
							$value[0],
							@mysqli_query($dblink, $value[1]),
							Ut::perc_replace($lang['ErrorAlreadyExists'], '<code>' . $value[2] . '</code>'),
							$dblink
						);
					}

					test(
						$lang['InstallingLogoImage'],
						@mysqli_query($dblink, $insert_logo_image),
						Ut::perc_replace($lang['ErrorAlreadyExists'], $lang['LogoImage']),
						$dblink
					);

					echo "            </ol>\n";
				}
				else
				{
					// The funny upgrading stuff. Make sure these are in order!
					uksort($upgrade, function($a, $b) {
						return version_compare ($a, $b);
					});

					foreach ($upgrade as $to_version => $dummy)
					{
						if (version_compare($version, $to_version, '<='))
						{
							echo "         <h2>Wacko " . $to_version." " . $lang['To'] . " " . WACKO_VERSION . "</h2>\n";
							echo "         <ol>\n";

							foreach ($upgrade[$to_version] as $value)
							{
								test(
									Ut::perc_replace($upgrade_msg[$value[0]]['ok'], '<code>' . $value[1] . '</code>'),
									@mysqli_query($dblink, $value[2]),
									Ut::perc_replace($upgrade_msg[$value[0]]['error'], '<code>' . $value[1] . '</code>'),
									$dblink
								);
							}

							echo "            </ol>\n";
						}
					}
				}

				echo "         <br>\n";
				echo "         <h2>" . $lang['InstallingDefaultData'] . "</h2>\n";
				echo "         <ul>\n";

				// inserting config values
				test(
					$lang['InstallingConfigValues'],
					@mysqli_query($dblink, $insert_config),
					Ut::perc_replace($lang['ErrorAlreadyExists'], $lang['ConfigValues']),
					$dblink
				);

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
				$dsn = "mysql:host=" . $config['database_host'] . ($config['database_port'] != '' ? ";port=" . $config['database_port'] : '') . ";dbname=" . $config['database_database'] . ($config['database_charset'] != '' ? ";charset=" . $config['database_charset'] : '');
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
		$dblink->query("SET SESSION sql_mode='$sql_modes'");

		echo "         </ul>\n";
		echo "         <br>\n";

		if (!$fatal_error)
		{
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
					test_pdo(
						Ut::perc_replace($lang['DeletingTable'], '<code>' . $value[0] . '</code>'),
						$value[1],
						Ut::perc_replace($lang['ErrorDeletingTable'], '<code>' . $value[0] . '</code>')
					);
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
						test_pdo(
							Ut::perc_replace($lang['CreatingTable'], '<code>' . $value[0] . '</code>'),
							$value[1],
							Ut::perc_replace($lang['ErrorCreatingTable'], '<code>' . $value[0] . '</code>')
						);
					}

					foreach ($insert_records as $value)
					{
						test_pdo(
							$value[0],
							$value[1],
							Ut::perc_replace($lang['ErrorAlreadyExists'], '<code>' . $value[2] . '</code>')
						);
					}

					test_pdo(
						$lang['InstallingLogoImage'],
						$insert_logo_image,
						Ut::perc_replace($lang['ErrorAlreadyExists'], $lang['LogoImage'])
					);

					echo "            </ol>\n";
				}
				else
				{
					// The funny upgrading stuff. Make sure these are in order!
					uksort($upgrade, function($a, $b) {
						return version_compare ($a, $b);
					});

					foreach ($upgrade as $to_version => $dummy)
					{
						if (version_compare($version, $to_version, '<='))
						{
							echo "         <h2>Wacko " . $to_version." " . $lang['To'] . " " . WACKO_VERSION . "</h2>\n";
							echo "         <ol>\n";

							foreach ($upgrade[$to_version] as $value)
							{
								test_pdo(
									Ut::perc_replace($upgrade_msg[$value[0]]['ok'], '<code>' . $value[1] . '</code>'),
									$value[2],
									Ut::perc_replace($upgrade_msg[$value[0]]['error'], '<code>' . $value[1] . '</code>')
								);
							}

							echo "            </ol>\n";
						}
					}
				}

				echo "         <br>\n";
				echo "         <h2>" . $lang['InstallingDefaultData'] . "</h2>\n";
				echo "         <ul>\n";

				// inserting config values
				test_pdo(
					$lang['InstallingConfigValues'],
					$insert_config,
					Ut::perc_replace($lang['ErrorAlreadyExists'], $lang['ConfigValues'])
				);

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
