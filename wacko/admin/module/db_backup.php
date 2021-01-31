<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	DB Backup											##
##########################################################
$_mode = 'db_backup';

$module[$_mode] = [
		'order'	=> 500,
		'cat'	=> 'database',
		'status'=> true,
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Backup
		'title'	=> $engine->_t($_mode)['title'],	// Backing up data
	];

##########################################################

function admin_db_backup(&$engine, &$module, &$tables, &$directories)
{
	$scheme			= [];

	// backup scheme
	if (   !isset($_GET['structure'])
		&& !isset($_GET['data'])
		&& !isset($_GET['files']))
	{
		$scheme['structure']	= 1;
		$scheme['data']			= 1;
	}

	if (isset($_GET['structure'])	&& $_GET['structure']	== 1)	$scheme['structure']	= 1;
	if (isset($_GET['data'])		&& $_GET['data']		== 1)	$scheme['data']			= 1;
	if (isset($_GET['files'])		&& $_GET['files']		== 1)	$scheme['files']		= 1;

	$getstr = '';

	if (is_array($scheme))
	{
		foreach ($scheme as $key => $val)
		{
			if ($val == 1)
			{
				$getstr .= '&amp;' . $key . '=1';
			}
			else
			{
				$getstr .= '&amp;' . $key . '=0';
			}
		}
	}
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
<?php
	if (isset($_POST['start']))
	{
		@set_time_limit(1800);

		$time		= time();
		$pack		= set_pack_dir($time);	// backup directory
		$root		= $_POST['root'];
		$data		= [];
		$structure	= [];
		$files		= [];
		$sql		= '';

		foreach ($_POST as $val => $key)
		{
			// strip prefix
			$val = substr($val, 7);

			// collect table names for sql recreation query
			if ($key == 'structure' && $val == true)
			{
				$structure[] = $val;
			}
			// extract table data
			else if ($key == 'data' && $val == true)
			{
				$data[] = $val;
				get_data($engine, $tables, $pack, $val, $root);
			}
			// compress files
			else if ($key == 'files' && $val == true)
			{
				$files[] = $val;
				get_files($engine, $pack, $val, $root);
			}
		}

		// write sql for recreating selected tables
		if ($structure == true)
		{
			foreach ($structure as $table)
			{
				// check whether table data was backed up
				if (in_array($table, $data) && $root == false)
				{
					$drop = 1;
				}
				else
				{
					$drop = 0;
				}

				// force drop for tables w/o WHERE clause
				if (in_array($table, $data)
					&& $tables[$table]['where'] === false)
				{
					$drop = 1;
				}

				// ...and for these specific tables
				if ($table == $engine->db->table_prefix . 'cache'
				||  $table == $engine->db->table_prefix . 'referrer'
				||  $table == $engine->db->table_prefix . 'log')
				{
					$drop = 1;
				}

				$sql .= get_table($engine, $table, $drop) . "\n";
			}
		}

		// save sql to the disk
		if ($sql == true)
		{
			// check file existence
			clearstatcache();
			$filename = $pack . BACKUP_FILE_STRUCTURE;

			if (file_exists($filename) === true)
			{
				unlink($filename);
			}

			// open file with writa access
			$file = fopen($filename, 'w');

			// write data (strip last semicolon
			// off the sql) and close file
			fwrite($file, $sql); // see array_pop($sql); on database.php
			fclose($file);
			chmod($filename, CHMOD_FILE);
		}

		// save backup log
		clearstatcache();
		$filename = $pack . BACKUP_FILE_LOG;

		if (file_exists($filename) === true)
		{
			unlink($filename);
		}

		// open file with write access
		$file	= fopen($filename, 'w');

		// log contents
		$contents = [
			$time,						// 0: backup time (unix format)
			rtrim(substr($pack, strlen(UPLOAD_BACKUP_DIR) + 18), '/'),	// 1: id
			$root,						// 2: cluster root
			implode(';', $structure),	// 3: structure
			implode(';', $data),		// 4: table data
			implode(';', $files),		// 5: files
			WACKO_VERSION,				// 6. wacko_version
			get_directory_size($pack)	// 7: size
			// TODO: add metadata to avoid conflicts
			// 8: unique_instance_key	-> warn / show user if he restores data from another deployment or
			// 9: hash
		];

		// write log file
		fwrite($file, implode("\n", $contents));
		fclose($file);
		chmod($filename, CHMOD_FILE);

		$engine->log(1, Ut::perc_replace($engine->_t('LogSavedBackup', SYSTEM_LANG), trim($pack, '/')));

		$message = '<p>' . Ut::perc_replace($engine->_t('BackupCompleted'), '<code>' . $pack . '</code>', $engine->href('', '', ['mode' => 'db_restore'])) . '</p>';

		$engine->show_message($message, 'success');
	}
	else
	{
		if (!is_writable(UPLOAD_BACKUP_DIR . '/'))
		{
			echo output_image($engine, false) . '<strong class="red">' . Ut::perc_replace($engine->_t('DirNotWritable'), '<code>' . UPLOAD_BACKUP_DIR . '</code>') . '</strong>' . "<br>\n";
		}
		else
		{
?>
		<p>
			<?php echo $engine->_t('BackupSettings'); ?>
		</p>
		<br>

<?php
		echo $engine->form_open('backup');
?>
			<table style="max-width:350px; border-spacing: 1px; border-collapse: separate; padding: 4px;" class="formation lined">
				<tr>
					<th class="t-right"><?php echo $engine->_t('BackupCluster'); ?>:</th>
					<th colspan="2"><input type="text" name="root" size="30" value=""></th>
				</tr>
				<tr>
					<th><?php echo $engine->_t('BackupTable'); ?></th>
					<th>  <a href="<?php echo $engine->href('', '') . $getstr . (isset($scheme['structure']) && $scheme['structure'] == 1 ? '&amp;structure=0' : '&amp;structure=1'); ?>"><?php echo $engine->_t('BackupStructure'); ?></a></th>
					<th><a href="<?php echo $engine->href('', '') . $getstr . (isset($scheme['data']) && $scheme['data'] == 1 ? '&amp;data=0' : '&amp;data=1'); ?>"><?php echo $engine->_t('BackupData'); ?></a></th>
				</tr>
<?php
			foreach ($tables as $table)
			{
				$check = false;

				if ($table['name'] != 'cache' && $table['name'] != 'referrer' && $table['name'] != 'log')
				{
					$check = true;
				}

				echo '<tr>' .
						'<td class="label">' . $table['name'] . '</td>' .
						'<td class="t-center">
							<input type="checkbox" name="__str__' . $table['name'] . '" value="structure"' . ( isset($scheme['structure']) && $scheme['structure'] == true ? ' checked' : '') . '>
						</td>' .
						'<td class="t-center">
							<input type="checkbox" name="__dat__' . $table['name'] . '" value="data"' . ( $check === true && isset($scheme['data']) && $scheme['data'] == true ? ' checked' : '') . '>
						</td>' .
					'</tr>' . "\n";
			}
?>
				<tr>
					<th colspan="2"><?php echo $engine->_t('BackupFolder'); ?></th>
					<th>  <a href="<?php echo $engine->href('', '') . $getstr . (isset($scheme['files']) && $scheme['files'] == 1 ? '&amp;files=0' : '&amp;files=1'); ?>"><?php echo $engine->_t('BackupFiles'); ?></a></th>
				</tr>
<?php
			$i = 0;

			foreach ($directories as $dir)
			{
				$i++;
				$check = false;

				//if ($dir != (CACHE_FEED_DIR || CACHE_PAGE_DIR || CACHE_SQL_DIR))
				//{
					$check = true;
				//}

				$dir = rtrim($dir, '/');

				echo '<tr>' .
						'<td colspan="2" class="label">' .
							'<label for="dir_' . $i . '"><strong>' . $dir . '</strong></label>' .
						'</td>' .
						'<td class="t-center">  ' .
							'<input type="checkbox" id="dir_' . $i . '" name="__dir__' . $dir . '" value="files"' . ( $check === true && (isset($scheme['files']) && $scheme['files'] == true) ? ' checked' : '') . '>' .
						'</td>' .
					'</tr>' . "\n";
			}
?>
				</table>
				<button type="submit" name="start" id="submit"><?php echo $engine->_t('Backup'); ?></button>
<?php
			echo $engine->form_close();
		}
	}
}

