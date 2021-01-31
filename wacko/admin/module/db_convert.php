<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	DB Engine Conversion								##
##########################################################
$_mode = 'db_convert';

$module[$_mode] = [
		'order'	=> 520,
		'cat'	=> 'database',
		'status'=> true,
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Convert
		'title'	=> $engine->_t($_mode)['title'],	// Converting Tables or Columns
];

##########################################################

function admin_db_convert(&$engine, &$module, &$tables)
{
	$scheme		= [];
	$getstr		= '';
	$sql		= '';
	$sql_log	= [];

	// optimization scheme
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
				$getstr .= '&' . $key . '=1';
			}
			else
			{
				$getstr .= '&' . $key . '=0';
			}
		}
	}
	?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
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

			$engine->log(1, $engine->_t('LogDatabaseConverted', SYSTEM_LANG));

			$message = $engine->_t('ConversionTablesOk');
			$engine->show_message($message, 'success');
?>
			<br>
			<div class="code">
				<pre><?php echo $sql_log; ?></pre>
			</div><br>
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

			$engine->log(1, $engine->_t('LogColumnsToStrict', SYSTEM_LANG));

			$message = $engine->_t('ConversionColumnsOk');
			$engine->show_message($message, 'success');

			?>
			<br>
			<div class="code">
				<pre><?php echo $sql_log; ?></pre>
			</div><br>
		<?php
		}
	}

	if (@$_POST['action'] == 'convert_tables')
	{
		?>
		<h2><?php echo $engine->_t('ConvertTablesEngine');?></h2>
		<p>
			<?php echo $engine->_t('ConvertTablesEngineInfo');?>
		</p>
		<br>
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
			echo output_image($engine, true) . $engine->_t('DbVersion') . ': ' . $db_version . "<br>\n";
		}
		else
		{
			$required_mysql_version = false;
			echo output_image($engine, false) . '<strong class="red">' . $engine->_t('DbVersionMin') . ': </strong> ' . $db_version . "<br>\n";
		}

		if ($InnoDB_support['SUPPORT'] == 'YES' || 'DEFAULT')
		{
			$required_engine = true;
			echo output_image($engine, true) . $engine->_t('DbEngineOk') . ' ' . $InnoDB_support['SUPPORT'] . "<br>\n";
		}
		else
		{
			$required_engine = false;
			echo output_image($engine, false) . '<strong class="red">' . $engine->_t('DbEngineMissing') . '</strong>' .  "<br>\n";
		}

		if ($required_mysql_version && $required_engine)
		{
			$results = $engine->db->load_all(
				"SELECT TABLE_NAME, ENGINE FROM INFORMATION_SCHEMA.TABLES
				WHERE TABLE_SCHEMA = '{$engine->db->database_database}'
					AND ENGINE = 'MyISAM'
				");

			echo '<br>';

			if ($results)
			{
				echo $engine->form_open('convert');
?>
				<table style="max-width:250px; border-spacing: 1px; border-collapse: separate; padding: 4px;" class="formation">
					<tr>
						<th style="width:50px;" colspan="2"><a href="<?php echo $engine->href('', '') . $getstr . ((isset($scheme['all']) && $scheme['all']) == 1 ? '&all=0' : '&all=1'); ?>"><?php echo $engine->_t('EngineTable');?></a></th>
						<th class="t-left"><?php echo $engine->_t('EngineTyp');?></th>
					</tr>
<?php
				foreach ($results as $table)
				{
					foreach ($tables as $wtable)
					{
						if ($table['TABLE_NAME'] == $wtable['name'])
						{
							echo '<tr class="hl-setting">' .
									'<td class="label"><input type="checkbox" name="' . $table['TABLE_NAME'] . '" value="table" checked></td>' .
									'<td>  <strong>' . $table['TABLE_NAME'] . '  </strong></td>' .
									'<td>' . ($table['ENGINE'] == 'MyISAM' ? '<strong class="red">' : '' ) . $table['ENGINE'] . ($table['ENGINE'] == 'MyISAM' ? '</strong>' : '') . '</td>' .
								'</tr>' .
								'<tr class="lined"><td colspan="3"></td></tr>' . "\n";
						}
					}

				}
?>
				</table>
				<button type="submit" name="start-convert_tables" id="submit"><?php echo $engine->_t('Convert');?></button>
<?php
				echo $engine->form_close();
			}
			else
			{
				echo $engine->_t('NoTablesToConvert');
			}
		}

		?>
		<br><br><br>
		<br>
<?php
	}
	else if (@$_POST['action'] == 'convert_columns')
	{
	?>
		<p>
		<?php echo $engine->_t('ConvertTablesStrictInfo');?>
		</p>
		<br>
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

		echo '<br>';

		if ($results)
		{
			echo $engine->form_open('sql_mode_strict');
			?>
			<table style="max-width:500px; border-spacing: 1px; border-collapse: separate; padding: 4px;" class="formation">
				<tr>
					<th style="width:50px;"><?php echo $engine->_t('EngineTable');?></th>
					<th class="t-left"><?php echo $engine->_t('EngineColumn');?></th>
					<th class="t-left"><?php echo $engine->_t('EngineTyp');?></th>
					<th class="t-left"><?php echo $engine->_t('EngineDefault');?></th>
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
							echo '<tr class="hl-setting">' .
									'<td>  ' . $table['TABLE_NAME'] . '  </td>' .
									'<td class="label">  <strong>' . $table['COLUMN_NAME'] . '  </strong></td>' .
									'<td>  ' . $table['DATA_TYPE'] . '  </td>' .
									'<td>' . ($table['COLUMN_DEFAULT'] == '0000-00-00 00:00:00' ? '<strong class="red">' : '' ) . $table['COLUMN_DEFAULT'] . ($table['COLUMN_DEFAULT'] == '0000-00-00 00:00:00' ? '</strong>' : '') . '</td>' .
								'</tr>' .
								'<tr class="lined"><td colspan="4"></td></tr>' . "\n";

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

				echo '<button type="submit" name="start-convert_columns" id="submit">' . $engine->_t('Convert') . '</button>';
			}
			else
			{
				echo $engine->_t('NoColumnsToConvert');
			}

			echo $engine->form_close();
		}
		else
		{
			echo $engine->_t('NoColumnsToConvert');
		}
	}
	else
	{
	?>

		<h2><?php echo $engine->_t('ConvertTablesEngine');?></h2>
		<p>
		<?php echo $engine->_t('ConvertTablesEngineInfo');?>
		</p>
		<?php
		echo $engine->form_open('convert_tables');
		?>
			<input type="hidden" name="action" value="convert_tables">
			<button type="submit" name="start" id="submit"><?php echo $engine->_t('Convert');?></button>
		<?php
		echo $engine->form_close();?>


		<h2><?php echo $engine->_t('ConvertColumnsToStrict');?></h2>
		<p>
			<?php echo $engine->_t('ConvertTablesStrictInfo');?>
		</p>
		<?php
		echo $engine->form_open('convert_columns');
		?>
			<input type="hidden" name="action" value="convert_columns">
			<button type="submit" name="start" id="submit"><?php echo $engine->_t('Convert');?></button>
		<?php
		echo $engine->form_close();
	}
}

