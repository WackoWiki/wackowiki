<?php
@set_time_limit(0);
@ignore_user_abort(true);

// test configuration
echo '<h2>' . $lang['TestingConfiguration'] . '</h2>' . "\n";

$delete_table		= [];
$create_trigger		= [];
$create_table		= [];
$insert_records		= [];
$upgrade			= [];

$upgrade_msg = [
	'alter' => [
		'ok'		=> $lang['AlterTable'],
		'error'		=> $lang['ErrorAlterTable']
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
		'error'		=> $lang['ErrorInsertRecord']
	],

	'rename' => [
		'ok'		=> $lang['RenameTable'],
		'error'		=> $lang['ErrorRenameTable']
	],

	'update' => [
		'ok'		=> $lang['UpdateTable'],
		'error'		=> $lang['ErrorUpdatingTable']
	]
];

// set back theme to default, just a precaution
$config['theme'] = 'default';

$config['allowed_languages']	??= '';
$config['multilanguage']		??= 0;
$config['rewrite_mode']			??= 0;
$config['wacko_version']		??= '';

if (empty($config['noreply_email']))
{
	$config['noreply_email'] = $config['admin_email'];
}

// check for language related default values
if (!$config['is_update'])
{
	$config = array_merge($config, $lang['ConfigDefaults']);
}

// no table_prefix for SQLite
if (in_array($config['db_driver'], ['sqlite', 'sqlite_pdo']))
{
	$config['table_prefix']			= '';
}

// update config values
if ($config['is_update'])
{
	if (version_compare($config['wacko_version'], '6.2.0', '<'))
	{
		$config['mysqli']				= $config['mysqli_legacy'];
	}
}

/*
 Set up the tables depending on which database we selected

 mysqli which is the default clause or pdo
 */

$port			= trim($config['db_port']);
$fatal_error	= false;

// check WackoWiki version
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

$sql_modes = match((int) $config['sql_mode']) {
	1		=> SQL_MODE_LAX[$config['db_vendor']],
	2		=> SQL_MODE_STRICT[$config['db_vendor']],
	default	=> 0, // server SQL mode
};

