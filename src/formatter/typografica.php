<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($text == '')
{
	return;
}

$typo = new Typografica($this, $options);

if (!isset($options['lang'])) $options['lang'] = $this->page['page_lang'] ?? ($this->resync_page_lang ?? $this->user_lang);

// kuso: since dashglued cause rendering bugs in Firefox, this option is now turned off.
$typo->settings['dashglue'] = false;

echo $typo->correct($text);
