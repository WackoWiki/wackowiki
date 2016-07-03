<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$safehtml = new SafeHTML;
echo $safehtml->parse($text);
