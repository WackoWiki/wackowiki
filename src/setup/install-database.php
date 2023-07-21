<?php
@set_time_limit(0);
@ignore_user_abort(true);

// test configuration
echo '<h2>' . $lang['TestingConfiguration'] . '</h2>' . "\n";

$delete_table		= [];
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

// update config values
if ($config['is_update'])
{
	if (version_compare($config['wacko_version'], '6.1.13', '<'))
	{
		$config['rename_global_acl']	= $config['rename_globalacl'];
	}

	if (version_compare($config['wacko_version'], '6.1.4', '<'))
	{
		// set timezone and new ICU formats
		$config['timezone']				= 'UTC';
		$config['date_format']			= 'dd.MM.yyyy';
		$config['time_format']			= 'HH:mm';
		$config['time_format_seconds']	= 'HH:mm:ss';

		$config['ext_bad_behaviour']	= $config['ext_bad_behavior'];
	}

	if (version_compare($config['wacko_version'], '6.1.17', '<'))
	{
		$config['typografica']			= $config['default_typografica'];
	}

	if (version_compare($config['wacko_version'], '6.1.19', '<'))
	{
		$config['upload_banned_exts']	= 'asa, asax, ascx, ashx, asmx, asp, aspx, axd, bat, cdx, cer, cgi, cmd, com, config, cpl, csproj, cs, dll, exe, htm, html, htr, htw, ida, idc, idq, jhtml, js, jsb, jsp, licx, mht, mhtml, msi, phar, php, php3, php4, php5, php7, pht, phtm, phtml, pif, pl, printer, py, rem, resources, resx, scr, shtm, shtml, soap, ssi, stm, vb, vbproj, vbs, vdisco, vxd, webinfo, xap, xht, xhtm, xhtml';
	}

	if (version_compare($config['wacko_version'], '6.1.20', '<'))
	{
		$config['max_page_size']		= 2048 * 1024;
	}

	if (version_compare($config['wacko_version'], '6.1.21', '<'))
	{
		$config['create_thumbnail']		= $config['img_create_thumbnail']	?? 0;
		$config['max_thumb_width']		= $config['img_max_thumb_width']	?? 150;
	}
}

/*
 Set up the tables depending on which database we selected

 mysqli_legacy which is the default clause
 or pdo
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

if (!empty($config['sql_mode_strict']))
{
	$sql_modes = SQL_MODE_STRICT;
}
else
{
	$sql_modes = SQL_MODE_PERMISSIVE;
}

switch ($config['db_driver'])
{
	case 'mysqli_legacy':

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
				$lang['ErrorDbConnection'] . '<br>' . 'MySQLi Error: ' . $e->getMessage()
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
			mysqli_query($dblink, "SET SESSION sql_mode='$sql_modes'");

			// check min database version
			$_db_version	= mysqli_query($dblink, "SELECT version()");
			$_db_version	= mysqli_fetch_assoc($_db_version);
			$db_version		= $_db_version['version()'];

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

	default:
		$dsn = match ($config['db_driver']) {
			'mysql_pdo'	=> "mysql:host=" . $config['db_host'] . ($config['db_port'] != '' ? ";port=" . $config['db_port'] : '') . ";dbname=" . $config['db_name'] . ($config['db_charset'] != '' ? ";charset=" . $config['db_charset'] : ''),
			# 'pgsql'	=> $config['db_driver'] . ":dbname=" . $config['db_name'] . ";host=" . $config['db_host'].($config['db_port'] != "" ? ";port=" . $config['db_port'] : ""),
			# 'sqlite3'	=> '',
			default		=> '',
		};

		echo '<ul>' . "\n";

		global $dblink;

		// Do the initial database connection test separately as it is a special case.
		try
		{
			test(
				$lang['TestConnectionString'],
				$dblink = @new PDO($dsn, $config['db_user'], $config['db_password']),
				$lang['ErrorDbConnection']
			);
			$dblink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e)
		{
			test(
				$lang['TestConnectionString'],
				false,
				$lang['ErrorDbConnection'] . '<br>' . 'PDO Error: ' . $e->getMessage()
			);
			$fatal_error = true;
		}

		// set SESSION sql_mode
		$dblink->query("SET SESSION sql_mode='$sql_modes'");

		// check min database version
		$_db_version	= $dblink->query("SELECT version()");
		$_db_version	= $_db_version->fetch(PDO::FETCH_ASSOC);
		$db_version		= $_db_version['version()'];

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
