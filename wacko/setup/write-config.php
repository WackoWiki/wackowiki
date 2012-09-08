<?php

function array_to_str ($arr, $name = '')
{
	if (!isset($entries)) $entries = '';
	if (!isset($arrays)) $arrays = '';

	$str = "\$wacko_config".($name ? "[\"".$name."\"]" : "")." = array(\n";

	foreach ($arr as $k => $v)
	{
		if(is_array($v))
		{
			$arrays .= array_to_str($v, $k);
		}
		else
		{
			$entries .= "\t'".$k.'\' => \''.str_replace("\n", "\\n", $v)."',\n";
		}
	}

	$str .= $entries.");\n";
	$str .= $arrays;
	return $str;
}

// config values
if ( ( $config['database_driver'] == ('mysqli_legacy' || 'mysql_pdo') ) && empty( $config['database_port'] ) )
{
	$config['database_port'] = $config['database_port'] = '3306';
}

// set version to current version, yay!
$config['wacko_version'] = WACKO_VERSION;

// reset old default upload path to new location
if ($config['upload_path'] == 'files')
{
	$config['upload_path'] = 'files/global';
}

///////////////////////////////////////////////////////////////////////////////////////////
//	BEGIN MANDATORY CONFIGURATION
///////////////////////////////////////////////////////////////////////////////////////////
$config_file['base_url']				= $config['base_url'];
// database connection
$config_file['database_collation']		= $config['database_collation'];
$config_file['database_driver']			= $config['database_driver'];
$config_file['database_engine']			= $config['database_engine'];
$config_file['database_host']			= $config['database_host'];
$config_file['database_port']			= $config['database_port'];
$config_file['database_database']		= $config['database_database'];
$config_file['database_user']			= $config['database_user'];
$config_file['database_password']		= $config['database_password'];
$config_file['table_prefix']			= $config['table_prefix'];
// security values
$config_file['system_seed']				= $config['system_seed'];
$config_file['recovery_password']		= $config['recovery_password'];
// paths
$config_file['cache_dir']				= $config['cache_dir'];
$config_file['classes_path']			= $config['classes_path'];
$config_file['action_path']				= $config['action_path'];
$config_file['handler_path']			= $config['handler_path'];
$config_file['upload_path']				= $config['upload_path'];
$config_file['upload_path_per_page']	= $config['upload_path_per_page'];
$config_file['upload_path_backup']		= $config['upload_path_backup'];
$config_file['header_action']			= $config['header_action'];
$config_file['footer_action']			= $config['footer_action'];
// version
$config_file['wacko_version']			= $config['wacko_version'];
#$config_file['']						= $config[''];

// convert config array into PHP code
$config_code = "<?php\n// config.php ".$lang['WrittenAt'].strftime("%c")."\n// ".$lang['ConfigDescription']."\n// ".$lang['DontChange']."\n\n";
$config_code .= array_to_str($config_file)."\n?>";

// try to write configuration file
echo "         <h2>".$lang['FinalStep']."</h2>\n";
echo "         <ul>\n";
echo "            <li>".$lang['Writing']." - ";

$perm_changed	= true;
$filename		= 'config/config.php';
$write_file		= file_put_contents($filename, $config_code);

if ($write_file == true)
{
	// Try and make it non-writable
	@chmod($filename, 0644);
	$perm_changed = !is__writable($filename);

	echo output_image(true)."</li>\n";

	print("            <li>".$lang['RemovingWritePrivilege']."   ".output_image($perm_changed))."</li>\n";
}
else
{
	// Problem saving file
	print(output_image(false)."</li>\n");
}

echo "         </ul>\n";

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
<form action="<?php echo my_location() ?>?installAction=write-config"
	method="post"><?php
	write_config_hidden_nodes(array('none' => ''));

	// If there was a problem then show the "Try Again" button.
	if($write_file == true)
	{
		echo "         <h2>".$lang['InstallationComplete']."</h2>\n";
		echo "         <p>".str_replace('%1', $config['base_url'], $lang['ThatsAll'])."</p>\n";
	}
	else
	{
		?> <input type="submit" value="<?php echo $lang['TryAgain'];?>" class="next" /> <?php
	}
	?></form>
	<?php
	if($write_file = false)
	{
		echo "         <div id=\"config_code\" class=\"config_code\"><pre>".htmlentities($config_code)."</pre></div>\n";
	}
	?>
<br />