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
<form action="<?php echo myLocation() ?>?installAction=database-install" method="post" name="form1">
<?php
   writeConfigHiddenNodes(array('database_driver' => '', 'database_host' => '', 'database_port' => '', 'database_database' => '', 'database_user' => '', 'database_password' => '', 'table_prefix' => ''));
   echo '   <input type="hidden" name="password" value="'.$_POST['password'].'" />' . "\n";

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

$drivers = array();
$drivers[] = array('mysql', 'mysql_legacy', 'MySQL');
$drivers[] = array('mysqli', 'mysqli_legacy', 'MySQLi');
$drivers[] = array('pdo', 'mysql_pdo', 'PDO MySQL');
// $drivers[] = array('pdo', 'mssql', 'PDO MS SQL');
// $drivers[] = array('pdo', 'pgsql', 'PDO PostgreSQL');
// $drivers[] = array('pdo', 'sqlite', 'PDO SQLite');
// $drivers[] = array('pdo', 'sqlite2', 'PDO SQLite2');
// $drivers[] = array('pdo', 'oci', 'PDO Oracle');

$detected = 0;
for($count = 0; $count < count($drivers); $count++)
{
	if(extension_loaded($drivers[$count][0]))
	{
		echo "      <li><input type=\"radio\" id=\"db_driver_".$drivers[$count][0]."\" name=\"config[database_driver]\" value=\"".$drivers[$count][1]."\"".($detected == 0 ? "checked=\"checked\"" : "")."><label for=\"db_driver_".$drivers[$count][0]."\">".$drivers[$count][2]."</label></li>\n";
		$detected++;
	}
}
?>
   </ul>
   <br />
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
   <h2><?php echo $lang['DeleteTables'];?></h2>
   <p class="notop"><?php echo $lang['DeleteTablesDesc']; ?></p>
   <label class="indented_label" for="wiki_delete_tables"><?php echo $lang['DeleteTables'];?></label>
   <input type="checkbox" id="wiki_delete_tables" name="config[DeleteTables]" <?php echo isset($config['DeleteTables']) ? "checked=\"checked\"" : "" ?> class="checkbox_input" />
   <br />
   <div class="fake_hr_seperator">
      <hr />
   </div>
   <input type="submit" value="<?php echo $lang['Continue'];?>" class="next" onclick="return check();" />
<?php
	}
?>
</form>