switch ($config['db_driver'])
{
	case 'mysqli':

		$config['db_port']								??= '3306';
		if (!$port = trim($config['db_port']))	$port	  = '3306';

		echo '<ul>' . "\n";

		global $dblink;

		// Do the initial database connection test separately as it is a special case.
		try
		{
			mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
			test(
				$lang['TestConnectionString'],
				$dblink = new mysqli($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name'], $port),
				$lang['ErrorDbConnection']
			);
		}
		catch (mysqli_sql_exception $e)
		{
			// There was a problem with the connection string
			test(
				$lang['TestConnectionString'],
				false,
				$lang['ErrorDbConnection'] . '<br>' . 'MySQLi Error: ' . $e->getMessage() . ' ' . $e->getCode()
			);

			$fatal_error = true;
		}

		if (!$fatal_error)
		{
			/*
			 The connection string and the database name are ok, proceed
			 */

			// set charset
			mysqli_set_charset($dblink, $config['db_charset']);

			// set SESSION sql_mode
			if ($sql_modes && $config['debug'] >= 3)
			{
				mysqli_query($dblink, "SET SESSION sql_mode='$sql_modes'");
			}

			// check min database version
			$_db_version	= mysqli_query($dblink, "SELECT version()");
			$_db_version	= mysqli_fetch_assoc($_db_version);
			$db_version		= $_db_version['version()'];

			$config['db_vendor'] = preg_match('/MariaDB/', $db_version, $matches)
				? 'mariadb'
				: 'mysql';

			$min_db_version		= preg_match('/MariaDB/', $db_version, $matches)
				? DB_MIN_VERSION['mariadb']
				: DB_MIN_VERSION['mysql'];
			$valid_db_version	= (bool) version_compare($db_version, $min_db_version, '>=');

			echo '<li>' . ($valid_db_version
				? $lang['TestDatabaseVersion'] . ' ' . output_image($valid_db_version)
				: Ut::perc_replace(
					$lang['ErrorDatabaseVersion'],
					'<code>' . $db_version . '</code>',
					'<code>' . $min_db_version . '</code>') . ' ' .
					output_image($valid_db_version)
				) . '</li>';

			$fatal_error = !$valid_db_version;
		}

		echo '</ul>' . "\n";
		echo '<br>' . "\n";

		if (!$fatal_error)
		{
			// mariadb / mysql only
			require_once 'setup/_insert_config.php';
			require_once 'setup/_insert_default.php';
			require_once 'setup/database_mysql.php';
			require_once 'setup/database_mysql_updates.php';
			require_once 'setup/_insert_queries.php';

			if (isset($config['DeleteTables']) && $config['DeleteTables'] == 'on')
			{
				echo '<h2>' . $lang['DeletingTables'] . '</h2>' . "\n";
				echo '<ol>' . "\n";

				foreach ($delete_table as $value)
				{
					test_mysqli(
						Ut::perc_replace($lang['DeletingTable'], '<code>' . $value[0] . '</code>'),
						$value[1],
						Ut::perc_replace($lang['ErrorDeletingTable'], '<code>' . $value[0] . '</code>')
					);

					/* echo '<pre>';
					print_r($value);
					echo '</pre>'; */
				}

				echo '<li>' . $lang['DeletingTablesEnd'] . '</li>' . "\n";
				echo '</ol>' . "\n";
				echo '<br>' . "\n";

				$version = 0;
			}

			if (!is_null($version))
			{
				// new installation
				if ($version == '0')
				{
					echo '<h2>' . $lang['InstallTables'] . '</h2>' . "\n";
					echo '<ol>' . "\n";

					foreach ($create_table as $value)
					{
						test_mysqli(
							Ut::perc_replace($lang['CreatingTable'], '<code>' . $value[0] . '</code>'),
							$value[1],
							Ut::perc_replace($lang['ErrorCreatingTable'], '<code>' . $value[0] . '</code>')
						);
					}

					foreach ($insert_records as $value)
					{
						test_mysqli(
							$value[0],
							$value[1],
							Ut::perc_replace($lang['ErrorAlreadyExists'], '<code>' . $value[2] . '</code>')
						);
					}

					test_mysqli(
						$lang['InstallLogoImage'],
						$insert_logo_image,
						Ut::perc_replace($lang['ErrorAlreadyExists'], $lang['LogoImage'])
					);

					echo '</ol>' . "\n";
				}
				else
				{
					// The funny upgrading stuff. Make sure these are in order!
					uksort($upgrade, function($a, $b) {
						return version_compare ($a, $b);
					});

					foreach (array_keys($upgrade) as $to_version) // index == value, BTW
					{
						if (version_compare($version, $to_version, '<='))
						{
							echo '<h2>Wacko ' . $to_version . ' ' . $lang['To'] . ' ' . WACKO_VERSION . '</h2>' . "\n";
							echo '<ol>' . "\n";

							foreach ($upgrade[$to_version] as $value)
							{
								test_mysqli(
									Ut::perc_replace($upgrade_msg[$value[0]]['ok'], '<code>' . $value[1] . '</code>'),
									$value[2],
									Ut::perc_replace($upgrade_msg[$value[0]]['error'], '<code>' . $value[1] . '</code>')
								);
							}

							echo '</ol>' . "\n";
						}
					}
				}

				echo '<br>' . "\n";
				echo '<h2>' . $lang['InstallDefaultData'] . '</h2>' . "\n";
				echo '<ul>' . "\n";

				// inserting config values
				test_mysqli(
					$lang['InstallConfigValues'],
					$insert_config,
					Ut::perc_replace($lang['ErrorAlreadyExists'], $lang['ConfigValues'])
				);

				echo '<li>' . $lang['InstallPagesBegin'];
				require_once 'setup/insert_pages.php';
				echo '</li>' . "\n";
				echo '<li>' . $lang['InstallPagesEnd'] . '</li>' . "\n";
				echo '</ul>' . "\n";
			}
		}

		break;

	case 'sqlite':

		echo '<ul>' . "\n";

		global $dblink;

		if (file_exists($config['db_name']) && !$config['is_update'])
		{
			test(
				$lang['TestConnectionString'],
				false,
				$lang['ErrorDbConnection'] . '<br>' . 'SQLlite file exists.'
			);

			$fatal_error = true;
		}

		if (!check_sqlite_name($config['db_name']))
		{
			test(
				$lang['TestConnectionString'],
				false,
				$lang['ErrorDbConnection'] . '<br>' . 'Please use one of the extensions db, sdb, sqlite.'
			);

			$fatal_error = true;
		}

		if (!$fatal_error)
		// Do the initial database connection test separately as it is a special case.
		try
		{
			test(
				$lang['TestConnectionString'],
				$dblink = new \SQLite3($config['db_name']),
				$lang['ErrorDbConnection']
			);

			$dblink->enableExceptions(true);
		}
		catch (Exception $e)
		{
			// There was a problem with the connection string
			test(
				$lang['TestConnectionString'],
				false,
				$lang['ErrorDbConnection'] . '<br>' . 'SQLlite Error: ' . $e->getMessage() . ' ' . $e->getCode()
			);

			$fatal_error = true;
		}

		if (!$fatal_error)
		{
			/*
			 The connection string and the database name are ok, proceed
			 */

			// set charset
			# none

			// set SESSION sql_mode
			# none

			// check min database version
			$db_version		= $dblink->querySingle("SELECT sqlite_version() AS version");

			$min_db_version		= DB_MIN_VERSION['sqlite'];
			$valid_db_version	= (bool) version_compare($db_version, $min_db_version, '>=');

			echo '<li>' . ($valid_db_version
				? $lang['TestDatabaseVersion'] . ' ' . output_image($valid_db_version)
				: Ut::perc_replace(
					$lang['ErrorDatabaseVersion'],
					'<code>' . $db_version . '</code>',
					'<code>' . $min_db_version . '</code>') . ' ' .
					output_image($valid_db_version)
				) . '</li>';

				$fatal_error = !$valid_db_version;
		}

		echo '</ul>' . "\n";
		echo '<br>' . "\n";

		if (!$fatal_error)
		{
			// sqlite only
			require_once 'setup/_insert_config.php';
			require_once 'setup/_insert_default.php';
			require_once 'setup/database_sqlite.php';
			require_once 'setup/database_sqlite_updates.php';
			require_once 'setup/_insert_queries.php';

			if (isset($config['DeleteTables']) && $config['DeleteTables'] == 'on')
			{
				echo '<h2>' . $lang['DeletingTables'] . '</h2>' . "\n";
				echo '<ol>' . "\n";

				foreach ($delete_table as $value)
				{
					test_sqlite(
						Ut::perc_replace($lang['DeletingTable'], '<code>' . $value[0] . '</code>'),
						$value[1],
						Ut::perc_replace($lang['ErrorDeletingTable'], '<code>' . $value[0] . '</code>')
					);

					/* echo '<pre>';
					 print_r($value);
					 echo '</pre>'; */
				}

				echo '<li>' . $lang['DeletingTablesEnd'] . '</li>' . "\n";
				echo '</ol>' . "\n";
				echo '<br>' . "\n";

				$version = 0;
			}

			if (!is_null($version))
			{
				// new installation
				if ($version == '0')
				{
					echo '<h2>' . $lang['InstallTables'] . '</h2>' . "\n";
					echo '<ol>' . "\n";

					foreach ($create_table as $value)
					{
						test_sqlite(
							Ut::perc_replace($lang['CreatingTable'], '<code>' . $value[0] . '</code>'),
							$value[1],
							Ut::perc_replace($lang['ErrorCreatingTable'], '<code>' . $value[0] . '</code>')
							);
					}

					$dblink->query("PRAGMA journal_mode=WAL");

					foreach ($create_trigger as $n => $value)
					{
						test_sqlite(
							Ut::perc_replace($lang['CreatingTrigger'], '<code>' . $n . '</code>'),
							$value,
							Ut::perc_replace($lang['ErrorCreatingTrigger'], '<code>' . $n . '</code>')
						);
					}

					foreach ($insert_records as $value)
					{
						test_sqlite(
							$value[0],
							$value[1],
							Ut::perc_replace($lang['ErrorAlreadyExists'], '<code>' . $value[2] . '</code>')
						);
					}

					test_sqlite(
						$lang['InstallLogoImage'],
						$insert_logo_image,
						Ut::perc_replace($lang['ErrorAlreadyExists'], $lang['LogoImage'])
					);

					echo '</ol>' . "\n";
				}
				else
				{
					// The funny upgrading stuff. Make sure these are in order!
					uksort($upgrade, function($a, $b) {
						return version_compare ($a, $b);
					});

						foreach (array_keys($upgrade) as $to_version) // index == value, BTW
						{
							if (version_compare($version, $to_version, '<='))
							{
								echo '<h2>Wacko ' . $to_version . ' ' . $lang['To'] . ' ' . WACKO_VERSION . '</h2>' . "\n";
								echo '<ol>' . "\n";

								foreach ($upgrade[$to_version] as $value)
								{
									test_sqlite(
										Ut::perc_replace($upgrade_msg[$value[0]]['ok'], '<code>' . $value[1] . '</code>'),
										$value[2],
										Ut::perc_replace($upgrade_msg[$value[0]]['error'], '<code>' . $value[1] . '</code>')
									);
								}

								echo '</ol>' . "\n";
							}
						}
				}

				echo '<br>' . "\n";
				echo '<h2>' . $lang['InstallDefaultData'] . '</h2>' . "\n";
				echo '<ul>' . "\n";

				// inserting config values
				test_sqlite(
					$lang['InstallConfigValues'],
					$insert_config,
					Ut::perc_replace($lang['ErrorAlreadyExists'], $lang['ConfigValues'])
				);

				echo '<li>' . $lang['InstallPagesBegin'];
				require_once 'setup/insert_pages.php';
				echo '</li>' . "\n";
				echo '<li>' . $lang['InstallPagesEnd'] . '</li>' . "\n";
				echo '</ul>' . "\n";
			}
		}

		break;

	default:
		$dsn = match ($config['db_driver']) {
			'mysql_pdo'		=> "mysql:host=" . $config['db_host'] . ($config['db_port'] != '' ? ";port=" . $config['db_port'] : '') . ";dbname=" . $config['db_name'] . ($config['db_charset'] != '' ? ";charset=" . $config['db_charset'] : ''),
			# 'pgsql'		=> $config['db_driver'] . ":dbname=" . $config['db_name'] . ";host=" . $config['db_host'].($config['db_port'] != "" ? ";port=" . $config['db_port'] : ""),
			'sqlite_pdo'	=> "sqlite:" . $config['db_name'],
			default			=> '',
		};

		echo '<ul>' . "\n";

		global $dblink;

		if ($config['db_driver'] == 'sqlite_pdo')
		{
			if (file_exists($config['db_name']) && !$config['is_update'])
			{
				test(
					$lang['TestConnectionString'],
					false,
					$lang['ErrorDbConnection'] . '<br>' . 'SQLlite file exists.'
				);

				$fatal_error = true;
			}

			if (!check_sqlite_name($config['db_name']))
			{
				test(
					$lang['TestConnectionString'],
					false,
					$lang['ErrorDbConnection'] . '<br>' . 'Please use one of the extensions db, sdb, sqlite.'
				);

				$fatal_error = true;
			}
		}

		if (!$fatal_error)
		// Do the initial database connection test separately as it is a special case.
		try
		{
			test(
				$lang['TestConnectionString'],
				$dblink = @new PDO(
					$dsn,
					$config['db_user'],
					$config['db_password']),
				$lang['ErrorDbConnection']
			);

			$dblink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e)
		{
			test(
				$lang['TestConnectionString'],
				false,
				$lang['ErrorDbConnection'] . '<br>' . 'PDO Error: ' . $e->getMessage() . ' ' . $e->getCode()
			);

			$fatal_error = true;
		}

		if (!$fatal_error)
		{
			// set SESSION sql_mode
			if ($sql_modes && $config['debug'] >= 3)
			{
				$dblink->query("SET SESSION sql_mode='$sql_modes'");
			}

			// check min database version
			if ($config['db_driver'] == 'sqlite_pdo')
			{
				$db_version		= $dblink->query("SELECT sqlite_version() AS version")->fetchColumn();
				$min_db_version	= DB_MIN_VERSION['sqlite'];
			}
			else
			{
				$_db_version	= $dblink->query("SELECT version()")->fetch(PDO::FETCH_ASSOC);
				$db_version		= $_db_version['version()'];

				$config['db_vendor'] = preg_match('/MariaDB/', $db_version, $matches)
					? 'mariadb'
					: 'mysql';

				$min_db_version		= preg_match('/MariaDB/', $db_version, $matches)
					? DB_MIN_VERSION['mariadb']
					: DB_MIN_VERSION['mysql'];
			}

			$valid_db_version	= (bool) version_compare($db_version, $min_db_version, '>=');

			echo '<li>' . ($valid_db_version
				? $lang['TestDatabaseVersion'] . ' ' . output_image($valid_db_version)
				: Ut::perc_replace(
					$lang['ErrorDatabaseVersion'],
					'<code>' . $db_version . '</code>',
					'<code>' . $min_db_version . '</code>') . ' ' .
					output_image($valid_db_version)
				) . '</li>';

				$fatal_error = !$valid_db_version;
		}

		echo '</ul>' . "\n";
		echo '<br>' . "\n";

		if (!$fatal_error)
		{
			require_once 'setup/_insert_config.php';
			require_once 'setup/_insert_default.php';

			if ($config['db_driver'] == 'sqlite_pdo')
			{
				require_once 'setup/database_sqlite.php';
				require_once 'setup/database_sqlite_updates.php';
			}
			else
			{
				require_once 'setup/database_mysql.php';
				require_once 'setup/database_mysql_updates.php';
			}

			require_once 'setup/_insert_queries.php';

			if (isset($config['DeleteTables']) && $config['DeleteTables'] == 'on')
			{
				echo '<h2>' . $lang['DeletingTables'] . '</h2>' . "\n";
				echo '<ol>' . "\n";

				foreach ($delete_table as $value)
				{
					test_pdo(
						Ut::perc_replace($lang['DeletingTable'], '<code>' . $value[0] . '</code>'),
						$value[1],
						Ut::perc_replace($lang['ErrorDeletingTable'], '<code>' . $value[0] . '</code>')
					);
				}

				echo '<li>' . $lang['DeletingTablesEnd'] . '</li>' . "\n";
				echo '</ol>' . "\n";
				echo '<br>' . "\n";

				$version = 0;
			}

			if (!is_null($version))
			{
				// new installation
				if ($version == '0')
				{
					echo '<h2>' . $lang['InstallTables'] . '</h2>' . "\n";
					echo '<ol>' . "\n";

					foreach ($create_table as $value)
					{
						test_pdo(
							Ut::perc_replace($lang['CreatingTable'], '<code>' . $value[0] . '</code>'),
							$value[1],
							Ut::perc_replace($lang['ErrorCreatingTable'], '<code>' . $value[0] . '</code>')
						);
					}

					if ($config['db_driver'] == 'sqlite_pdo')
					{
						$dblink->query("PRAGMA journal_mode=WAL");

						foreach ($create_trigger as $n => $value)
						{
							test_pdo(
								Ut::perc_replace($lang['CreatingTrigger'], '<code>' . $n . '</code>'),
								$value,
								Ut::perc_replace($lang['ErrorCreatingTrigger'], '<code>' . $n . '</code>')
								);
						}
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
						$lang['InstallLogoImage'],
						$insert_logo_image,
						Ut::perc_replace($lang['ErrorAlreadyExists'], $lang['LogoImage'])
					);

					echo '</ol>' . "\n";
				}
				else
				{
					// The funny upgrading stuff. Make sure these are in order!
					uksort($upgrade, function($a, $b) {
						return version_compare ($a, $b);
					});

					foreach (array_keys($upgrade) as $to_version) // index == value, BTW
					{
						if (version_compare($version, $to_version, '<='))
						{
							echo '<h2>Wacko ' . $to_version . ' ' . $lang['To'] . ' ' . WACKO_VERSION . '</h2>' . "\n";
							echo '<ol>' . "\n";

							foreach ($upgrade[$to_version] as $value)
							{
								test_pdo(
									Ut::perc_replace($upgrade_msg[$value[0]]['ok'], '<code>' . $value[1] . '</code>'),
									$value[2],
									Ut::perc_replace($upgrade_msg[$value[0]]['error'], '<code>' . $value[1] . '</code>')
								);
							}

							echo '</ol>' . "\n";
						}
					}
				}

				echo '<br>' . "\n";
				echo '<h2>' . $lang['InstallDefaultData'] . '</h2>' . "\n";
				echo '<ul>' . "\n";

				// inserting config values
				test_pdo(
					$lang['InstallConfigValues'],
					$insert_config,
					Ut::perc_replace($lang['ErrorAlreadyExists'], $lang['ConfigValues'])
				);

				echo '<li>' . $lang['InstallPagesBegin'];
				require_once 'setup/insert_pages.php';
				echo '</li>' . "\n";
				echo '<li>' . $lang['InstallPagesEnd'] . '</li>' . "\n";
				echo '</ul>' . "\n";
			}
		}

		break;
}

if (!$fatal_error)
{
?>
<p><?php echo Ut::perc_replace($lang['NextStep'], '<code>' . CONFIG_FILE . '</code>');?></p>
<form action="<?php echo $base_path; ?>?installAction=write-config" method="post">
<?php
	// set detected db_vendor
	$config_parameters['db_vendor'] = $config['db_vendor'];

	write_config_hidden_nodes($config_parameters);
?>
	<button type="submit" class="next"><?php echo $lang['Continue'];?></button>
</form>
<?php
}
else
{
?>
<button type="submit" class="next" onclick="history.go(-1);"><?php echo $lang['Back'];?></button>
<button type="button" class="next" onClick="window.location.reload( true );"><?php echo $lang['TryAgain'];?></button>
<?php
}
?>
