<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$safehtml = new SafeHTML\SafeHTML();
echo $safehtml->parse($text);
