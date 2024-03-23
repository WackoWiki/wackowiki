<?php

if (!defined('IN_WACKO'))
{
	exit;
}

const SET_MENU			= 1;
const SET_MENU_ONLY		= 2;
const ACTIONS			= ['lang', 'version-check', 'config-site', 'config-database', 'install-database', 'write-config'];

class Installer
{
	static function run(&$db)
	{
		// check for missing setup folder
		if (!file_exists('setup/header.php'))
		{
			header('HTTP/1.1 503 Service Unavailable');
			die('WackoWiki fatal error: setup/ folder is missing or empty. Please add the missing setup folder in order to upgrade your WackoWiki installation.');
		}

		$install_action = trim((string) ($_REQUEST['installAction'] ?? ''));

		// call installer
		if (!$install_action || !in_array($install_action, ACTIONS))
		{
			$install_action = 'lang';
		}

		$install_module = 'setup/' . $install_action . '.php';

		global $config, $base_path;
		$config		= $db->steal_config();
		$base_path	= $db->get_base_url();

		include 'setup/header.php';

		if (@file_exists($install_module))
		{
			include $install_module;
		}
		else
		{
			echo '<p><em>' . $lang['InvalidAction'] . '</em></p>';
		}

		include 'setup/footer.php';

		exit;
	}
}
