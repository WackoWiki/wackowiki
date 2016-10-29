<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   DB Engine Conversion                             ##
########################################################
$_module = 'db_convert';

$module[$_module] = [
		'order'	=> 520,
		'cat'	=> 'database',
		'status'=> true,
		'mode'	=> $_module,
		'name'	=> 'Convert',
		'title'	=> 'Converting Tables or Columns',
		'vars'	=> [&$tables],
];

########################################################

function admin_db_convert(&$engine, &$module)
{
	// import passed variables and objects
	$tables	= & $module['vars'][0];

	$scheme		= '';
	$getstr		= '';
	$elements	= '';
	$sql		= '';
	$sql_log	= [];

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
				$getstr .= '&'.$key.'=1';
			}
			else
			{
				$getstr .= '&'.$key.'=0';
			}
		}
	}
	?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php

	if (isset($_POST['start-convert_tables']))
	{
		foreach ($_POST as $val => $key)
		{
			if ($key == 'table')
			{
				$sql = "ALTER TABLE {$val} ENGINE=INNODB";
				$engine->db->sql_query($sql);

				$sql_log[] = $sql;
			}
		}

		if ($sql)
		{
			$sql_log = implode(",\n", $sql_log);

			$engine->log(1, 'Convertion database');

			$message = 'Convertion of the selected tables successfully.';
			$engine->show_message($message, 'success');
?>
			<br />
			<div class="code" style="padding:3px;">
				<small><pre><?php echo $sql_log; ?></pre></small>
			</div><br />
<?php
		}
	}
	else if (isset($_POST['start-convert_columns']))
	{
		$engine->db->sql_mode_strict = false;

		foreach ($engine->sess->sql_strict_queries as $sql)
		{
			if ($sql)
			{
				// setting the SQL Mode, disable possible Strict SQL Mode
				$engine->db->sql_query("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION';");
				$engine->db->sql_query($sql);

				$sql_log[] = $sql;
			}
		}

		$engine->sess->sql_strict_queries = null;

		if ($sql)
		{
			$sql_log = implode(",\n", $sql_log);

			$engine->log(1, 'Converted colums to comply with the SQL strict mode');

			$message = 'Convertion of the selected columns successfully.';
			$engine->show_message($message, 'success');

			?>
			<br />
			<div class="code" style="padding: 3px;">
				<small><pre><?php echo $sql_log; ?></pre></small>
			</div><br />
		<?php
		}
	}

	if (@$_POST['action'] == 'convert_tables')
	{
		?>
		<h2>Converting Tables from MyISAM to InnoDB/XtraDB</h2>
		<p>
			If you have existing tables, that you want to convert to InnoDB/XtraDB* for better reliability and scalability, use the following routine. These tables were originally MyISAM, which was formerly the default.
		</p>
		<br />
<?php
		// Determine whether InnoDB plugin is installed in MySQL
		// https://dev.mysql.com/doc/refman/5.7/en/engines-table.html
		// https://dev.mysql.com/doc/refman/5.7/en/information-schema.html
		// If InnoDB is available, but not the default engine, the result will be YES. If it's not available, the result will obviously be NO.
		$sql_InnoDB			= "SELECT SUPPORT FROM INFORMATION_SCHEMA.ENGINES WHERE ENGINE = 'InnoDB'";
		$InnoDB_support		= $engine->db->load_single($sql_InnoDB);

		$_db_version	= $engine->db->load_single("SELECT version()");
		$db_version		= $_db_version['version()'];
		$db_version		= preg_replace('#[^0-9\.]#', '', $db_version);

		if (version_compare($db_version, '5.6.4', '>='))
		{
			$required_mysql_version = true;
			echo output_image($engine, true).'Requires at least MySQL 5.6.4, available version: ' . $db_version . "<br />\n";
		}
		else
		{
			$required_mysql_version = false;
			echo output_image($engine, false).'<strong class="red">Requires at least MySQL 5.6.4, available version: </strong> ' . $db_version . "<br />\n";
		}

		if ($InnoDB_support['SUPPORT'] == 'YES' || 'DEFAULT')
		{
			$required_engine = true;
			echo output_image($engine, true).'InnoDB/XtraDB is available. '. $InnoDB_support['SUPPORT']. "<br />\n";
		}
		else
		{
			$required_engine = false;
			echo output_image($engine, false).'<strong class="red">InnoDB / XtraDB is not available.</strong>'. "<br />\n";
		}

		if ($required_mysql_version === true && $required_engine = true)
		{
			$results = $engine->db->load_all(
				"SELECT TABLE_NAME, ENGINE FROM INFORMATION_SCHEMA.TABLES
				WHERE TABLE_SCHEMA = '{$engine->db->database_database}'
					AND ENGINE = 'MyISAM'
				");

			echo '<br />';

			if ($results)
			{
				echo $engine->form_open('convert');
?>
				<table style="max-width:250px; border-spacing: 1px; border-collapse: separate; padding: 4px;" class="formation">
					<tr>
						<th style="width:50px;" colspan="2"><a href="?mode=<?php echo $module['mode']; ?><?php echo $getstr.( (isset($scheme['all']) && $scheme['all']) == 1 ? '&all=0' : '&all=1' ); ?>">Table</a></th>
						<th style="text-align:left;">Typ</th>
					</tr>
<?php
				foreach ($results as $table)
				{
					foreach ($tables as $wtable)
					{
						if ($table['TABLE_NAME'] == $wtable['name'])
						{
							echo '<tr class="hl_setting">'.
									'<td class="label"><input type="checkbox" name="'.$table['TABLE_NAME'].'" value="table" checked="checked" /></td>'.
									'<td>&nbsp;&nbsp;<strong>'.$table['TABLE_NAME'].'&nbsp;&nbsp;</strong></td>'.
									'<td>'.( $table['ENGINE'] == 'MyISAM' ? '<strong class="red">' : '' ).$table['ENGINE'].( $table['ENGINE'] == 'MyISAM' ? '</strong>' : '' ).'</td>'.
								'</tr>'.
								'<tr class="lined"><td colspan="3"></td></tr>'."\n";
						}
					}

				}
?>
				</table>
				<input type="submit" name="start-convert_tables" id="submit" value="convert" />
<?php
				echo $engine->form_close();
			}
			else
			{
				echo 'No tables to convert.';
			}
		}

		?>
		<br /><br /><br />
		<p><small>
			* XtraDB is an enhanced version of the InnoDB storage engine, designed to better scale on modern hardware, and it includes a variety of other features useful in high performance environments.

			It is fully backwards compatible, and it identifies itself to MariaDB as "ENGINE=InnoDB" (just like InnoDB), and so can be used as a drop-in replacement for standard InnoDB.
		</small></p>
		<br />
<?php
	}
	else if (@$_POST['action'] == 'convert_columns')
	{
	?>
		<p>
		If you have existing tables, that you want to convert to comply with the SQL srtict mode, use the following routine.
		</p>
		<br />
		<?php

		// SQL mode strict
		// https://dev.mysql.com/doc/refman/5.7/en/sql-mode.html
		// https://mariadb.com/kb/en/mariadb/sql_mode/

		// case 1 DATETIME
		// case 2
		$results = $engine->db->load_all(
			"SELECT TABLE_NAME, COLUMN_NAME, COLUMN_DEFAULT, DATA_TYPE
			FROM INFORMATION_SCHEMA.columns
			WHERE DATA_TYPE = 'datetime'
				AND COLUMN_DEFAULT = '0000-00-00 00:00:00'
			");

		echo '<br />';

		if ($results)
		{
			echo $engine->form_open('sql_mode_strict');
			?>
			<table style="max-width:500px; border-spacing: 1px; border-collapse: separate; padding: 4px;" class="formation">
				<tr>
					<th style="width:50px;">Table</th>
					<th style="text-align:left;">Column</th>
					<th style="text-align:left;">Typ</th>
					<th style="text-align:left;">Default</th>
				</tr>
		<?php
			foreach ($results as $table)
			{
				foreach ($tables as $wtable)
				{
					if ($table['TABLE_NAME'] == $wtable['name'])
					{
						// case 1  DATETIME
						if ($table['DATA_TYPE'] == 'datetime')
						{
							echo '<tr class="hl_setting">'.
									'<td>&nbsp;&nbsp;'.$table['TABLE_NAME'].'&nbsp;&nbsp;</td>'.
									'<td class="label">&nbsp;&nbsp;<strong>'.$table['COLUMN_NAME'].'&nbsp;&nbsp;</strong></td>'.
									'<td>&nbsp;&nbsp;'.$table['DATA_TYPE'].'&nbsp;&nbsp;</td>'.
									'<td>'.( $table['COLUMN_DEFAULT'] == '0000-00-00 00:00:00' ? '<strong class="red">' : '' ).$table['COLUMN_DEFAULT'].( $table['COLUMN_DEFAULT'] == '0000-00-00 00:00:00' ? '</strong>' : '' ).'</td>'.
								'</tr>'.
								'<tr class="lined"><td colspan="4"></td></tr>'."\n";

							$sql_log[] = "ALTER TABLE {$table['TABLE_NAME']} CHANGE {$table['COLUMN_NAME']} {$table['COLUMN_NAME']} DATETIME NULL DEFAULT NULL";
							$sql_log[] = "UPDATE {$table['TABLE_NAME']} SET {$table['COLUMN_NAME']} = NULL WHERE {$table['COLUMN_NAME']} = '0000-00-00 00:00:00'";
						}

						// other cases?
					}
				}
			}
		?>
			</table>
		<?php
			if ($sql_log)
			{
				$engine->sess->sql_strict_queries = $sql_log;

				echo '<input type="submit" name="start-convert_columns" id="submit" value="convert" />';
			}
			else
			{
				echo 'No columns to convert.';
			}

			echo $engine->form_close();
		}
		else
		{
			echo 'No columns to convert.';
		}
	}
	else
	{
	?>

		<h2>Converting Tables from MyISAM to InnoDB/XtraDB</h2>
		<p>
		If you have existing tables, that you want to convert to InnoDB/XtraDB* for better reliability and scalability, use the following routine. These tables were originally MyISAM, which was formerly the default.
		</p>
		<?php
		echo $engine->form_open('convert_tables');
		?>
			<input type="hidden" name="action" value="convert_tables" />
			<input type="submit" name="start" id="submit" value="convert" />
		<?php
		echo $engine->form_close();?>


		<h2>Converting Columns to SQL strict</h2>
		<p>
			If you have existing tables, that you want to convert to comply with the SQL srtict mode, use the following routine.
		</p>
		<?php
		echo $engine->form_open('convert_columns');
		?>
			<input type="hidden" name="action" value="convert_columns" />
			<input type="submit" name="start" id="submit" value="convert" />
		<?php
		echo $engine->form_close();
	}
}

?>
