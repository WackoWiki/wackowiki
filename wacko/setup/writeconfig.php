<?php

function array_to_str ($arr, $name="") {
 $str = "\$wakkaConfig".($name?"[\"".$name."\"]":"")." = array(\n";
 foreach ($arr as $k => $v)
 {
   if (is_array($v))
    $arrays .= array_to_str($v, $k);
   else
    $entries .= "\t\"".$k."\" => \"".str_replace("\n","\\n",$v)."\",\n";
 }
 $str .= $entries.");\n";
 $str .= $arrays;
 return $str;
}

//apply rights
test($lang["apply rights"]." _cache...",       @chmod ("_cache", 0777),        $lang["apply rights yourself"]."_cache", 0);
test($lang["apply rights"]." xml...",          @chmod ("xml", 0777),           $lang["apply rights yourself"]."xml", 0);
test($lang["apply rights"]." files...",        @chmod ("files", 0777),         $lang["apply rights yourself"]."files", 0);
test($lang["apply rights"]." files/perpage...",@chmod ("files/perpage", 0777), $lang["apply rights yourself"]."files/perpage", 0);
test($lang["apply rights"]." sitemap.xml...",  @chmod ("sitemap.xml", 0777),   $lang["apply rights yourself"]."sitemap.xml", 0);

// fetch config
$config = $config2 = unserialize($_POST["config_s"]);

if (!$wakkaConfig["wacko_version"]) $config["cookie_prefix"] = $config["table_prefix"];
//$config["default_bookmarks"] = $lang["default_bookmarks"];
//$config["site_bookmarks"] = $lang["site_bookmarks"];
if (!$wakkaConfig["wacko_version"]) $config["aliases"] = array("Admins" => $config["admin_name"]);

// merge existing configuration with new one
$config = array_merge((array)$wakkaConfig, (array)$config);

// set version to current version, yay!
$config["wakka_version"] = WAKKA_VERSION;
$config["wacko_version"] = WACKO_VERSION;

// convert config array into PHP code
$configCode = "<?php\n// wakka.config.php ".$lang["writtenAt"].strftime("%c")."\n// ".$lang["dontchange"]."\n\n";
$configCode .= array_to_str($config)."\n?>";

// try to write configuration file
echo $lang["writing"];
test($lang["writing2"]." <tt>".$wakkaConfigLocation."</tt>...", $fp = @fopen($wakkaConfigLocation, "w"), "", 0);

if ($fp)
{
  fwrite($fp, $configCode);
  fclose($fp);
  echo $lang["ready"]." <a href=\"".$config["base_url"]."\">".$lang["return"]."</a>. ".$lang["SecurityRisk"]."</p>";
}
else
{
  // complain
  print("<p>".$lang["warning"]." <tt>".$wakkaConfigLocation."</tt> ".$lang["GivePrivileges"].".</p>\n");
  ?>
  <form action="<?php echo myLocation() ?>?installAction=writeconfig" method="post">
  <input type="hidden" name="config_s" value="<?php echo htmlspecialchars(serialize($config2)) ?>" />
  <input type="hidden" name="config[language]" value="<?php echo $config["language"]; ?>" />
  <input type="submit" value="<?php echo $lang["try again"];?>" />
  </form>
  <?php
  print("<div style=\"background-color: #EEEEEE; padding: 10px 10px;\">\n<xmp>".$configCode."</xmp>\n</div>\n");
}

?>