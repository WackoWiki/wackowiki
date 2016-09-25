<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Database Repair and Optimization Script          ##
########################################################

$module['db_repair'] = [
		'order'	=> 540,
		'cat'	=> 'Database',
		'status'=> true,
		'mode'	=> 'db_repair',
		'name'	=> 'Repair',
		'title'	=> 'Repair and Optimize Database',
		'vars'	=> [&$tables, &$directories],
	];

// TODO: to merge with db_optimize module

########################################################

function admin_db_repair(&$engine, &$module)
{
	$check = '';

	// import passed variables and objects
	$tables			= & $module['vars'][0];
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	if ( isset( $_POST['repair'] ) )
	{
		$optimize = 2 == $_POST['action'];
		$okay		= true;
		$problems	= [];

		echo '<ol>';

		// Loop over the tables, checking and repairing as needed.
		foreach ( $tables as $table )
		{
			$check = $engine->db->load_single( "CHECK TABLE {$table['name']}" );
			#$engine->db->sql_query($sql);

			if ( 'OK' == $check['Msg_text'] )
			{
				$message = '<li>' . 'The %1 table is okay.';
				echo str_replace('%1', '<code>'.$table['name'].'</code>', $message);
			}
			else
			{
				$message = '<li>' . 'The %1 table is not okay. It is reporting the following error: %2. WackoWiki will attempt to repair this table&hellip;';

				echo str_replace('%1', '<code>'.$table['name'].'</code>',
						str_replace('%2', '<code>'.$check['Msg_text'].'</code>',
								$message));

				$check = $engine->db->load_single( "REPAIR TABLE {$table['name']}" );
				#$engine->db->sql_query($sql);

				if ( 'OK' == $check['Msg_text'] )
				{
					$message =  '<li>' . 'Successfully repaired the %1 table.';
					echo str_replace('%1', '<code>'.$table['name'].'</code>', $message);
				}
				else
				{
					$message = '<li>' . 'Failed to repair the %1 table. <br />Error: %2';

					echo str_replace('%1', '<code>'.$table['name'].'</code>',
							str_replace('%2', '<code>'.$check['Msg_text'].'</code>',
									$message));

					$problems[$table]	= $check['Msg_text'];
					$okay				= false;
				}
			}

			if ( $okay && $optimize )
			{
				echo '<ul>';

				$check = $engine->db->load_single( "ANALYZE TABLE {$table['name']}" );
				#$engine->db->sql_query($sql);

				if ( 'Table is already up to date' == $check['Msg_text'] )
				{
					$message = '<li>' . 'The %1 table is already optimized.' . '</li>';
					echo str_replace('%1', '<code>'.$table['name'].'</code>', $message);
				}
				else
				{
					$check = $engine->db->load_single( "OPTIMIZE TABLE {$table['name']}" );
					#$engine->db->sql_query($sql);

					if ( 'OK' == $check['Msg_text'] || 'Table is already up to date' == $check['Msg_text'] )
					{
						$message = '<li>' . 'Successfully optimized the %1 table.' . '</li>';
						echo str_replace('%1', '<code>'.$table['name'].'</code>', $message);
					}
					else
					{
						$message = '<li>' . 'Failed to optimize the %1 table. <br />Error: ' . '<code>'.$check['Msg_text'].'</code>' . '</li>';
						echo str_replace('%1', '<code>'.$table['name'].'</code>', $message);
					}
				}

				echo '</ul></li>';
			}
		}

		echo '</ol>';

		if ( $problems )
		{
			echo '<p>' . 'Some database problems could not be repaired.' . '</p>'.  '';
			$problem_output = '';

			foreach ( $problems as $table => $problem )
			{
				$problem_output .= "$table: $problem\n";
			}

			echo '<p><textarea name="errors" id="errors" rows="20" cols="60">' . $problem_output . '</textarea></p>';
		}
		else
		{
			echo '<br /><p>' . 'Repairs complete' . '</p>';
		}
	}
	else
	{
		echo '<h2>Repair Database</h2>';

		echo '<p>' . 'This script can automatically look for some common database problems and repair them. Repairing can take a while, so please be patient.' . '</p>';

		echo $engine->form_open('repair');
		?>
		<br />
		<input type="hidden" name="action" value="1" />
		<input type="submit" name="repair" id="submit" value="Repair Database" />
		<?php		echo $engine->form_close();?>
		<br />

		<h2>Repair and Optimize Database</h2>
		<p><?php echo 'This script can also attempt to optimize the database. This improves performance in some situations. Repairing and optimizing the database can take a long time and the database will be locked while optimizing.' ; ?></p>
		<br />
		<?php
		echo $engine->form_open('repair');
		?>
		<input type="hidden" name="action" value="2" />
		<input type="submit" name="repair" id="submit" value="Repair and Optimize Database" />
		<?php		echo $engine->form_close();
	}
}

?>