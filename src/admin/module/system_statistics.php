<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	System Statistics									##
##########################################################

$module['system_statistics'] = [
		'order'	=> 101,
		'cat'	=> 'basics',
		'status'=> true,
	];

##########################################################

function admin_system_statistics($engine, $module, $tables, $directories)
{
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
	<br>
	<?php echo $engine->_t('DbStatSection');?>
	<br>
	<br>
	<?php if (!$engine->db->is_sqlite)
	{
	?>
	<table class="db-stats formation lined">
		<tr>
			<th><?php echo $engine->_t('DbTable');?></th>
			<th><?php echo $engine->_t('DbRecords');?></th>
			<th><?php echo $engine->_t('DbSize');?></th>
			<th><?php echo $engine->_t('DbIndex');?></th>
		</tr>
<?php
	$results	= $engine->db->load_all("SHOW TABLE STATUS FROM `{$engine->db->db_name}`", true);
	$trows		= 0;
	$tdata		= 0;
	$tindex		= 0;
	$tfrag		= 0;

	foreach ($results as $table)
	{
		foreach ($tables as $wtable)
		{
			if ($table['Name'] == $wtable['name'])
			{
				echo
					'<tr>' .
						'<th class="label"><strong>' . $table['Name'] . '</strong></th>' .
						'<td>' . $engine->number_format($table['Rows']) . '</td>' .
						'<td>' . $engine->factor_multiples($table['Data_length'], 'binary', true, true) . '</td>' .
						'<td>' . $engine->factor_multiples($table['Index_length'], 'binary', true, true) . '</td>' .
					'</tr>' . "\n";

				$trows	+= $table['Rows'];
				$tdata	+= $table['Data_length'];
				$tindex	+= $table['Index_length'];
				$tfrag	+= $table['Data_free'];
			}
		}
	}

	echo
		'<tr>' .
			'<td class="label"><strong>' . $engine->_t('DbTotal') . ':</strong></td>' .
			'<td><strong>' . $engine->number_format($trows) . '</strong></td>' .
			'<td><strong>' . $engine->factor_multiples($tdata, 'binary', true, true) . '</strong></td>' .
			'<td><strong>' . $engine->factor_multiples($tindex, 'binary', true, true) . '</strong></td>' .
			'<td><strong>' .
				($engine->db->db_engine !== 'InnoDB'
					? $engine->factor_multiples($tfrag, 'binary', true, true)
					: '-') . '</strong></td>' .
		'</tr>' . "\n";
	?>
	</table>
	<?php
	}
	?>
	<br>
	<?php echo $engine->_t('FileStatSection');?>
	<br>
	<br>
	<table class="file-stats formation lined">
		<tr>
			<th><?php echo $engine->_t('FileFolder');?></th>
			<th><?php echo $engine->_t('FileFiles');?></th>
			<th><?php echo $engine->_t('FileSize');?></th>
		</tr>
<?php
	clearstatcache();

	$tfiles	= 0;
	$tsize	= 0;

	foreach ($directories as $dir)
	{
		$files	= 0;
		$size	= 0;

		foreach (Ut::file_glob($dir, GLOB_ALL) as $file)
		{
			$size += filesize($file);
			$files++;
		}

		if ($files)
		{
			$tfiles += $files;
			$tsize += $size;

			echo
				'<tr>' .
					'<td class="label"><strong>' . $dir . '</strong></td>' .
					'<td>' . $files . '</td>' .
					'<td>' . $engine->factor_multiples($size, 'binary', true, true) . '</td>' .
				'</tr>' . "\n";
		}
	}
?>
		<tr>
			<td class="label"><strong><?php echo $engine->_t('FileTotal');?>:</strong></td>
			<td><strong><?php echo $tfiles; ?></strong></td>
			<td><strong><?php echo $engine->factor_multiples($tsize, 'binary', true, true); ?></strong></td>
		</tr>
	</table>

<?php

}
