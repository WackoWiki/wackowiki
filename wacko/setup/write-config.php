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
$was_wakka_upgrade = array_key_exists("wakka_version", $config) && !array_key_exists("wacko_version", $config);
$config["wakka_version"] = WAKKA_VERSION;
$config["wacko_version"] = WACKO_VERSION;

// convert config array into PHP code
$configCode = "<?php\n// config.inc.php ".$lang["WrittenAt"].strftime("%c")."\n// ".$lang["ConfigDescription"]."\n// ".$lang["DontChange"]."\n\n";
$configCode .= array_to_str($config)."\n?>";

// try to write configuration file
print("         <h2>".$lang["FinalSteps"]."</h2>\n");
print("         <ul>\n");
print("            <li>".$lang["Writing"]." - ");

$perm_changed = true;
$fp = @fopen('config.inc.php', "w");

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
   }
else
   {
      // Problem saving file
      print(output_image(false)."</li>\n");
   }

// try to delete wakka config file
$deleted_old_wakka_config_file = true;
if($was_wakka_upgrade && is_file('wakka.config.php'))
   {
      @chown('wakka.config.php', 666);
      $deleted_old_wakka_config_file = unlink('wakka.config.php');
      print("            <li>".$lang["DeletingWakkaConfigFile"]." - ".output_image($deleted_old_wakka_config_file))."</li>\n";
   }

print("         </ul>\n");

print("         <h2>".$lang["SecurityConsiderations"]."</h2>\n");
print("         <ul class=\"security\">\n");

if(!$perm_changed)
   {
      print("            <li>".$lang["SecurityRisk"]."</li>\n");
   }

print("            <li>".$lang["RemoveSetupDirectory"]."</li>\n");

if(!$deleted_old_wakka_config_file)
   {
      print("            <li>".$lang["RemoveWakkaConfigFile"]."</li>\n");
   }

if(!$fp)
   {
      print("            <li>".$lang["ErrorGivePrivileges"]."</li>\n");
   }

print("         </ul>\n");

?>
<form action="<?php echo myLocation() ?>?installAction=write-config" method="post">
<?php
writeConfigHiddenNodes(array('none' => ''));

// If there was a problem then show the "Try Again" button.
if($fp)
   {
      print("         <h2>".$lang["InstallationComplete"]."</h2>\n");
      print("         <p>".str_replace("%1", $config["base_url"], $lang["ThatsAll"])."</p>\n");
   }
else
   {
?>
   <input type="submit" value="<?php echo $lang["TryAgain"];?>" class="next" />
<?php
   }
?>
</form>
<?php
if(!$fp)
   {
      print("         <div class=\"config_code\"><pre>".htmlentities($configCode)."</pre></div>\n");
   }
?>
<br />