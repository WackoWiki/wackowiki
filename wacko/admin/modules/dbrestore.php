<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   DB Restore                                       ##
########################################################

$module['dbrestore'] = array(
		'order'	=> 10,
		'cat'	=> 'Database',
		'mode'	=> 'dbrestore',
		'name'	=> 'Restore database',
		'title'	=> 'Restoring backup data',
		'vars'	=> array(&$tables, &$directories),
	);

########################################################

function admin_dbrestore(&$engine, &$module)
{

//$dir = $engine->config['upload_path_backup'].'/2007_06_27_20_53_bd57f009381325efff2d684d4c2fbd54';
//if ($dh = opendir($dir))
//{
//	while (false !== ($file = readdir($dh)))
//	{
//		if (is_dir($dir.'/'.$file) !== true)
//		{
//			chmod($dir.'/'.$file, 0777);
//		}
//	}
//	closedir($dh);
//	chmod($dir, 0777);
//}

	// import passed variables and objects
	$tables			= & $module['vars'][0];
	$directories	= & $module['vars'][1];
?>
				<h1><?php echo $module['title']; ?></h1>
				<br />
<?php
	$logs			= '';

	if (isset($_POST['start']) && $_POST['id'] == true)
	{
		set_time_limit(3600);

		$dir	= $engine->config['upload_path_backup'].'/';
		$pack	= $_POST['id'];

		// set parameters
		if ($_POST['ignore_keys']	== 1) $ikeys	= true;
		if ($_POST['ignore_files']	== 1) $ifiles	= true;

		// read backup log
		$log = str_replace("\n", '', file($dir.$pack.'/'.BACKUP_FILE_LOG));

		// start process logging
		$results = '<strong>'.date('H:i:s').' - Initiated Backups'."\n".
			'================================================'."\n".
			'Using parameters:'."\n".
			"\t".'Ignore dublicated keys: '.( $ikeys === true ? 'Yes' : 'No' )."\n".
			"\t".'Ignore dublicated files: '.( $ifiles === true ? 'Yes' : 'No' )."\n\n".
			'Saved cluster: '.( $log[2] == true ? $log[2] : 'No' )."\n".
			"\t".( $log[2] == true ? 'Data Protection - DROP TABLE omitted' : 'Assume DROP TABLE' )."\n".
			'</strong>'."\n\n";

		// request structure restore
		$results .= '<strong>'.date('H:i:s').' - Restoring the structure of the tables'."\n".
			'================================================</strong>'."\n";

		if ($log[3] == true)
		{
			$results .= '<strong>Perform SQL-instructions:</strong>'."\n\n";
			$results .= file_get_contents($dir.$pack.'/'.BACKUP_FILE_STRUCTURE)."\n\n";

			// run
			$total = put_table($engine, $pack);

			$results .= '<strong>'.date('H:i:s').' - Completed. Processed instructions: '.$total.'</strong>'."\n\n\n";
		}
		else
		{
			$results .= '<strong>The structure of the tables are not saved - skip</strong>'."\n\n\n";
		}

		// request data restore
		$results .= '<strong>'.date('H:i:s').' - Restore the contents of tables'."\n".
			'================================================</strong>'."\n";

		if ($log[4] == true)
		{
			$list = explode(';', $log[4]);

			// sql mode
			if		($log[2] == false)						$mode = 'INSERT';
			else if	($log[2] == true && $ikeys === true)	$mode = 'INSERT IGNORE';
			else if	($log[2] == true && $ikeys == false)	$mode = 'REPLACE';

			$results .= '<strong>Just download and process dump tables'."\n".
				'(Instruction '.$mode.'):</strong>'."\n\n";

			// run
			$overall = 0;

			foreach ($list as $table)
			{
				// force sql mode for some tables
				if (($table == $tables[$engine->config['table_prefix'].'acl']['name'] ||
				$table == $tables[$engine->config['table_prefix'].'link']['name']) &&
				$ikeys == false)
					$mode = 'REPLACE';

				$results .= "\t".'<strong>'.date('H:i:s').' - '.$table."\n".
					"\t".'==========================</strong>'."\n";

				$total		= put_data($engine, $pack, $table, $mode);
				$overall	+= $total;

				$results .= "\t\t".'records:   '.$total."\n\n";
			}

			$results .= '<strong>'.date('H:i:s').' - Completed. Total entries: '.$overall.'</strong>'."\n\n\n";
		}
		else
		{
			$results .= '<strong>Data not saved - skip</strong>'."\n\n\n";
		}

		// request files restore
		$results .= '<strong>'.date('H:i:s').' - Restoring files'."\n".
			'================================================</strong>'."\n";

		if ($log[5] == true)
		{
			$list = explode(';', $log[5]);

			// rewrite mode
			if ($ifiles === true)	$keep = 1;
			else					$keep = 0;

			$results .= '<strong>Decompress and store the contents of directories'."\n".
				'(homonymic files '.( $ifiles === true ? 'skip' : 'substitute' ).'):</strong>'."\n\n";

			// run
			$overall = array();

			foreach ($list as $dir)
			{
				$results .= "\t".'<strong>'.date('H:i:s').' - '.$dir."\n".
					"\t".'==========================</strong>'."\n";

				$total		= put_files($engine, $pack, $dir, $keep);

				$overall[0]	+= $total[0]; //isset($total[0]) ? $total[0] : null;
				$overall[1]	+= $total[1]; //isset($total[1]) ? $total[1] : null;

				$results .=
					"\t\t".'File:    '.(int)array_sum($total)."\n".
					"\t\t".'recorded:  '.(int)$total[0]."\n".
					"\t\t".'skipped: '.(int)$total[1]."\n\n";

			}

			$results .= '<strong>'.date('H:i:s').' - Completed. Total files:'."\n".
				"\t".'all:     '.(int)array_sum($overall)."\n".
				"\t".'recorded:  '.(int)$overall[0]."\n".
				"\t".'skipped: '.(int)$overall[1]."\n".
				'</strong>'."\n\n";
		}
		else
		{
			$results .= '<strong>Files are not stored - skip</strong>'."\n\n\n";
		}

		// finishing
		$results .= '<strong>================================================'."\n".
			date('H:i:s').' - RESTORATION COMPLETED</strong>';

				$message = 'The backup is restored, the implementation of the report is attached below. To
							delete this backup file, click <a href="?mode=dbrestore&remove=1&id=<?php echo $pack; ?>">here</a>.';
				$engine->show_message($message);
?>
				<div class="code" style="padding:3px;"><small><pre><?php echo $results; ?></pre></small></div><br />
<?php
		$engine->log(1, 'Restored backup of a database '.$pack);
	}
	else
	{
		if ((isset($_POST['remove']) && $_POST['id'] == true) ||
		(isset($_GET['remove']) && $_GET['id'] == true))
		{
			if ($_POST['id'] == true)
			{
				remove_pack($engine, $_POST['id']);
				$engine->log(1, 'Removed backup database '.$_POST['id']);
			}
			else if ($_GET['id'] == true)
			{
				remove_pack($engine, $_GET['id']);
				$engine->log(1, 'Removed backup database '.$_GET['id']);
			}

			$message = '<p class="green"><em>The selected backup has been successfully removed.</em></p>';
			$engine->show_message($message);
		}
?>
				<p>
					You can restore any of the packages found Standby or
					Remove it from the server.
				</p>
				<br />
				<form action="admin.php" method="post" name="restore">
					<input type="hidden" name="mode" value="dbrestore" />
					<table style="border-spacing: 1px; border-collapse: separate; padding: 4px;" class="formation">
						<tr>
							<th>Creation Date</th>
							<th>The contents of the package</th>
						</tr>
<?php
		$dir = $engine->config['upload_path_backup'].'/';

		// open backups dir and run through all subdirs
		if ($dh = opendir(rtrim($dir, '/')))
		{
			while (false !== ($packname = readdir($dh)))
			{
				// we only need subdirs with appropriate name length
				// and with backup register contained within
				if (is_dir($dir.$packname) === true && //strlen($packname) == 49) &&
				file_exists($dir.$packname.'/'.BACKUP_FILE_LOG) === true)
				{
					$_array1 = str_replace("\n", '', file($dir.$packname.'/'.BACKUP_FILE_LOG));
					$_array2 = array('pack' => $packname);
					// read log
					$logs[] = array_merge($_array1, $_array2);
				}
			}

			#$engine->debug_print_r($logs);

			if (is_array($logs))
			{
				// sort 'creation date' descending with custom numeric comparisons function
				usort($logs, function (array $a, array $b) { return $b[0] - $a[0]; });

				foreach ($logs as $log)
				{	// open row
					echo '<tr>'."\n";

					// pack
					echo '<td><table><tr><td class="label" style="width:10px;">'.
							'<input name="id" type="radio" value="'.$log['pack'].'" />'.
						'</td><th style="text-align:left;white-space:nowrap;">'.
							date($engine->config['date_format'].' '.$engine->config['time_format_seconds'], $log[0]).
						'</th></tr></table></td>'."\n";

					// description
					echo '<td><table>';
						// cluster root
						echo '<tr><th colspan="3" style="text-align:left;white-space:nowrap;">'.
								'Cluster: '.( $log[2] == true ? $log[2] : '<em style="font-weight:normal;" class="grey">Entire site</em>' ).
							'</th></tr>'."\n";
						// contents
						echo '<tr>'.
								'<th>Structure</th>'.
								'<th>Data</th>'.
								'<th>Files</th>'.
							'</tr>'."\n";
						// structure
						echo '<tr>'.
								'<td>';

						$list = explode(';', $log[3]);

						foreach ($tables as $table)
						{
							if (in_array($table['name'], $list))
							{
								echo '<strong>'.$table['name'].'</strong><br />';
							}
							else
							{
								echo '<em class="grey">'.$table['name'].'</em><br />';
							}
						}

						// data
						echo '</td>'."\n".
							'<td>';

						$list = explode(';', isset($log[4]) ? $log[4] : null);

						foreach ($tables as $table)
						{
							if (in_array($table['name'], $list))
							{
								echo '<strong>'.$table['name'].'</strong><br />';
							}
							else
							{
								echo '<em class="grey">'.$table['name'].'</em><br />';
							}
						}

						// files
						echo '</td>'."\n".
							'<td>';

						$list = explode(';', isset($log[5]) ? $log[5] : null);

						foreach ($directories as $directory)
						{
							$directory = rtrim($directory, '/');

							if (in_array($directory, $list))
							{
								echo '<strong>'.$directory.'</strong><br />';
							}
							else
							{
								echo '<em class="grey">'.$directory.'</em><br />';
							}
						}

						echo	 '</td>'."\n".
							'</tr></table>'."\n";

					// close row
					echo '</td></tr>'.
						'<tr class="lined"><td colspan="2"></td></tr>'."\n";
				} // end dir check
			} // end while loop
			closedir($dh);
		} // end opendir
?>
						<tr>
							<td colspan="2">
								<strong>Additional options for recovery:</strong><br />
								<input id="ignore_keys" name="ignore_keys" type="checkbox" value="1" />
								<label for="ignore_keys"><small>Ignore dublicated keys table (not replace) *</small></label><br />
								<input id="ignore_files" name="ignore_files" type="checkbox" value="1" />
								<label for="ignore_files"><small>Ignore the same files (not overwrite) **</small></label><br />
							</td>
						</tr>
					</table>
					<input name="start" id="submit" type="submit" value="restore" />
					<input name="remove" id="submit" type="submit" value="remove" />
				</form>
				<br />
				<p><small>
					* Before restoring the backup <span class="underline">cluster</span>, the target table
					not destroyed (to prevent loss of information from non -
					Clusters). Thus, in the recovery process will occur
					duplicate record. In normal mode, they will be replaced by recordings of
					backup (using SQL-instructions  <code>REPLACE</code>), but if this
					checked, all duplicates will be skipped (to be kept current
					values of records), and added to the table only the records with new keys
					(SQL-instruction <code>INSERT IGNORE</code>). <span class="underline">Note</span>: to restore
					complete backup of the site, this option has no value.<br />
					<br />
					** If the backup contains the user files (global and
					perpage, cache files, etc.), while in normal mode when you restore it 			will replace the same
					files are placed in the same directory. This option allows you to save the 	current
					copies of the files and restore from a backup only new (missing
					on the server) files.
				</small></p>
<?php
	}
}

?>
