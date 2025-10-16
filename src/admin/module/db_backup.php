<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	DB Backup											##
##########################################################

$module['db_backup'] = [
		'order'	=> 500,
		'cat'	=> 'database',
		'status'=> true,
	];

##########################################################

function admin_db_backup($engine, $module, $tables, $directories)
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
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
<?php
	if (isset($_POST['start']))
	{
		@set_time_limit(1800);

		$time		= time();				// backup time (unix format)
		$pack		= set_pack_dir($time);	// backup directory
		$note		= $_POST['log_note'] ?? '';
		$note		= $engine->sanitize_text_field($note, true);
		$root		= $_POST['root'] ?? '';
		$engine->sanitize_page_tag($root);
		$data		= [];
		$structure	= [];
		$files		= [];
		$sql		= '';

		foreach ($_POST as $val => $key)
		{
			// strip prefix
			$val = substr($val, 7);

			// collect table names for sql recreation query
			if ($key == 'structure' && $val)
			{
				$structure[] = $val;
			}
			// extract table data
			else if ($key == 'data' && $val)
			{
				$data[] = $val;
				get_data($engine, $tables, $pack, $val, $root);
			}
			// compress files
			else if ($key == 'files' && $val)
			{
				$files[] = $val;
				get_files($engine, $directories, $pack, $val, $root);
			}
		}

		// write sql for recreating selected tables
		if ($structure)
		{
			foreach ($structure as $table)
			{
				// check whether table data was backed up
				if (in_array($table, $data) && !$root)
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
				if ($table == $engine->prefix . 'cache'
				||  $table == $engine->prefix . 'log'
				||  $table == $engine->prefix . 'referrer')
				{
					$drop = 1;
				}

				$sql .= get_table($engine, $table, $drop) . "\n";
			}
		}

		// save sql to the disk
		if ($sql)
		{
			// check file existence
			clearstatcache();
			$filename = $pack . BACKUP_FILE_STRUCTURE;

			if (file_exists($filename) === true)
			{
				unlink($filename);
			}

			// open file with write access
			$file = fopen($filename, 'w');

			// write data (strip last semicolon off the sql)
			// and close file
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

		// log contents
		$contents = [
			'time'			=> $time,
			'cluster'		=> $root,
			'structure'		=> implode(';', $structure),
			'data'			=> implode(';', $data),
			'files'			=> implode(';', $files),
			'wacko_version'	=> WACKO_VERSION,
			'size'			=> get_directory_size($pack),
			'note'			=> $note,
			// TODO: add metadata to avoid conflicts
			// unique_instance_key	-> warn / show user if he restores data from another deployment or
			// hash
		];

		ksort($contents, SORT_STRING);
		$text = Ut::serialize($contents, JSON_PRETTY_PRINT);

		// write log file
		file_put_contents($filename, $text);
		chmod($filename, CHMOD_FILE);

		$engine->log(1, Ut::perc_replace($engine->_t('LogSavedBackup', SYSTEM_LANG), trim($pack, '/')));

		$message = '<p>' .
			Ut::perc_replace(
				$engine->_t('BackupCompleted'),
				'<code>' . $pack . '</code>',
				$engine->href('', '', ['mode' => 'db_restore'])) .
			'</p>';

		$engine->show_message($message, 'success');
	}
	else
	{
		if (!is_writable(UPLOAD_BACKUP_DIR . '/'))
		{
			echo output_image($engine, false) .
				'<strong class="red">' .
					Ut::perc_replace($engine->_t('DirNotWritable'), '<code>' . UPLOAD_BACKUP_DIR . '</code>') .
				'</strong><br>' . "\n";
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
			<table class="backup formation lined">
				<tr>
					<th class="label"><label for="root"><?php echo $engine->_t('BackupCluster'); ?></label></th>
					<td colspan="2"><input type="text" id="root" name="root" size="30" value=""></td>
				</tr>
				<tr><td colspan="3"><br></td></tr>
				<tr>
					<th><?php echo $engine->_t('BackupTable'); ?></th>
					<th><a href="<?php echo $engine->href('', '') . $getstr . (isset($scheme['structure']) && $scheme['structure'] == 1 ? '&amp;structure=0' : '&amp;structure=1'); ?>"><?php echo $engine->_t('BackupStructure'); ?></a></th>
					<th><a href="<?php echo $engine->href('', '') . $getstr . (isset($scheme['data']) && $scheme['data'] == 1 ? '&amp;data=0' : '&amp;data=1'); ?>"><?php echo $engine->_t('BackupData'); ?></a></th>
				</tr>
<?php
			foreach ($tables as $table)
			{
				$check = false;

				if (   $table['name'] != $engine->prefix . 'cache'
					&& $table['name'] != $engine->prefix . 'log'
					&& $table['name'] != $engine->prefix . 'referrer')
				{
					$check = true;
				}

				echo '<tr>' .
						'<td class="label">' . $table['name'] . '</td>' .
						'<td class="t-center">
							<input type="checkbox" name="__str__' . $table['name'] . '" value="structure"' . ( isset($scheme['structure']) && $scheme['structure'] ? ' checked' : '') . '>
						</td>' .
						'<td class="t-center">
							<input type="checkbox" name="__dat__' . $table['name'] . '" value="data"' . ( $check === true && isset($scheme['data']) && $scheme['data'] ? ' checked' : '') . '>
						</td>' .
					'</tr>' . "\n";
			}
?>
				<tr><td colspan="3"><br></td></tr>
				<tr>
					<th><?php echo $engine->_t('BackupFolder'); ?></th>
					<th colspan="2"><a href="<?php echo $engine->href('', '') . $getstr . (isset($scheme['files']) && $scheme['files'] == 1 ? '&amp;files=0' : '&amp;files=1'); ?>"><?php echo $engine->_t('BackupFiles'); ?></a></th>
				</tr>
<?php
			$i = 0;

			foreach ($directories as $dir)
			{
				$i++;
				$check = false;

				//if ($dir != (CACHE_FEED_DIR || CACHE_PAGE_DIR || CACHE_SQL_DIR || CACHE_TEMPLATE_DIR || THUMB_DIR))
				//{
					$check = true;
				//}

				$dir = rtrim($dir, '/');

				echo '<tr>' .
						'<td class="label">' .
							'<label for="dir_' . $i . '">' . $dir . '</label>' .
						'</td>' .
						'<td colspan="2" class="t-center">  ' .
							'<input type="checkbox" id="dir_' . $i . '" name="__dir__' . $dir . '" value="files"' . ( $check === true && (isset($scheme['files']) && $scheme['files']) ? ' checked' : '') . '>' .
						'</td>' .
					'</tr>' . "\n";
			}
?>
				<tr><td colspan="3"><br></td></tr>
				<tr>
					<th class="label"><label for="log_note"><?php echo $engine->_t('BackupNote'); ?></label></th>
					<td colspan="3">
						<input type="text" id="log_note" name="log_note" maxlength="200" value="" size="30">
					</td>
				</tr>
			</table>
			<br>
			<button type="submit" name="start" id="submit"><?php echo $engine->_t('Backup'); ?></button>
<?php
			echo $engine->form_close();
		}
	}
}
