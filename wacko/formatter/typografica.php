<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($text == '')
{
	return;
}

$typo = new Typografica($this);

// kuso: since dashglued cause rendering bugs in Firefox, this option is now turned off.
$typo->settings['dashglue'] = false;

echo $typo->correct($text);
