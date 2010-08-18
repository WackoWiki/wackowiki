<?php

########################################################
##   DB Backup                                        ##
########################################################

$module['dbbackup'] = array(
		'order'	=> 10,
		'cat'	=> 'Database',
		'mode'	=> 'dbbackup',
		'name'	=> 'Backup database',
		'title'	=> 'Backing up data',
		'vars'	=> array(&$tables, &$directories),
	);

########################################################

function admin_dbbackup(&$engine, &$module)
{
	// import passed variables and objects
	$tables			= & $module['vars'][0];
	$directories	= & $module['vars'][1];

	// backup scheme
	if (!isset($_GET['structure']) &&
		!isset($_GET['data'])  &&
		!isset($_GET['files']) )
	{
		$scheme['structure']	= 1;
		$scheme['data']			= 1;
	}

	if (isset($_GET['structure'])	&& $_GET['structure']	== 1)	$scheme['structure']	= 1;
	if (isset($_GET['data']) 		&& $_GET['data']		== 1)	$scheme['data']			= 1;
	if (isset($_GET['files']) 		&& $_GET['files']		== 1)	$scheme['files']		= 1;

	$getstr = '';
	if (is_array($scheme))
	{
		foreach ($scheme as $key => $val)
		{
			if ($val == 1)
				$getstr .= '&'.$key.'=1';
			else
				$getstr .= '&'.$key.'=0';
		}
	}
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	if (isset($_POST['start']))
	{
		@set_time_limit(1800);

		$time	= time();
		$pack	= SetPackDir($engine, $time);	// backup directory
		$root	= $_POST['root'];
		$data	= array();
		$strc	= array();
		$fils	= array();

		foreach ($_POST as $val => $key)
		{
			// strip prefix
			$val = substr($val, 7);

			// collect table names for sql recreation query
			if ($key == 'structure' && $val == true)
			{
				$strc[] = $val;
			}
			// extract table data
			else if ($key == 'data' && $val == true)
			{
				$data[] = $val;
				GetData($engine, $tables, $pack, $val, $root);
			}
			// compress files
			else if ($key == 'files' && $val == true)
			{
				$fils[] = $val;
				GetFiles($engine, $pack, $val, $root);
			}
		}

		// write sql for recreating selected tables
		if ($strc == true)
		{
			foreach ($strc as $table)
			{
				// check whether table data was backed up
				if (in_array($table, $data) && $root == false)
					$drop = 1;
				else
					$drop = 0;

				// force drop for tables w/o WHERE clause
				if (in_array($table, $data) &&
				$tables[$engine->config['table_prefix'].$table]['where'] === false)
					$drop = 1;

				// ...and for these specific tables
				if ($table == $engine->config['table_prefix'].'cache' ||
				$table == $engine->config['table_prefix'].'referrer' ||
				$table == $engine->config['table_prefix'].'log')
					$drop = 1;

				$sql .= GetTable($engine, $table, $drop)."\n";
			}
		}

		// save sql to the disk
		if ($sql == true)
		{
			// check file existance
			clearstatcache();
			$filename = $pack.BACKUP_FILE_STRUCTURE;
			if (file_exists($filename) === true) unlink($filename);

			// open file with writa access
			$file	= fopen($filename, 'w');

			// write data (strip last semicolon
			// off the sql) and close file
			fwrite($file, substr($sql, 0, strrpos($sql, ';')));
			fclose($file);
			chmod($filename, 0644);
		}

		// save backup log
		clearstatcache();
		$filename = $pack.BACKUP_FILE_LOG;
		if (file_exists($filename) === true) unlink($filename);

		// open file with writa access
		$file	= fopen($filename, 'w');

		// log contents
		$contents = array(
			$time,					// 0: backup time (unix format)
			rtrim(substr($pack, strlen($engine->config['upload_path_backup']) + 18), '/'),	// 1: id
			$root,					// 2: cluster root
			implode(';', $strc),	// 3: structure
			implode(';', $data),	// 4: table data
			implode(';', $fils)		// 5: files
		);

		// write log file
		fwrite($file, implode("\n", $contents));
		fclose($file);
		chmod($filename, 0644);

		$engine->log(1, 'Saved backup database '.trim($pack, '/'));
?>
		<p>
			Backing up and archiving completed. Package backup
			retained in the backup-directory directory files.<br />To obtain
			use FTP (not sure if you copy the structure to maintain
			directories and file names and directories).<br />To restore a backup
			copy or remove a package, go to <a href="?mode=dbrestore">Restoration</a>.
		</p>
		<br />
<?php
	}
	else
	{
?>
		<p>
			Specify the desired scheme of Backup. The root cluster does not affect the
			global backup files and cache files (with their choice of
			they are always saved in full).<br />
			<br />
			<u>Attention</u>: To avoid loss of information from the database,
			indicate the root cluster, the table from this backup will not be
			restructured; similar, with only the reserve of
			table without saving the data. To complete the conversion tables in the format
			backup must be <em>full redundancy throughout the framework
			data (structure plus contents) without specifying the cluster</em>.
		</p>
		<br />
		<form action="admin.php" method="post" name="backup">
			<input type="hidden" name="mode" value="dbbackup" />
			<table border="0" cellspacing="1" cellpadding="4" style="max-width:350px" class="formation">
				<tr>
					<th style="text-align:right">Cluster:</th>
					<th colspan="2"><input name="root" size="30" value="" /></th>
				</tr>
				<tr>
					<th>Table</th>
					<th>&nbsp;&nbsp;<a href="?mode=dbbackup<?php echo $getstr.( $scheme['structure'] == 1 ? '&structure=0' : '&structure=1' ); ?>">Structure</a></th>
					<th><a href="?mode=dbbackup<?php echo $getstr.( $scheme['data'] == 1 ? '&data=0' : '&data=1' ); ?>">Data</a></th>
				</tr>
<?php
		foreach ($tables as $table)
		{
			$check = false;

			if ($table['name'] != 'cache' && $table['name'] != 'referrer' && $table['name'] != 'log')
				$check = true;

			echo '<tr>'.
					'<td class="label"><strong>'.$table['name'].'</strong></td>'.
					'<td align="center">&nbsp;&nbsp;<input name="__str__'.$table['name'].'" type="checkbox" value="structure"'.( $scheme['structure'] == true ? 'checked="checked"' : '' ).' /></td>'.
					'<td align="center"><input name="__dat__'.$table['name'].'" type="checkbox" value="data"'.( $check === true && $scheme['data'] == true ? 'checked="checked"' : '' ).' /></td>'.
				'</tr>'.
				'<tr class="lined"><td colspan="3"></td></tr>'."\n";
		}
?>
				<tr>
					<th colspan="2">Folder</th>
					<th>&nbsp;&nbsp;<a href="?mode=dbbackup<?php echo $getstr.( $scheme['files'] == 1 ? '&files=0' : '&files=1' ); ?>">Files</a></th>
				</tr>
<?php
		foreach ($directories as $dir)
		{
			$check = false;

			if ($dir != $engine->config['cache_dir']) $check = true;

			$dir = rtrim($dir, '/');

			echo '<tr>'.
					'<td colspan="2" class="label"><strong>'.$dir.'</strong></td>'.
					'<td align="center">&nbsp;&nbsp;<input name="__dir__'.$dir.'" type="checkbox" value="files"'.( $check === true && (isset($scheme['files']) && $scheme['files'] == true) ? 'checked="checked"' : '' ).' /></td>'.
				'</tr>'.
				'<tr class="lined"><td colspan="3"></td></tr>'."\n";
		}
?>
			</table>
			<input name="start" id="submit" type="submit" value="save" />
		</form>
<?php
	}
}

?>