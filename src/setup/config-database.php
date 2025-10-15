<script>
	<!--
		function check()
		{
			var f = document.forms.form1;

			// Ensure a database driver is selected
			var db_driver_selected = false;

			// If there is no value property then we have an array of possible database driver radio boxes
			if(f.elements["config[db_driver]"].value == undefined)
			{
				for (var i = 0; i < f.elements["config[db_driver]"].length; i++)
				{
					if(f.elements["config[db_driver]"][i].checked)
					{
						db_driver_selected = true;
						break;
					}
				}
			}
			else
			{
				// Else there is only one database driver radio box available, and it will already be selected
				db_driver_selected = true;
			}

			if(!db_driver_selected)
			{
				alert('<?php echo _t('ErrorNoDbDriverSelected');?>');
				db_driver_selected = false;
			}
			else if(f.elements["config[DeleteTables]"].checked)
			{
				if(!confirm('<?php echo _t('ConfirmTableDeletion');?>'))
				{
					db_driver_selected = false;
				}
			}

			return db_driver_selected;
		}
	// -->
</script>

<form action="<?php echo $base_path ?>?installAction=install-database" method="post" name="form1">
<?php
write_config_hidden_nodes($config_parameters);

echo '   <input type="hidden" name="password" value="' . ($_POST['password'] ?? '') . '">' . "\n";

