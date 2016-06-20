<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($options)) $options = '';

if ($this->is_admin())
{
	if (!isset($_POST['clear_cache']))
	{
		echo $this->form_open('purge_cache');

		echo '<div class="layout-box">';
		// config cache
		echo '<input type="checkbox" id="purgeconfig_cache" name="config_cache" value="1" />';
		echo '<label for="purgeconfig_cache">'.$this->get_translation('ConfigCache').'</label><br />';
		// page cache
		echo '<input type="checkbox" id="purgefiles_cache" name="pages_cache" value="1" />';
		echo '<label for="purgefiles_cache">'.$this->get_translation('PageCache').'</label><br />';
		// sql cache
		echo '<input type="checkbox" id="purgesql_cache" name="sql_cache" value="1" />';
		echo '<label for="purgesql_cache">'.$this->get_translation('SQLCache').'</label><br />';
		// feed cache
		echo '<input type="checkbox" id="purgefeeds_cache" name="feed_cache" value="1" />';
		echo '<label for="purgefeeds_cache">'.$this->get_translation('FeedCache').'</label><br /><br />';

		echo '<input type="submit" name="clear_cache" value="'. $this->get_translation('ClearCache').'" />';
		echo '</div>';

		echo $this->form_close();
	}
	// clear cache
	else
	{
		if (isset($_POST['clear_cache']))
		{
			@set_time_limit(0);

			// pages cache
			if (isset($_POST['pages_cache']) && $_POST['pages_cache'] == 1)
			{
				$directory	= $this->config['cache_dir'].CACHE_PAGE_DIR;

				if ($handle = opendir(rtrim($directory, '/')))
				{
					while (false !== ($file = readdir($handle)))
					{
						if ($file != '.' && $file != '..' && !is_dir($directory.$file))
						{
							unlink($directory.$file);
						}
					}

					closedir($handle);
				}

				// empties cache table and reset AUTO_INCREMENT value to its start value
				$this->sql_query("TRUNCATE ".$this->config['table_prefix']."cache");
			}

			// SQL cache
			if (isset($_POST['sql_cache']) && $_POST['sql_cache'] == 1)
			{
				$this->cache->invalidate_sql_cache();
			}

			// config cache
			if (isset($_POST['config_cache']) && $_POST['config_cache'] == 1)
			{
				$this->cache->destroy_config_cache();
			}

			// feeds cache
			if (isset($_POST['config_feed']) && $_POST['config_feed'] == 1)
			{
				// feeds
				$directory	= $this->config['cache_dir'].CACHE_FEED_DIR;

				if ($handle = opendir(rtrim($directory, '/')))
				{
					while (false !== ($file = readdir($handle)))
					{
						if (!is_dir($directory.$file))
						{
							unlink($directory.$file);
						}
					}

					closedir($handle);
				}
			}

			$message = $this->get_translation('CacheCleared');
			$this->show_message($message, 'success');
		}
	}
}

?>