<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	DB Restore											##
##########################################################

$module['db_restore'] = [
		'order'	=> 501,
		'cat'	=> 'database',
		'status'=> true,
	];

##########################################################

function admin_db_restore($engine, $module, $tables, $directories)
{
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
<?php
	$logs			= [];
	$ikeys			= '';
	$ifiles			= '';
	$backup_dir		= BACKUP_DIR . '/';

	$backup_id		= $_POST['backup_id'] ?? ($_GET['backup_id'] ?? false);

	// validate directory format 2022_0208_145128
	if (!preg_match('/^(\d{4}_\d{4}_\d{6})$/', $backup_id))
	{
		$backup_id = false;
	}

	$show_package = function ($log, $select = true, $id = 0) use ($engine, $tables, $directories)
	{
		// pack
		echo
			'<tr class="hl-setting">' . "\n" .
				'<td>
					<table class="restore-meta">
						<tr>' .
							'<td class="label">' .
							($select
								? '<input type="radio" id="pack_' . $id . '" name="backup_id" value="' . $log['pack'] . '">'
								: '' ) .
							'</td>
							<th class="t-left nowrap">' .
								($select ? '<label for="pack_' . $id . '">' : '') .
									$engine->date_format($log['time'], $engine->db->date_format . ' ' . $engine->db->time_format_seconds) .
								($select ? '</label>' : '') .
							'</th>
						</tr>
						<tr>
							<td></td>
							<td>
								' . ($log['wacko_version'] ?? null) . '
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								' . ($log['db_engine'] ?? null) . '
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								' . (isset($log['size']) ? $engine->factor_multiples($log['size'], 'binary', true, true) : null) . '
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								' . ($log['note'] ? '<br><div class="msg comment">' . Ut::html($log['note']) . '</div>' : null) . '
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<br><a href="' . $engine->href('', '', ['remove' => 1, 'backup_id' => Ut::html($log['pack'])]) . '">' . $engine->_t('DeleteButton') . '</a>
							</td>
						</tr>
					</table>' .
				'</td>' . "\n" .

				// Description:
				'<td><table>' .
				// cluster root
				'<tr>' .
					'<th colspan="3" class="t-left nowrap">' .
						$engine->_t('BackupCluster') . ' ' . ($log['cluster'] ?: '<em class="grey">' . $engine->_t('BackupEntireSite') . '</em>' ) .
					'</th>' .
				'</tr>' . "\n" .
				// contents
				'<tr>' .
					'<th>' . $engine->_t('BackupStructure') . '</th>' .
					'<th>' . $engine->_t('BackupData') . '</th>' .
					'<th>' . $engine->_t('BackupFiles') . '</th>' .
				'</tr>' . "\n" .
				// a. structure
				'<tr>' .
					'<td>';

				$list_structure = explode(';', $log['structure']);

				foreach ($tables as $table)
				{
					if (in_array($table['name'], $list_structure))
					{
						echo '<strong>' . $table['name'] . '</strong><br>' . "\n";
					}
					else
					{
						echo '<em class="grey">' . $table['name'] . '</em><br>' . "\n";
					}
				}

				// b. data
				echo
					'</td>' . "\n" .
					'<td>';

				$list_data = explode(';', $log['data'] ?? null);

				foreach ($tables as $table)
				{
					if (in_array($table['name'], $list_data))
					{
						echo '<strong>' . $table['name'] . '</strong><br>' . "\n";
					}
					else
					{
						echo '<em class="grey">' . $table['name'] . '</em><br>';
					}
				}

				// c. files
				echo
					'</td>' . "\n" .
					'<td>';

				$list_files = explode(';', $log['files'] ?? null);

				foreach ($directories as $directory)
				{
					$directory = rtrim($directory, '/');

					if (in_array($directory, $list_files))
					{
						echo '<strong>' . $directory . '</strong><br>';
					}
					else
					{
						echo '<em class="grey">' . $directory . '</em><br>';
					}
				}

				echo
					"</td>\n" .
					"</tr>\n</table>\n" .

			// close row
			"</td>\n</tr>\n";
			// end dir check
	};

	// RESTORE backup
	if (	isset($_POST['restore'])
		&& (isset($_POST['backup_id']) && $_POST['backup_id']))
	{
		// read backup log
		$text				= file_get_contents(Ut::join_path(BACKUP_DIR, $backup_id, BACKUP_FILE_LOG));
		$log				= Ut::unserialize($text);
		$log['pack']		= $backup_id;
		$log['db_engine']	??= 'InnoDB';


		if (!$backup_id)
		{
			$engine->show_message('Invalid directory format, expects <code>2025_1122_145128</code>', 'error');

			return;
		}
		else if ($engine->db->db_engine !== $log['db_engine'])
		{
			$engine->show_message(
				Ut::perc_replace($engine->_t('DbEngineInvalid'), ' <code>' . $engine->db->db_engine . '</code>'),
				'error'
			);

			return;
		}

		// confirm restore backup
		if (!isset($_POST['start']))
		{
			$disabled = $engine->db->db_engine === 'SQLite3' ? ' disabled' : '';

			echo $engine->form_open('restore_backup');

			// check for possible backwards compatibility issues if the version differs
			if ($log['wacko_version'] !== WACKO_VERSION)
			{
				$engine->show_message($engine->_t('RestoreWrongVersion'), 'error');
			}

			// show details of backup package
			echo
				'<table class="formation">' .
					'<tr>
						<td></td>
					</tr>';

					// open row
					$show_package($log, false);
					// close row

			echo
					'<tr>
						<td colspan="2">
							<strong>' . $engine->_t('RestoreOptions') . '</strong><br>
							<input type="checkbox" id="ignore_keys" name="ignore_keys" value="1"' . $disabled .'>
							<label for="ignore_keys"><small>' . $engine->_t('IgnoreDuplicatedKeysNr') . ' *</small></label><br>
							<input type="checkbox" id="ignore_files" name="ignore_files" value="1">
							<label for="ignore_files"><small>' . $engine->_t('IgnoreSameFiles') . ' **</small></label><br>
						</td>
					</tr>' .
				'</table>
				<br>';

			echo
				'<input type="hidden" name="backup_id" value="' . Ut::html($backup_id) . '">' . "\n" .
				'<input type="hidden" name="start" value="true">' . "\n" .
				Ut::perc_replace($engine->_t('ConfirmDbRestore'), ' <code>' . Ut::html($backup_id) . '</code>') . '<br><br>' .
				'<button type="submit" id="submit" name="restore">' . $engine->_t('RestoreYes') . '</button> ' .
				'<a href="' . $engine->href() . '" class="btn-link"><button type="button" id="button">' . $engine->_t('RestoreNo') . '</button></a>' .
				'<br><small>' . $engine->_t('ConfirmDbRestoreInfo') . '</small>';

			echo
				'<br><br>
				<p><small>' .
				$engine->_t('RestoreOptionsInfo') .
				'</small></p>';

			echo $engine->form_close();
		}

		// start restore backup
		if (isset($_POST['start']))
		{
			set_time_limit(3600);

			// $dir see above
			$pack	= $backup_id;

			// set parameters
			if (isset($_POST['ignore_keys'])  && $_POST['ignore_keys']	== 1) $ikeys	= true;
			if (isset($_POST['ignore_files']) && $_POST['ignore_files']	== 1) $ifiles	= true;

			// start process logging
			$results = date('H:i:s') . ' - ' . $engine->_t('RestoreStarted') . "\n" .
				'––––––––––––––––––––––––––––––––––––––––––––––––' . "\n" .
				$engine->_t('RestoreParameters') . ':' . "\n" .
				"\t" . $engine->_t('IgnoreDuplicatedKeys') . ': ' . ($ikeys === true ? $engine->_t('RestoreYes') : $engine->_t('RestoreNo') ) . "\n" .
				"\t" . $engine->_t('IgnoreDuplicatedFiles') . ': ' . ($ifiles === true ? $engine->_t('RestoreYes') : $engine->_t('RestoreNo') ) . "\n\n";

			if ($log['db_engine'] === 'InnoDB')
			{
				$results .=
					$engine->_t('SavedCluster') . ': ' . ($log['cluster'] ?: $engine->_t('RestoreNo')) . "\n" .
					"\t" . Ut::perc_replace($engine->_t(
						($log['cluster']
							? 'DataProtection'
							: 'AssumeDropTable'), SYSTEM_LANG), 'DROP TABLE') . "\n" .
					"\n\n";
			}

			if ($log['db_engine'] === 'SQLite3')
			{
				// request db restore
				$results .= date('H:i:s') . ' - ' . $engine->_t('RestoreSQLiteDatabase') . "\n" .
					'––––––––––––––––––––––––––––––––––––––––––––––––'  . "\n";

				try
				{
					$results .=
						$engine->_t('SQLiteDatabaseRestored') . "\n" .
						"\t" . sqlite_restore($pack, $engine->db->db_name) . "\n\n\n";
				}
				catch (Exception $e)
				{
					echo 'Restore failed: ' . $e->getMessage() . "\n";
				}

			}
			else #if ($log['db_engine'] === 'InnoDB')
			{
				// request structure restore
				$results .= date('H:i:s') . ' - ' . $engine->_t('RestoreTableStructure') . "\n" .
					'––––––––––––––––––––––––––––––––––––––––––––––––' . "\n";

				if ($log['structure'])
				{
					$results .= $engine->_t('RunSqlQueries') . "\n\n";
					$results .= file_get_contents(Ut::join_path(BACKUP_DIR, $pack, BACKUP_FILE_STRUCTURE)) . "\n\n";

					// run
					$total = put_table($engine, $pack);

					$results .= date('H:i:s') . ' - ' . $engine->_t('CompletedSqlQueries') . ' ' . $total . "\n\n\n";
				}
				else
				{
					$results .= $engine->_t('NoTableStructure') . "\n\n\n";
				}

				// request data restore
				$results .= date('H:i:s') . ' - ' . $engine->_t('RestoreRecords') . "\n" .
					'––––––––––––––––––––––––––––––––––––––––––––––––' . "\n";

				if ($log['data'])
				{
					$list = explode(';', $log['data']);

					// sql mode
					if		(!$log['cluster'])	$mode = 'INSERT';
					else if	($ikeys === true)	$mode = 'INSERT IGNORE';
					else if	(!$ikeys)			$mode = 'REPLACE';

					$results .= $engine->_t('ProcessTablesDump') . "\n" .
						'(' . $engine->_t('Instruction') . ' ' . $mode . '):' . "\n\n";

					// run
					$overall = 0;

					foreach ($list as $table)
					{
						// force sql mode for some tables
						if (($table == $tables[$engine->prefix . 'acl']['name']
						||   $table == $tables[$engine->prefix . 'file_link']['name']
						||   $table == $tables[$engine->prefix . 'page_link']['name'])
						&& !$ikeys)
						{
							$mode = 'REPLACE';
						}
						$results .= "\t" . date('H:i:s') . ' - ' . $table."\n" .
							"\t" . '––––––––––––––––––––––––––' . "\n";

						$total		= put_data($engine, $pack, $table, $mode);
						$overall	+= $total;

						$results .= "\t\t" . $engine->_t('RestoredRecords') . '   ' . $total . "\n\n";
					}

					$results .= date('H:i:s') . ' - ' . $engine->_t('RecordsRestoreDone') . ' ' . $overall . "\n\n\n";
				}
				else
				{
					$results .= $engine->_t('SkippedRecords') . "\n\n\n";
				}
			}

			// request files restore
			$results .= date('H:i:s') . ' - ' . $engine->_t('RestoringFiles') . "\n" .
				'––––––––––––––––––––––––––––––––––––––––––––––––' . "\n";

			if (isset($log['files']) && $log['files'])
			{
				$list = explode(';', $log['files']);

				// rewrite mode
				if ($ifiles === true)	$keep = 1;
				else					$keep = 0;

				$results .= $engine->_t('DecompressAndStore') . "\n" .
					'(' . $engine->_t('HomonymicFiles') . ': ' .
					($ifiles === true
						? $engine->_t('RestoreSkip')
						: $engine->_t('RestoreReplace') ) . '):' . "\n\n";

				// run
				$overall		= [];
				$overall[0]		= 0;
				$overall[1]		= 0;

				foreach ($list as $sub_dir)
				{
					// process only allowed directories
					if (!in_array($sub_dir, $directories))
					{
						continue;
					}

					$results .= "\t" . date('H:i:s') . ' - ' . $sub_dir . "\n" .
						"\t" . '––––––––––––––––––––––––––' . "\n";

					$total		= put_files($pack, $sub_dir, $keep);

					$overall[0]	+= $total[0] ?? null;
					$overall[1]	+= $total[1] ?? null;

					$results .=
						"\t\t" . $engine->_t('RestoreFile') . ' ' .		(int) array_sum($total) . "\n" .
						"\t\t" . $engine->_t('RestoredFiles') . ' ' .	(int) $total[0] . "\n" .
						"\t\t" . $engine->_t('SkippedFiles') . ' ' .	(int) $total[1] . "\n\n";

				}

				$results .= date('H:i:s') . ' - ' . $engine->_t('FileRestoreDone') . "\n" .
					"\t" . $engine->_t('FilesAll') . ' ' .		(int) array_sum($overall) . "\n" .
					"\t" . $engine->_t('RestoredFiles') . ' ' .	(int) $overall[0] . "\n" .
					"\t" . $engine->_t('SkippedFiles') . ' ' .	(int) $overall[1] . "\n" .
					"\n\n";
			}
			else
			{
				$results .= $engine->_t('SkipFiles') . "\n\n\n";
			}

			// finishing
			$results .= '––––––––––––––––––––––––––––––––––––––––––––––––' . "\n" .
				date('H:i:s') . ' - ' . $engine->_t('RestoreDone');

			$message = $engine->_t('BackupRestored') .
					' <a href="' . $engine->href('', '', ['remove' => 1, 'backup_id' => Ut::html($pack)]) . '">' . $engine->_t('DeleteButton') . '</a>.';
			$engine->show_message($message, 'success');
?>
			<div class="code">
				<pre><?php echo $results; ?></pre>
			</div><br>
<?php
			// purge old cache files
			Ut::purge_directory(CACHE_PAGE_DIR);
			Ut::purge_directory(CACHE_SQL_DIR);
			Ut::purge_directory(CACHE_CONFIG_DIR);
			Ut::purge_directory(CACHE_TEMPLATE_DIR);

			$engine->log(1, Ut::perc_replace($engine->_t('LogDbRestored', SYSTEM_LANG), $pack));
		}
	}
	// REMOVE backup
	// confirm delete backup
	else if ((isset($_POST['remove']) && isset($_POST['backup_id']))
		||   (isset($_GET['remove']) && isset($_GET['backup_id'])))
	{
		echo $engine->form_open('delete_backup');

		echo '<input type="hidden" name="backup_id" value="' . Ut::html($backup_id) . '">' . "\n" .
			'<div class="msg warning">' .
				Ut::perc_replace($engine->_t('BackupDelete'), ' <code>' . Ut::html($backup_id) . '</code>') . '<br><br>' .
				'<button type="submit" id="submit_delete" name="delete">' . $engine->_t('RestoreYes') . '</button> ' .
				'<a href="' . $engine->href() . '" class="btn-link"><button type="button" id="button">' . $engine->_t('RestoreNo') . '</button></a>' .
				'<br><small>' . $engine->_t('BackupDeleteInfo') . '</small>' .
			'</div>
			<br>';

		echo $engine->form_close();
	}
	else
	{
		// archive backup
		if (isset($_POST['archive']) && isset($_POST['backup_id']) && $backup_id)
		{
			$file = Ut::join_path(BACKUP_DIR, $backup_id . '.tar');

			if (!is_file($file))
			{
				create_archive($backup_id);

				$engine->log(4, Ut::perc_replace($engine->_t('LogBackupArchived', SYSTEM_LANG), $backup_id));
				$engine->show_message(
					Ut::perc_replace(
						$engine->_t('BackupArchived'),
						' <code>' . Ut::html($file) . '</code>'),
					'success');
			}
			else
			{
				$engine->show_message(
					Ut::perc_replace(
						$engine->_t('BackupArchiveExists'),
						' <code>' . Ut::html($file) . '</code>'),
					'notice');
			}
		}

		// delete backup
		if (   (isset($_POST['delete']) && $_POST['backup_id'])
			|| (isset($_GET['delete'])  && $_GET['backup_id']))
		{
			if ($backup_id)
			{
				remove_pack($backup_id);

				$engine->log(1, Ut::perc_replace($engine->_t('LogRemovedBackup', SYSTEM_LANG), $backup_id));
				$engine->show_message($engine->_t('BackupRemoved'), 'success');
			}
		}

		// SHOW backups
?>
		<p>
			<?php echo $engine->_t('RestoreInfo'); ?>
		</p>
<?php
		if (!(PHP_OS_FAMILY === 'Windows') && !is_executable($backup_dir))
		{
			echo substr(sprintf('%o', fileperms($backup_dir)), -4) . "<br>\n";
			echo output_image($engine, false) .
				'<strong class="red">' .
					Ut::perc_replace($engine->_t('DirectoryNotExecutable'), ' <code>' . Ut::html($backup_dir) . '</code>') .
				'</strong><br>' . "\n";
		}
		else
		{
			// SHOW backups
		?>
			<br>
<?php
			echo $engine->form_open('restore');

			$control_buttons =
				'<button type="submit" name="restore" id="restore-submit">' . $engine->_t('BackupRestore') . '</button> ' .
				'<button type="submit" name="archive" id="archive-submit">' . $engine->_t('ArchiveButton') . '</button> ' .
				'<button type="submit" name="remove" id="remove-submit">' . $engine->_t('BackupRemove') . '</button>';

			// open backups dir and run through all subdirs
			if ($dh = opendir(rtrim($backup_dir, '/')))
			{
				while (false !== ($pack_dir = readdir($dh)))
				{
					$file = Ut::join_path(BACKUP_DIR, $pack_dir, BACKUP_FILE_LOG);

					// we only need subdirs with appropriate name length
					// and with backup register contained within
					if (is_dir(Ut::join_path(BACKUP_DIR, $pack_dir)) === true
						#&& strlen($pack_dir) == 16)
						&& file_exists($file) === true)
					{
						$text		= file_get_contents($file);
						$_array1	= Ut::unserialize($text);
						$_array2	= ['pack' => $pack_dir];
						// read log
						$logs[]		= array_merge($_array1, $_array2);
					} // end dir check
				} // end while loop

				# Ut::debug_print_r($logs);

				if (!empty($logs))
				{
					echo $control_buttons;

					echo
					'<table class="restore formation">
						<tr>
							<th>' . $engine->_t('BackupCreationDate') . '</th>
							<th>' . $engine->_t('BackupPackageContents') . '</th>
						</tr>';

					// sort 'creation date' descending with custom numeric comparisons function
					usort($logs, function (array $a, array $b) { return $b['time'] - $a['time']; });

					foreach ($logs as $i => $log)
					{
						// open row
						$show_package($log, true, $i);
						// close row

						echo	'<tr class="lined"><td colspan="2"></td></tr>' . "\n";
					} // end foreach

					echo '</table>';
					echo $control_buttons;
				}
				else
				{
					$message = $engine->_t('NoBackupsAvailable');
					$engine->show_message($message) ;
				}

				closedir($dh);
			} // end opendir

			echo $engine->form_close();
		}
	}
}
