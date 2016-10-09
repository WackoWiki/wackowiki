<?php

// config values
if ( ( $config['database_driver'] == ('mysqli_legacy' || 'mysql_pdo') ) && empty( $config['database_port'] ) )
{
	$config['database_port'] = $config['database_port'] = '3306';
}

// set version to current version, yay!
$config['wacko_version'] = WACKO_VERSION;

$config_file = [];

///////////////////////////////////////////////////////////////////////////////////////////
//	BEGIN MANDATORY CONFIGURATION
///////////////////////////////////////////////////////////////////////////////////////////
$config_file['base_url']				= $config['base_url'];
// database connection
$config_file['database_charset']		= $config['database_charset'];
$config_file['database_collation']		= $config['database_collation'];
$config_file['database_driver']			= $config['database_driver'];
$config_file['database_engine']			= $config['database_engine'];
$config_file['database_host']			= $config['database_host'];
$config_file['database_port']			= $config['database_port'];
$config_file['database_database']		= $config['database_database'];
$config_file['database_user']			= $config['database_user'];
$config_file['database_password']		= $config['database_password'];
$config_file['sql_mode_strict']			= $config['sql_mode_strict'];
$config_file['table_prefix']			= $config['table_prefix'];
// security values
$config_file['system_seed']				= $config['system_seed'];
$config_file['recovery_password']		= $config['recovery_password'];
$config_file['hashid_seed']				= $config['hashid_seed'];
// version
$config_file['wacko_version']			= $config['wacko_version'];

///////////////////////////////////////////////////////////////////////////////////////////
//	END MANDATORY CONFIGURATION
///////////////////////////////////////////////////////////////////////////////////////////

// convert config array into PHP code
$config_code  = "<?php\n// config.php ".$lang['WrittenAt'].strftime("%c")."\n// ".$lang['ConfigDescription']."\n// ".$lang['DontChange']."\n\n";
$config_code .= array_to_str($config_file)."\n?>";

// try to write configuration file
echo "         <h2>".$lang['FinalStep']."</h2>\n";
echo "         <ul>\n";
echo "            <li>".$lang['Writing']." - ";

$perm_changed	= true;
$file_name		= CONFIG_FILE;

if (is_writable($file_name))
{
	$write_file		= file_put_contents($file_name, $config_code);

	if ($write_file == true)
	{
		// Try and make it non-writable
		@chmod($file_name, 0644);
		$perm_changed = !is_writable($file_name);

		echo output_image(true)."</li>\n";

		echo "            <li>".$lang['RemovingWritePrivilege']."   ".output_image($perm_changed)."</li>\n";
	}
	else
	{
		// Problem saving file
		echo output_image(false)."</li>\n";
	}
}
else
{
	// Folder is non-writable
	$write_file = false;
	echo output_image(false)."</li>\n";
}

echo "         </ul>\n";

// TODO: show feedback?
if ($config['is_update'])
{
	// purge old cache files
	Ut::purge_directory(CACHE_PAGE_DIR);
	Ut::purge_directory(CACHE_SQL_DIR);
	Ut::purge_directory(CACHE_CONFIG_DIR);
	Ut::purge_directory(CACHE_TEMPLATE_DIR);
}

echo "         <h2>".$lang['SecurityConsiderations']."</h2>\n";
echo "         <ul class=\"security\">\n";

if(!$perm_changed)
{
	echo "            <li>".$lang['SecurityRisk']."</li>\n";
}

echo "            <li>".$lang['RemoveSetupDirectory']."</li>\n";

if($write_file == false)
{
	echo "            <li>".$lang['ErrorGivePrivileges']."</li>\n";
}

echo "         </ul>\n";

?>
<form action="<?php echo my_location() ?>?installAction=write-config" method="post">
<?php
	write_config_hidden_nodes(array('none' => ''));

	// If there was a problem then show the "Try Again" button.
	if($write_file == true)
	{
		echo "         <h2>".$lang['InstallationComplete']."</h2>\n";
		echo "         <p>".str_replace('%1', $config['base_url'], $lang['ThatsAll'])."</p>\n";
	}
	else
	{
		?> <input type="submit" value="<?php echo $lang['TryAgain'];?>" class="next" />
		<?php
	}
	?></form>
	<?php
	if($write_file == false)
	{
		echo '         <div id="config_code" class="config_code"><pre>'.htmlentities($config_code, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)."</pre></div>\n";
	}
	?>
<br />
