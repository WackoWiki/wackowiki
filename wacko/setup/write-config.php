<?php

function array_to_str ($arr, $name="")
   {
      $str = "\$wakkaConfig".($name?"[\"".$name."\"]":"")." = array(\n";

      foreach ($arr as $k => $v)
         {
            if(is_array($v))
               $arrays .= array_to_str($v, $k);
            else
               $entries .= "\t\"".$k."\" => \"".str_replace("\n","\\n",$v)."\",\n";
         }

      $str .= $entries.");\n";
      $str .= $arrays;
      return $str;
   }

   // fetch config
   $config = $config2 = unserialize($_POST["config_s"]);

   if (!$wakkaConfig["wacko_version"]) $config["cookie_prefix"] = $config["table_prefix"];

   if (!$wakkaConfig["wacko_version"]) $config["aliases"] = array("Admins" => $config["admin_name"]);

   // merge existing configuration with new one
   $config = array_merge((array)$wakkaConfig, (array)$config);

   // set version to current version, yay!
   $config["wakka_version"] = WAKKA_VERSION;
   $config["wacko_version"] = WACKO_VERSION;

   // convert config array into PHP code
   $configCode = "<?php\n// wakka.config.php ".$lang["WrittenAt"].strftime("%c")."\n// ".$lang["DontChange"]."\n\n";
   $configCode .= array_to_str($config)."\n?>";

   // try to write configuration file
   print("         <h2>".$lang["Writing"]."</h2>\n");
   print("         <ul>\n");
   print("            <li>".$lang["Writing2"]." <tt>".$wakkaConfigLocation."</tt> - ");

   $fp = @fopen($wakkaConfigLocation, "w");

   if ($fp)
      {
         // Saving file was successful
         fwrite($fp, $configCode);
         fclose($fp);

         // Try and make it non-writable
         @chmod("wakka.config.php", 0644);
         $perm_changed = !is__writable('wakka.config.php');

         print(output_image(true)."</li>\n");
         print("            <li>".$lang["RemovingWritePrivilege"]." - ".output_image($perm_changed))."</li>\n";
         print("         </ul>\n");

         print("         <h2>".$lang["SecurityConsiderations"]."</h2>\n");
         print("         <ul class=\"security\">\n");

         if(!$perm_changed)
            {
               print("            <li>".$lang["SecurityRisk"]."</li>\n");
            }

         print("            <li>".$lang["RemoveSetupDirectory"]."</li>\n");

         print("         </ul>\n");

         print("         <br /><p>".str_replace("%1", $config["base_url"], $lang["InstallationComplete"])."</p>\n");
      }
   else
      {
         // Problem saving file
         print(output_image(false)."</li>\n");
         print("         </ul>\n");

         print("         <h2>".$lang["SecurityConsiderations"]."</h2>\n");
         print("         <ul class=\"security\">\n");
         print("            <li>".str_replace("%1", $wakkaConfigLocation, $lang["ErrorGivePrivileges"])."</li>\n");
         print("            <li>".$lang["RemoveSetupDirectory"]."</li>\n");
         print("         </ul>\n");
?>
         <form action="<?php echo myLocation() ?>?installAction=write-config" method="post">
            <input type="hidden" name="config_s" value="<?php echo htmlspecialchars(serialize($config2)) ?>" />
            <input type="hidden" name="config[language]" value="<?php echo $config["language"]; ?>" />
            <input type="submit" value="<?php echo $lang["TryAgain"];?>" class="next" />
         </form>
<?php
         print("         <div class=\"config_code\"><pre>".htmlentities($configCode)."</pre></div>\n");
      }
?>         <br />
