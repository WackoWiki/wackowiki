<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$safehtml = new safehtml();
echo $safehtml->parse($text);

?>
