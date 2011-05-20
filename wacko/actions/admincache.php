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
		echo $this->form_open();

		echo '<div class="layout-box">';
		// config cache
		echo '<input id="purgeconfig_cache" type="checkbox" name="config_cache" value="1" />';
		echo '<label for="purgeconfig_cache">'.$this->get_translation('ConfigCache').'</label><br />';
		// page cache
		echo '<input id="purgefiles_cache" type="checkbox" name="pages_cache" value="1" />';
		echo '<label for="purgefiles_cache">'.$this->get_translation('PageCache').'</label><br />';
		// sql cache
		echo '<input id="purgesql_cache" type="checkbox" name="sql_cache" value="1" />';
		echo '<label for="purgesql_cache">'.$this->get_translation('SQLCache').'</label><br />';
		// feed cache
		echo '<input id="purgefeeds_cache" type="checkbox" name="feed_cache" value="1" />';
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

			if (isset($_POST['pages_cache']) && $_POST['pages_cache'] == 1)
			{
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
				$this->sql_query("DELETE FROM ".$this->config['table_prefix']."cache");
			}

			if (isset($_POST['sql_cache']) && $_POST['sql_cache'] == 1)
			{
				// queries
				$handle = opendir(rtrim($this->config['cache_dir'].CACHE_SQL_DIR, '/'));

				while (false !== ($file = readdir($handle)))
				{
					if ($file != '.' && $file != '..' && !is_dir($this->config['cache_dir'].CACHE_SQL_DIR.$file))
					{
						unlink($this->config['cache_dir'].CACHE_SQL_DIR.$file);
					}
				}

				closedir($handle);
			}

			if (isset($_POST['config_cache']) && $_POST['config_cache'] == 1)
			{
				// config
				$handle = opendir(rtrim($this->config['cache_dir'].CACHE_CONFIG_DIR, '/'));

				while (false !== ($file = readdir($handle)))
				{
					if ($file != '.' && $file != '..' && !is_dir($this->config['cache_dir'].CACHE_CONFIG_DIR.$file))
					{
						unlink($this->config['cache_dir'].CACHE_CONFIG_DIR.$file);
					}
				}

				closedir($handle);
			}

			if (isset($_POST['config_feed']) && $_POST['config_feed'] == 1)
			{
				// feeds
				$handle = opendir(rtrim($this->config['cache_dir'].CACHE_FEED_DIR, '/'));

				while (false !== ($file = readdir($handle)))
				{
					if (!is_dir($this->config['cache_dir'].CACHE_FEED_DIR.$file))
					{
						unlink($this->config['cache_dir'].CACHE_FEED_DIR.$file);
					}
				}

				closedir($handle);
			}

			echo $this->get_translation('CacheCleared');
		}
	}
}

?>