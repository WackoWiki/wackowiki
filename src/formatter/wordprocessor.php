<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$text = preg_replace('/{{(toc).*?}}/ui', '', $text);
$data = $this->format($text, 'wiki');
// remove obsolete <ignore> tags
$data = str_replace(['<ignore>', '</ignore>'], '', $data);
$data = preg_replace('/<br\s*>/u', '</p><p>', $data);

echo $data;
