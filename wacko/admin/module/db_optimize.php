<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   DB Optimization                                  ##
########################################################
$_mode = 'db_optimize';

$module[$_mode] = [
		'order'	=> 530,
		'cat'	=> 'database',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Optimization
		'title'	=> $engine->_t($_mode)['title'],	// Optimizing the database
		'vars'	=> [&$tables],
	];

########################################################

function admin_db_optimize(&$engine, &$module)
{
	// import passed variables and objects
	$tables	= & $module['vars'][0];

	$scheme		= '';
	$getstr		= '';
	$elements	= '';

	// optimizatin scheme
	if (isset($_GET['all']) && $_GET['all'] == 1)
	{
		$scheme['all'] = 1;
	}

	if (is_array($scheme))
	{
		foreach ($scheme as $key => $val)
		{
			if ($val == 1)
			{
				$getstr .= '&' . $key.'=1';
			}
			else
			{
				$getstr .= '&' . $key.'=0';
			}
		}
	}
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	if (isset($_POST['optimize']))
	{
		foreach ($_POST as $val => $key)
		{
			if ($key == 'table') $elements[] = $val;
		}

		if ($elements)
		{
			$sql = implode(",\n\t", $elements);
			$sql = "OPTIMIZE TABLE $sql";

			$engine->db->sql_query($sql);

			$engine->log(1, 'Optimize database');

			$message = 'Optimization of the selected tables successfully.';

?>
			<br />
			<div class="code" style="padding:3px;">
				<small><pre><?php echo $sql; ?></pre></small>
			</div><br />
<?php
		}
		else
		{
			$message = 'No table for optimization selected.';
		}

		$engine->show_message($message);
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
<?php
		echo $engine->form_open('optimize');
?>
			<table style="max-width: 250px; border-spacing: 1px; border-collapse: separate; padding: 4px;" class="formation">
				<tr>
					<th style="width: 50px;" colspan="2"><a href="?mode=<?php echo $module['mode']; ?><?php echo $getstr.( (isset($scheme['all']) && $scheme['all']) == 1 ? '&all=0' : '&all=1' ); ?>">Table</a></th>
					<th style="text-align:left;">Fragmentation</th>
				</tr>
<?php
		$results = $engine->db->load_all("SHOW TABLE STATUS FROM `{$engine->db->database_database}`");

		foreach ($results as $table)
		{
			foreach ($tables as $wtable)
			{
				if ($table['Name'] == $wtable['name'])
				{
					echo '<tr class="hl_setting">'.
							'<td class="label"><input type="checkbox" name="' . $table['Name'] . '" value="table" '.( $table['Data_free'] > 0 || (isset($scheme['all']) && $scheme['all'] == true) ? 'checked="checked"' : '' ).'/></td>'.
							'<td>&nbsp;&nbsp;<strong>' . $table['Name'] . '&nbsp;&nbsp;</strong></td>'.
							'<td>'.( $table['Data_free'] > 0 ? '<strong class="red">' : '' ).$engine->binary_multiples($table['Data_free'], false, true, true).( $table['Data_free'] > 0 ? '</strong>' : '' ).'</td>'.
						'</tr>'.
						'<tr class="lined"><td colspan="3"></td></tr>'."\n";
				}
			}
		}
?>
			</table>
			<input type="submit" name="optimize" id="submit" value="optimize" />
<?php
		echo $engine->form_close();
	}
}

?>