// If none of the PHP SQL extensions are loaded then let the user know there is a problem
if (   !extension_loaded('mysqli')
	&& !extension_loaded('sqlite3')
	&& (!extension_loaded('pdo')
		|| (extension_loaded('pdo')
			&& (	!extension_loaded('pdo_mysql')
				&&	!extension_loaded('pdo_sqlite'))
			)
		)
	)
{
?>
	<p class="notop"><?php echo _t('ErrorNoDbDriverDetected'); ?></p>
<?php
}
else
{
?>
	<h2><?php echo _t('DbDriver');?></h2>
	<p class="notop"><?php echo _t('DbDriverDesc'); ?></p>
	<ul>
<?php
	/*
	 Each time a new database type is supported it needs to be added to this list

	 [0]   :  database PHP extension name
	 [1]   :  database driver name to be stored in the config file
	 [2]   :  the name to display in the list here
	 */

	if ($config['db_driver'] == 'mysqli_legacy')
	{
		$config['db_driver'] = 'mysqli';
	}

	$drivers	= [];

	if (!$config['is_update'])
	{
		$drivers[]	= ['mysqli',		'mysqli',		'MySQLi (' . _t('Recommended') . ')'];
		$drivers[]	= ['pdo_mysql',		'mysql_pdo',	'PDO MySQL'];
		$drivers[]	= ['pdo_sqlite',	'sqlite_pdo',	'PDO SQLite'];
		$drivers[]	= ['sqlite',		'sqlite',		'SQLite'];
		// $drivers[]	= ['pdo',		'pgsql',		'PDO PostgreSQL'];
	}
	else
	{
		// Can't switch between SQLite and MariaDB / MySQL during upgrade routine!
		if ($config['sqlite'])
		{
			$drivers[]	= ['pdo_sqlite',	'sqlite_pdo',	'PDO SQLite'];
			$drivers[]	= ['sqlite',		'sqlite',		'SQLite'];
		}
		else
		{
			$drivers[]	= ['mysqli',		'mysqli',		'MySQLi (' . _t('Recommended') . ')'];
			$drivers[]	= ['pdo_mysql',		'mysql_pdo',	'PDO MySQL'];
		}
	}

	foreach ($drivers as $k => $driver)
	{
		if (extension_loaded($driver[0]) || ($driver[0] == 'sqlite' && class_exists('SQLite3')))
		{
			echo '<li>
						<input type="radio" id="db_driver_' . $driver[0] . '" name="config[db_driver]" value="' . $driver[1] . '" ' .
							($config['db_driver']
								? ($config['db_driver'] == $driver[1]		? 'checked' : '')
								: ($k == 0									? 'checked' : '')
							) .
							" onClick=\"this.form.action='?installAction=config-database'; submit(); \"" .
						'>
						<label for="db_driver_' . $driver[0] . '">' . $driver[2] . "</label>
					</li>\n";
		}
	}
?>
	</ul>
	<br>
<?php
if (!in_array($config['db_driver'], ['sqlite', 'sqlite_pdo']))
{
	echo $separator; ?>
	<label class="label_top" for="sql_mode"><?php echo _t('DbSqlMode');?></label>
	<p class="notop"><?php echo _t('DbSqlModeDesc'); ?></p>

<?php
	/*
	 SQL modes

	 [0]   :  SQL mode
	 [1]   :  SQL mode to be stored in the config file
	 [2]   :  the name to display in the list here
	 */

	$sql_modes		= [];
	$sql_modes[]	= ['server',			'0',	'Server'];			// default
	$sql_modes[]	= ['session lax',		'1',	'Session Lax'];
	$sql_modes[]	= ['session strict',	'2',	'Session Strict'];

	echo '	<select id="sql_mode" name="config[sql_mode]" required>';

	foreach ($sql_modes as $sql_mode)
	{
		echo '<option value="' . $sql_mode[1] . '" ' . ($config['sql_mode'] == $sql_mode[1] ? 'selected' : '') . '>' . $sql_mode[2] . "</option>\n";
	}

	echo "</select>\n";
?>
	<br>
<?php
	if ($config['debug'] >= 3)
	{
		echo $separator; ?>
		<label class="label_top" for="db_vendor"><?php echo _t('DbVendor');?></label>
		<p class="notop"><?php echo _t('DbVendorDesc'); ?></p>

	<?php
		/*
		 Each time a new database vendor is supported it needs to be added to this list

		 [0]   :  database vendor name
		 [1]   :  database vendor name to be stored in the config file
		 [2]   :  the name to display in the list here
		 */

		$vendors	= [];
		$vendors[]	= ['mariadb',	'mariadb',	'MariaDB'];	// default
		$vendors[]	= ['mysql',		'mysql',	'MySQL'];

		echo '	<select id="db_vendor" name="config[db_vendor]" required>';

		foreach ($vendors as $vendor)
		{
			echo '<option value="' . $vendor[1] . '" ' . ($config['db_vendor'] == $vendor[1] ? 'selected' : '') . '>' . $vendor[2] . "</option>\n";
		}

		echo "</select>\n";
	}
?>
	<br>
<?php echo $separator; ?>
	<label class="label_top" for="db_charset"><?php echo _t('DbCharset');?></label>
	<p class="notop"><?php echo _t('DbCharsetDesc'); ?></p>

<?php
	/*
	 Each time a new database charset is supported it needs to be added to this list
	 https://dev.mysql.com/doc/refman/8.0/en/charset-charsets.html

	 [0]   :  database charset name
	 [1]   :  database charset name to be stored in the config file
	 [2]   :  the name to display in the list here
	 */

	$charsets	= [];
	$charsets[]	= ['utf8mb4',	'utf8mb4',	'utf8mb4 (' . _t('Recommended') . ')'];	// default

	echo '	<select id="db_charset" name="config[db_charset]" required>';

	foreach ($charsets as $charset)
	{
		echo '<option value="' . $charset[1] . '" ' . ($config['db_charset'] == $charset[1] ? 'selected' : '') . '>' . $charset[2] . "</option>\n";
	}

	echo "</select>\n";
?>
	<br>
<?php
}
	if (!$config['is_update'])
	{
		if (!in_array($config['db_driver'], ['sqlite', 'sqlite_pdo']))
		{
			echo $separator;
			?>
			<h2><?php echo _t('DbEngine');?></h2>
			<p class="notop"><?php echo _t('DbEngineDesc'); ?></p>
			<ul>
			<?php
			/*
			 Each time a new database engine is supported it needs to be added to this list

			 [0]   :  database engine name
			 [1]   :  database engine name to be stored in the config file
			 [2]   :  the name to display in the list here
			 */

			$engines	= [];
			$engines[]	= ['mysql_innodb', 'InnoDB', 'InnoDB (' . _t('Recommended') . ')'];	// default

			foreach ($engines as $k => $engine)
			{
				echo '<li>
							<input type="radio" id="db_engine_' . $engine[0] . '" name="config[db_engine]" value="' . $engine[1] . '" ' . ($k == 0 ? 'checked' : '') . '>
							<label for="db_engine_' . $engine[0] . '">' . $engine[2] . "</label>
						</li>\n";
			}
			?>
			</ul>
			<br>

			<?php echo $separator; ?>
			<label class="label_top" for="db_host"><?php echo _t('DbHost');?></label>
			<p class="notop"><?php echo _t('DbHostDesc'); ?></p>
			<input type="text" maxlength="1000" id="db_host" name="config[db_host]" value="<?php echo $config['db_host'] ?>" placeholder="localhost" class="text_input" required>
			<br>
			<?php echo $separator; ?>
			<label class="label_top" for="db_port"><?php echo _t('DbPort');?></label>
			<p class="notop"><?php echo _t('DbPortDesc'); ?></p>
			<input type="number" maxlength="10" id="db_port" name="config[db_port]" value="<?php echo $config['db_port'] ?>" class="text_input">
			<br>
			<?php echo $separator;
		}
?>
		<label class="label_top" for="db_name"><?php echo _t('DbName');?></label>
		<?php
		if (!in_array($config['db_driver'], ['sqlite', 'sqlite_pdo']))
		{
			?>
			<p class="notop"><?php echo _t('DbNameDesc'); ?></p>
			<?php
		}
		else
		{
			?>
			<p class="notop"><?php echo _t('DbNameSqliteDesc'); ?></p>
			<p class="msg notice"><?php echo _t('DbNameSqliteHelp'); ?></p>
			<?php
		}
		?>
		<input type="text" maxlength="64" id="db_name" name="config[db_name]" value="<?php echo $config['db_name'] ?>" class="text_input" required>
		<br>
		<?php echo $separator; ?>
		<?php
		if (in_array($config['db_driver'], ['sqlite', 'sqlite_pdo']))
		{
			?>
			<input type="hidden" name="config[table_prefix]" value="0">
			<?php
		}
		else
		{
			?>
			<label class="label_top" for="db_user"><?php echo _t('DbUser');?></label>
			<p class="notop"><?php echo _t('DbUserDesc'); ?></p>
			<input type="text" maxlength="50" id="db_user" name="config[db_user]" value="<?php echo $config['db_user'] ?>" class="text_input" required>
			<br>
			<?php echo $separator; ?>
			<label class="label_top" for="db_password"><?php echo _t('DbPassword');?></label>
			<p class="notop"><?php echo _t('DbPasswordDesc'); ?></p>
			<input type="password" maxlength="50" id="db_password" name="config[db_password]" autocomplete="off" value="<?php echo $config['db_password'] ?>" class="text_input">
			<br>
			<?php echo $separator; ?>
			<label class="label_top" for="table_prefix"><?php echo _t('Prefix');?></label>
			<p class="notop"><?php echo _t('PrefixDesc'); ?></p>
			<input type="text" maxlength="64" id="table_prefix" name="config[table_prefix]" value="<?php echo $config['table_prefix'] ?>" pattern="[\p{L}\p{Nd}\_]+" class="text_input">
			<br>
			<?php echo $separator;
		}
	}

	if (!$config['is_update'])
	{?>
		<h2><?php echo _t('DeleteTables');?></h2>
		<p class="notop"><?php echo _t('DeleteTablesDesc'); ?></p>
		<label class="indented_label" for="wiki_delete_tables"><?php echo _t('DeleteTables');?></label>
		<input type="checkbox" id="wiki_delete_tables" name="config[DeleteTables]" <?php echo isset($config['DeleteTables']) ? ' checked' : ''; ?> class="checkbox_input">
		<br>
		<?php echo $separator;
	}
	else
	{
		echo '<input type="hidden" value="off" name="config[DeleteTables]">';
	}
?>
	<button type="submit" class="next" onclick="return check();"><?php echo _t('Continue');?></button>
<?php
}
?>
</form>
