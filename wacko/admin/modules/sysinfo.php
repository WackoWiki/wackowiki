<?php

########################################################
##   System Informations                              ##
########################################################

$module['sysinfo'] = array(
		'order'	=> 1,
		'cat'	=> 'Basic functions',
		'mode'	=> 'sysinfo',
		'name'	=> 'System Info',
		'title'	=> 'System Informations',
	);

########################################################

function admin_sysinfo(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	Version informations:<br />
	<br />
	<table border="0" cellspacing="1" cellpadding="4" style="max-width:600px" class="formation">
		<tr>
			<th style="width:120px;">Parameter</th>
			<th style="text-align:left;"></th>
			<th style="text-align:left;">Value</th>
		</tr>
<?php

	// get mysql version
	$_mysql_version =$engine->load_all("SELECT version()");
	$mysql_version = $_mysql_version[0]['version()'];

	$upload_max_filesize = trim(str_replace('M', '', get_cfg_var('upload_max_filesize')));

	$memory = trim(str_replace('M', '', ini_get('memory_limit')));
	// fallback if ini_get doesn't work
	if (intval($memory) == 0) $memory = trim(str_replace('M', '', get_cfg_var('memory_limit')));
	$_php_ram = $memory;

	// Sysinfo in array
	$sysinfo['app_version']			= array('Wacko version', $engine->config['wacko_version']);
	$sysinfo['os']					= array('OS', PHP_OS.' ('.@php_uname().')');
	#$sysinfo['os_extended']		= array('OS extended', @php_uname());
	$sysinfo['server_software']		= array('Web server', $_SERVER['SERVER_SOFTWARE']);
	$sysinfo['mysql_version']		= array('MySQL version', $mysql_version);
	$sysinfo['php_version']			= array('PHP Version', PHP_VERSION);
	$sysinfo['memory']				= array('Memory', $engine->binary_multiples($_php_ram*1024*1024, 0, true, true));
	$sysinfo['upload_max_filesize']	= array('Upload max filesize', $engine->binary_multiples($upload_max_filesize*1024*1024, 0, true, true));
	$sysinfo['max_execution_time']	= array('Max execution time', get_cfg_var('max_execution_time').' seconds');
	$sysinfo['php_extentions']		= array('PHP extentions', implode(', ',get_loaded_extensions()));
	if ( function_exists( 'apache_get_modules' ) )
	{
		$sysinfo['apache_modules']		= array('Apache modules', implode(', ',apache_get_modules()));
	}
	$sysinfo['server_name']			= array('Server name', $_SERVER['SERVER_NAME']);

	// add additional system parameters
	#$sysinfo['other']				= addwhatyourmissing;

	foreach ($sysinfo as $param => $value)
	{
		echo '<tr>'.
				'<td class="label"><strong>'.$value[0].'</strong></td>'.
				'<td> </td>'.
				'<td>'.$value[1].'</td>'.
			'<tr class="lined"><td colspan="5"></td></tr>'."\n";
	}
?>
	</table>

<?php

/*if ($action == 'phpinfo')
{
	// output phpinfo

	phpinfo();

	exit();
}*/

}

?>