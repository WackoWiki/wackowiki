<?php

if (!$wakkaConfig["wakka_version"])
{
?>
<script language="JavaScript" type="text/javascript">
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
               alert('<?php echo $lang["no database driver selected"];?>');
               return false;
            }

         if (f.elements["config[admin_name]"].value.search(re) == -1)
            {
               alert('<?php echo $lang["incorrect wikiname"];?>');
               return false;
            }

         re = new RegExp("[a-zA-Z0-9_\-]+@[a-zA-Z0-9_\-]+\.[a-zA-Z]+", "i");

         if (f.elements["config[admin_email]"].value.search(re)==-1)
            {
               alert('<?php echo $lang["incorrect email"];?>');
               return false;
            }

         if (f.elements["password"].value.length<5)
            {
               alert('<?php echo $lang["password too short"];?>');
               return false;
            }

         if (f.elements["password"].value!=f.elements["password2"].value)
            {
               alert('<?php echo $lang["passwords don't match"];?>');
               return false;
            }

         if (f.elements["config[base_url]"].value.indexOf( "?" ) != -1)

         if (f.elements["config[rewrite_mode]"].value != 0)
            if (!confirm('<?php echo addcslashes($lang["RewriteModeAlert"],"\n"); ?>'))
               return false;

         return true;
         // -->
   }
</script>
<?php } else {?>
<script language="JavaScript">
   <!--
   function check()
      {
         return true;
      }
   // -->
</script>
<?php } ?>
<form action="<?php echo myLocation() ?>?installAction=install" name="form1" method="post">
<input type="hidden" name="config[language]" value="<?php echo $config["language"];?>" />
<table>

 <tr><td></td><td><strong><?php echo $lang["title"];?></strong></td></tr>

 <?php
   if ($wakkaConfig["wakka_version"])
      {
         print("<tr><td></td><td>".$lang["installed"]."<strong>".($wakkaConfig["wacko_version"]?$wakkaConfig["wacko_version"]:$wakkaConfig["wakka_version"])."</strong>. ".$lang["toUpgrade"]."<strong>".WACKO_VERSION."</strong>. ".$lang["review"]."</td></tr>\n");
         print("<tr><td></td><td class='warning'>".$lang["PleaseBackup"]."</td></tr>\n");
      }
   else
      {
         print("<tr><td></td><td>".$lang["fresh"]."<strong>".WACKO_VERSION."</strong>. ".$lang["pleaseConfigure"]."</td></tr>\n");
      }
 ?>

 <tr><td></td><td><br /><?php echo $lang["note"];?></td></tr>
<?php
   if (!$wakkaConfig["wakka_version"])
      {
?>
 <tr><td></td><td><br /><strong><?php echo $lang["dbConf"];?></strong></td></tr>

<?php
         // If none of the PHP SQL extensions are loaded then let the user know there is a problem
         if(!extension_loaded("mysql") && !extension_loaded("mysqli") && !extension_loaded("pdo"))
            {
               // We don't dl("mysql.so"); anymore since PHP5 and PHP6 have deprecated this
               print("<tr><td></td><td class='warning'>".$lang["noDbDriverDetected"]."</td></tr>\n");
            }
         else
            {
?>
 <tr><td></td><td><?php echo $lang["dbDriverDesc"];?></td></tr>
 <tr><td align="right" nowrap style="vertical-align: top;"><?php echo $lang["dbDriver"]; ?>:</td><td><?php if(extension_loaded("mysql")) { ?><input type="radio" name="config[database_driver]" value="mysql_legacy" checked="checked" />MySQL<br /><?php } if(extension_loaded("mysqli")) { ?><input type="radio" name="config[database_driver]" value="mysqli_legacy" <?php if(!extension_loaded("mysql")) echo 'checked="checked" '; ?>/>MySQLi<br /><?php } if(extension_loaded("pdo")) { ?><input type="radio" name="config[database_driver]" value="mysql" <?php if(!extension_loaded("mysql") && !extension_loaded("mysqli")) echo 'checked="checked" '; ?>/>PDO MySQL<br /><input type="radio" name="config[database_driver]" value="dblib" />PDO DB-Lib<br /><input type="radio" name="config[database_driver]" value="mssql" />PDO MS SQL<br /><input type="radio" name="config[database_driver]" value="sybase" />PDO Sybase<br /><input type="radio" name="config[database_driver]" value="firebird" />PDO Firebird/Interbase<br /><input type="radio" name="config[database_driver]" value="ibm" />PDO IBM DB2<br /><input type="radio" name="config[database_driver]" value="informix" />PDO Informix<br /><input type="radio" name="config[database_driver]" value="oci" />PDO Oracle<br /><input type="radio" name="config[database_driver]" value="pgsql" />PDO PostgreSQL<br /><input type="radio" name="config[database_driver]" value="sqlite" />PDO SQLite<br /><input type="radio" name="config[database_driver]" value="sqlite2" />PDO SQLite2<?php } ?></td></tr>
 <tr><td></td><td><?php echo $lang["dbHostDesc"];?></td></tr>
 <tr><td align="right" nowrap><?php echo $lang["dbHost"];?>:</td><td><input type="text" size="50" name="config[database_host]" value="<?php echo $wakkaConfig["database_host"] ?>" /></td></tr>
 <tr><td></td><td><?php echo $lang["dbPortDesc"];?></td></tr>
 <tr><td align="right" nowrap><?php echo $lang["dbPort"];?>:</td><td><input type="text" size="50" name="config[database_port]" value="<?php echo $wakkaConfig["database_port"] ?>" /></td></tr>

 <tr><td></td><td><?php echo $lang["dbDesc"];?></td></tr>
 <tr><td align="right" nowrap><?php echo $lang["db"];?>:</td><td><input type="text" size="50" name="config[database_database]" value="<?php echo $wakkaConfig["database_database"] ?>" /></td></tr>
 <tr><td></td><td><?php echo $lang["dbPasswDesc"];?></td></tr>
 <tr><td align="right" nowrap><?php echo $lang["dbUser"];?>:</td><td><input type="text" size="50" name="config[database_user]" value="<?php echo $wakkaConfig["database_user"] ?>" /></td></tr>
 <tr><td align="right" nowrap><?php echo $lang["dbPassw"];?>:</td><td><input type="password" size="50" name="config[database_password]" value="<?php echo $wakkaConfig["database_password"] ?>" /></td></tr>
 <tr><td></td><td><?php echo $lang["prefixDesc"];?></td></tr>
 <tr><td align="right" nowrap><?php echo $lang["prefix"];?>:</td><td><input type="text" size="50" name="config[table_prefix]" value="<?php echo $wakkaConfig["table_prefix"] ?>" /></td></tr>
<?php
            }
      }
