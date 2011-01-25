<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$file = implode('', file('config/interwiki.conf', 1));
echo $this->format('%%'.$file.'%%');

?>