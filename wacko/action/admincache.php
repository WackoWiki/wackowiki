<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($this->is_admin())
{
	if (@$_POST['_action'] === 'purge_cache')
	{
		@set_time_limit(0);

		$done = '';

		if (isset($_POST['pages_cache']) && ($n = Ut::purge_directory(CACHE_PAGE_DIR)))
		{
			// empties cache table and reset AUTO_INCREMENT value to its start value
			$this->sql_query("TRUNCATE {$this->db->table_prefix}cache");

			$done .= $this->get_translation('PageCache') . ' (' . $n . ') ... ';
		}

		if (isset($_POST['sql_cache']) && ($n = Ut::purge_directory(CACHE_SQL_DIR)))
		{
			$done .= $this->get_translation('SQLCache') . ' (' . $n . ') ... ';
		}

		if (isset($_POST['config_cache']) && ($n = Ut::purge_directory(CACHE_CONFIG_DIR)))
		{
			$done .= $this->get_translation('ConfigCache') . ' (' . $n . ') ... ';
		}

		if (isset($_POST['config_feed']) && ($n = Ut::purge_directory(CACHE_FEED_DIR)))
		{
			$done .= $this->get_translation('FeedCache') . ' (' . $n . ') ... ';
		}

		$this->set_message($done . $this->get_translation('CacheCleared'), 'success');

		$this->redirect($this->href());
	}

	echo $this->form_open('purge_cache');

	echo '<div class="layout-box">';

	echo '<input type="checkbox" id="purgeconfig_cache" name="config_cache" />';
	echo '<label for="purgeconfig_cache">'.$this->get_translation('ConfigCache').'</label><br />';

	echo '<input type="checkbox" id="purgefiles_cache" name="pages_cache" />';
	echo '<label for="purgefiles_cache">'.$this->get_translation('PageCache').'</label><br />';

	echo '<input type="checkbox" id="purgesql_cache" name="sql_cache" />';
	echo '<label for="purgesql_cache">'.$this->get_translation('SQLCache').'</label><br />';

	echo '<input type="checkbox" id="purgefeeds_cache" name="feed_cache" />';
	echo '<label for="purgefeeds_cache">'.$this->get_translation('FeedCache').'</label><br /><br />';

	echo '<input type="submit" name="clear_cache" value="'. $this->get_translation('ClearCache').'" />';
	echo '</div>';

	echo $this->form_close();

}
