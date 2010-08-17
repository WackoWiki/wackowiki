<?php

if ($this->IsAdmin())
{
	if (!isset($_POST["clear"]))
	{
		echo $this->FormOpen();
		?>
<input
	type="submit" name="clear"
	value="<?php echo $this->GetTranslation("ClearCache");?>" />
		<?php
		echo $this->FormClose();
	}
	// clear cache
	else
	{
		@set_time_limit(0);

		// pages
		$handle = opendir(rtrim($this->config['cache_dir'].CACHE_PAGE_DIR,"/"));
		while (false !== ($file = readdir($handle)))
		{
			if ($file != "." && $file != ".." && !is_dir($this->config['cache_dir'].CACHE_PAGE_DIR.$file))
			{
				unlink($this->config['cache_dir'].CACHE_PAGE_DIR.$file);
			}
		}
		closedir($handle);
		$this->Query("DELETE FROM ".$this->config['table_prefix']."cache");

		// queries
		$handle = opendir(rtrim($this->config['cache_dir'].CACHE_SQL_DIR, "/"));
		while (false !== ($file = readdir($handle)))
		{
			if ($file != "." && $file != ".." && !is_dir($this->config['cache_dir'].CACHE_SQL_DIR.$file))
			{
				unlink($this->config['cache_dir'].CACHE_SQL_DIR.$file);
			}
		}
		closedir($handle);

		echo $this->GetTranslation("CacheCleared");
	}
}

?>