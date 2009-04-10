<?php

function array_to_str ($arr, $name="")
   {
      if ( !isset( $entries ) ) $entries = "";
      if ( !isset( $arrays  ) ) $arrays = "";

      $str = "\$wackoConfig".($name?"[\"".$name."\"]":"")." = array(\n";

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

if ( ( $config["database_driver"] == "mysqli_legacy" ) && empty( $config["database_port"] ) )
	$config["database_port"] = $config["database_port"] = "3306";

if ( !isset( $config["wacko_version"] ) )
   {
      $config["cookie_prefix"] = $config["table_prefix"];
      $config["aliases"] = array("Admins" => $config["admin_name"]);
   }

// set version to current version, yay!
$config["wakka_version"] = WAKKA_VERSION;
$config["wacko_version"] = WACKO_VERSION;

// convert config array into PHP code
$configCode = "<?php\n// config.inc.php ".$lang["WrittenAt"].strftime("%c")."\n// ".$lang["ConfigDescription"]."\n// ".$lang["DontChange"]."\n\n";
$configCode .= array_to_str($config)."\n?>";

// try to write configuration file
print("         <h2>".$lang["Writing"]."</h2>\n");
print("         <ul>\n");
print("            <li>".$lang["Writing2"]." <tt>".$wackoConfigLocation."</tt> - ");

$fp = @fopen($wackoConfigLocation, "w");

if ($fp)
   {
      // Saving file was successful
      fwrite($fp, $configCode);
      fclose($fp);

      // Try and make it non-writable
      @chmod("config.inc.php", 0644);
      $perm_changed = !is__writable('config.inc.php');

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
      print("            <li>".str_replace("%1", $wackoConfigLocation, $lang["ErrorGivePrivileges"])."</li>\n");
      print("            <li>".$lang["RemoveSetupDirectory"]."</li>\n");
      print("         </ul>\n");
	?>
<form action="<?php echo myLocation() ?>?installAction=write-config" method="post">
<?php
   writeConfigHiddenNodes(array('none' => ''));
?>
   <input type="submit" value="<?php echo $lang["TryAgain"];?>" class="next" />
</form>
<?php
      print("         <div class=\"config_code\"><pre>".htmlentities($configCode)."</pre></div>\n");
   }
?>
<br />
