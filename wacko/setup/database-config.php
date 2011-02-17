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
                           alert('<?php echo $lang["ErrorNoDbDriverSelected"];?>');
                           db_driver_selected = false;
                        }

                     return db_driver_selected;
                  }
            // -->
         </script>
         <form action="<?php echo myLocation() ?>?installAction=database-install" method="post" name="form1">
            <input type="hidden" name="config[wakka_name]" value="<?php echo $config["wakka_name"];?>" />
            <input type="hidden" name="config[root_page]" value="<?php echo $config["root_page"];?>" />
            <input type="hidden" name="config[language]" value="<?php echo $config["language"];?>" />
            <input type="hidden" name="config[multilanguage]" value="<?php echo $config["multilanguage"] == 'on' ? 1 : $config["multilanguage"]; ?>" />
            <input type="hidden" name="config[admin_name]" value="<?php echo $config["admin_name"];?>" />
            <input type="hidden" name="password" value="<?php echo $_POST["password"];?>" />
            <input type="hidden" name="config[admin_email]" value="<?php echo $config["admin_email"];?>" />
            <input type="hidden" name="config[base_url]" value="<?php echo $config["base_url"];?>" />
            <input type="hidden" name="config[rewrite_mode]" value="<?php echo $config["rewrite_mode"] == 'on' ? 1 : $config["rewrite_mode"]; ?>" />
            <input type="hidden" name="config[cache]" value="<?php echo $config["cache"];?>" />
<?php
   // If none of the PHP SQL extensions are loaded then let the user know there is a problem
   if(!extension_loaded("mysql") && !extension_loaded("mysqli") && !extension_loaded("pdo"))
      {
?>
            <p class="notop"><?php print $lang["ErrorNoDbDriverDetected"]; ?></p>
<?php
      }
   else
      {
		// is this an upgrade?
		if (isset($wakkaConfig["wakka_version"]))
		{
			// overwrite default value, default is PDO but no upgrade is supported with PDO
			$wakkaConfig['database_driver'] = 'mysqli_legacy';

			// upgrade: assign old to new config names (overwrite default values)
			if (isset($wakkaConfig['mysql_host']))		$wakkaConfig['database_host']		= $wakkaConfig['mysql_host'];
			if (isset($wakkaConfig['mysql_database']))	$wakkaConfig['database_database']	= $wakkaConfig['mysql_database'];
			if (isset($wakkaConfig['mysql_user']))		$wakkaConfig['database_user']		= $wakkaConfig['mysql_user'];
			if (isset($wakkaConfig['mysql_password']))	$wakkaConfig['database_password']	= $wakkaConfig['mysql_password'];
		}
?>
            <h2><?php echo $lang["DBDriver"];?></h2>
            <p class="notop"><?php print $lang["DBDriverDesc"]; ?></p>
            <ul>
<?php
         /*
            Each time a new database type is supported it needs to be added to this list

            [0]   :  database PHP extension name
            [1]   :  database driver name to be stored in the config file
            [2]   :  the name to display in the list here
         */

         $drivers = array();
         $drivers[] = array("mysql", "mysql_legacy", "MySQL");
         $drivers[] = array("mysqli", "mysqli_legacy", "MySQLi");

         // no upgrade is supported for PDO
         if (!isset($wakkaConfig["wakka_version"]))
         {
         	$drivers[] = array("pdo", "mysql", "PDO MySQL");
         }
         // $drivers[] = array("pdo", "mssql", "PDO MS SQL");
         // $drivers[] = array("pdo", "pgsql", "PDO PostgreSQL");
         // $drivers[] = array("pdo", "sqlite", "PDO SQLite");
         // $drivers[] = array("pdo", "sqlite2", "PDO SQLite2");

         $detected = 0;

         for($count = 0; $count < count($drivers); $count++)
            {
               if(extension_loaded($drivers[$count][0]))
                  {
                     echo "               <li><input type=\"radio\" id=\"db_driver_".$drivers[$count][0]."\" name=\"config[database_driver]\" value=\"".$drivers[$count][1]."\"".($detected == 0 ? "checked=\"checked\"" : "")."><label for=\"db_driver_".$drivers[$count][1]."\">".$drivers[$count][2]."</label></li>\n";
                     $detected++;
                  }
            }
?>
            </ul>
            <br />
            <div class="fake_hr_seperator"><hr /></div>
            <h2><?php echo $lang["DBHost"];?></h2>
            <p class="notop"><?php print $lang["DBHostDesc"]; ?></p>
            <input type="text" maxlength="1000" name="config[database_host]" value="<?php echo $wakkaConfig["database_host"] ?>" class="text_input" />
            <br />
            <div class="fake_hr_seperator"><hr /></div>
            <h2><?php echo $lang["DBPort"];?></h2>
            <p class="notop"><?php print $lang["DBPortDesc"]; ?></p>
            <input type="text" maxlength="10" name="config[database_port]" value="<?php echo $wakkaConfig["database_port"] ?>" class="text_input" style="width: 100px;" />
            <br />
            <div class="fake_hr_seperator"><hr /></div>
            <h2><?php echo $lang["DB"];?></h2>
            <p class="notop"><?php print $lang["DBDesc"]; ?></p>
            <input type="text" maxlength="64" name="config[database_database]" value="<?php echo $wakkaConfig["database_database"] ?>" class="text_input" />
            <br />
            <div class="fake_hr_seperator"><hr /></div>
            <h2><?php echo $lang["DBUser"];?></h2>
            <p class="notop"><?php print $lang["DBUserDesc"]; ?></p>
            <input type="text" maxlength="50" name="config[database_user]" value="<?php echo $wakkaConfig["database_user"] ?>" class="text_input" />
            <br />
            <div class="fake_hr_seperator"><hr /></div>
            <h2><?php echo $lang["DBPassword"];?></h2>
            <p class="notop"><?php print $lang["DBPasswordDesc"]; ?></p>
            <input type="password" maxlength="50" name="config[database_password]" value="<?php echo $wakkaConfig["database_password"] ?>" class="text_input" />
            <br />
            <div class="fake_hr_seperator"><hr /></div>
            <h2><?php echo $lang["Prefix"];?></h2>
            <p class="notop"><?php print $lang["PrefixDesc"]; ?></p>
            <input type="text" maxlength="64" name="config[table_prefix]" value="<?php echo $wakkaConfig["table_prefix"] ?>" class="text_input" />
            <br />
            <div class="fake_hr_seperator"><hr /></div>
            <input type="submit" value="<?php echo $lang["Continue"];?>" class="next" onclick="return check();" />
<?php
      }
?>
         </form>
