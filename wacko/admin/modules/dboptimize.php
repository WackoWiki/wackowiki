<?php

########################################################
##   DB Optimization                                  ##
########################################################

$module['dboptimize'] = array(
		'order'	=> 10,
		'cat'	=> 'Database',
		'mode'	=> 'dboptimize',
		'name'	=> 'Optimization framework',
		'title'	=> 'Optimizing the database',
		'vars'	=> array(&$tables),
	);

########################################################

function admin_dboptimize(&$engine, &$module)
{
	// import passed variables and objects
	$tables	= & $module['vars'][0];

	// optimizatin scheme
	if (isset($_GET['all']) && $_GET['all'] == 1) $scheme['all'] = 1;

	$scheme= '';
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
		foreach ($_POST as $val => $key)
		{
			if ($key == 'table') $elements[] = $val;
		}

		$sql = implode(",\n\t", $elements);
		$sql = "OPTIMIZE TABLE $sql";

		$engine->query($sql);

		$engine->log(1, 'Optimize database');
?>
		<p>
			Optimization of the selected tables successfully.
		</p>
		<br />
		<div class="code" style="padding:3px;"><small><pre><?php echo $sql; ?></pre></small></div><br />
<?php
	}
	else
	{
?>
		<p>
			To optimize (defragment and order by key)
			The following database tables. Optimization reduces the amount of disk
			space occupied by the database, and increases productivity.
		</p>
		<br />
		<form action="admin.php" method="post" name="optimize">
			<input type="hidden" name="mode" value="dboptimize" />
			<table border="0" cellspacing="1" cellpadding="4" style="max-width:250px" class="formation">
				<tr>
					<th style="width:50px;" colspan="2"><a href="?mode=dboptimize<?php echo $getstr.( $scheme['all'] == 1 ? '&all=0' : '&all=1' ); ?>">Table</a></th>
					<th style="text-align:left;">Fragmentation</th>
				</tr>
<?php
		$results = $engine->load_all("SHOW TABLE STATUS FROM `{$engine->config['database_database']}`");

		foreach ($results as $table)
		{
			foreach ($tables as $wtable)
			{
				if ($table['Name'] == $wtable['name'])
				{
					echo '<tr>'.
							'<tr><td class="label"><input name="'.$table['Name'].'" type="checkbox" value="table" '.( $table['Data_free'] > 0 || (isset($scheme['all']) && $scheme['all'] == true) ? 'checked="checked"' : '' ).'/></td>'.
							'<td>&nbsp;&nbsp;<strong>'.$table['Name'].'&nbsp;&nbsp;</strong></td>'.
							'<td>'.( $table['Data_free'] > 0 ? '<strong class="red">' : '' ).ceil($table['Data_free'] / 1000).' Kb'.( $table['Data_free'] > 0 ? '</strong>' : '' ).'</td>'.
						'</tr>'.
						'<tr class="lined"><td colspan="3"></td></tr>'."\n";
				}
			}
		}
?>
			</table>
			<input name="start" id="submit" type="submit" value="optimize" />
		</form>
<?php
	}
}

?>