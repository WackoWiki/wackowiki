<form action="<?php echo my_location() ?>?installAction=site-config" method="post">
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
<h2><?php echo $lang['PHPVersion']; ?></h2>
<p class="notop"><?php echo $lang['PHPDetected']; ?> <?php echo phpversion() . '   ' . output_image($php_version_result); ?></p>
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
	<li>MySQLi   <?php echo output_image(extension_loaded('mysqli')); ?></li>
	<li>PDO   <?php echo output_image($detected > 0); ?></li>
</ul>
	<?php
	/*
	 Check for required PHP Extensions
	 */

	// TODO: check for mb_string, iconv, bcmath, pcre, pcre utf-8, ctype, gd, JSON, SPL extension
	//		- Case 'PCRE has not been compiled with Unicode property support.'
	$php_extension = [
		'bcmath',
		'ctype',
		'gd',
		'iconv',
		'json',
		'mbstring',
		'openssl',
		'pcre',
		'spl',
	];
	?>
<h2><?php echo $lang['PHPExtensions']; ?></h2>
<ul>
	<?php
	foreach ($php_extension as $extension)
	{
		$result = extension_loaded($extension);

		if (!$result)
		{
			$php_extension_result = false;
		}

		echo "\t<li>" . $extension . ' ', output_image($result), "</li>\n";
	}
	?>
</ul>
	<?php
	/*
	 Check file permissions
	 */

	// [0] - directory, file
	// [1] - permissions (octal integer, precede the number with a 0 (zero)!)
	$file_permission = [
		[CACHE_CONFIG_DIR,		0777],
		[CACHE_FEED_DIR,		0777],
		[CACHE_PAGE_DIR,		0777],
		[CACHE_SQL_DIR,			0777],
		[CACHE_TEMPLATE_DIR,	0777],
		[CONFIG_FILE,			0777],
		[SITE_LOCK,				0660],
		[AP_LOCK,				0660],
		[UPLOAD_BACKUP_DIR,		0777],
		[UPLOAD_GLOBAL_DIR,		0777],
		[UPLOAD_PER_PAGE_DIR,	0777],
		[THUMB_DIR,				0777],
		[XML_DIR,				0777],
		[SITEMAP_XML,			0777],
	];

	$file_permissions_result = true;

	// If the cache directory is writable then we can enable caching as default
	echo '			<input type="hidden" name="config[cache]" value="' . (is_writable(CACHE_PAGE_DIR) ? '1' : $config['cache']) . '">' . "\n";
	?>
<h2><?php echo $lang['Permissions']; ?></h2>
<ul>
	<?php
	// Try applying the correct permissions now and then display whether it worked or not, if they fail then the user will have to manually set the permissions
	foreach ($file_permission as $permission)
	{
		@chmod ($permission[0], $permission[1]);
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
<p><?php echo Ut::perc_replace($lang['NotePermissions'], '<code>' . CONFIG_FILE . '</code>');?></p>
<input type="submit" value="<?php echo $lang['Continue'];?>" class="next">
<?php
	}
	else if (!$php_version_result)
	{
?>
<p><?php echo $lang['ErrorMinPHPVersion']; ?></p>
<input type="button" value="<?php echo $lang['TryAgain'];?>" class="next" onClick="window.location.reload( true );">
<?php
	}
	else if (!$database_result)
	{
?>
<p><?php echo $lang['ErrorNoDbDriverDetected']; ?></p>
<input type="button" value="<?php echo $lang['TryAgain'];?>" class="next" onClick="window.location.reload( true );">
<?php
	}
	else if (!$file_permissions_result)
	{
?>
<p class="warning"><?php echo Ut::perc_replace($lang['NotePermissions'], '<code>' . CONFIG_FILE . '</code>'); ?></p>
<p class="security"><?php echo $lang['ErrorPermissions']; ?></p>
<input type="button" value="<?php echo $lang['TryAgain'];?>" class="next" onClick="window.location.reload( true );">
<input type="submit" value="<?php echo $lang['Continue'];?>" class="next">
<?php
	}
?>
</form>
