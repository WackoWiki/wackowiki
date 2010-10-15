<?php

if ($this->is_admin())
{
	if (!isset($_POST['clear']))
	{
		echo $this->form_open();
		?>
<input
	type="submit" name="clear"
	value="<?php echo $this->get_translation('ClearCache');?>" />
		<?php
		echo $this->form_close();
	}
	// clear cache
	else
	{
		@set_time_limit(0);

		// pages
		$handle = opendir(rtrim($this->config['cache_dir'].CACHE_PAGE_DIR, '/'));
		while (false !== ($file = readdir($handle)))
		{
			if ($file != '.' && $file != '..' && !is_dir($this->config['cache_dir'].CACHE_PAGE_DIR.$file))
			{
				unlink($this->config['cache_dir'].CACHE_PAGE_DIR.$file);
			}
		}
		closedir($handle);
		$this->query("DELETE FROM ".$this->config['table_prefix']."cache");

		// queries
		$handle = opendir(rtrim($this->config['cache_dir'].CACHE_SQL_DIR, "/"));
		while (false !== ($file = readdir($handle)))
		{
			if ($file != '.' && $file != '..' && !is_dir($this->config['cache_dir'].CACHE_SQL_DIR.$file))
			{
				unlink($this->config['cache_dir'].CACHE_SQL_DIR.$file);
			}
		}
		closedir($handle);

		echo $this->get_translation('CacheCleared');
	}
}

?>