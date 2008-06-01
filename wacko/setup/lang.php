<form action="<?php echo myLocation() ?>?installAction=default" method="post">
<table>

  <tr><td></td><td><strong><?php echo $lang["title"];?></strong></td></tr>

  <tr><td></td><td><br /><strong><?php echo $lang["langConf"];?></strong></td></tr>
  <tr><td></td><td><?php echo $lang["langDesc"];?></td></tr>
  <tr><td align="right" nowrap><?php echo $lang["lang"];?>:</td><td>
  <select name="config[language]">
<?php
$handle=opendir("setup/lang");
while (false!==($file = readdir($handle))) {
  if ($file != "." && $file != ".." && !is_dir($file) && 1==preg_match("/^installer\.(.*?)\.php$/",$file,$match)) {
   echo "<option value=\"".$match[1]."\" ".($wakkaConfig["language"]==$match[1]?"selected=\"selected\"":"").">".$match[1]."</option>\n";
  }
}
closedir($handle);
?>
  </select>
  </td></tr>

  <tr><td></td><td><input type="submit" value="<?php echo $lang["Continue"];?>" /></td></tr>
</table>
</form>