?>

 <tr><td></td><td><br /><strong><?php echo $lang["SiteConf"];?></strong></td></tr>

 <tr><td></td><td><?php echo $lang["nameDesc"];?></td></tr>
 <tr><td align="right" nowrap><?php echo $lang["name"];?>:</td><td><input type="text" size="50" name="config[wakka_name]" value="<?php echo $wakkaConfig["wakka_name"] ?>" /></td></tr>

 <tr><td></td><td><?php echo $lang["homeDesc"];?></td></tr>
 <tr><td align="right" nowrap><?php echo $lang["home"];?>:</td><td><input type="text" size="50" name="config[root_page]" value="<?php echo $wakkaConfig["root_page"] ?>" /></td></tr>

<?php
 if (!$wakkaConfig["wakka_version"])
 {
?>
 <tr><td></td><td><?php echo $lang["multilangDesc"];?></td></tr>
 <tr><td align="right" nowrap><?php echo $lang["multilang"];?>:</td><td><input type="hidden" name="config[multilanguage]" value="0" /><input type="checkbox" name="config[multilanguage]" value="1" <?php echo $wakkaConfig["multilanguage"] ? "checked" : "" ?> /> <?php echo $lang["enabled"];?></td></tr>

 <tr><td></td><td><br /><strong><?php echo $lang["AdminConf"];?></strong></td></tr>

 <tr><td></td><td><?php echo $lang["adminDesc"];?></td></tr>
 <tr><td align="right" nowrap><?php echo $lang["admin"];?>:</td><td><input type="text" size="50" name="config[admin_name]" value="<?php echo $wakkaConfig["admin_name"] ?>" /></td></tr>

 <tr><td></td><td><?php echo $lang["passwDesc"];?></td></tr>
 <tr><td align="right" nowrap><?php echo $lang["password"];?>:</td><td><input type="password" size="50" name="password" value="" /></td></tr>
 <tr><td align="right" nowrap><?php echo $lang["password2"];?>:</td><td><input type="password" size="50" name="password2" value="" /></td></tr>

 <tr><td></td><td><?php echo $lang["mailDesc"];?></td></tr>
 <tr><td align="right" nowrap><?php echo $lang["mail"];?>:</td><td><input type="text" size="50" name="config[admin_email]" value="<?php echo $wakkaConfig["admin_email"] ?>" /></td></tr>
<?php
 }
?>

 <tr><td></td><td><br /><strong><?php echo $lang["UrlConf"];?></strong>
 <?php echo $wakkaConfig["wakka_version"] ? "" : "<br />".$lang["newinstall"] ?></td></tr>

 <tr><td></td><td><?php echo $lang["baseDesc"];?></td></tr>
 <tr><td align="right" nowrap><?php echo $lang["base"];?>:</td><td><input type="text" size="50" name="config[base_url]" value="<?php echo $wakkaConfig["base_url"] ?>" /></td></tr>

 <tr><td></td><td><?php echo $lang["rewriteDesc"];?></td></tr>
 <tr><td align="right" nowrap><?php echo $lang["rewrite"];?>:</td><td><input type="hidden" name="config[rewrite_mode]" value="0" /><input type="checkbox" name="config[rewrite_mode]" value="1" <?php echo $wakkaConfig["rewrite_mode"] ? "checked" : "" ?> /> <?php echo $lang["enabled"];?></td></tr>


 <tr><td></td><td><input type="submit" value="<?php echo $lang["Continue"];?>" onclick="return check();" /></td></tr>
</table>
</form>