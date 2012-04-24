<form action="<?php echo my_location() ?>?installAction=site-config" method="post">
<?php

write_config_hidden_nodes(array('none' => ''));

?>
<p><?php echo $lang['Requirements']; ?></p>
	<?php
	/*
		Check PHP Version
	*/

	$php_version_result = version_compare(PHP_MIN_VERSION, PHP_VERSION, '<');
	?>
<h2><?php echo $lang['PHPVersion']; ?></h2>
<p class="notop"><?php echo $lang['PHPDetected']; ?> <?php echo phpversion().'   '.output_image($php_version_result); ?></p>
	<?php
	/*
		Check if mod_rewrite is installed
	*/
	?>
<h2><?php echo $lang['ModRewrite']; ?></h2>
<p class="notop"><?php echo $lang['ModRewriteInstalled']; ?>   <?php if(function_exists('apache_get_modules')) { echo output_image(in_array('mod_rewrite', apache_get_modules())); } else { echo $lang['ModRewriteStatusUnknown']; } ?></p>
	<?php
	/*
	 Check which database extensions are installed and what versions of the db are there
	 */
	$database_result = extension_loaded('mysql') || extension_loaded('mysqli') || extension_loaded('pdo');

	/*
		With PDO it is not enough that we can just say "ok we've detected PDO".
		We have to actually confirm that one of the specific database types is enabled.
		Later when we support all the PDO types this can be removed but for now we
		only support a subset of them.

		This is a copy of the array from database-config.php
	*/

	$accepted_pdo_drivers	= array();
	$accepted_pdo_drivers[]	= 'mysql';

	$detected = 0;

	if(extension_loaded('pdo'))
	{
		// mssql mysql sqlite
		$drivers = PDO::getAvailableDrivers();

		for($count = 0; $count < count($drivers); $count++)
		{
			// If you want to find the name out
			// print $drivers[$count];

			if(in_array($drivers[$count], $accepted_pdo_drivers))
			{
				$detected++;
				break;
			}
		}
	}
	?>
<h2><?php echo $lang['Database']; ?></h2>
<ul>
	<li>MySQL   <?php echo output_image(extension_loaded('mysql')); ?></li>
	<li>MySQLi   <?php echo output_image(extension_loaded('mysqli')); ?></li>
	<li>PDO   <?php echo output_image($detected > 0); ?></li>
</ul>
	<?php
	/*
	 Check file permissions
	 */

	// Try applying the correct permissions now and then display whether it worked or not, if they fail then the user will have to manually set the permissions
	@chmod ('_cache/config', 0777);
	@chmod ('_cache/feeds', 0777);
	@chmod ('_cache/pages', 0777);
	@chmod ('_cache/queries', 0777);
	@chmod ('config/config.php', 0777);
	@chmod ('config/lock', 0660);
	@chmod ('config/lock_ap', 0660);
	@chmod ('files/global', 0777);
	@chmod ('files/perpage', 0777);
	@chmod ('xml', 0777);
	@chmod ('sitemap.xml', 0777);


	// If the cache directory is writable then we can enable caching as default
	echo "            <input type=\"hidden\" name=\"config[cache]\" value=\"".(is__writable('_cache/') ? "1" : $config['cache'])."\" />\n";

	$file_permissions_result = is__writable('config/config.php') && is__writable('_cache/config/') && is__writable('_cache/feeds/') && is__writable('_cache/pages/') && is__writable('_cache/queries/') && is__writable('xml/') && is__writable('files/global/') && is__writable('files/perpage/') && is__writable('sitemap.xml');
	?>
<h2><?php echo $lang['Permissions']; ?></h2>
<ul>
	<li>_cache/config   <?php echo output_image(is__writable('_cache/config/')); ?></li>
	<li>_cache/feeds   <?php echo output_image(is__writable('_cache/feeds/')); ?></li>
	<li>_cache/pages   <?php echo output_image(is__writable('_cache/pages/')); ?></li>
	<li>_cache/queries   <?php echo output_image(is__writable('_cache/queries/')); ?></li>
	<li>config/config.php   <?php echo output_image(is__writable('config/config.php')); ?></li>
	<li>config/lock   <?php echo output_image(is__writable('config/lock')); ?></li>
	<li>config/lock_ap   <?php echo output_image(is__writable('config/lock_ap')); ?></li>
	<li>files/global   <?php echo output_image(is__writable('files/global/')); ?></li>
	<li>files/perpage   <?php echo output_image(is__writable('files/perpage/')); ?></li>
	<li>xml   <?php echo output_image(is__writable('xml/')); ?></li>
	<li>sitemap.xml   <?php echo output_image(is__writable('sitemap.xml')); ?></li>
</ul>
	<?php
	/*
		End of checks, are we ready to install?
	*/
	?>
<h2><?php echo $lang['ReadyToInstall']; ?></h2>
	<?php
	if($php_version_result && $database_result && $file_permissions_result)
	{
		?>
<p><?php echo $lang['Ready'];?></p>
<p><?php echo $lang['NotePermissions'];?></p>
<input type="submit" value="<?php echo $lang['Continue'];?>" class="next" />
<?php
	}
	else if(!$php_version_result)
	{
?>
<p><?php echo $lang['ErrorMinPHPVersion']; ?></p>
<input type="button" value="<?php echo $lang['TryAgain'];?>" class="next" onClick="window.location.reload( true );" />
<?php
	}
	else if(!$database_result)
	{
?>
<p><?php echo $lang['ErrorNoDbDriverDetected']; ?></p>
<input type="button" value="<?php echo $lang['TryAgain'];?>" class="next" onClick="window.location.reload( true );" />
<?php
	}
	else if(!$file_permissions_result)
	{
?>
<p><?php echo $lang['NotePermissions']; ?></p>
<p><?php echo $lang['ErrorPermissions']; ?></p>
<input type="button" value="<?php echo $lang['TryAgain'];?>" class="next" onClick="window.location.reload( true );" />
<input type="submit" value="<?php echo $lang['Continue'];?>" class="next" />
<?php
	}
?>
</form>