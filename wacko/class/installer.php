<?php

if (!defined('IN_WACKO'))
{
	exit;
}

class Installer
{
	function __construct()
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

		// start installer
		//global $config;
		//$config = & $this->config;	// STS: sane $config there already

		if (!($action = trim(@$_REQUEST['installAction'])))
		{
			$action = 'lang';
		}

		$install_module = 'setup/' . $action . '.php';

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
