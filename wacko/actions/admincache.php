<?php

if ($this->IsAdmin())
{
	if (!$_POST["clear"])
	{
		echo $this->FormOpen();
		?>
<input
	type="submit" name="clear"
	value="<?php echo $this->GetResourceValue("ClearCache");?>" />
		<?php
		echo $this->FormClose();
}
else
{
	@set_time_limit(0);
	$handle=opendir(rtrim($this->GetConfigValue("cache_dir"),"/"));
	while (false!==($file = readdir($handle))) {
		if ($file != "." && $file != ".." && !is_dir($this->GetConfigValue("cache_dir").$file)) {
			unlink($this->GetConfigValue("cache_dir").$file);
		}
	}
	closedir($handle);
	$this->Query("DELETE FROM ".$this->config["table_prefix"]."cache");

	echo $this->GetResourceValue("CacheCleared");
}
}

?>