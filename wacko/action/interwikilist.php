<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$file = file_get_contents(Ut::join_path(CONFIG_DIR, 'interwiki.conf'));
echo $this->format('%%' . $file . '%%');
