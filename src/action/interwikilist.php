<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Displays all available Interwiki addresses.

Usage:
	{{interwikilist}}
EOD;

// set defaults
$help		??= 0;

if ($help)
{
	echo $this->help($info, 'interwikilist');
	return;
}

$file = file_get_contents(Ut::join_path(CONFIG_DIR, 'interwiki.conf'));
echo $this->format('%%' . $file . '%%');
