<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	DB Restore											##
##########################################################

$module['db_restore'] = [
		'order'	=> 510,
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
	$backup_dir		= UPLOAD_BACKUP_DIR . '/';

	// IDs PROCESSING (COMMON PROCEDURES)
	$set = [];

	$backup_id = $_POST['backup_id'] ?? ($_GET['backup_id'] ?? false);

	// validate directory format 2022_0208_145128
	if (!preg_match('/^(\d{4}_\d{4}_\d{6})$/', $backup_id))
	{
		$backup_id = false;
	}

	// RESTORE backup
	if (isset($_POST['restore'])
		&& (isset($_POST['backup_id']) && $_POST['backup_id']))
	{
		// confirm restore backup
		if (((isset($_POST['restore']) && isset($_POST['backup_id']))
		||  (isset($_GET['restore']) && isset($_GET['backup_id'])))
		&&  !isset($_POST['start']))
		{
			// read backup log
			$text	= file_get_contents(Ut::join_path(UPLOAD_BACKUP_DIR, $backup_id, BACKUP_FILE_LOG));
			$log	= Ut::unserialize($text);

			echo $engine->form_open('restore_backup');

			// check for possible backwards compatibility issues if the version differs
			if ($log['wacko_version'] !== WACKO_VERSION)
			{
				$engine->show_message($engine->_t('RestoreWrongVersion'), 'error') ;
			}

			// show details of backup package
			echo '<table class="formation">' .
						'<tr>
							<td>' .
							'</td>
						</tr>' .
					// open row
					'<tr class="hl-setting">' . "\n" .

					// pack
					'<td>
						<table class="restore-meta">
							<tr>
								<td class="label">' .
								'</td>
								<th class="t-left nowrap">' .
									date($engine->db->date_format . ' ' . $engine->db->time_format_seconds, $log['time']) .
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
									' . (isset($log['size']) ? $engine->binary_multiples($log['size'], false, true, true) : null) . '
								</td>
							</tr>
						</table>' .
					'</td>' . "\n";

					// description
					echo '<td><table>';
						// cluster root
						echo '<tr><th colspan="3" class="t-left nowrap">' .
								$engine->_t('BackupCluster') . ' ' . ($log['cluster'] ?: '<em class="grey">' . $engine->_t('BackupEntireSite') . '</em>' ) .
							'</th></tr>' . "\n";
						// contents
						echo '<tr>' .
								'<th>' . $engine->_t('BackupStructure') . '</th>' .
								'<th>' . $engine->_t('BackupData') . '</th>' .
								'<th>' . $engine->_t('BackupFiles') . '</th>' .
							'</tr>' . "\n";
						// structure
						echo '<tr>' .
								'<td>';

						$list = explode(';', $log['structure']);

						foreach ($tables as $table)
						{
							if (in_array($table['name'], $list))
							{
								echo '<strong>' . $table['name'] . '</strong><br>';
							}
							else
							{
								echo '<em class="grey">' . $table['name'] . '</em><br>';
							}
						}

						// data
						echo '</td>' . "\n" .
							'<td>';

						$list = explode(';', $log['data'] ?? null);

						foreach ($tables as $table)
						{
							if (in_array($table['name'], $list))
							{
								echo '<strong>' . $table['name'] . '</strong><br>';
							}
							else
							{
								echo '<em class="grey">' . $table['name'] . '</em><br>';
							}
						}

						// files
						echo '</td>' . "\n" .
							'<td>';

						$list = explode(';', $log['files'] ?? null);

						foreach ($directories as $directory)
						{
							$directory = rtrim($directory, '/');

							if (in_array($directory, $list))
							{
								echo '<strong>' . $directory . '</strong><br>';
							}
							else
							{
								echo '<em class="grey">' . $directory . '</em><br>';
							}
						}

						echo	 "</td>\n" .
							"</tr>\n</table>\n";

					// close row
					echo "</td>\n</tr>\n" .
					// end dir check
						'<tr>
							<td colspan="2">
								<strong>' . $engine->_t('RestoreOptions') . '</strong><br>
								<input type="checkbox" id="ignore_keys" name="ignore_keys" value="1">
								<label for="ignore_keys"><small>' . $engine->_t('IgnoreDuplicatedKeysNr') . ' *</small></label><br>
								<input type="checkbox" id="ignore_files" name="ignore_files" value="1">
								<label for="ignore_files"><small>' . $engine->_t('IgnoreSameFiles') . ' **</small></label><br>
							</td>
						</tr>' .
					'</table>
				<br>';

				echo	'<input type="hidden" name="backup_id" value="' . Ut::html($backup_id) . '">' . "\n" .
						'<input type="hidden" name="start" value="true">' . "\n" .
						Ut::perc_replace($engine->_t('ConfirmDbRestore'), ' <code>' . Ut::html($backup_id) . '</code>') . '<br><br>' .
						'<button type="submit" id="submit" name="restore">' . $engine->_t('RestoreYes') . '</button> ' .
						'<a href="' . $engine->href() . '" class="btn-link"><button type="button" id="button">' . $engine->_t('RestoreNo') . '</button></a>' .
						'<br><small>' . $engine->_t('ConfirmDbRestoreInfo') . '</small>';

				echo '<br><br>
						<p><small>' .
							$engine->_t('RestoreOptionsInfo') .
						'</small></p>';

			echo $engine->form_close();
		}

		if (isset($_POST['start']))
		{
			set_time_limit(3600);

			// $dir see above
			$pack	= $backup_id;

			// set parameters
			if (isset($_POST['ignore_keys']) && $_POST['ignore_keys']	== 1) $ikeys	= true;
			if (isset($_POST['ignore_files']) && $_POST['ignore_files']	== 1) $ifiles	= true;

			// read backup log
			$text	= file_get_contents(Ut::join_path(UPLOAD_BACKUP_DIR, $pack, BACKUP_FILE_LOG));
			$log	= Ut::unserialize($text);

			// start process logging
			$results = '<strong>' . date('H:i:s') . ' - ' . $engine->_t('RestoreStarted') . "\n" .
				'================================================' . "\n" .
				$engine->_t('RestoreParameters') . ':' . "\n" .
				"\t" . $engine->_t('IgnoreDuplicatedKeys') . ': ' . ($ikeys === true ? $engine->_t('RestoreYes') : $engine->_t('RestoreNo') ) . "\n" .
				"\t" . $engine->_t('IgnoreDuplicatedFiles') . ': ' . ($ifiles === true ? $engine->_t('RestoreYes') : $engine->_t('RestoreNo') ) . "\n\n" .
				$engine->_t('SavedCluster') . ': ' . ($log['cluster'] ?: $engine->_t('RestoreNo')) . "\n" .
				"\t" . Ut::perc_replace($engine->_t(
					($log['cluster']
						? 'DataProtection'
						: 'AssumeDropTable'), SYSTEM_LANG), 'DROP TABLE') . "\n" .
				'</strong>' . "\n\n";

			// request structure restore
			$results .= '<strong>' . date('H:i:s') . ' - ' . $engine->_t('RestoreTableStructure') . "\n" .
				'================================================</strong>' . "\n";

			if ($log['structure'])
			{
				$results .= '<strong>' . $engine->_t('RunSqlQueries') . '</strong>' . "\n\n";
				$results .= file_get_contents(Ut::join_path(UPLOAD_BACKUP_DIR, $pack, BACKUP_FILE_STRUCTURE)) . "\n\n";

				// run
				$total = put_table($engine, $pack);

				$results .= '<strong>' . date('H:i:s') . ' - ' . $engine->_t('CompletedSqlQueries') . ' ' . $total . '</strong>' . "\n\n\n";
			}
			else
			{
				$results .= '<strong>' . $engine->_t('NoTableStructure') . '</strong>' . "\n\n\n";
			}

			// request data restore
			$results .= '<strong>' . date('H:i:s') . ' - ' . $engine->_t('RestoreRecords') . "\n" .
				'================================================</strong>' . "\n";

			if ($log['data'])
			{
				$list = explode(';', $log['data']);

				// sql mode
				if		(!$log['cluster'])	$mode = 'INSERT';
				else if	($ikeys === true)	$mode = 'INSERT IGNORE';
				else if	(!$ikeys)			$mode = 'REPLACE';

				$results .= '<strong>' . $engine->_t('ProcessTablesDump') . "\n" .
					'(' . $engine->_t('Instruction') . ' ' . $mode . '):</strong>' . "\n\n";

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
					$results .= "\t" . '<strong>' . date('H:i:s') . ' - ' . $table."\n" .
						"\t" . '==========================</strong>' . "\n";

					$total		= put_data($engine, $pack, $table, $mode);
					$overall	+= $total;

					$results .= "\t\t" . $engine->_t('RestoredRecords') . '   ' . $total . "\n\n";
				}

				$results .= '<strong>' . date('H:i:s') . ' - ' . $engine->_t('RecordsRestoreDone') . ' ' . $overall . '</strong>' . "\n\n\n";
			}
			else
			{
				$results .= '<strong>' . $engine->_t('SkippedRecords') . '</strong>' . "\n\n\n";
			}

			// request files restore
			$results .= '<strong>' . date('H:i:s') . ' - ' . $engine->_t('RestoringFiles') . "\n" .
				'================================================</strong>' . "\n";

			if (isset($log['files']) && $log['files'])
			{
				$list = explode(';', $log['files']);

				// rewrite mode
				if ($ifiles === true)	$keep = 1;
				else					$keep = 0;

				$results .= '<strong>' . $engine->_t('DecompressAndStore') . "\n" .
					'(' . $engine->_t('HomonymicFiles') . ': ' .
					($ifiles === true
						? $engine->_t('RestoreSkip')
						: $engine->_t('RestoreReplace') ) . '):</strong>' . "\n\n";

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

					$results .= "\t" . '<strong>' . date('H:i:s') . ' - ' . $sub_dir . "\n" .
						"\t" . '==========================</strong>' . "\n";

					$total		= put_files($pack, $sub_dir, $keep);

					$overall[0]	+= $total[0] ?? null;
					$overall[1]	+= $total[1] ?? null;

					$results .=
						"\t\t" . $engine->_t('RestoreFile') . ' ' .		(int) array_sum($total) . "\n" .
						"\t\t" . $engine->_t('RestoredFiles') . ' ' .	(int) $total[0] . "\n" .
						"\t\t" . $engine->_t('SkippedFiles') . ' ' .	(int) $total[1] . "\n\n";

				}

				$results .= '<strong>' . date('H:i:s') . ' - ' . $engine->_t('FileRestoreDone') . "\n" .
					"\t" . $engine->_t('FilesAll') . ' ' .		(int) array_sum($overall) . "\n" .
					"\t" . $engine->_t('RestoredFiles') . ' ' .	(int) $overall[0] . "\n" .
					"\t" . $engine->_t('SkippedFiles') . ' ' .	(int) $overall[1] . "\n" .
					'</strong>' . "\n\n";
			}
			else
			{
				$results .= '<strong>' . $engine->_t('SkipFiles') . '</strong>' . "\n\n\n";
			}

			// finishing
			$results .= '<strong>================================================' . "\n" .
				date('H:i:s') . ' - ' . $engine->_t('RestoreDone') . '</strong>';

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
				'<button type="submit" name="remove" id="remove-submit">' . $engine->_t('BackupRemove') . '</button>';

			// open backups dir and run through all subdirs
			if ($dh = opendir(rtrim($backup_dir, '/')))
			{
				while (false !== ($pack_dir = readdir($dh)))
				{
					$file = Ut::join_path(UPLOAD_BACKUP_DIR, $pack_dir, BACKUP_FILE_LOG);

					// we only need subdirs with appropriate name length
					// and with backup register contained within
					if (is_dir(Ut::join_path(UPLOAD_BACKUP_DIR, $pack_dir)) === true
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

				#Ut::debug_print_r($logs);

				if (!empty($logs))
				{
					echo $control_buttons;
	?>
					<table class="restore formation">
						<tr>
							<th><?php echo $engine->_t('BackupCreationDate');?></th>
							<th><?php echo $engine->_t('BackupPackageContents');?></th>
						</tr>
	<?php
					// sort 'creation date' descending with custom numeric comparisons function
					usort($logs, function (array $a, array $b) { return $b[0] - $a[0]; });

					foreach ($logs as $i => $log)
					{
						// open row
						echo '<tr class="hl-setting">' . "\n";

						// pack
						echo '<td>
								<table class="restore-meta">
									<tr>' .
										'<td class="label">' .
										#	'<input type="checkbox" name="' . $log['pack'] . '" value="id" ' . ( in_array($log['pack'], $set) ? ' checked' : '') . '>
										#</td>' .
										#'<td>' .
											'<input type="radio" id="pack_' . $i . '" name="backup_id" value="' . $log['pack'] . '">' .
										'</td>
										<th class="t-left nowrap">' .
											'<label for="pack_' . $i . '">' .
												date($engine->db->date_format . ' ' . $engine->db->time_format_seconds, $log['time']) .
												'</label>' .
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
											' . (isset($log['size']) ? $engine->binary_multiples($log['size'], false, true, true) : null) . '
										</td>
									</tr>
									<tr>
										<td></td>
										<td>
											<br><a href="' . $engine->href('', '', ['remove' => 1, 'backup_id' => Ut::html($log['pack'])]) . '">' . $engine->_t('DeleteButton') . '</a>
										</td>
									</tr>
								</table>' .
							"</td>\n";

						// description
						echo '<td><table>';
							// cluster root
							echo '<tr><th colspan="3" class="t-left nowrap">' .
									$engine->_t('BackupCluster') . ' ' . ($log['cluster'] ?: '<em class="grey">' . $engine->_t('BackupEntireSite') . '</em>' ) .
								'</th></tr>' . "\n";
							// contents
							echo '<tr>' .
									'<th>' . $engine->_t('BackupStructure') . '</th>' .
									'<th>' . $engine->_t('BackupData') . '</th>' .
									'<th>' . $engine->_t('BackupFiles') . '</th>' .
								'</tr>' . "\n";
							// structure
							echo '<tr>' .
									'<td>';

							$list = explode(';', $log['structure']);

							foreach ($tables as $table)
							{
								if (in_array($table['name'], $list))
								{
									echo '<strong>' . $table['name'] . '</strong><br>';
								}
								else
								{
									echo '<em class="grey">' . $table['name'] . '</em><br>';
								}
							}

							// data
							echo '</td>' . "\n" .
								'<td>';

							$list = explode(';', $log['data'] ?? null);

							foreach ($tables as $table)
							{
								if (in_array($table['name'], $list))
								{
									echo '<strong>' . $table['name'] . '</strong><br>';
								}
								else
								{
									echo '<em class="grey">' . $table['name'] . '</em><br>';
								}
							}

							// files
							echo '</td>' . "\n" .
								'<td>';

							$list = explode(';', $log['files'] ?? null);

							foreach ($directories as $directory)
							{
								$directory = rtrim($directory, '/');

								if (in_array($directory, $list))
								{
									echo '<strong>' . $directory . '</strong><br>';
								}
								else
								{
									echo '<em class="grey">' . $directory . '</em><br>';
								}
							}

							echo	"</td>\n" .
								"</tr>\n</table>\n";

						// close row
						echo "</td>\n</tr>\n" .
							'<tr class="lined"><td colspan="2"></td></tr>' . "\n";
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
