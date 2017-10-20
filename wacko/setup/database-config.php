<script>
	<!--
		function check()
		{
			var f = document.forms.form1;

			// Ensure a database driver is selected
			var db_driver_selected = false;

			// If there is no value property then we have an array of possible database driver radio boxes
			if(f.elements["config[database_driver]"].value == undefined)
			{
				for (var i = 0; i < f.elements["config[database_driver]"].length; i++)
				{
					if(f.elements["config[database_driver]"][i].checked)
					{
						db_driver_selected = true;
						break;
					}
				}
			}
			else
			{
				// Else there is only one database driver radio box available and it will already be selected
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

<form action="<?php echo my_location() ?>?installAction=database-install" method="post" name="form1">
<?php

write_config_hidden_nodes([
	'database_charset'	=> '',
	'database_driver'	=> '',
	'database_engine'	=> '',
	'database_host'		=> '',
	'database_port'		=> '',
	'database_database'	=> '',
	'database_user'		=> '',
	'database_password'	=> '',
	'table_prefix'		=> '']
);

echo '   <input type="hidden" name="password" value="' . (isset($_POST['password']) ? $_POST['password'] : '') . '" />' . "\n";

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
	<h2><?php echo $lang['DBDriver'];?></h2>
	<p class="notop"><?php echo $lang['DBDriverDesc']; ?></p>
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

$detected = 0;

for ($count = 0; $count < count($drivers); $count++)
{
	if (extension_loaded($drivers[$count][0]))
	{
		if ($config['is_update'] == false)
		{
			echo '      <li>
							<input type="radio" id="db_driver_' . $drivers[$count][0] . '" name="config[database_driver]" value="' . $drivers[$count][1] . '" '.($detected == 0 ? 'checked' : '') . '>
							<label for="db_driver_' . $drivers[$count][0] . '">' . $drivers[$count][2] . "</label>
						</li>\n";
		}
		else
		{
			echo '      <li>
							<input type="radio" id="db_driver_' . $drivers[$count][0] . '" name="config[database_driver]" value="' . $drivers[$count][1] . '" '.($config['database_driver'] == $drivers[$count][1] ? 'checked' : '') . '>
							<label for="db_driver_' . $drivers[$count][0] . '">' . $drivers[$count][2] . "</label>
						</li>\n";
		}

		$detected++;
	}
}
?>
	</ul>
	<br />
<?php echo $seperator; ?>
	<label class="label_top" for="database_charset"><?php echo $lang['DBCharset'];?></label>
	<p class="notop"><?php echo $lang['DBCharsetDesc']; ?></p>

<?php
/*
 Each time a new database charset is supported it needs to be added to this list
 https://dev.mysql.com/doc/refman/5.6/en/charset-charsets.html

 [0]   :  database charset name
 [1]   :  database charset name to be stored in the config file
 [2]   :  the name to display in the list here
 */

$charset	= [];
# $charset[]	= ['utf8', 'utf8', 'UTF-8 Unicode (' . $lang['Recommended'] . ')']; // requires unicode ready wiki engine! -> Version 7.0
$charset[]	= ['cp1251',	'cp1251',	'cp1251 Windows Cyrillic'];
$charset[]	= ['latin1',	'latin1',	'cp1252 West European'];
$charset[]	= ['latin2',	'latin2',	'ISO 8859-2 Central European']; // not tested
$charset[]	= ['greek',		'greek',	'ISO 8859-7 Greek']; // not tested


$detected = 0;

echo '	<select id="database_charset" name="config[database_charset]" required>';

// set default database charset to cp1251 Windows Cyrillic for Russian
if ($config['is_update'] == false && $config['language'] == 'ru')
{
	$config['database_charset'] = 'cp1251';
}

for ($count = 0; $count < count($charset); $count++)
{
	echo '		<option value="' . $charset[$count][1] . '" '.($config['database_charset'] == $charset[$count][1] ? 'selected' : '') . '>' . $charset[$count][2] . "</option>\n";
	$detected++;
}

echo "	</select>\n";
?>
	<br />
<?php
if ($config['is_update'] == false)
{?>
<?php echo $seperator; ?>
	<h2><?php echo $lang['DBEngine'];?></h2>
	<p class="notop"><?php echo $lang['DBEngineDesc']; ?></p>
	<ul>
<?php
/*
 Each time a new database engine is supported it needs to be added to this list

 [0]   :  database engine name
 [1]   :  database engine name to be stored in the config file
 [2]   :  the name to display in the list here
 */

$engines	= [];
$engines[]	= ['mysql_innodb', 'InnoDB', 'InnoDB / XtraDB (' . $lang['Recommended'] . ')'];
$engines[]	= ['mysql_myisam', 'MyISAM', 'MyISAM'];

$detected = 0;

for ($count = 0; $count < count($engines); $count++)
{
	echo '      <li>
					<input type="radio" id="db_engine_' . $engines[$count][0] . '" name="config[database_engine]" value="' . $engines[$count][1] . '" '.($detected == 0 ? 'checked' : '') . '>
					<label for="db_engine_' . $engines[$count][0] . '">' . $engines[$count][2] . "</label>
				</li>\n";
	$detected++;
}
?>
	</ul>
	<br />
<?php
}
else
{
	echo '<input type="hidden" value="' . $config['database_engine'] . '" name="config[database_engine]">';
}
?>
<?php echo $seperator; ?>
	<label class="label_top" for="database_host"><?php echo $lang['DBHost'];?></label>
	<p class="notop"><?php echo $lang['DBHostDesc']; ?></p>
	<input type="text" maxlength="1000" id="database_host" name="config[database_host]" value="<?php echo $config['database_host'] ?>" placeholder="localhost" class="text_input" required/>
	<br />
<?php echo $seperator; ?>
	<label class="label_top" for="database_port"><?php echo $lang['DBPort'];?></label>
	<p class="notop"><?php echo $lang['DBPortDesc']; ?></p>
	<input type="number" maxlength="10" id="database_port" name="config[database_port]" value="<?php echo $config['database_port'] ?>" class="text_input"/> <br />
<?php echo $seperator; ?>
	<label class="label_top" for="database_database"><?php echo $lang['DB'];?></label>
	<p class="notop"><?php echo $lang['DBDesc']; ?></p>
	<input type="text" maxlength="64" id="database_database" name="config[database_database]" value="<?php echo $config['database_database'] ?>" class="text_input" required/>
	<br />
<?php echo $seperator; ?>
	<label class="label_top" for="database_user"><?php echo $lang['DBUser'];?></label>
	<p class="notop"><?php echo $lang['DBUserDesc']; ?></p>
	<input type="text" maxlength="50" id="database_user" name="config[database_user]" value="<?php echo $config['database_user'] ?>" class="text_input" required/>
	<br />
<?php echo $seperator; ?>
	<label class="label_top" for="database_password"><?php echo $lang['DBPassword'];?></label>
	<p class="notop"><?php echo $lang['DBPasswordDesc']; ?></p>
	<input type="password" maxlength="50" id="database_password" name="config[database_password]" autocomplete="off" value="<?php echo $config['database_password'] ?>" class="text_input" />
	<br />
<?php echo $seperator; ?>
	<label class="label_top" for="table_prefix"><?php echo $lang['Prefix'];?></label>
	<p class="notop"><?php echo $lang['PrefixDesc']; ?></p>
	<input type="text" maxlength="64" id="table_prefix" name="config[table_prefix]" value="<?php echo $config['table_prefix'] ?>" class="text_input"/>
	<br />
<?php echo $seperator; ?>
<?php
if ($config['is_update'] == false)
{?>
	<h2><?php echo $lang['DeleteTables'];?></h2>
	<p class="notop"><?php echo $lang['DeleteTablesDesc']; ?></p>
	<label class="indented_label" for="wiki_delete_tables"><?php echo $lang['DeleteTables'];?></label>
	<input type="checkbox" id="wiki_delete_tables" name="config[DeleteTables]" <?php echo isset($config['DeleteTables']) ? ' checked' : ''; ?> class="checkbox_input"/>
	<br />
<?php echo $seperator; ?>
<?php
}
else
{
	echo '<input type="hidden" value="off" name="config[DeleteTables]">';
}
?>
	<input type="submit" value="<?php echo $lang['Continue'];?>" class="next" onclick="return check();"/>
<?php
	}
?>
</form>