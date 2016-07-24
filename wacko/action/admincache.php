<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($this->is_admin())
{
	$me = $this->href();

	if (@$_POST['_action'] === 'purge_cache')
	{
		@set_time_limit(0);

		$done = $tpl->post();

		if (isset($_POST['pages_cache']) && ($n = Ut::purge_directory(CACHE_PAGE_DIR)))
		{
			// empties cache table and reset AUTO_INCREMENT value to its start value
			$this->db->sql_query("TRUNCATE {$this->db->table_prefix}cache");
			$done->page_n = $n;
		}

		if (isset($_POST['sql_cache']) && ($n = Ut::purge_directory(CACHE_SQL_DIR)))
		{
			$done->sql_n = $n;
		}

		if (isset($_POST['config_cache']) && ($n = Ut::purge_directory(CACHE_CONFIG_DIR)))
		{
			$done->config_n = $n;
		}

		if (isset($_POST['feed_cache']) && ($n = Ut::purge_directory(CACHE_FEED_DIR)))
		{
			$done->feed_n = $n;
		}

		$this->set_message($done, 'success');

		$this->http->redirect($me);
	}

	// STS $add = (@$_GET['add'] || @$_POST['add']);
	$tpl->href = $me;

	if (!($this->db->rewrite_mode || $this->db->ap_mode))
	{
		$tpl->h_mini = $this->mini_href();
	}
}
