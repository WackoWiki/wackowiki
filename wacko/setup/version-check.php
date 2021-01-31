<form action="<?php echo my_location() ?>?installAction=config-site" method="post">
<?php

write_config_hidden_nodes(['none' => '']);

?>
<p><?php echo $lang['Requirements']; ?></p>
	<?php
	/*
		Check PHP Version
	*/

	$php_version_result = version_compare(PHP_MIN_VERSION, PHP_VERSION, '<');
	?>
<h2><?php echo $lang['PhpVersion']; ?></h2>
<p class="notop"><?php echo $lang['PhpDetected']; ?> <?php echo phpversion() . '   ' . output_image($php_version_result); ?></p>
	<?php
	/*
		Check if mod_rewrite is installed
	*/
	?>
<h2><?php echo $lang['ModRewrite']; ?></h2>
<p class="notop"><?php echo $lang['ModRewriteInstalled']; ?>
	<?php
	if (function_exists('apache_get_modules'))
	{
		echo output_image(in_array('mod_rewrite', apache_get_modules()));
	}
	else
	{
		echo $lang['ModRewriteStatusUnknown'];
	} ?>
</p>
	<?php
	if ($config['is_update'])
	{
		$_db_version		= $db->load_single("SELECT version()");
		$db_version			= $_db_version['version()'];
		$min_db_version		= preg_match('/MariaDB/', $db_version, $matches)
			? DB_MIN_VERSION['mariadb']
			: DB_MIN_VERSION['mysql'];
		$valid_db_version	= version_compare($db_version, $min_db_version , '>=')
			? true
			: false;
	}

	/*
	 Check which database extensions are installed and what versions of the db are there
	 */
	$database_result = extension_loaded('mysqli') || extension_loaded('pdo');

	/*
		With PDO it is not enough that we can just say "ok we've detected PDO".
		We have to actually confirm that one of the specific database types is enabled.
		Later when we support all the PDO types this can be removed but for now we
		only support a subset of them.

		This is a copy of the array from database-config.php
	*/

	$accepted_pdo_drivers	= [];
	$accepted_pdo_drivers[]	= 'mysql';

	$detected = 0;

	if (extension_loaded('pdo'))
	{
		// mssql mysql sqlite
		$drivers = PDO::getAvailableDrivers();

		for ($count = 0; $count < count($drivers); $count++)
		{
			// If you want to find the name out
			// print $drivers[$count];

			if (in_array($drivers[$count], $accepted_pdo_drivers))
			{
				$detected++;
				break;
			}
		}
	}
	?>
<h2><?php echo $lang['Database']; ?></h2>
<ul>
	<?php
	if ($config['is_update'])
	{
		echo '<li>Version: ' . $db_version . '   ' . output_image($valid_db_version) . "<br><br></li>\n";
	}
	?>

	<li>MySQLi   <?php echo output_image(extension_loaded('mysqli')); ?></li>
	<li>PDO   <?php echo output_image($detected > 0); ?></li>
</ul>
	<?php
	/*
	 Check for required PHP Extensions
	 */

	// check for mb_string, iconv, bcmath, pcre, ctype, gd, JSON, SPL extension
	$php_extension = [
		'bcmath',
		'ctype',
		'gd',
		'iconv',
		'intl',
		'json',
		'mbstring',
		'openssl',
		'pcre',
		'spl',
	];
	?>
<h2><?php echo $lang['PhpExtensions']; ?></h2>
<ul class="column-3">
	<?php
	foreach ($php_extension as $extension)
	{
		$result = extension_loaded($extension);

		if (!$result)
		{
			$php_extension_result = false;
		}

		echo "\t<li>" . $extension . ' ' . output_image($result) . "</li>\n";
	}

	// Check whether PCRE has been compiled with UTF-8 support
	$UTF8_ar = [];

	if (1 != preg_match('/^.{1}$/u', "ñ", $UTF8_ar))
	{
		echo "\t<li>" . $lang['PcreWithoutUtf8'] . ' ' . output_image(false) . "</li>\n";
	}

	unset($UTF8_ar);
	?>
