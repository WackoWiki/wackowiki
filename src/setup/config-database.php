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
				alert('<?php echo $lang['ErrorNoDbDriverSelected'];?>');
				db_driver_selected = false;
			}
			else if(f.elements["config[DeleteTables]"].checked)
			{
				if(!confirm('<?php echo $lang['ConfirmTableDeletion'];?>'))
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
if (!extension_loaded('mysqli') && !extension_loaded('pdo'))
{
?>
	<p class="notop"><?php echo $lang['ErrorNoDbDriverDetected']; ?></p>
<?php
}
else
{
?>
	<h2><?php echo $lang['DbDriver'];?></h2>
	<p class="notop"><?php echo $lang['DbDriverDesc']; ?></p>
	<ul>
<?php
/*
 Each time a new database type is supported it needs to be added to this list

 [0]   :  database PHP extension name
 [1]   :  database driver name to be stored in the config file
 [2]   :  the name to display in the list here
 */

$drivers	= [];
$drivers[]	= ['mysqli',	'mysqli_legacy',	'MySQLi (' . $lang['Recommended'] . ')'];
$drivers[]	= ['pdo',		'mysql_pdo',		'PDO MySQL'];
// $drivers[]	= ['pdo',		'pgsql',		'PDO PostgreSQL'];
// $drivers[]	= ['pdo',		'sqlite3',		'PDO SQLite3'];

foreach ($drivers as $k => $driver)
{
	if (extension_loaded($driver[0]))
	{
		echo '<li>
					<input type="radio" id="db_driver_' . $driver[0] . '" name="config[db_driver]" value="' . $driver[1] . '" ' .
						($config['is_update']
							? ($config['db_driver'] == $driver[1]		? 'checked' : '')
							: ($k == 0										? 'checked' : '')
						) . '>
					<label for="db_driver_' . $driver[0] . '">' . $driver[2] . "</label>
				</li>\n";
	}
}
?>
	</ul>
	<br>
<?php echo $separator; ?>
	<label class="label_top" for="db_charset"><?php echo $lang['DbCharset'];?></label>
	<p class="notop"><?php echo $lang['DbCharsetDesc']; ?></p>

<?php
/*
 Each time a new database charset is supported it needs to be added to this list
 https://dev.mysql.com/doc/refman/5.7/en/charset-charsets.html

 [0]   :  database charset name
 [1]   :  database charset name to be stored in the config file
 [2]   :  the name to display in the list here
 */

$charsets	= [];
$charsets[]	= ['utf8mb4',	'utf8mb4',	'utf8mb4 (' . $lang['Recommended'] . ')'];	// default

echo '	<select id="db_charset" name="config[db_charset]" required>';

foreach ($charsets as $charset)
{
	echo '<option value="' . $charset[1] . '" ' . ($config['db_charset'] == $charset[1] ? 'selected' : '') . '>' . $charset[2] . "</option>\n";
}

echo "</select>\n";
?>
	<br>
<?php
if (!$config['is_update'])
{
	echo $separator;
	?>
	<h2><?php echo $lang['DbEngine'];?></h2>
	<p class="notop"><?php echo $lang['DbEngineDesc']; ?></p>
	<ul>
	<?php
	/*
	 Each time a new database engine is supported it needs to be added to this list

	 [0]   :  database engine name
	 [1]   :  database engine name to be stored in the config file
	 [2]   :  the name to display in the list here
	 */

	$engines	= [];
	$engines[]	= ['mysql_innodb', 'InnoDB', 'InnoDB (' . $lang['Recommended'] . ')'];	// default

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
	<label class="label_top" for="db_host"><?php echo $lang['DbHost'];?></label>
	<p class="notop"><?php echo $lang['DbHostDesc']; ?></p>
	<input type="text" maxlength="1000" id="db_host" name="config[db_host]" value="<?php echo $config['db_host'] ?>" placeholder="localhost" class="text_input" required>
	<br>
	<?php echo $separator; ?>
	<label class="label_top" for="db_port"><?php echo $lang['DbPort'];?></label>
	<p class="notop"><?php echo $lang['DbPortDesc']; ?></p>
	<input type="number" maxlength="10" id="db_port" name="config[db_port]" value="<?php echo $config['db_port'] ?>" class="text_input">
	<br>
	<?php echo $separator; ?>
	<label class="label_top" for="db_name"><?php echo $lang['DbName'];?></label>
	<p class="notop"><?php echo $lang['DbNameDesc']; ?></p>
	<input type="text" maxlength="64" id="db_name" name="config[db_name]" value="<?php echo $config['db_name'] ?>" class="text_input" required>
	<br>
	<?php echo $separator; ?>
	<label class="label_top" for="db_user"><?php echo $lang['DbUser'];?></label>
	<p class="notop"><?php echo $lang['DbUserDesc']; ?></p>
	<input type="text" maxlength="50" id="db_user" name="config[db_user]" value="<?php echo $config['db_user'] ?>" class="text_input" required>
	<br>
	<?php echo $separator; ?>
	<label class="label_top" for="db_password"><?php echo $lang['DbPassword'];?></label>
	<p class="notop"><?php echo $lang['DbPasswordDesc']; ?></p>
	<input type="password" maxlength="50" id="db_password" name="config[db_password]" autocomplete="off" value="<?php echo $config['db_password'] ?>" class="text_input">
	<br>
	<?php echo $separator; ?>
	<label class="label_top" for="table_prefix"><?php echo $lang['Prefix'];?></label>
	<p class="notop"><?php echo $lang['PrefixDesc']; ?></p>
	<input type="text" maxlength="64" id="table_prefix" name="config[table_prefix]" value="<?php echo $config['table_prefix'] ?>" pattern="[\p{L}\p{Nd}\_]+" class="text_input">
	<br>
	<?php echo $separator;
}

if (!$config['is_update'])
{?>
	<h2><?php echo $lang['DeleteTables'];?></h2>
	<p class="notop"><?php echo $lang['DeleteTablesDesc']; ?></p>
	<label class="indented_label" for="wiki_delete_tables"><?php echo $lang['DeleteTables'];?></label>
	<input type="checkbox" id="wiki_delete_tables" name="config[DeleteTables]" <?php echo isset($config['DeleteTables']) ? ' checked' : ''; ?> class="checkbox_input">
	<br>
	<?php echo $separator;
}
else
{
	echo '<input type="hidden" value="off" name="config[DeleteTables]">';
}
?>
	<button type="submit" class="next" onclick="return check();"><?php echo $lang['Continue'];?></button>
<?php
	}
?>
</form>
