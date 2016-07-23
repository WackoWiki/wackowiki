<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   System Informations                              ##
########################################################

$module['system_info'] = array(
		'order'	=> 130,
		'cat'	=> 'Basic functions',
		'status'=> true,
		'mode'	=> 'system_info',
		'name'	=> 'System Info',
		'title'	=> 'System Informations',
	);

########################################################

function admin_system_info(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	Version informations:<br />
	<br />
	<table style="max-width:600px; border-spacing: 1px; border-collapse: separate; padding: 4px;" class="formation">
		<tr>
			<th style="width:120px;">Parameter</th>
			<th style="text-align:left;"></th>
			<th style="text-align:left;">Value</th>
		</tr>
<?php

	// get MariaDB / mysql version
	$_db_version		= $engine->db->load_single("SELECT version()");
	$db_version			= $_db_version['version()'];

	// get SQL mode
	$_sql_mode			= $engine->db->load_single("SELECT @@GLOBAL.sql_mode, @@SESSION.sql_mode");
	$sql_mode_global	= $_sql_mode['@@GLOBAL.sql_mode'];
	$sql_mode_session	= $_sql_mode['@@SESSION.sql_mode'];

	// get_cfg_var()	-> returns whatever is in php.ini
	// ini_get()		-> returns runtime settings
	$upload_max_filesize = trim(str_replace('M', '', get_cfg_var('upload_max_filesize')));

	// check if gzip compression is enabled // @extension_loaded('zlib')
	if (function_exists('ob_gzhandler') || ini_get('zlib.output_compression'))
	{
		$gzip_compression = 'On';
	}
	else
	{
		$gzip_compression = 'Off';
	}

	$memory = trim(str_replace('M', '', ini_get('memory_limit')));

	// fallback if ini_get doesn't work
	if (intval($memory) == 0)
	{
		$memory = trim(str_replace('M', '', get_cfg_var('memory_limit')));
	}

	$_php_ram = $memory;

	// Sysinfo in array
	$sysinfo['app_version']			= array('Wacko version', $engine->config['wacko_version']);
	$sysinfo['app_updated']			= array('Last update', $engine->config['maint_last_update']);
	$sysinfo['os']					= array('OS', PHP_OS.' ('.@php_uname().')');
	$sysinfo['server_name']			= array('Server name', $_SERVER['SERVER_NAME']);
	$sysinfo['server_software']		= array('Web server', $_SERVER['SERVER_SOFTWARE']);
	$sysinfo['db_version']			= array('MariaDB / MySQL version', $db_version);
	$sysinfo['sql_mode_global']		= array('SQL Modes Global', $sql_mode_global);
	$sysinfo['sql_mode_session']	= array('SQL Modes Session', $sql_mode_session);
	$sysinfo['php_version']			= array('PHP Version', PHP_VERSION);
	$sysinfo['memory']				= array('Memory', $engine->binary_multiples($_php_ram * 1024 * 1024, false, true, true));
	$sysinfo['upload_max_filesize']	= array('Upload max filesize', $engine->binary_multiples($upload_max_filesize * 1024 * 1024, false, true, true));
	$sysinfo['max_execution_time']	= array('Max execution time', get_cfg_var('max_execution_time').' seconds');
	$sysinfo['session_save_path']	= array('Session path', get_cfg_var('session.save_path'));
	$sysinfo['default_charset']		= array('PHP default charset', ini_get('default_charset'));
	$sysinfo['gzip_compression']	= array('GZip compression', $gzip_compression);
	$sysinfo['php_extensions']		= array('PHP extensions', implode(', ',get_loaded_extensions()));

	if ( function_exists( 'apache_get_modules' ) )
	{
		$sysinfo['apache_modules']		= array('Apache modules', implode(', ',apache_get_modules()));
	}

	foreach ($sysinfo as $param => $value)
	{
		echo '<tr class="lined">'.
				'<td class="label"><strong>'.$value[0].'</strong></td>'.
				'<td> </td>'.
				'<td>'.$value[1].'</td>'.
			#'<tr class="lined"><td colspan="5"></td></tr>'.
			"\n";
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