<?php

########################################################
##   Welcome screen and site locking                  ##
########################################################

$module['lock'] = array(
		'order'	=> 1,
		'cat'	=> 'Basic functions',
		'mode'	=> 'lock',
		'name'	=> 'Main Menu',
		'title'	=> 'WackoWiki Administration',
		'vars'	=> array(&$tables, &$directories),
		'objs'	=> array(&$init),
	);

########################################################

function admin_lock(&$engine, &$module)
{
	// import passed variables and objects
	$init			= & $module['objs'][0];
	$tables			= & $module['vars'][0];
	$directories	= & $module['vars'][1];

	// (un)lock website
	if (isset($_POST['action']) && $_POST['action'] == 'lock')
	{
		$access	= $init->is_locked();
		$file	= fopen('lock', 'w');

		if ($access === true)
		{
			fwrite($file, '0');
		}
		else
		{
			fwrite($file, '1');
		}

		fclose($file);
		unset($access);
		$engine->set_user($_user, 0);
		$engine->redirect('admin.php');
	}
	// clear cache
	else if (isset($_POST['action']) && $_POST['action'] == 'cache')
	{
		// pages
		$handle = opendir(rtrim($engine->config['cache_dir'].CACHE_PAGE_DIR, '/'));
		while (false !== ($file = readdir($handle)))
		{
			if (!is_dir($engine->config['cache_dir'].CACHE_PAGE_DIR.$file))
			{
				unlink($engine->config['cache_dir'].CACHE_PAGE_DIR.$file);
			}
		}
		closedir($handle);
		$engine->query("DELETE FROM {$engine->config['table_prefix']}cache");

		// queries
		$handle = opendir(rtrim($engine->config['cache_dir'].CACHE_SQL_DIR, '/'));
		while (false !== ($file = readdir($handle)))
		{
			if (!is_dir($engine->config['cache_dir'].CACHE_SQL_DIR.$file))
			{
				unlink($engine->config['cache_dir'].CACHE_SQL_DIR.$file);
			}
		}
		closedir($handle);

		// feeds
		$handle = opendir(rtrim($engine->config['cache_dir'].CACHE_FEED_DIR, '/'));
		while (false !== ($file = readdir($handle)))
		{
			if (!is_dir($engine->config['cache_dir'].CACHE_FEED_DIR.$file))
			{
				unlink($engine->config['cache_dir'].CACHE_FEED_DIR.$file);
			}
		}
		closedir($handle);
	}
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	<p>
		Note: Before the administration of technical activities
		<span class="underline">strongly</span> are encouraged to block access to the site!
	</p>
	<br />
	<form action="admin.php" method="post" name="lock">
		<input type="hidden" name="mode" value="lock" />
		<input type="hidden" name="action" value="lock" />
		<table border="0" cellspacing="1" cellpadding="4" style="max-width:200px" class="formation">
			<tr>
				<td class="label" style="white-space:nowrap"><?php echo ( $init->is_locked() === true ? '<span class="red">The site is closed</span>' : '<span class="green">The site is open</span>' ); ?></td>
				<td align="center"><input id="submit" type="submit" value="<?php echo ( $init->is_locked() === true ? 'open' : 'close' ); ?>" /></td>
			</tr>
		</table>
	</form>
	<br />
	<form action="admin.php" method="post" name="cache">
		<input type="hidden" name="mode" value="lock" />
		<input type="hidden" name="action" value="cache" />
		<table border="0" cellspacing="1" cellpadding="4" style="max-width:200px" class="formation">
			<tr>
				<td class="label" style="white-space:nowrap"><?php echo $engine->get_translation('ClearCache');?></td>
				<td align="center"><?php  echo (isset($_POST['action']) && $_POST['action'] == 'cache' ? $engine->get_translation('CacheCleared') : '<input id="submit" type="submit" value="clean" />');?></td>
			</tr>
		</table>
	</form>

	<br />
	Database Statistics:<br />
	<br />
	<table border="0" cellspacing="1" cellpadding="4" style="max-width:500px" class="formation">
		<tr>
			<th style="width:50px;">Table</th>
			<th style="text-align:left;">Records</th>
			<th style="text-align:left;">Size</th>
			<th style="text-align:left;">Index</th>
			<th style="text-align:left;">Overhead</th>
		</tr>
<?php
	$results = $engine->load_all("SHOW TABLE STATUS FROM `{$engine->config['database_database']}`");
	$tdata = '';
	$tindex = '';
	$tfrag = '';

	foreach ($results as $table)
	{
		foreach ($tables as $wtable)
		{
			if ($table['Name'] == $wtable['name'])
			{
				echo '<tr>'.
						'<td class="label"><strong>'.$table['Name'].'</strong></td>'.
						'<td>&nbsp;&nbsp;&nbsp;'.$table['Rows'].'</td>'.
						'<td>'.ceil($table['Data_length'] / 1000).' kB</td>'.
						'<td>'.ceil($table['Index_length'] / 1000).' kB</td>'.
						'<td>'.ceil($table['Data_free'] / 1000).' kB</td>'.
					'</tr>'.
					'<tr class="lined"><td colspan="5"></td></tr>'."\n";

				$tdata	+= $table['Data_length'];
				$tindex	+= $table['Index_length'];
				$tfrag	+= $table['Data_free'];
			}
		}
	}
?>
		<tr>
			<td class="label"><strong>Total:</strong></td>
			<td></td>
			<td><strong><?php echo round($tdata / 1000000, 2); ?> MB</strong></td>
			<td><strong><?php echo round($tindex / 1000000, 2); ?> MB</strong></td>
			<td><strong><?php echo round($tfrag / 1000000, 2); ?> MB</strong></td>
		</tr>
	</table>
	<br />
	File system Statistics:<br />
	<br />
	<table border="0" cellspacing="1" cellpadding="4" style="max-width:300px" class="formation">
		<tr>
			<th style="width:50px;">Folder</th>
			<th style="text-align:left;">Files</th>
			<th style="text-align:left;">Size</th>
		</tr>
<?php
	clearstatcache();

	$tfiles = '';
	$tsize = '';

	foreach ($directories as $dir)
	{
		$dir = rtrim($dir, '/');

		if ($handle = @opendir($dir))
		{
			$files	= 0;
			$size	= 0;

			while (false !== ($file = readdir($handle)))
			{
				if (is_dir($dir.'/'.$file) === false)
				{
					$size += filesize($dir.'/'.$file);
					$files++;
					$tfiles++;
				}
			}
			$tsize += $size;

			echo '<tr>'.
					'<td class="label"><strong>'.$dir.'</strong></td>'.
					'<td>&nbsp;&nbsp;&nbsp;'.$files.'</td>'.
					'<td>'.ceil($size / 1000).' kB</td>'.
				'</tr>'.
				'<tr class="lined"><td colspan="3"></td></tr>'."\n";
		}
		@closedir($handle);
	}
?>
		<tr>
			<td class="label"><strong>Total:</strong></td>
			<td>&nbsp;&nbsp;&nbsp;<strong><?php echo $tfiles; ?></strong></td>
			<td><strong><?php echo round($tsize / 1000000, 2); ?> MB</strong></td>
		</tr>
	</table>
<?php
}

?>