<?php

if (!defined('IN_WACKO'))
{
	exit;
}

const SETUP_LOCK		= 'config/lock_setup';
const SET_MENU			= 1;
const SET_MENU_ADMIN	= 2;
const SET_MENU_ONLY		= 3;
const ACTIONS			= ['lang', 'version-check', 'config-site', 'config-database', 'install-database', 'write-config'];

class Installer
{
	static function run(&$db)
	{
		global $config, $base_path;
		$config		= $db->steal_config();
		$base_path	= $db->get_base_url();
		$logged_in	= true;

		// check for missing setup folder
		if (!file_exists('setup/header.php'))
		{
			header('HTTP/1.1 503 Service Unavailable');
			die('WackoWiki fatal error: setup/ folder is missing or empty. Please add the missing setup folder in order to upgrade your WackoWiki installation.');
		}

		require_once 'setup/common.php';

		// check for locking
		if (@file_exists(SETUP_LOCK))
		{
			// read password from lockfile
			$lines		= file(SETUP_LOCK);
			$lock_pw	= trim($lines[0]);

			$logged_in	= false;

			if (isset($_POST['config']))
			{
				$config_post	= $_POST['config'];
			}

			// Check for auth token
			if (!empty($config_post['auth']))
			{
				if (validate_token($config_post['auth'], $lock_pw))
				{
					$logged_in = true;
				}
			}

			// Handle login form submission
			if (!$logged_in && !empty($_POST['setup_login']))
			{
				$input_pass = $_POST['password'] ?? '';

				if ($lock_pw === $input_pass)
				{
					$config['auth']	= generate_secure_token($lock_pw);
					$logged_in		= true;
				}
				else
				{
					$error = true;
				}

				// reset
				$_REQUEST['installAction'] = '';
			}
		}

		$install_action = trim((string) ($_REQUEST['installAction'] ?? ''));

		// call installer
		if (!$logged_in)
		{
			$install_action = 'login';
		}
		else if (!$install_action || !in_array($install_action, ACTIONS))
		{
			$install_action = 'lang';
		}

		$install_module = 'setup/' . $install_action . '.php';
		require_once 'setup/header.php';


		if (@file_exists($install_module))
		{
			require_once $install_module;
		}
		else
		{
			echo '<p><em>' . $lang['InvalidAction'] . '</em></p>';
		}

		require_once 'setup/footer.php';

		exit;
	}
}
