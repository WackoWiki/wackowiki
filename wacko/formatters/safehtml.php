<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$this->use_class('safehtml', 'lib/safehtml/');

$safehtml = new safehtml();
echo ($safehtml->parse($text));

?>