<script type="text/javascript">
	<!--
		function check()
		{
			var f = document.forms.form1;
			var re = new RegExp("^[A-Z][a-z]+[A-Z0-9][A-Za-z0-9]*$");

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

write_config_hidden_nodes(array(
	'database_charset' => '',
	'database_driver' => '',
	'database_engine' => '',
	'database_host' => '',
	'database_port' => '',
	'database_database' => '',
	'database_user' => '',
	'database_password' => '',
	'table_prefix' => '')
);

echo '   <input type="hidden" name="password" value="'.(isset($_POST['password']) ? $_POST['password'] : '').'" />' . "\n";

	// If none of the PHP SQL extensions are loaded then let the user know there is a problem
	if(!extension_loaded('mysql') && !extension_loaded('mysqli') && !extension_loaded('pdo'))
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

$drivers	= array();
$drivers[]	= array('mysqli',	'mysqli_legacy',	'MySQLi ('.$lang['Recommended'].')');
$drivers[]	= array('pdo',		'mysql_pdo',		'PDO MySQL');
// $drivers[]	= array('pdo',		'pgsql',		'PDO PostgreSQL');
// $drivers[]	= array('pdo',		'sqlite2',		'PDO SQLite2');

$detected = 0;

for($count = 0; $count < count($drivers); $count++)
{
	if(extension_loaded($drivers[$count][0]))
	{
		if ($config['is_update'] == false)
		{
			echo "      <li><input type=\"radio\" id=\"db_driver_".$drivers[$count][0]."\" name=\"config[database_driver]\" value=\"".$drivers[$count][1]."\" ".($detected == 0 ? "checked=\"checked\"" : "")."><label for=\"db_driver_".$drivers[$count][0]."\">".$drivers[$count][2]."</label></li>\n";
		}
		else
		{
			echo "      <li><input type=\"radio\" id=\"db_driver_".$drivers[$count][0]."\" name=\"config[database_driver]\" value=\"".$drivers[$count][1]."\" ".($config['database_driver'] == $drivers[$count][1] ? "checked=\"checked\"" : "")."><label for=\"db_driver_".$drivers[$count][0]."\">".$drivers[$count][2]."</label></li>\n";
		}

		$detected++;
	}
}
?>
   </ul>
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <h2><?php echo $lang['DBCharset'];?></h2>
   <p class="notop"><?php echo $lang['DBCharsetDesc']; ?></p>
   <ul>
<?php
/*
 Each time a new database charset is supported it needs to be added to this list
 https://dev.mysql.com/doc/refman/5.6/en/charset-charsets.html

 [0]   :  database charset name
 [1]   :  database charset name to be stored in the config file
 [2]   :  the name to display in the list here
 */

$charset	= array();
# $charset[]	= array('utf8', 'utf8', 'UTF-8 Unicode ('.$lang['Recommended'].')'); // requires unicode ready wiki engine! -> Version 5.5
$charset[]	= array('cp1251', 'cp1251', 'Windows Cyrillic');
$charset[]	= array('latin1', 'latin1', 'cp1252 West European');
$charset[]	= array('latin2', 'latin2', 'ISO 8859-2 Central European'); // not tested
$charset[]	= array('greek', 'greek', 'ISO 8859-7 Greek'); // not tested


$detected = 0;

echo '    <select id="config[database_charset]" name="config[database_charset]">';

for($count = 0; $count < count($charset); $count++)
{
	echo "      <li><option value=\"".$charset[$count][1]."\" ".($config['database_charset'] == $charset[$count][1] ? "selected=\"selected\"" : "").">".$charset[$count][2]."</option></li>\n";
	$detected++;
}

echo "    </select>\n";
?>
   </ul>
   <br />
   <?php
if ($config['is_update'] == false)
{?>
   <div class="fake_hr_seperator">
      <hr />
   </div>
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

$engines	= array();
$engines[]	= array('mysql_myisam', 'MyISAM', 'MyISAM');
$engines[]	= array('mysql_innodb', 'InnoDB', 'InnoDB ('.$lang['Recommended'].')');

$detected = 0;

for($count = 0; $count < count($engines); $count++)
{
	echo "      <li><input type=\"radio\" id=\"db_engine_".$engines[$count][0]."\" name=\"config[database_engine]\" value=\"".$engines[$count][1]."\" ".($detected == 0 ? "checked=\"checked\"" : "")."><label for=\"db_engine_".$engines[$count][0]."\">".$engines[$count][2]."</label></li>\n";
	$detected++;
}
?>
   </ul>
   <br />
   <?php
}
else
{
	echo '<input type="hidden" value="'.$config['database_engine'].'" name="config[database_engine]">';
}
?>
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <h2><?php echo $lang['DBHost'];?></h2>
   <p class="notop"><?php echo $lang['DBHostDesc']; ?></p>
   <input type="text" maxlength="1000" name="config[database_host]" value="<?php echo $config['database_host'] ?>" class="text_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <h2><?php echo $lang['DBPort'];?></h2>
   <p class="notop"><?php echo $lang['DBPortDesc']; ?></p>
   <input type="text" maxlength="10" name="config[database_port]" value="<?php echo $config['database_port'] ?>" class="text_input" style="width: 100px;" /> <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <h2><?php echo $lang['DB'];?></h2>
   <p class="notop"><?php echo $lang['DBDesc']; ?></p>
   <input type="text" maxlength="64" name="config[database_database]" value="<?php echo $config['database_database'] ?>" class="text_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <h2><?php echo $lang['DBUser'];?></h2>
   <p class="notop"><?php echo $lang['DBUserDesc']; ?></p>
   <input type="text" maxlength="50" name="config[database_user]" value="<?php echo $config['database_user'] ?>" class="text_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <h2><?php echo $lang['DBPassword'];?></h2>
   <p class="notop"><?php echo $lang['DBPasswordDesc']; ?></p>
   <input type="password" maxlength="50" name="config[database_password]" value="<?php echo $config['database_password'] ?>" class="text_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <h2><?php echo $lang['Prefix'];?></h2>
   <p class="notop"><?php echo $lang['PrefixDesc']; ?></p>
   <input type="text" maxlength="64" name="config[table_prefix]" value="<?php echo $config['table_prefix'] ?>" class="text_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
<?php
if ($config['is_update'] == false)
{?>
   <h2><?php echo $lang['DeleteTables'];?></h2>
   <p class="notop"><?php echo $lang['DeleteTablesDesc']; ?></p>
   <label class="indented_label" for="wiki_delete_tables"><?php echo $lang['DeleteTables'];?></label>
   <input type="checkbox" id="wiki_delete_tables" name="config[DeleteTables]" <?php echo isset($config['DeleteTables']) ? "checked=\"checked\"" : "" ?> class="checkbox_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
<?php
}
else
{
	echo '<input type="hidden" value="off" name="config[DeleteTables]">';
}
?>
   <input type="submit" value="<?php echo $lang['Continue'];?>" class="next" onclick="return check();" />
<?php
	}
?>
</form>