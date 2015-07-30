<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($text == '')
{
	return;
}

$this->use_class('typografica', $this->config['formatter_path'].'/class/');

$typo = new typografica($this);

// kuso: since dashglued cause rendering bugs in Firefox, this option is now turned off.
$typo->settings['dashglue'] = false;

echo $typo->correct($text, false);

?>
