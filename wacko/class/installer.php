<?php

if (!defined('IN_WACKO'))
{
	exit;
}

class Installer
{
	static function run(&$db)
	{
		if (!isset($_REQUEST['installAction']) && !strstr($_SERVER['SERVER_SOFTWARE'], 'IIS'))
		{
			$req = $_SERVER['REQUEST_URI'];

			if ($req{strlen($req) - 1} != '/' && strstr($req, '.php') != '.php')
			{
				header('Location: http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'/');
				exit;
			}
		}

		if (!($action = trim(@$_REQUEST['installAction'])))
		{
			$action = 'lang';
		}

		$install_module = 'setup/' . $action . '.php';

		global $config;
		$config = $db->steal_config();

		include('setup/header.php');

		if (@file_exists($install_module))
		{
			include($install_module);
		}
		else
		{
			echo '<em>Invalid action</em>';
		}

		include('setup/footer.php');

		exit;
	}

}
