<?php

if (!defined('IN_WACKO'))
{
	exit;
}

class Installer
{
	static function run(&$db)
	{
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