</ul>
	<?php
	/*
	 Check file permissions
	 */

	// [0] - directory, file
	// [1] - write permissions (octal integer, precede the number with a 0 (zero)!)
	$file_permission = [
		[CACHE_CONFIG_DIR,		CHMOD_DIR],
		[CACHE_FEED_DIR,		CHMOD_DIR],
		[CACHE_PAGE_DIR,		CHMOD_DIR],
		[CACHE_SESSION_DIR,		CHMOD_DIR],
		[CACHE_SQL_DIR,			CHMOD_DIR],
		[CACHE_TEMPLATE_DIR,	CHMOD_DIR],
		[CONFIG_FILE,			CHMOD_FILE],
		[SITE_LOCK,				CHMOD_FILE],
		[AP_LOCK,				CHMOD_FILE],
		[UPLOAD_BACKUP_DIR,		CHMOD_DIR],
		[UPLOAD_GLOBAL_DIR,		CHMOD_DIR],
		[UPLOAD_PER_PAGE_DIR,	CHMOD_DIR],
		[THUMB_DIR,				CHMOD_DIR],
		[XML_DIR,				CHMOD_DIR],
		[SITEMAP_XML,			CHMOD_FILE],
	];

	$file_permissions_result = true;

	// If the cache directory is writable then we can enable caching as default
	echo '<input type="hidden" name="config[cache]" value="' . (is_writable(CACHE_PAGE_DIR) ? '1' : $config['cache']) . '">' . "\n";
	?>
<h2><?php echo $lang['Permissions']; ?></h2>
<ul>
	<?php
	// Try applying the correct permissions now and then display whether it worked or not, if they fail then the user will have to manually set the permissions
	foreach ($file_permission as $permission)
	{
		@chmod($permission[0], $permission[1]);
		$result = is_writable($permission[0]);

		if (!$result)
		{
			$file_permissions_result = false;
			# echo "\t<li>" . 'File permissions: <code>' . decoct(fileperms($permission[0])) . "</code></li>\n";
		}

		echo "\t<li>" . $permission[0] . '   ' . output_image($result) . "</li>\n";
	}
	?>
</ul>
	<?php
	/*
		End of checks, are we ready to install?
	*/
	?>
<h2><?php echo $lang['ReadyToInstall']; ?></h2>
	<?php
	if ($php_version_result && $database_result && $file_permissions_result)
	{
		?>
<p><?php echo $lang['Ready'];?></p>
<p class="warning"><?php echo Ut::perc_replace($lang['NotePermissions'], '<code>' . CONFIG_FILE . '</code>');?></p>
<button type="submit" class="next"><?php echo $lang['Continue'];?></button>
<?php
	}
	else if (!$php_version_result)
	{
?>
<p><?php echo $lang['ErrorMinPhpVersion']; ?></p>
<button type="button" class="next" onClick="window.location.reload( true );"><?php echo $lang['TryAgain'];?></button>
<?php
	}
	else if (!$database_result)
	{
?>
<p><?php echo $lang['ErrorNoDbDriverDetected']; ?></p>
<button type="button" class="next" onClick="window.location.reload( true );"><?php echo $lang['TryAgain'];?></button>
<?php
	}
	else if (!$file_permissions_result)
	{
?>
<p class="warning"><?php echo Ut::perc_replace($lang['NotePermissions'], '<code>' . CONFIG_FILE . '</code>'); ?></p>
<p class="security"><?php echo $lang['ErrorPermissions']; ?></p>
<button type="button" class="next" onClick="window.location.reload( true );"><?php echo $lang['TryAgain'];?></button>
<button type="submit" class="next"><?php echo $lang['Continue'];?></button>
<?php
	}
?>
</form>
