<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Clears cache.

Usage:
	{{admincache}}
EOD;

// set defaults
$help			??= 0;

if ($help)
{
	$tpl->help	= $this->help($info, 'admincache');
	return;
}

if ($this->is_admin())
{
	$action = $_POST['_action'] ?? null;

	if ($action === 'purge_cache')
	{
		@set_time_limit(0);

		$done = $tpl->post();

		if (isset($_POST['pages_cache']) && ($n = Ut::purge_directory(CACHE_PAGE_DIR)))
		{
			$sql_truncate = ($engine->db->sqlite
				? 'DELETE FROM '
				: 'TRUNCATE ');

			// empties cache table and reset AUTO_INCREMENT value to its start value
			$this->db->sql_query($sql_truncate . $this->prefix . 'cache');
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

		if (isset($_POST['template_cache']) && ($n = Ut::purge_directory(CACHE_TEMPLATE_DIR)))
		{
			$done->template_n = $n;
		}

		if (isset($_POST['thumb_cache']) && ($n = Ut::purge_directory(THUMB_DIR)))
		{
			$done->thumbglobal_n = $n;
		}

		if (isset($_POST['thumb_cache']) && ($n = Ut::purge_directory(THUMB_LOCAL_DIR)))
		{
			$done->thumblocal_n = $n;
		}

		$this->set_message($done, 'success');

		$this->show_must_go_on();
	}

	// STS $add = (@$_GET['add'] || @$_POST['add']);
	$tpl->form_href = $this->href();
}
