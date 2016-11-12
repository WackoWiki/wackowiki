<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   System Informations                              ##
########################################################
$_mode = 'system_info';

$module[$_mode] = [
		'order'	=> 130,
		'cat'	=> 'basics',
		'status'=> true,
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// System Info
		'title'	=> $engine->_t($_mode)['title'],	// System Informations
	];

########################################################

function admin_system_info(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	Version informations:<br />
	<br />
	<table style="max-width:800px; border-spacing: 1px; border-collapse: separate; padding: 4px;" class="formation">
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
	$sysinfo['app_version']			= ['Wacko version', $engine->db->wacko_version];
	$sysinfo['app_updated']			= ['Last update', $engine->db->maint_last_update];
	$sysinfo['os']					= ['OS', PHP_OS.' ('.@php_uname() . ')'];
	$sysinfo['server_name']			= ['Server name', $_SERVER['SERVER_NAME']];
	$sysinfo['server_software']		= ['Web server', $_SERVER['SERVER_SOFTWARE']];
	$sysinfo['db_version']			= ['MariaDB / MySQL version', $db_version];
	$sysinfo['sql_mode_global']		= ['SQL Modes Global', wordwrap($sql_mode_global, 80, "\n", true)];
	$sysinfo['sql_mode_session']	= ['SQL Modes Session', wordwrap($sql_mode_session, 80, "\n", true)];
	$sysinfo['php_version']			= ['PHP Version', PHP_VERSION];
	$sysinfo['memory']				= ['Memory', $engine->binary_multiples($_php_ram * 1024 * 1024, false, true, true)];
	$sysinfo['upload_max_filesize']	= ['Upload max filesize', $engine->binary_multiples($upload_max_filesize * 1024 * 1024, false, true, true)];
	$sysinfo['max_execution_time']	= ['Max execution time', get_cfg_var('max_execution_time') . ' seconds'];
	$sysinfo['session_save_path']	= ['Session path', get_cfg_var('session.save_path')];
	$sysinfo['default_charset']		= ['PHP default charset', ini_get('default_charset')];
	$sysinfo['gzip_compression']	= ['GZip compression', $gzip_compression];
	$sysinfo['php_extensions']		= ['PHP extensions', implode(', ',get_loaded_extensions())];

	if ( function_exists( 'apache_get_modules' ) )
	{
		$sysinfo['apache_modules']		= ['Apache modules', implode(', ',apache_get_modules())];
	}

	foreach ($sysinfo as $param => $value)
	{
		echo '<tr class="lined">'.
				'<td class="label"><strong>' . $value[0] . '</strong></td>'.
				'<td> </td>'.
				'<td>' . $value[1] . '</td>'.
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