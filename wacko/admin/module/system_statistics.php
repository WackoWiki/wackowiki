<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	System Statistics									##
##########################################################
$_mode = 'system_statistics';

$module[$_mode] = [
		'order'	=> 120,
		'cat'	=> 'basics',
		'status'=> true,
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Statistics
		'title'	=> $engine->_t($_mode)['title'],	// Show statistics
	];

##########################################################

function admin_system_statistics(&$engine, &$module, &$tables, &$directories)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
	<br>
	<?php echo $engine->_t('DbStatSection');?>:
	<br>
	<br>
	<table style="max-width: 600px;" class="formation lined">
		<tr>
			<th style="width:50px;"><?php echo $engine->_t('DbTable');?></th>
			<th class="t-left"><?php echo $engine->_t('DbRecords');?></th>
			<th class="t-left"><?php echo $engine->_t('DbSize');?></th>
			<th class="t-left"><?php echo $engine->_t('DbIndex');?></th>
			<th class="t-left"><?php echo $engine->_t('DbOverhead');?></th>
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
				echo '<tr>' .
						'<th class="label"><strong>' . $table['Name'] . '</strong></th>' .
						'<td>&nbsp;&nbsp;&nbsp;' . number_format($table['Rows'], 0, ',', '.') . '</td>' .
						'<td>' . $engine->binary_multiples($table['Data_length'], false, true, true) . '</td>' .
						'<td>' . $engine->binary_multiples($table['Index_length'], false, true, true) . '</td>' .
						'<td>' . $engine->binary_multiples($table['Data_free'], false, true, true) . '</td>' .
					'</tr>' .
					#'<tr class="lined"><td colspan="5"></td></tr>' .
					"\n";

				$trows	+= $table['Rows'];
				$tdata	+= $table['Data_length'];
				$tindex	+= $table['Index_length'];
				$tfrag	+= $table['Data_free'];
			}
		}
	}
?>
		<tr>
			<td class="label"><strong><?php echo $engine->_t('DbTotal');?>:</strong></td>
			<td><strong>&nbsp;&nbsp;&nbsp;<?php echo number_format($trows, 0, ',', '.'); ?></strong></td>
			<td><strong><?php echo $engine->binary_multiples($tdata, false, true, true); ?></strong></td>
			<td><strong><?php echo $engine->binary_multiples($tindex, false, true, true); ?></strong></td>
			<td><strong><?php echo $engine->binary_multiples($tfrag, false, true, true); ?></strong></td>
		</tr>
	</table>
	<br>
	<?php echo $engine->_t('FileStatSection');?>:
	<br>
	<br>
	<table style="max-width:300px;" class="formation lined">
		<tr>
			<th style=""><?php echo $engine->_t('FileFolder');?></th>
			<th class="t-left"><?php echo $engine->_t('FileFiles');?></th>
			<th class="t-left"><?php echo $engine->_t('FileSize');?></th>
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

			echo '<tr>' .
					'<td class="label"><strong>' . $dir . '</strong></td>' .
					'<td>&nbsp;&nbsp;&nbsp;' . $files . '</td>' .
					'<td>' . $engine->binary_multiples($size, false, true, true) . '</td>' .
				'</tr>' . "\n";
		}
	}
?>
		<tr>
			<td class="label"><strong><?php echo $engine->_t('FileTotal');?>:</strong></td>
			<td>&nbsp;&nbsp;&nbsp;<strong><?php echo $tfiles; ?></strong></td>
			<td><strong><?php echo $engine->binary_multiples($tsize, false, true, true); ?></strong></td>
		</tr>
	</table>

<?php

}

?>
