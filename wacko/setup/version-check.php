         <form action="<?php echo myLocation() ?>?installAction=site-config" method="post">
            <input type="hidden" name="config[language]" value="<?php echo $config["language"];?>" />
<?php

if ($wakkaConfig["wakka_version"])
   {
      // If this is an upgrade install
      print("            <p>".$lang["Installed"].($wakkaConfig["wacko_version"] ? $wakkaConfig["wacko_version"] : $wakkaConfig["wakka_version"]).". ".$lang["ToUpgrade"].WACKO_VERSION.".</p>\n");
      print("            <p>".$lang["PleaseBackup"]."</p>\n");
   }
else
   {
      // Else it is a fresh install
      print("            <p>".$lang["Fresh"]."<strong>".WACKO_VERSION."</strong>.</p>\n");
   }
 ?>
            <p><?php echo $lang["Requirements"]; ?></p>
<?php
   /*
      Check PHP Version
   */

   $php_version_result = version_compare("4.0.7", PHP_VERSION, "<");
?>
            <h2><?php echo $lang["PHPVersion"]; ?></h2>
            <p class="notop"><?php echo $lang["PHPDetected"]; ?> <?php print phpversion().' - '.output_image($php_version_result); ?></p>
<?php
   /*
      Check if mod_rewrite is installed
   */
?>
            <h2><?php echo $lang["ModRewrite"]; ?></h2>
            <p class="notop"><?php echo $lang["ModRewriteInstalled"]; ?> - <?php if(function_exists('apache_get_modules')) { print output_image(in_array('mod_rewrite', apache_get_modules())); } else { print($lang["ModRewriteStatusUnknown"]); } ?></p>
<?php
   /*
      Check which database extensions are installed and what versions of the db are there
   */
   $database_result = extension_loaded("mysql") || extension_loaded("mysqli") || extension_loaded("pdo");

   /*
      With PDO it is not enough that we can just say "ok we've detected PDO".
      We have to actually confirm that one of the specific database types is enabled.
      Later when we support all the PDO types this can be removed but for now we
      only support a subset of them.

      This is a copy of the array from database-config.php
   */

   $accepted_pdo_drivers = array();
   $accepted_pdo_drivers[] = "mysql";

   $detected = 0;

   if(extension_loaded("pdo"))
      {
         // mssql mysql sqlite
         $drivers = PDO::getAvailableDrivers();

         for($count = 0; $count < count($drivers); $count++)
            {
               // If you want to find the name out
               // print $drivers[$count];

               if(in_array($drivers[$count], $accepted_pdo_drivers))
                  {
                     $detected++;
                     break;
                  }
            }
      }
?>
            <h2><?php echo $lang["Database"]; ?></h2>
            <ul>
               <li>MySQL - <?php print output_image(extension_loaded("mysql")); ?></li>
               <li>MySQLi - <?php print output_image(extension_loaded("mysqli")); ?></li>
               <li>PDO - <?php print output_image($detected > 0); ?></li>
            </ul>
<?php
   /*
      Check file permissions
   */

   // Try applying the correct permissions now and then display whether it worked or not, if they fail then the user will have to manually set the permissions
   @chmod ("_cache", 0777);
   @chmod ("xml", 0777);
   @chmod ("files", 0777);
   @chmod ("files/perpage", 0777);
   @chmod ("sitemap.xml", 0777);
   @chmod ("wakka.config.php", 0777);

   $file_permissions_result = is__writable('wakka.config.php') && is__writable('_cache/') && is__writable('xml/') && is__writable('files/') && is__writable('files/perpage/') && is__writable('sitemap.xml');
?>
            <h2><?php echo $lang["Permissions"]; ?></h2>
            <ul>
               <li>wakka.config.php - <?php print output_image(is__writable('wakka.config.php')); ?></li>
               <li>_cache - <?php print output_image(is__writable('_cache/')); ?></li>
               <li>xml - <?php print output_image(is__writable('xml/')); ?></li>
               <li>files - <?php print output_image(is__writable('files/')); ?></li>
               <li>files/perpage - <?php print output_image(is__writable('files/perpage/')); ?></li>
               <li>sitemap.xml - <?php print output_image(is__writable('sitemap.xml')); ?></li>
            </ul>
<?php
/*
   End of checks, are we ready to install?
*/
?>
            <h2><?php echo $lang["ReadyToInstall"]; ?></h2>
<?php
            if($php_version_result && $database_result)
               {
?>
            <p><?php echo $lang["Ready"];?></p>
            <p><?php echo $lang["NotePermissions"];?></p>
            <input type="submit" value="<?php echo $lang["Continue"];?>" class="next" />
<?php
               }
            else if(!$php_version_result)
               {
?>
            <p><?php echo $lang["ErrorMinPHPVersion"]; ?></p>
<?php
               }
            else if(!$file_permissions_result)
               {
?>
            <p><?php echo $lang["NotePermissions"]; ?></p>
            <p><?php echo $lang["ErrorPermissions"]; ?></p>
            <input type="submit" value="<?php echo $lang["Continue"];?>" class="next" />
<?php
               }
?>
         </form>
