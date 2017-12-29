<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Database Repair and Optimization Script				##
##########################################################
$_mode = 'db_repair';

$module[$_mode] = [
		'order'	=> 540,
		'cat'	=> 'database',
		'status'=> true,
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Repair
		'title'	=> $engine->_t($_mode)['title'],	// Repair and Optimize Database
		'vars'	=> [&$tables, &$directories],
	];

##########################################################

function admin_db_repair(&$engine, &$module)
{
	$check = '';

	// import passed variables and objects
	$tables			= & $module['vars'][0];
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
<?php
	if (isset($_POST['repair']))
	{
		$optimize	= 2 == $_POST['action'];
		$okay		= true;
		$problems	= [];

		echo '<ol>';

		// Loop over the tables, checking and repairing as needed.
		foreach ($tables as $table)
		{
			$check = $engine->db->load_single("CHECK TABLE {$table['name']}");

			if ('OK' == $check['Msg_text'])
			{
				echo '<li>' . Ut::perc_replace($engine->_t('TableOk'), '<code>' . $table['name'] . '</code>') . '</li>';
			}
			else
			{
				echo '<li>' . Ut::perc_replace($engine->_t('TableNotOk'), '<code>' . $table['name'] . '</code>', '<code>' . $check['Msg_text'] . '</code>') . '</li>';

				$check = $engine->db->load_single("REPAIR TABLE {$table['name']}");

				if ('OK' == $check['Msg_text'])
				{
					echo '<li>' . Ut::perc_replace($engine->_t('TableRepaired'), '<code>' . $table['name'] . '</code>') . '</li>';
				}
				else
				{
					echo '<li>' . Ut::perc_replace($engine->_t('TableRepairFailed'), '<code>' . $table['name'] . '</code>', '<code>' . $check['Msg_text'] . '</code>') . '</li>';

					$problems[$table]	= $check['Msg_text'];
					$okay				= false;
				}
			}

			if ($okay && $optimize)
			{
				echo '<ul>';

				$check = $engine->db->load_single("ANALYZE TABLE {$table['name']}");

				if ('Table is already up to date' == $check['Msg_text'])
				{
					echo '<li>' . Ut::perc_replace($engine->_t('TableAlreadyOptimized'), '<code>' . $table['name'] . '</code>') . '</li>';
				}
				else
				{
					$check = $engine->db->load_single("OPTIMIZE TABLE {$table['name']}");

					if ('OK' == $check['Msg_text'] || 'Table is already up to date' == $check['Msg_text'])
					{
						echo '<li>' . Ut::perc_replace($engine->_t('TableOptimized'), '<code>' . $table['name'] . '</code>') . '</li>';
					}
					else
					{
						echo '<li>' . Ut::perc_replace($engine->_t('TableOptimizeFailed'), '<code>' . $table['name'] . '</code>', '<code>' . $check['Msg_text'] . '</code>') . '</li>';
					}
				}

				echo '</ul></li>';
			}
		}

		echo '</ol>';

		if ($problems)
		{
			echo '<p>' . $engine->_t('TableNotRepaired') . '</p>' .   '';
			$problem_output = '';

			foreach ($problems as $table => $problem)
			{
				$problem_output .= "$table: $problem\n";
			}

			echo '<p><textarea name="errors" id="errors" rows="20" cols="60">' . $problem_output . '</textarea></p>';
		}
		else
		{
			echo '<br><p>' . $engine->_t('RepairsComplete') . '</p>';
		}
	}
	else
	{
		echo '<h2>' . $engine->_t('DbRepairSection') . '</h2>';

		echo '<p>' . $engine->_t('DbOptimizeRepairInfo') . '</p>';

		echo $engine->form_open('repair');
		?>
		<br>
		<input type="hidden" name="action" value="1">
		<input type="submit" name="repair" id="submit" value="<?php echo $engine->_t('DbRepair');?>">
		<?php	echo $engine->form_close();?>
		<br>

		<h2><?php echo $engine->_t('DbOptimizeRepairSection');?></h2>
		<p><?php echo $engine->_t('DbOptimizeRepairInfo'); ?></p>
		<br>
		<?php
		echo $engine->form_open('repair');
		?>
		<input type="hidden" name="action" value="2">
		<input type="submit" name="repair" id="submit" value="<?php echo $engine->_t('DbOptimizeRepair');?>">
		<?php	echo $engine->form_close();
	}
}

?>