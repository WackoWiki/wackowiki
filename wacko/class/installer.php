<?php

if (!defined('IN_WACKO'))
{
	exit;
}

const SET_MENU			= 1;
const SET_MENU_ONLY		= 2;

class Installer
{
	static function run(&$db)
	{
		if (!file_exists('setup/header.php'))
		{
			die("WackoWiki fatal error: setup/ folder is missing or empty. Please add the missing setup folder in order to upgrade your WackoWiki installation.");
		}

		if (!($install_action = trim(@$_REQUEST['installAction'])))
		{
			$install_action = 'lang';
		}

		$install_module = 'setup/' . $install_action . '.php';

		global $config;
		$config = $db->steal_config();

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
