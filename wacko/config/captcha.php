<?php

if (!defined('IN_CAPTCHA'))
{
	exit;
}

define('SESSION_HANDLER_PATH',		null);				// Where to find session files. Same setting as in config/constants.php
define('COOKIE_PREFIX',				'wacko_');			// Part 1 of session_name - see init.php ln. 421 for details "  session_name($this->config['cookie_prefix'].SESSION_HANDLER_ID);  "
define('SESSION_HANDLER_ID',		'sid');				// Part 2 of session_name - see previous . Same setting as in config/constants.php

?>