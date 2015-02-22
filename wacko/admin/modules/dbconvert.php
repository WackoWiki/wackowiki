<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   DB Engine Convertion                             ##
########################################################

$module['dbconvert'] = array(
		'order'	=> 5,
		'cat'	=> 'Database',
		'mode'	=> 'dbconvert',
		'name'	=> 'Convert',
		'title'	=> 'Converting Tables from MyISAM to InnoDB',
		'vars'	=> array(&$tables),
);

########################################################

function admin_dbconvert(&$engine, &$module)
{
	// import passed variables and objects
	$tables	= & $module['vars'][0];

	$scheme		= '';
	$getstr		= '';
	$elements	= '';
	$sql		= '';

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
	if (isset($_POST['start']))
	{
		/* echo '<pre>';
		 print_r($_POST);
		 echo '</pre>'; */

		foreach ($_POST as $val => $key)
		{
			if ($key == 'table')
			{
				$sql = "ALTER TABLE {$val} ENGINE=INNODB";
				$engine->sql_query($sql);

				$sql_log[] = $sql;
			}
		}

		if ($sql)
		{
			$sql_log = implode(",\n", $sql_log);

			$engine->log(1, 'Convertion database');

			$message = 'Convertion of the selected tables successfully.';
			$engine->show_message($message);
?>
			<br />
			<div class="code" style="padding:3px;">
				<small><pre><?php echo $sql_log; ?></pre></small>
			</div><br />
<?php
		}
	}
	else
	{
?>
		<p>
			If you have existing tables, that you want to convert to InnoDB for better reliability and scalability, use the following routine. These tables were originally MyISAM, which was formerly the default.
		</p>
		<br />
<?php
		// Determine whether InnoDB plugin is installed in MySQL
		// https://dev.mysql.com/doc/refman/5.6/en/engines-table.html
		// https://dev.mysql.com/doc/refman/5.6/en/information-schema.html
		// If InnoDB is available, but not the default engine, the result will be YES. If it's not available, the result will obviously be NO.
		$_InnoDB_support = "SELECT SUPPORT FROM INFORMATION_SCHEMA.ENGINES WHERE ENGINE = 'InnoDB'";
		$InnoDB_support = $engine->load_all($_InnoDB_support);

		$_mysql_version =$engine->load_all("SELECT version()");
		$mysql_version = $_mysql_version[0]['version()'];
		$mysql_version = preg_replace('#[^0-9\.]#', '', $mysql_version);

		// Draws a tick or cross next to a result
		function output_image($ok)
		{
			global $engine;
			return '<img src="'.$engine->config['base_url'].'setup/images/'.($ok ? 'tick' : 'cross').'.png" width="20" height="20" alt="'.($ok ? 'OK' : 'Problem').'" title="'.($ok ? 'OK' : 'Problem').'" class="tickcross" />'.' ';
			#$output_image = '';
		}

		if (version_compare($mysql_version, '5.6.4', '>='))
		{
			$required_mysql_version = true;
			echo output_image(true).'Requires at least MySQL 5.6.4, available version: ' . $mysql_version . "<br />\n";
		}
		else
		{
			$required_mysql_version = false;
			echo output_image(false).'<strong class="red">Requires at least MySQL 5.6.4, available version: </strong> ' . $mysql_version . "<br />\n";
		}

/* 		echo '<pre>';
		print_r($results);
		echo '</pre>'; */

		if ($InnoDB_support[0]['SUPPORT'] == 'YES' || 'DEFAULT')
		{
			$required_engine = true;
			echo output_image(true).'InnoDB is available. '. $InnoDB_support[0]['SUPPORT']. "<br />\n";
		}
		else
		{
			$required_engine = false;
			echo output_image(false).'<strong class="red">InnoDB is not available.</strong>'. "<br />\n";
		}

		if ($required_mysql_version === true && $required_engine = true)
		{
			$results = $engine->load_all("SELECT TABLE_NAME, ENGINE FROM INFORMATION_SCHEMA.TABLES
											WHERE TABLE_SCHEMA = '{$engine->config['database_database']}'
											AND ENGINE = 'MyISAM'
											");

			echo '<br />';

			if ($results)
			{
?>
				<form action="admin.php" method="post" name="convert">
					<input type="hidden" name="mode" value="dbconvert" />
					<table style="max-width:250px; border-spacing: 1px; border-collapse: separate; padding: 4px;" class="formation">
						<tr>
							<th style="width:50px;" colspan="2"><a href="?mode=dbconvert<?php echo $getstr.( (isset($scheme['all']) && $scheme['all']) == 1 ? '&all=0' : '&all=1' ); ?>">Table</a></th>
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
									'<td class="label"><input name="'.$table['TABLE_NAME'].'" type="checkbox" value="table" checked="checked" /></td>'.
									'<td>&nbsp;&nbsp;<strong>'.$table['TABLE_NAME'].'&nbsp;&nbsp;</strong></td>'.
									'<td>'.( $table['ENGINE'] == 'MyISAM' ? '<strong class="red">' : '' ).$table['ENGINE'].( $table['ENGINE'] == 'MyISAM' ? '</strong>' : '' ).'</td>'.
								'</tr>'.
								'<tr class="lined"><td colspan="3"></td></tr>'."\n";
						}
					}

				}
?>
					</table>
					<input name="start" id="submit" type="submit" value="convert" />
				</form>
<?php
			}
			else
			{
				echo 'No tables to convert.';
			}
		}
	}
}

?>